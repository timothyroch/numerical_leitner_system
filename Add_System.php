<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("classes/connect.php");
include("classes/create_folder.php");
include("classes/card.php");
include("classes/create_system.php");
include("classes/login.php");


// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Check if user is logged in
$login = new Login();
$user_data = $login->check_login($_SESSION['nls_db_userid']);

// Fetch systems belonging to the logged-in user
$systemObj = new SystemCard();
$id = $_SESSION['nls_db_userid'];
$folders = $systemObj->get_folder($id);

//select folderid to make a variable
// Fetch folder IDs
$DB = new Database();
$query = "SELECT folderid FROM folder";
$result = $DB->read($query);

if ($result && isset($result[0]['folderid'])) {
    $folderid = $result[0]['folderid']; // Use the first folderid from the result
    $DB = new Database();
    // Fetch visibility based on folderid
    $query = "SELECT visibility FROM folder WHERE folderid = '$folderid'";
    $result = $DB->read($query);
    $visibility = $result ? $result[0]['visibility'] : 0;
} else {
    $visibility = 0; // Default to private if no folderid found
}


// Initialize $name
$name = "";

// Fetch systems from the database
$systemObj = new SystemCard();
$systems = $systemObj->get_system(null);


// Process form submission to create a new folder and systems
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['name']) && !empty($_POST['name'])) {
        $name = $_POST['name'];

        $create = new Folder();
        $id = $_SESSION['nls_db_userid'];

        if ($create->create_folder($_POST)) {
            // Redirect to another page after adding the system
            header("Location: Add_System.php");
            die;
        }
    } elseif (isset($_POST['systemname']) && isset($_POST['folderid']) && !empty($_POST['systemname'])) {
        // Create system
        $folder_id = $_POST['folderid'];
        $systemname = $_POST['systemname'];
        $create = new Create();
        $create->create_system($folder_id, ['systemname' => $systemname]);
        header("Location: Add_System.php");
        die;
    } elseif (isset($_POST['folder_visibility'])) { // Changed to elseif
        // Create new Database object
        $DB = new Database();
        $conn = $DB->connect();
        
        // Escape folder ID
        $folderid = mysqli_real_escape_string($conn, $_POST['folder_visibility']);
        
        // Determine visibility based on checkbox presence
        $visibility = isset($_POST['visibility']) && $_POST['visibility'] === 'on' ? 1 : 0;
        
        // Update folder visibility
        $query = "UPDATE folder SET visibility = '$visibility' WHERE folderid = '$folderid'";
        $result = $DB->save($query);
    
        if ($result) {
            header("Location: Add_System.php");
            echo "Visibility updated successfully.";
        } else {
            echo "Failed to update visibility.";
        }
    } else {
        echo "No folder ID provided.";
    }
    
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NLS | Leitner System</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f0f0;
            color: #333;
            margin: 0;
            padding: 0;
        }

        #sidebar {
    width: 100%; 
    color: #fff;
    background-color: #0078d4;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    padding: 10px 20px; 
    position: fixed;
    top: 0;
    left: 0;
    z-index: 100;
    display: flex;
    justify-content: space-between; 
    align-items: center; 
    flex-wrap: wrap; 
}

#sidebar h2 {
    margin: 0;
    font-size: 18px; 
    text-align: left;
}

#sidebaruser {
    display: flex;
    align-items: center; 
    margin-right: 50px;
}

#sidebaruser a {
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    margin: 0 10px; 
    padding: 8px 12px; 
    border-radius: 4px; 
    transition: background-color 0.3s, color 0.3s; 
    display: flex;
    align-items:center;
}
#sidebaruser a svg{
    margin-right: 8px; 
    vertical-align: middle; 
}
#sidebaruser div {
    display: flex;
    align-items:center;
}
#sidebaruser div svg{
    margin-right: 8px; 
    vertical-align: middle; 
}

