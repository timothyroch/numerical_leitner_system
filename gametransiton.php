<?php
$encoded_name = $_GET['8e7d1f4b3a9c2e6a5f8b0d4c7a1e9f3b'];
$systemName = base64_decode($encoded_name);
$encoded_id = $_GET['d2f4a7c9e8b0d1a6c3e5f7b9a4d2e8c1'];
$systemId = base64_decode($encoded_id);

// Properly escape systemName for HTML and JavaScript
$escapedSystemName = htmlspecialchars($systemName, ENT_QUOTES, 'UTF-8');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $escapedSystemName; ?></title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Khula:700');
        body {
            background: #111;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: white;
            font-family: 'Khula', sans-serif;
            overflow: hidden;
        }
        .hidden {
            opacity: 0;
        }
        .console-container {
            font-size: 4em;
            text-align: center;
            height: 200px;
            width: 80%;
            display: block;
            position: relative;
            color: white;
        }
        .console-underscore {
            display: inline-block;
            position: relative;
            top: -0.14em;
            left: 10px;
        }
    </style>
</head>
<body>
    <div class='console-container' id="console-container">
        <span id='text'></span>
        <div class='console-underscore' id='console'>&#95;</div>
    </div>

    <script>
        function consoleText(words, id, colors) {
            if (colors === undefined) colors = ['#fff'];
            var visible = true;
            var con = document.getElementById('console');
            var letterCount = 1;
            var x = 1;
            var waiting = false;
            var target = document.getElementById(id);
            target.setAttribute('style', 'color:' + colors[0]);
            
            // Display only the first message once
            var message = words[0];
            var intervalId = window.setInterval(function() {
                if (letterCount === 0 && !waiting) {
                    waiting = true;
                    target.innerHTML = message.substring(0, letterCount);
                    window.setTimeout(function() {
                        letterCount += x;
                        waiting = false;
                    }, 500);
                } else if (letterCount === message.length + 1 && !waiting) {
                    waiting = true;
                    window.setTimeout(function() {
                        clearInterval(intervalId); // Stop the text animation
                        con.className = 'console-underscore hidden'; // Hide underscore

                        // Fade out the container manually
                        var container = document.getElementById('console-container');
                        var opacity = 1;
                        var fadeOutInterval = setInterval(function() {
                            opacity -= 0.05;
                            if (opacity <= 0) {
                                clearInterval(fadeOutInterval);
                                // Redirect to play.php after fade out
                                var encodedName = encodeURIComponent('<?php echo $encoded_name; ?>');
                                var encodedId = encodeURIComponent('<?php echo $encoded_id; ?>');
                                window.location.href = 'play.php?4c8d2e1b9a7f3c5e0d6a8b9c4f2e7d1a=' + encodedName + '&a1b9c8d2e4f7a3b6d0e5c8a9f1b2c7d3=' + encodedId;
                            }
                            container.style.opacity = opacity;
                        }, 20);
                    }, 500);
                } else if (!waiting) {
                    target.innerHTML = message.substring(0, letterCount);
                    letterCount += x;
                }
            }, 40);
        }
        
        // Safely include systemName in JavaScript
        var systemName = <?php echo json_encode($systemName); ?>;
        consoleText([systemName + '.'], 'text', ['#0078d4']);
    </script>
</body>
</html>
