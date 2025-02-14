<?php
session_start();

include("classes/connect.php");
include("classes/login.php");

$login = new Login();
$user_data = $login->check_login($_SESSION['nls_db_userid']);
$userid = $_SESSION['nls_db_userid'];


$id = base64_decode($_GET['H7k3B9tR5X']);
$username = base64_decode($_GET['L2m8V4zQ7Y']);
$school = base64_decode($_GET['N1w6C3J9F']);
$bio = base64_decode($_GET['P4x7R2dQ8L']);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($username); ?>'s Profile</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f0f0f0;
            margin: 0;

            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            height: 100vh;
            box-sizing: border-box;
        }

        .main {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            width: 100%;
            height:70vh;
            max-width: 800px;
            border-radius: 8px;
            background-color: white;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
            padding: 20px;
            box-sizing: border-box;
            position: relative;
        }

        label {
            font-weight: 600;
            margin-bottom: 8px;
        }

        .profile-info {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            background-color: #f9f9f9;
            margin-bottom: 20px;
            color: #555;
            box-sizing: border-box;
        }

        textarea.profile-info {
            resize: none;
            height: 150px;
            font-family: 'Roboto', sans-serif;
        }


        .cancelButton a {
            color: white;
            background-color: #0078D7;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            position: absolute;
            top: 20px;
            left: 20px;
            transition: background-color 0.3s;
            display:flex;
            align-items:center;
        }
        .cancelButton a svg{
            margin-right: 8px; 
            vertical-align: middle; 
        }

        .cancelButton a:hover {
            background-color: #005a9e;
        }

        .visit-link a {
            color: white;
            background-color: #0078D7;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            position: absolute;
            top: 20px;
            right: 20px;
            transition: background-color 0.3s;
            display:flex;
            align-items:center;
        }
        .visit-link a svg{
            margin-right: 8px; 
            vertical-align: middle; 
        }

        .visit-link a:hover {
            background-color: #005a9e;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
            width: 100%;
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

        @media (max-width: 1200px) {

            body{
                margin:0;
            }

            .visit-link a {
            color: white;
            background-color: #0078D7;
            padding: 15px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 20px;
            font-weight: 500;
            position: absolute;
            top: 20px;
            right: 20px;
            transition: background-color 0.3s;
        }
        .cancelButton a {
            color: white;
            background-color: #0078D7;
            padding: 15px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 20px;
            font-weight: 500;
            position: absolute;
            top: 20px;
            left: 20px;
            transition: background-color 0.3s;
        }
        }

        @media (max-width: 520px) {

            .profile-info {
                font-size: 14px;

            }

            .visit-link a {
            color: white;
            background-color: #0078D7;
            padding: 12px 17px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 20px;
            font-weight: 500;
            position: absolute;
            top: 20px;
            right: 20px;
            transition: background-color 0.3s;
        }
        .cancelButton a {
            color: white;
            background-color: #0078D7;
            padding: 12px 17px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 20px;
            font-weight: 500;
            position: absolute;
            top: 20px;
            left: 20px;
            transition: background-color 0.3s;
        }
        }
    </style>
</head>
<body>
    <iframe class="background-iframe" src="techbg.php" allowfullscreen></iframe>

    <span class="cancelButton"><a href="search.php">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>    
    Back</a></span>
    <span class="visit-link">
    <a href="visit.php?A9R4V2k8T7L1X5M3Q=<?php echo base64_encode($id); ?>&J6N8W1F9C2P7D4L0Z=<?php echo urlencode(base64_encode($username)); ?>">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-telescope"><path d="m10.065 12.493-6.18 1.318a.934.934 0 0 1-1.108-.702l-.537-2.15a1.07 1.07 0 0 1 .691-1.265l13.504-4.44"/><path d="m13.56 11.747 4.332-.924"/><path d="m16 21-3.105-6.21"/><path d="M16.485 5.94a2 2 0 0 1 1.455-2.425l1.09-.272a1 1 0 0 1 1.212.727l1.515 6.06a1 1 0 0 1-.727 1.213l-1.09.272a2 2 0 0 1-2.425-1.455z"/><path d="m6.158 8.633 1.114 4.456"/><path d="m8 21 3.105-6.21"/><circle cx="12" cy="13" r="2"/></svg>    
    Visit</a></span>

    <div class="main">
        <div class="form-group">
            <label for="username">Username:</label>
            <div class="profile-info"><?php echo htmlspecialchars($username); ?></div>
        </div>
        <div class="form-group">
            <label for="school">School:</label>
            <div class="profile-info"><?php echo htmlspecialchars($school); ?></div>
        </div>
        <div class="form-group">
            <label for="biography">Biography:</label>
            <textarea class="profile-info" readonly><?php echo htmlspecialchars($bio); ?></textarea>
        </div>
    </div>
</body>
</html>





