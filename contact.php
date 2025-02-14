<?php
include("classes/connect.php");
include("classes/login.php");

// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
$login = new Login();
$user_data = $login->check_login($_SESSION['nls_db_userid']);

// Get the user ID and name from the URL parameters
$userid = htmlspecialchars(base64_decode($_GET['G7x2L9K4mB1T3V8QJ6']));
$username = htmlspecialchars(base64_decode($_GET['R5w8N2P9dC4X7Z1V0F']));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $a = $_POST['from'];
    $b = $_POST['to'];
    $c = $_POST['message'];

    // Escape the input data to prevent SQL injection
    $DB = new Database();
    $conn = $DB->connect();

    $from = mysqli_real_escape_string($conn, $a);
    $to = mysqli_real_escape_string($conn, $b);
    $message = mysqli_real_escape_string($conn, $c);

    // SQL query to insert the new card
    $query = "INSERT INTO messages (deliver, receiver, message) VALUES ('$from', '$to', '$message')";

    // Save the query
    $result = $DB->save($query);

    if ($result) {
        header("Location: contact.php?G7x2L9K4mB1T3V8QJ6=" . urlencode(base64_encode($userid)) . "&R5w8N2P9dC4X7Z1V0F=" . urlencode(base64_encode($username)));
        exit();
    } else {
        echo "error in creating message";
    }
}

$I = $user_data['userid'];
$HE = $userid;

// Fetch all messages for the conversation
$DB = new Database();

$query = "SELECT * FROM messages WHERE (deliver = '$I' AND receiver = '$HE') OR (deliver = '$HE' AND receiver = '$I') ORDER BY published ASC";
$messages = $DB->read($query);


// Fetch all messages for the conversation
$DB = new Database();

$query = "SELECT * FROM users WHERE userid = '$userid'";
$users = $DB->read($query);
$user = $users[0]; // If read returns an array of results


