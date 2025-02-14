<?php

include("classes/connect.php");
include("classes/signup.php");

$username = "";
$email =  "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $signup = new Signup();
    $result = $signup->evaluate($_POST);

    if ($result != "") {
        echo "<div class='error'>";
        echo "<br>The following errors occurred:<br><br>";
        echo $result;
        echo "</div>";
    } else {
        header("Location: login.php");
        die;
    }

    $username = $_POST['username'];
    $email = $_POST['email'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NLS | Signup</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f4f4f4;
        }

        #bar {
            width: 100%;
            height: 50px;
            background-color: #0078D4;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            position: fixed;
            top: 0;
            z-index: 100;
        }

        #title {
            font-size: 18px;
            font-weight: 700;
        }

        #signup_button {
            background-color: white;
            color: #0078D4;
            font-size: 14px;
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        #signup_button:hover {
            background-color: #e1e1e1;
        }

        #bar2 {
            background-color: white;
            width: 90%;
            max-width: 400px;
            margin-top: 80px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            box-sizing: border-box;
        }

        #text {
            height: 40px;
            width: 100%;
            border-radius: 4px;
            border: solid 1px #ddd;
            padding: 0 10px;
            font-size: 14px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        #button {
            width: 100%;
            height: 40px;
            border-radius: 4px;
            font-weight: bold;
            border: none;
            background-color: #0078D4;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #button:hover {
            background-color: #005a9e;
        }

        .background-iframe {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
            z-index: -1;
            object-fit: cover;
            filter: brightness(50%);
        }

        @media (max-width: 768px) {
            #title {
                font-size: 16px;
            }

            #signup_button {
                font-size: 12px;
                padding: 5px 10px;
            }

            #bar2 {
                width: 95%;
                margin-top: 60px;
                padding: 15px;
            }
        }

        @media (max-width: 480px) {
            #title {
                font-size: 14px;
            }

            #signup_button {
                font-size: 10px;
                padding: 4px 8px;
            }

            #bar2 {
                width: 100%;
                margin-top: 50px;
                padding: 10px;
            }

            #text {
                font-size: 12px;
            }

            #button {
                height: 36px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <iframe class="background-iframe" src="bird.php" allowfullscreen></iframe>
    
    <div id="bar">
        <div id="title">Numerical Leitner System</div>
        <a href="login.php" id="signup_button">Login</a>
    </div>

    <div id="bar2">
        <form method="post" action="index.php">
            <input name="username" type="text" id="text" placeholder="Username" required><br>
            <input name="email" type="email" id="text" placeholder="Email" required><br>
            <input name="password" type="password" id="text" placeholder="Password" required><br>
            <input name="password2" type="password" id="text" placeholder="Confirm Password" required><br>
            <input type="submit" id="button" value="Sign up">
        </form>
    </div>
</body>
</html>

