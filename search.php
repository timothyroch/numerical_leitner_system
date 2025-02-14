<?php
session_start();

include("classes/connect.php");
include("classes/create_folder.php");
include("classes/card.php");
include("classes/create_system.php");
include("classes/login.php");

$login = new Login();
$user_data = $login->check_login($_SESSION['nls_db_userid']);

$searchQuery = "";
$result = null;
$recentSearches = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if 'username' is set in POST data
    if (isset($_POST['username'])) {
        $searchQuery = $_POST['username'];

        if (!empty($searchQuery)) {
            $DB = new Database();
            $conn = $DB->connect();
            $searchQuery = mysqli_real_escape_string($conn, $searchQuery);
            $userId = $user_data['userid'];
            $query = "SELECT * FROM users WHERE username LIKE '%$searchQuery%' AND userid != '$userId'";
            $result = $DB->read($query);

            if ($result) {
                if (isset($_SESSION['recent_searches'])) {
                    $recentSearches = $_SESSION['recent_searches'];
                }
                array_unshift($recentSearches, $searchQuery);
                $recentSearches = array_unique($recentSearches);
                if (count($recentSearches) > 3) {
                    array_pop($recentSearches);
                }
                $_SESSION['recent_searches'] = $recentSearches;
            }
        }
    }
}

if (isset($_POST['delete_recent'])) {
    $deleteIndex = $_POST['delete_index'];
    if (isset($_SESSION['recent_searches'][$deleteIndex])) {
        unset($_SESSION['recent_searches'][$deleteIndex]);
        $_SESSION['recent_searches'] = array_values($_SESSION['recent_searches']);
    }
}

$suggestedUsers = [];
if (isset($user_data['userid'])) {
    $userId = $user_data['userid'];
    $query = "SELECT * FROM users WHERE userid != '$userId' ORDER BY RAND() LIMIT 5";
    $DB = new Database();
    $suggestedUsers = $DB->read($query);
}

$recentSearches = $_SESSION['recent_searches'] ?? [];


// Fetch unique users involved in conversations
$DB = new Database();
$conn = $DB->connect();
$query = "SELECT DISTINCT CASE
              WHEN deliver = '$userId' THEN receiver
              ELSE deliver
          END AS user_id
          FROM messages
          WHERE deliver = '$userId' OR receiver = '$userId'";
$usersInConversations = $DB->read($query);

// Extract user IDs
$userIds = array_column($usersInConversations, 'user_id');

// Initialize database connection
$conn = $DB->connect();

// Escape each user ID
$userIds = array_map(function($id) use ($conn) {
    return mysqli_real_escape_string($conn, $id);
}, $userIds);

// Convert to a comma-separated string for SQL IN clause
$userIds = implode("','", $userIds);

// Fetch usernames of these user IDs
$query = "SELECT userid, username FROM users WHERE userid IN ('$userIds')";
$convoUsers = $DB->read($query);


// Initialize an array to store the latest messages
$latestMessages = [];

