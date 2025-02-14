<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lightspeed Jump!</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .container {
            position: relative;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
            background: black;
        }

        .stars {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .star {
            position: absolute;
            width: 2px;
            height: 2px;
            background-color: white;
            animation: twinkle 1s infinite alternate;
        }

        @keyframes twinkle {
            from { opacity: 1; }
            to { opacity: 0.5; }
        }

        .spaceship {
            position: absolute;
            width: 50px;
            height: 30px;
            background-image: url('https://cdn.pixabay.com/photo/2018/08/07/14/14/spacecraft-3589965_960_720.png');
            background-size: cover;
            animation: fly 10s linear infinite;
            z-index: 2;
        }

        @keyframes fly {
            from { transform: translateX(-150px) translateY(10vh); }
            to { transform: translateX(100vw) translateY(10vh); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="stars"></div>
        <div id="spaceship" class="spaceship"></div>
    </div>
    <script>
        const starsContainer = document.querySelector('.stars');
        const spaceship = document.getElementById('spaceship');

        function createStar() {
            const star = document.createElement('div');
            star.classList.add('star');
            star.style.top = Math.random() * 100 + 'vh';
            star.style.left = Math.random() * 100 + 'vw';
            star.style.animationDuration = Math.random() * 2 + 1 + 's'; // Randomize twinkle speed
            star.style.animationDelay = Math.random() * 5 + 's'; // Randomize start time
            starsContainer.appendChild(star);
        }

        for (let i = 0; i < 200; i++) {
            createStar();
        }

        function randomizeSpaceship() {
            const delay = Math.random() * 20 + 5; // Random delay between 5 and 25 seconds
            const topPosition = Math.random() * 100 + 'vh';
            const leftPosition = Math.random() * 100 + 'vw';
            spaceship.style.top = topPosition;
            spaceship.style.left = leftPosition;

            spaceship.style.animation = 'none'; // Reset animation
            void spaceship.offsetWidth; // Trigger reflow
            spaceship.style.animation = 'fly 10s linear infinite'; // Restart animation

            setTimeout(randomizeSpaceship, delay * 1000); // Schedule next appearance
        }

        randomizeSpaceship(); // Start the randomization
    </script>
</body>
</html>