#sidebaruser a:hover {
    background-color: #005a9e; 
    color: #fff; 
}


        #core {
            margin-top: 30px;
            padding: 20px;
        }

        #bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #0078d4;
            color: #fff;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        #bar h2 {
            margin: 0;
            font-size: 20px;
        }

        #add-button {
            background-color: #005a9e;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
            display: flex;
            align-items:center;
        }
        #add-button svg {
    margin-right: 8px; 
    vertical-align: middle; 
}

        #add-button:hover {
            background-color: #004080;
        }

        .no-systems {
            text-align: center;
            color: #333;
            font-size: 18px;
            margin-top: 20px;
        }

        /* Popup Styles */
        #popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            border-radius: 10px;
            display: none;
            z-index: 1000;
            width: 90%;
            max-width: 400px;
            transition: opacity 0.3s, transform 0.3s;
            opacity: 0;
        }

        #popup.show {
            opacity: 100%;
            display: block;
        }
        #core.show {
            opacity: 20%;
        }


        #popup h3 {
            margin: 0 0 20px;
            font-size: 1.5rem;
            color: #333;
            font-weight: 600;
        }

        #popup form {
            display: flex;
            flex-direction: column;
        }

        #popup input[type="text"] {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            color: #333;
            outline: none;
        }

        #popup button {
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
        }

        #popup button[type="submit"] {
            background-color: #0078d4;
            color: #fff;
            margin-bottom: 10px;
        }

        #popup button[type="button"] {
            background-color: #f3f3f3;
            color: #333;
        }

.menu-toggle {
    display: none; /* Hidden by default */
}
#sidebaruseri {
                display: none;
            }


        /* Responsive Layout */
        @media (min-width: 1300px) {

            #sidebari {
   display: none;
            }
            #sidebar {
    width: 15%; 
    height: 100vh; 
    position: fixed;
    top: 0;
    left: 0;
    z-index: 100;
    padding: 20px;
    display: flex;
    flex-direction: column; 
    justify-content: flex-start; 
    align-items: flex-start; 
    background-color: #0078d4; 
    color: white;
    border-radius: 0 10px 10px 0; 
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1); 
}

#sidebar h2 {
    margin: 0;
    font-size: 32px; 
    text-align: center; 
    border-bottom: 2px solid #005a9e; 
    padding-bottom: 10px;
    width: 100%; 
}

#sidebaruser {
    display: flex;
    flex-direction: column; 
    width: 100%; 
    margin-top: 20px; 
}

#sidebaruser a {
    display: block; 
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    margin: 10px 0; 
    padding: 10px 15px; 
    border-radius: 5px; 
    transition: background-color 0.3s, color 0.3s; 
    display:flex;
    align-items:center;
}
#sidebaruser a svg{
    margin-right: 8px; 
    vertical-align: middle; 
}
#sidebaruser div {

display: flex;
align-items:center;
}
#sidebaruser div svg{
margin-right: 8px; 
vertical-align: middle; 
}

#sidebaruser a:hover {
    background-color: #005a9e; 
    color: #fff; 
}



            #core {

                margin-top: 0px;
                margin-left: 17%;
                padding: 20px;
                background-color: #fff;
                border-radius: 10px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                min-height: 100vh;
            }

            #bar {
                background-color: #0078d4;
                color: white;
                padding: 15px;
                border-radius: 5px;
                margin-bottom: 20px;
            }
        }
        @media (max-width: 768px) {

            #sidebar {
                display: block;
    width: 100%; 
    height: 70px;
    color: #fff;
    background-color: #0078d4;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    padding: 10px 20px; 
    position: fixed;
    top: 0;
    left: 0;
    z-index: 100;
    display: flex;
    justify-content: end; 
    align-items: center; 
    flex-wrap: wrap; 
}

#sidebar h2 {
    display: none;

}

#sidebaruser {
    display: none;

}

#sidebaruser a {
display: none;
}
.menu-toggle {
    position: fixed;
    top: 15px;
    left: 15px;
    z-index: 200; 
    font-size: 24px;
    color: #0078d4;
    cursor: pointer;
    background: #fff;
    border: 1px solid #0078d4;
    border-radius: 5px;
    padding: 10px;
}

            #sidebari {
                width: 90%;
    height: 100vh; /* Full viewport height */
    position: fixed;
    top: 0;
    left: 0;
    z-index: 100;
    padding: 20px;
    display: flex;
    flex-direction: column; 
    justify-content: flex-start; 
    align-items: flex-start; 
    background-color: #0078d4; 
    color: white;
    border-radius: 0 10px 10px 0; 
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1); 
    left: -110%; 
    transition: left 0.3s ease; 
}
#sidebari h2 {
    margin: 0;
    font-size: 32px; 
    text-align: center; 
    border-bottom: 2px solid #005a9e; 
    padding-bottom: 10px;
    width: 100%; 
}

#sidebaruseri {
    display: visible; 
    display: flex;
    flex-direction: column; 
    width: 100%; 
    margin-top: 20px; 
}

