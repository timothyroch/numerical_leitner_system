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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <link href="https://fonts.googleapis.com/css?family=Baloo+Paaji&display=swap" rel="stylesheet">
    <style>
        :root {
            --background-light: #0078d4; /* Light blue background color */
            --primary-blue: #005a9e; /* Darker blue for the container */
            --text-light: #ffffff; /* White text color */
            --accent-blue: #004578; /* Even darker blue for accents */
        }

        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Baloo Paaji', cursive;
            background-color: var(--background-light); /* Set background color for the entire page */
            color: var(--text-light);
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden; /* Hide scrollbars */
        }

        .container {
            width: 90%;
            max-width: 600px;
            height: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            border-radius: 15px; /* Rounded corners for the container */
            text-align: center;
            padding: 20px;
            background-color: var(--background-light); /* Set background color for the entire page */
        }

        h1 {
            font-size: 3em;
            text-transform: uppercase;
            margin: 0;
            color: var(--text-light); /* Text color */
            line-height: 1.2;
        }

        h1 span {
            display: block;
            color: var(--text-light);
            transform: translateY(-20px);
            opacity: 0;
            animation: titleAnimation 3.5s ease forwards;
        }

        h1 span:nth-child(1) {
            animation-delay: 0.62s;
        }

        h1 span:nth-child(2) {
            animation-delay: 0.82s;
        }

        h1 span:nth-child(3) {
            animation-delay: 1.2s;
        }

        h1 span:last-child {
            color: var(--accent-blue);
            animation-delay: 1.4s;
        }

        @keyframes titleAnimation {
            0% {
                transform: translateY(-20px);
                opacity: 0;
            }
            40% {
                transform: translateY(0);
                opacity: 1;
            }
            80% {
                transform: translateY(0);
                opacity: 1;
            }
            100% {
                transform: translateY(20px);
                opacity: 0;
            }
        }

        /* Fade-out effect */
        .fade-out {
            transition: opacity 1s ease-out;
            opacity: 0;
        }
    </style>
</head>
<body>
    <section class="container">
        <h1 class="title">
            <span>Hi, nice</span>
            <span>to see</span>
            <span>you here</span>
            <span><?php echo htmlspecialchars($user_data['username']); ?></span>
        </h1>
    </section>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const titleAnimationDuration = 3500; // Duration of the title animation in milliseconds
            const fadeOutDuration = 1000; // Duration of the fade-out effect in milliseconds
            const totalDelay = titleAnimationDuration; // Total delay before starting fade-out

            // Function to handle the fade-out effect and redirect
            function fadeOutAndRedirect() {
                document.body.classList.add('fade-out');
                setTimeout(() => {
                    window.location.href = 'Add_System.php';
                }, fadeOutDuration); // Delay matches the fade-out duration
            }

            // Start the fade-out and redirect after the title animation completes
            setTimeout(fadeOutAndRedirect, totalDelay);
        });
    </script>
</body>
</html>