// Fetch the latest message for each user in conversation
foreach ($convoUsers as $user) {
    $HE = $user['userid'];
    $query = "SELECT * FROM messages 
              WHERE (deliver = '$userId' AND receiver = '$HE') 
              OR (deliver = '$HE' AND receiver = '$userId') 
              ORDER BY published DESC LIMIT 1";
    $messages = $DB->read($query);
    if ($messages) {
        $latestMessages[$HE] = $messages[0]; // Store the latest message
    } else {
        $latestMessages[$HE] = ['message' => 'No messages yet.']; // Default message if none found
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Users</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f2f5;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            box-sizing: border-box;
            animation: fadeIn 1s;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .background-iframe {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            min-height: 100vh;
            height:auto;
            border: none;
            z-index: -1;
        }

        .main-container {
            width: 100%;
            min-height: 100vh;
            height:auto;
            padding: 20px;
            background-color: white;

            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .search-container {
            display: flex;
            justify-content: center;
            width: 100%;
            margin-bottom: 20px;
        }

        .search-container form {
            display: flex;
            width: 100%;
            gap: 10px;
        }

        .search-container input[type="text"] {
            flex: 1;
            padding: 10px 15px;
            border: 2px solid #0078D7;
            border-radius: 5px;
            font-size: 16px;
        }

        .search-container input[type="submit"] {
            padding: 10px 20px;
            border: none;
            background-color: #0078D7;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .search-container input[type="submit"]:hover {
            background-color: #005a9e;
        }

        .search-results, .recent-searches, .suggested-users {
            margin-top: 20px;
        }

        .search-results h2, .recent-searches h2, .suggested-users h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .search-results ul, .recent-searches ul, .suggested-users ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .search-results li, .recent-searches li, .suggested-users li {
            padding: 15px;
            border-bottom: 1px solid #ccc;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.3s;
        }

        .search-results li:hover, .recent-searches li:hover, .suggested-users li:hover {
            background-color: #f9f9f9;
        }

        .search-results .username, .recent-searches .username, .suggested-users .username {
            font-size: 18px;
            font-weight: 500;
        }

        .search-results .visit-link a, .suggested-users .visit-link a {
            color: #0078D7;
            text-decoration: none;
            font-weight: 500;
        }

        .visit-link a:hover {
            text-decoration: underline;
        }

        .delete-button {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            display:flex;
            align-items:center;
        }
        .delete-button svg{
            margin-right: 8px; 
            vertical-align: middle;
        }

        .delete-button:hover {
            background-color: #cc0000;
        }

        .conversations {
            background-color: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    max-height: calc(100vh - 40px);
    overflow-y: auto;
    width: auto;
    margin-bottom:20px;
        }
        .conversations h2 {
    font-size: 24px;
    margin-bottom: 10px;
    display:flex;
    align-items:center;
}
.conversations h2 svg{
    margin-right: 8px; 
    vertical-align: middle;
    }
.conversations ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}
.conversations li {
    display: flex;
    align-items: center;
    padding: 10px;
    border-bottom: 1px solid #eee;
    transition: background-color 0.3s;
}
.conversations li:hover {
    background-color: #f0f2f5;
}
.conversations .username {
    font-size: 16px;
    font-weight: bold;
    margin-right: 10px;
    color: #333;
}

.conversations .visit-link {
    flex-grow: 1;
    display: flex;
    justify-content: flex-end;
}

.conversations .header a {
    color: #0078D7;
    font-weight: 500;
    padding: 5px 10px;
    border-radius: 5px;
    background-color: #0078D7;
    color: #fff;
    transition: background-color 0.3s;
    display:flex;
    align-items:center;
}
.conversations .header a svg{
    margin-right: 8px; 
    vertical-align: middle;
}
.conversations .header div {
display:flex;
align-items:center;
}
.conversations .header div svg{
    margin-right: 8px; 
    vertical-align: middle; 
}

.conversations .header a:hover {
    background-color: #005a9e;
}

.conversations .latest-message {
    font-size: 14px;
    color: #666;
    flex-grow: 1;
}


.conversations .username-and-message {
    display: flex;
    flex-direction: column;
    justify-content: center;
    flex-grow: 1;
}

        .conversations .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .conversations a {
    text-decoration: none;
    color: inherit;
}

        .profile-section {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .profile-section .profile-info {
            display: flex;
            flex-direction: row;
        }

        .profile-section .profile-info .username {
            font-size: 18px;
            font-weight: bold;
        }
        .options{
            margin-right:20px;
            font-size: 16px;
            text-decoration:none;
            display:flex;
            align-items:center;
        }
        .options a{
            text-decoration:none;
            color:black;
        }
        .options:hover{
            text-decoration:none;
            color:black;
            background-color:white;
            font-size: 16.5px;
        }
        
        
        .options svg{
            margin-right: 8px; 
            vertical-align: middle; 
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .main-container {
                padding: 10px;
            }

            .search-container form {
                flex-direction: column;
            }

            .search-container input[type="text"] {
                margin-bottom: 10px;
            }
        }
    </style>
    <script>
        function validateForm() {
            var username = document.forms["searchForm"]["username"].value;
            if (username === "") {
                alert("Search query cannot be empty.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
<iframe class="background-iframe" src="techbg.php" allowfullscreen></iframe>

<div class="main-container">
    <!-- Conversations section -->
    <div class="conversations">
        <div class="header">
            <a href="Add_System.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-house"><path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/><path d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
            Home</a>
            <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>    
            <?php echo htmlspecialchars($user_data['username']); ?></div>
        </div>
        <h2>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>    
        Messages</h2>
        <ul>
        <?php foreach ($convoUsers as $user): ?>
            <a href="contact.php?G7x2L9K4mB1T3V8QJ6=<?php echo base64_encode($user['userid']); ?>&R5w8N2P9dC4X7Z1V0F=<?php echo htmlspecialchars(base64_encode($user['username'])); ?>">
                <li>
                    
                    <div class="username-and-message">
                        <span class="username">
                            
                        <?php echo htmlspecialchars($user['username']); ?></span>
                        <div class="latest-message">
                            <?php echo htmlspecialchars($latestMessages[$user['userid']]['message']); ?>
                        </div>
                    </div>
                    <span class="visit-link">
                    </span>
                </li>
            </a>
        <?php endforeach; ?>
    </ul>
    </div>

    <!-- Search and Results section -->
    <div class="search-container">
        <form name="searchForm" action="search.php" method="POST" onsubmit="return validateForm()">
            <input type="text" name="username" placeholder="Search for users" value="<?php echo htmlspecialchars($searchQuery); ?>">
            <input type="submit" value="Search">
        </form>
    </div>
    <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($searchQuery)): ?>
        <div class="search-results">
            <?php if ($result): ?>
                <h2>Search Results:</h2>
                <ul>
                    <?php foreach ($result as $row): ?>
                        <li style="display:flex; justify-content:space-between;">
                            <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>    
                            <?php echo htmlspecialchars($row['username']); ?></span>
                            </div>
                            <div>
                            <span class="username">

                            <span class="options">
                                <a href="visitprofile.php?H7k3B9tR5X=<?php echo base64_encode($row['userid']); ?>&L2m8V4zQ7Y=<?php echo htmlspecialchars(base64_encode($row['username'])); ?>&N1w6C3J9F=<?php echo htmlspecialchars(base64_encode($row['university'])); ?>&P4x7R2dQ8L=<?php echo htmlspecialchars(base64_encode($row['biography'])); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-person-standing"><circle cx="12" cy="5" r="1"/><path d="m9 20 3-6 3 6"/><path d="m6 8 6 2 6-2"/><path d="M12 10v4"/></svg>
                                Profile</a>
                            </span>
                            <span class="options"><a href="contact.php?G7x2L9K4mB1T3V8QJ6=<?php echo base64_encode($row['userid']); ?>&R5w8N2P9dC4X7Z1V0F=<?php echo htmlspecialchars(base64_encode($row['username'])); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-more"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><path d="M8 10h.01"/><path d="M12 10h.01"/><path d="M16 10h.01"/></svg>
                            Contact</a></span>
                            <span class="options"><a href="visit.php?A9R4V2k8T7L1X5M3Q=<?php echo base64_encode($row['userid']); ?>&J6N8W1F9C2P7D4L0Z=<?php echo urlencode(base64_encode($row['username'])); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-telescope"><path d="m10.065 12.493-6.18 1.318a.934.934 0 0 1-1.108-.702l-.537-2.15a1.07 1.07 0 0 1 .691-1.265l13.504-4.44"/><path d="m13.56 11.747 4.332-.924"/><path d="m16 21-3.105-6.21"/><path d="M16.485 5.94a2 2 0 0 1 1.455-2.425l1.09-.272a1 1 0 0 1 1.212.727l1.515 6.06a1 1 0 0 1-.727 1.213l-1.09.272a2 2 0 0 1-2.425-1.455z"/><path d="m6.158 8.633 1.114 4.456"/><path d="m8 21 3.105-6.21"/><circle cx="12" cy="13" r="2"/></svg>
                            Visit</a></span>
                            </div>

                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No users found.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Side content section -->
    <div class="side-content">
        <?php if (!empty($recentSearches)): ?>
            <div class="recent-searches">
                <h2>Recent Searches</h2>
                <ul>
                    <?php foreach ($recentSearches as $index => $search): ?>
                        <li>
                            <span class="username"><?php echo htmlspecialchars($search); ?></span>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="delete_index" value="<?php echo $index; ?>">
                                <span class="visit-link">
                                    <button type="submit" name="delete_recent" class="delete-button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                    Delete</button>
                                </span>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($suggestedUsers)): ?>
            <div class="suggested-users">
                <h2>Suggested Users</h2>
                <ul>
                    <?php foreach ($suggestedUsers as $user): ?>
                        <li style="display:flex; justify-content:space-between;">
                            <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>    
                            <?php echo htmlspecialchars($user['username']); ?></span>
                            </div>
                            <div>
                            <span class="username">

                            <span class="options">
                                <a href="visitprofile.php?H7k3B9tR5X=<?php echo base64_encode($user['userid']); ?>&L2m8V4zQ7Y=<?php echo htmlspecialchars(base64_encode($user['username'])); ?>&N1w6C3J9F=<?php echo htmlspecialchars(base64_encode($user['university'])); ?>&P4x7R2dQ8L=<?php echo htmlspecialchars(base64_encode($user['biography'])); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-person-standing"><circle cx="12" cy="5" r="1"/><path d="m9 20 3-6 3 6"/><path d="m6 8 6 2 6-2"/><path d="M12 10v4"/></svg>
                                Profile</a>
                            </span>
                            <span class="options"><a href="contact.php?G7x2L9K4mB1T3V8QJ6=<?php echo base64_encode($user['userid']); ?>&R5w8N2P9dC4X7Z1V0F=<?php echo htmlspecialchars(base64_encode($user['username'])); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-more"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><path d="M8 10h.01"/><path d="M12 10h.01"/><path d="M16 10h.01"/></svg>
                            Contact</a></span>
                            <span class="options"><a href="visit.php?A9R4V2k8T7L1X5M3Q=<?php echo base64_encode($user['userid']); ?>&J6N8W1F9C2P7D4L0Z=<?php echo urlencode(base64_encode($user['username'])); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-telescope"><path d="m10.065 12.493-6.18 1.318a.934.934 0 0 1-1.108-.702l-.537-2.15a1.07 1.07 0 0 1 .691-1.265l13.504-4.44"/><path d="m13.56 11.747 4.332-.924"/><path d="m16 21-3.105-6.21"/><path d="M16.485 5.94a2 2 0 0 1 1.455-2.425l1.09-.272a1 1 0 0 1 1.212.727l1.515 6.06a1 1 0 0 1-.727 1.213l-1.09.272a2 2 0 0 1-2.425-1.455z"/><path d="m6.158 8.633 1.114 4.456"/><path d="m8 21 3.105-6.21"/><circle cx="12" cy="13" r="2"/></svg>
                            Visit</a></span>
                            </div>

                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>