#sidebaruseri a {
    display: block; 
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    margin: 10px 0; 
    padding: 10px 15px; 
    border-radius: 5px; 
    transition: background-color 0.3s, color 0.3s; 
    display: flex;
    align-items:center;
}
#sidebaruseri a svg{
    margin-right: 8px; 
    vertical-align: middle; 
}
#sidebaruseri div {

    display: flex;
    align-items:center;
}
#sidebaruseri div svg{
    margin-right: 8px; 
    vertical-align: middle; 
}

#sidebaruseri a:hover {
    background-color: #005a9e; 
    color: #fff; 
}

#core {
                margin-top: 80px;
                padding: 20px;
                background-color: #fff;
                border-radius: 10px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                min-height: 100vh;
            }

    .menu-toggle {
        display: block; 
    }

    #sidebari.open {
        left: 0; 
    }
}
    </style>
</head>
<body>

    <!-- Sidebar for PC and Mobile -->
    <div id="sidebar">
        <h2>NLS</h2>

        <div id="sidebaruser">
            <div class="user">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <?php echo $user_data['username']; ?>
        </div>
            <a href="editprofile.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>
            Edit Profile</a>
            <a href="javascript:void(0);" onclick="confirmLogout()">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
            Logout</a>
            <a href="search.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map"><path d="M14.106 5.553a2 2 0 0 0 1.788 0l3.659-1.83A1 1 0 0 1 21 4.619v12.764a1 1 0 0 1-.553.894l-4.553 2.277a2 2 0 0 1-1.788 0l-4.212-2.106a2 2 0 0 0-1.788 0l-3.659 1.83A1 1 0 0 1 3 19.381V6.618a1 1 0 0 1 .553-.894l4.553-2.277a2 2 0 0 1 1.788 0z"/><path d="M15 5.764v15"/><path d="M9 3.236v15"/></svg>
            Navigate</a>
        </div>
    </div>
                <!-- Mobile Menu Button -->
                <div id="menu-toggle" class="menu-toggle">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-align-left"><line x1="21" x2="3" y1="6" y2="6"/><line x1="15" x2="3" y1="12" y2="12"/><line x1="17" x2="3" y1="18" y2="18"/></svg>
        </div>

        <!-- Sidebar iphones -->
        <div id="sidebari">
        <h2>NLS</h2>
        <div id="sidebaruseri">
            <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>    
            <?php echo $user_data['username']; ?></div>
            <a href="editprofile.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>    
            Edit Profile</a>
            <a href="javascript:void(0);" onclick="confirmLogout()">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>    
            Logout</a>
            <a href="search.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map"><path d="M14.106 5.553a2 2 0 0 0 1.788 0l3.659-1.83A1 1 0 0 1 21 4.619v12.764a1 1 0 0 1-.553.894l-4.553 2.277a2 2 0 0 1-1.788 0l-4.212-2.106a2 2 0 0 0-1.788 0l-3.659 1.83A1 1 0 0 1 3 19.381V6.618a1 1 0 0 1 .553-.894l4.553-2.277a2 2 0 0 1 1.788 0z"/><path d="M15 5.764v15"/><path d="M9 3.236v15"/></svg>    
            Navigate</a>
        </div>
    </div>





<div id="core">
    <div id="bar">
        <h2>Workspace</h2>
        <button id="add-button" onclick="showAdd()">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
        Add a Folder
    </button>
    </div>

    <?php if ($folders): ?>
        <?php foreach ($folders as $folder): ?>
            <?php include("folder.php"); ?>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="no-systems">You have no systems.</div>
    <?php endif; ?>
</div>

<div id="popup">
    <h3>Create Your New Folder</h3>
    <form method="post" action="Add_System.php">
        <input type="text" placeholder="Type folder name..." name="name" value="<?php echo htmlspecialchars($name); ?>">
        <button type="submit">Create</button>
        <button type="button" onclick="hideAdd()">Cancel</button>
    </form>
</div>

<script>
    function showAdd() {
        document.getElementById('popup').classList.add('show');
        document.getElementById('core').classList.add('show');
    }

    function hideAdd() {
        document.getElementById('popup').classList.remove('show');
        document.getElementById('core').classList.remove('show');
    }

    function confirmLogout() {
        const confirmed = confirm("Are you sure you want to log out?");
        if (confirmed) {
            window.location.href = "logout.php";
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menu-toggle');
    const sidebari = document.getElementById('sidebari');

    menuToggle.addEventListener('click', function() {
        sidebari.classList.toggle('open');
    });
});

</script>

</body>
</html>





