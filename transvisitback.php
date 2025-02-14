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
$userid = htmlspecialchars(base64_decode($_GET['H3J7K9P1X2L8M4Q6R5']));
$username = htmlspecialchars(base64_decode($_GET['D8T4F1V9W2N6R3C7X0']));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaving <?php echo $username ?>'s workspace</title>
    <link href="https://fonts.googleapis.com/css?family=Baloo+Paaji&display=swap" rel="stylesheet">
    <style>
        /* Define CSS variables for colors */
        :root {
            --background-light: #0078d4;
            --primary-blue: #005a9e;
            --text-light: #ffffff;
            --accent-yellow: #f0e130;
        }

        /* Set default styles for the body and html */
        body, html {
            height: 100%;
            margin: 0;
            background: black;
            overflow: hidden;
            font-family: 'Baloo Paaji', cursive;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--text-light);
        }

        /* Style the canvas element */
        canvas {
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
        }

        /* Style the header */
        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 15%;
            margin-left: 1%;
            margin-top: 1%;
        }

        .header h1 {
            font-size: 2.5rem;
            margin: 0;
            color: #0078d4;
        }

        /* Style for the redirect link */
        .redirect-link {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 1em;
            color: #0078d4;
            text-decoration: none;
            z-index: 2;
        }

        .redirect-link:hover {
            text-decoration: underline;
        }

        /* Style the container for the message */
/* Style the container for the message */
/* Style the container for the message */
.container {
    width: 90%;
    max-width: 600px;
    height: 300px;
    display: flex;
    justify-content: center;
    align-items: center;
    position: absolute;
    border-radius: 15px;
    text-align: center;
    padding: 20px;
    z-index: 2;
    opacity: 1;
    transition: opacity 2s ease-out; /* Smooth transition */
}



        /* Style the message text */
        h1 {
            font-size: 2em;
            text-transform: uppercase;
            margin: 0;
            color: var(--accent-yellow);
            line-height: 1.2;
            animation: titleAnimation 1.9s ease forwards;
        }

        /* Style individual lines of the message */
        h1 span {
            display: block;
            opacity: 0;
            animation: fadeInOut 1.9s ease forwards;
        }

        /* Delay animations for each line of the message */
        h1 span:nth-child(1) { animation-delay: 0.2s; }
        h1 span:nth-child(2) { animation-delay: 0.4s; }
        h1 span:nth-child(3) { animation-delay: 0.6s; }
        h1 span:last-child { animation-delay: 0.8s; }

        /* Keyframes for the fade-in and fade-out effect */
        @keyframes fadeInOut {
            0% { opacity: 0; transform: translateY(-20px); }
            50% { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(20px); }
        }

        /* Class to fade out the container */
        .fade-out {
            opacity: 0;
            transition: opacity 2s ease-out; /* Smooth fade-out transition */
        }
    </style>
</head>
<body>
    <!-- Header with a title -->
    <div class="header"><h1>Numerical Leitner System</h1></div>
    <!-- Link to redirect to login -->
    <!-- Canvas element for the star animation -->
    <canvas id="canvas"></canvas>
    <!-- Container for the message text -->
    <section class="container">
        <h1 class="title">
            <span>Leaving</span>
            <span>workspace of</span>
            <span><?php echo $username; ?></span>
        </h1>
    </section>
    <script>
        // Number of stars
        const numStars = 200;
        // Initial speed of stars (stationary)
        const initialSpeed = 0;
        // Speed of stars when lightspeed effect is active
        const speedOfLight = 20;
        // Current speed of stars
        let speed = initialSpeed;
        // Array to store star objects
        const stars = [];

        // Get the canvas element and context
        const canvas = document.getElementById('canvas');
        const ctx = canvas.getContext('2d');

        // Function to resize the canvas to fit the window
        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }

        // Star object constructor
        function Star() {
            this.reset();
        }

        // Reset the star to a new random position
        Star.prototype.reset = function() {
            this.x = Math.random() * canvas.width;
            this.y = Math.random() * canvas.height;
            this.z = Math.random() * canvas.width;
            this.origX = this.x;
            this.origY = this.y;
        }

        // Update the star's position based on speed
        Star.prototype.update = function() {
            this.z -= speed;
            if (this.z <= 0) {
                this.reset();
            }
        };

        // Draw the star on the canvas
        Star.prototype.draw = function() {
            let x = (this.x - canvas.width / 2) * (canvas.width / this.z);
            x = x + canvas.width / 2;
            let y = (this.y - canvas.height / 2) * (canvas.width / this.z);
            y = y + canvas.height / 2;
            ctx.beginPath();
            ctx.arc(x, y, 1, 0, Math.PI * 2);
            ctx.fillStyle = 'white';
            ctx.fill();
        };

        // Initialize the stars by creating Star objects and pushing them to the stars array
        function initStars() {
            for (let i = 0; i < numStars; i++) {
                stars.push(new Star());
            }
        }

        // Animate the stars by updating and drawing them
        function animate() {
            ctx.fillStyle = 'black';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            for (let star of stars) {
                star.update();
                star.draw();
            }
            requestAnimationFrame(animate);
        }

        // Resize the canvas when the window is resized
        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();
        // Initialize and animate the stars
        initStars();
        animate();

        // Function to start the lightspeed effect by setting the speed
        function startLightspeed() {
            speed = speedOfLight;
        }

        // Function to fade out the message and start the lightspeed effect
        function fadeOutAndRedirect() {
            const container = document.querySelector('.container');
            container.classList.add('fade-out');
            setTimeout(startLightspeed, 600); // Start lightspeed after message fades out
            setTimeout(() => {
                window.location.href = 'search.php';
            }, 2200); // Redirect after a delay to allow lightspeed effect
        }

        // Set a timeout to fade out the message and start the lightspeed effect after a delay
        setTimeout(fadeOutAndRedirect, 1900); // Adjust delay to match the title animation
    </script>
</body>
</html>