?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($username); ?></title>
    <style>
        body {
            margin: 0;
            background-color: #f0f0f0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .header{
          margin-top: 0%;
          width: 100%;
          height: 5%;
          background-color: white;
          display: flex;
          align-items: center;
          justify-content: space-between;
        }
        .header p{
            display:block;
          font-weight: bold;
          font-size: 20px;
          color: #0078D7;
        }
        #cancelButton {
            padding: 10px 15px;
            font-size: 14px;
            font-weight: 500;
            color: #0078D7;
            text-decoration: none;
            display:flex;
            align-items:center;
        }
        #cancelButton svg{
            margin-right: 8px; 
            vertical-align: middle; 
        }
        #cancelButton:hover {
            opacity:70%;
        }
        .form {
            position: fixed;
            bottom: 0;
            width: 100%;
            background: #fff;
            padding: 10px 20px;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .form textarea {
            width: 80%;
            height: 50px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin-right: 10px;
        }
        .convo {
          margin-top: 0.5%;
            margin-bottom: 70px;
            padding: 20px;
            max-height: 70vh;
            height:auto;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .convo p{
          position: absolute;
          z-index: -1;
          height: 30%;
          top: 35%;
          width: 15%;
          left: 42.5%;
          font-weight: bold;
          color: #0078D7;
          font-size: 6vh;
          opacity: 20%;
          display: flex;
          align-items: center;
          justify-content: center;
          text-align: center;
        }
        .message {
            display: flex;
            flex-direction: column;
            max-width: 70%;
            margin: 10px 0;
            padding: 10px 15px;
            border-radius: 15px;
            line-height: 1.4;
        }
        .message.sent {
            align-self: flex-end;
            background-color: #0078D7;
            color: white;
            border-radius: 15px 15px 0 15px;
            width: 30%;
        }
        .message.received {
            align-self: flex-start;
            background-color: #e1e1e1;
            color: #333;
            border-radius: 15px 15px 15px 0;
            width: 30%;
        }
        .timestamp {
            font-size: 12px;
            margin-top: 5px;
            color: #999;
            text-align: right;
        }
        input[type="submit"] {
            border: 1px solid #0078D7;
            color: white;
            background-color: #0078D7;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, border-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #005bb5;
            border-color: #005bb5;
        }
        .visit-link{
 display:flex;
 flex-direction:row;
        }
        .visit-link a{
            
          padding: 10px 15px;
            font-size: 14px;
            font-weight: 500;
            color: #0078D7;
            text-decoration: none;
            display:flex;
            align-items:center;
}
.visit-link svg{
            margin-right: 8px; 
            vertical-align: middle; 
        }
.visit-link a:hover {
     opacity:70%;
        }

        @media (max-width:1030px) {
            .message.sent {
            align-self: flex-end;
            background-color: #0078D7;
            color: white;
            border-radius: 15px 15px 0 15px;
            width: 60%;
        }
        .message.received {
            align-self: flex-start;
            background-color: #e1e1e1;
            color: #333;
            border-radius: 15px 15px 15px 0;
            width: 60%;
        }
        .form textarea {
            width: 60%;
            height: 50px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin-right: 10px;
        }
        .header p{
            display:none;
        }
        }
    </style>
</head>
<body>

<div class="header">
<a href="search.php" id="cancelButton">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0078D7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>    
Back</a>
<p><?php echo $username ?></p>


<div class="visit-link">
    <a href="visitprofile.php?H7k3B9tR5X=<?php echo base64_encode($user['userid']); ?>&L2m8V4zQ7Y=<?php echo htmlspecialchars(base64_encode($user['username'])); ?>&N1w6C3J9F=<?php echo htmlspecialchars(base64_encode($user['university'])); ?>&P4x7R2dQ8L=<?php echo htmlspecialchars(base64_encode($user['biography'])); ?>">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0078d7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-person-standing"><circle cx="12" cy="5" r="1"/><path d="m9 20 3-6 3 6"/><path d="m6 8 6 2 6-2"/><path d="M12 10v4"/></svg>    
    Profile</a>
&nbsp
<a href="visit.php?A9R4V2k8T7L1X5M3Q=<?php echo base64_encode($user['userid']); ?>&J6N8W1F9C2P7D4L0Z=<?php echo urlencode(base64_encode($user['username'])); ?>">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0078d7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-telescope"><path d="m10.065 12.493-6.18 1.318a.934.934 0 0 1-1.108-.702l-.537-2.15a1.07 1.07 0 0 1 .691-1.265l13.504-4.44"/><path d="m13.56 11.747 4.332-.924"/><path d="m16 21-3.105-6.21"/><path d="M16.485 5.94a2 2 0 0 1 1.455-2.425l1.09-.272a1 1 0 0 1 1.212.727l1.515 6.06a1 1 0 0 1-.727 1.213l-1.09.272a2 2 0 0 1-2.425-1.455z"/><path d="m6.158 8.633 1.114 4.456"/><path d="m8 21 3.105-6.21"/><circle cx="12" cy="13" r="2"/></svg>    
Visit</a></div>


      </div>

<div class="convo">
    <?php if ($messages): ?>
        <?php foreach ($messages as $message): ?>
            <div class="message <?php echo $message['deliver'] == $I ? 'sent' : 'received'; ?>">
                <?php echo htmlspecialchars($message['message']); ?>
                <div class="timestamp"><?php echo htmlspecialchars($message['published']); ?></div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
       <?php echo ""; ?>
    <?php endif; ?>
    <p>Numerical<br>Leitner<br>System<p>
</div>

<form method="post" action="contact.php?G7x2L9K4mB1T3V8QJ6=<?php echo urlencode(base64_encode($userid)); ?>&R5w8N2P9dC4X7Z1V0F=<?php echo urlencode(base64_encode($username)); ?>" class="form">
    <input type="hidden" name="from" value="<?php echo $user_data['userid'] ?>">
    <input type="hidden" name="to" value="<?php echo $userid ?>">
    <textarea name="message" placeholder="Type here..." required></textarea>
    <input type="submit" value="Send">
</form>




</body>
</html>
