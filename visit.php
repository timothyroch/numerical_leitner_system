<?php
session_start();

// Include your database connection file
include("classes/connect.php");
include("classes/card.php");
include("classes/login.php");


//isset
$login = new Login();
$user_data = $login->check_login($_SESSION['nls_db_userid']);

$userid =  base64_decode($_GET['A9R4V2k8T7L1X5M3Q']);
$username = base64_decode($_GET['J6N8W1F9C2P7D4L0Z']);

// Fetch systems belonging to the logged-in user
$systemObj = new SystemCard();
$id = $userid;
$folders = $systemObj->get_public_folder($id);



// Fetch systems from the database
$systemObj = new SystemCard();
$systems = $systemObj->get_public_system(null);



?>









<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visiting <?php echo htmlspecialchars($username); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            animation: fadeIn 1s;
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        .background-iframe {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
            z-index: -1;
        }

        #cancelButton {
            padding: 5px 10px;
            font-size: 14px;
            font-weight: 500;
            color: #0078D7;
            text-decoration: none;
            border: 1px solid #0078D7;
            border-radius: 5px;
            position: absolute;
            top: 20px;
            left: 20px;
            transition: background-color 0.3s, color 0.3s;
        }

        #cancelButton:hover {
            background-color: #0078D7;
            color: #ffffff;
        }

        #core {
            max-width: 900px;
            margin: 1.5% auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 90%;
        }

        #bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #0078d4;
            color: white;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        #bar a{
color:white;
text-decoration:none;
display:flex;
align-items:center;
        }
        #bar a svg{
            margin-right: 8px; 
            vertical-align: middle; 
}
#bar a:hover{
opacity:70%;
}

        #bar h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 500;
            display:flex;
            align-items:center;
        }
        #bar h2 svg{
            margin-right: 8px; 
            vertical-align: middle; 
}

        .system-container {
            margin-top: 20px;
            padding: 10px;
            background-color: #f5f5f5;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .system-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .no-systems {
            text-align: center;
            color: #888;
            font-size: 18px;
            margin-top: 20px;
        }

        /* Media Queries for Responsiveness */
        @media (max-width: 768px) {
            #core {
                width: 95%;
                padding: 15px;
            }

            #bar h2 {
                font-size: 16px;
            }

            .system-container {
                padding: 8px;
            }

            #cancelButton {
                padding: 4px 8px;
                font-size: 12px;
                top: 15px;
                left: 15px;
            }
        }

        @media (max-width: 480px) {
            #bar {
                flex-direction: column;
                align-items: flex-start;
            }

            #bar h2 {
                font-size: 14px;
                margin-bottom: 10px;
            }

            #cancelButton {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <iframe class="background-iframe" src="techbg.php" allowfullscreen></iframe>


    <div id="core">
        <div id="bar">
        <a href="search.php">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-door-open"><path d="M13 4h3a2 2 0 0 1 2 2v14"/><path d="M2 20h3"/><path d="M13 20h9"/><path d="M10 12v.01"/><path d="M13 4.562v16.157a1 1 0 0 1-1.242.97L5 20V5.562a2 2 0 0 1 1.515-1.94l4-1A2 2 0 0 1 13 4.561Z"/></svg>
        Return</a>
            <h2>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>    
            Visiting <?php echo htmlspecialchars($username); ?></h2>
        </div>

        <?php if ($folders): ?>
            <?php foreach ($folders as $folder): ?>
                <?php include("visitfolder.php"); // Include card template ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-systems"><?php echo htmlspecialchars($username); ?> has no folder</div>
        <?php endif; ?>
    </div>


</body>
</html>
