<?php
session_start();

include("classes/connect.php");
include("classes/login.php");

$email = "";
$password = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = new Login();
    $result = $login->evaluate($_POST);

    if ($result != "") {
        echo "<div class='error'>";
        echo "<br>Your credientials doesn't match our records<br><br>";
        echo "</div>";
    } else {
        // Redirect to circle.php first
        header("Location: welcome.php");
        die;
    }

    $email = $_POST['email'];
    $password = $_POST['password'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NLS | Log in</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

        :root {
            --primary-blue: #0078D4;
            --secondary-blue: #005a9e;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 0;
        }

        #bar {
            width: 100%;
            background-color: var(--primary-blue);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 10px 40px;
            border-radius: 8px 8px 0 0;
            max-width: 400px;
            margin-top: -40px;
            margin-bottom: 40px;
        }

        #bar #title {
            font-size: 20px;
            font-weight: 700;
        }

        #form-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: rgba(255, 255, 255, 0.8); /* semi-transparent background */
            padding: 40px;
            border-radius:8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            margin-top: 0;
            text-align: center;
            max-width: 400px;
        }

        #text {
            height: 40px;
            width: 100%;
            border-radius: 4px;
            border: solid 1px #ddd;
            padding: 0 10px;
            font-size: 14px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        #button {
            width: 100%;
            height: 40px;
            border-radius: 4px;
            font-weight: bold;
            border: none;
            background-color: var(--primary-blue);
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #button:hover {
            background-color: var(--secondary-blue);
        }

        .error {
            text-align: center;
            font-size: 16px;
            color: white;
            background-color: #d9534f;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .footer {
            font-size: 12px;
            color: #666;
            margin-top: 20px;
        }

        .footer a {
            color: var(--primary-blue);
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .background-iframe {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
            z-index: -1; /* Place it behind other content */
        }

        .rotating-text {
            font-family: 'Roboto', sans-serif;
            font-weight: 600;
            font-size: 3rem;
            color: white;
            position: absolute;
            text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;
            top: 10%;
            left: 10%;
        }

        .rotating-text p {
            display: inline-flex;
            margin: 0;
            vertical-align: top;
        }

        .word {
            position: absolute;
            display: flex;
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .letter {
            display: inline-block;
            transform-origin: center center 25px;
            transition: transform 0.32s cubic-bezier(0.6, 0, 0.7, 0.2);
        }

        .letter.out {
            transform: rotateX(90deg);
        }

        .letter.in {
            transform: rotateX(0deg);
        }

        .letter.behind {
            transform: rotateX(-90deg);
        }

        .alizarin { color: var(--primary-blue); }
        .wisteria { color: var(--secondary-blue); }
        .peter-river { color: var(--accent-blue); }
        .emerald { color: var(--tertiary-blue); }
        .sun-flower { color: var(--primary-blue); }

        @media (max-width: 768px) {
            .rotating-text {
                font-size: 2rem;
                top: 5%;
                left: 5%;
            }

            #form-container {
                width: 90%;
                padding: 20px;
            }
            #bar {
                width: 100%;
                padding: 10px 20px;
            }
        }
    </style>
</head>
<body>
    <iframe class="background-iframe" src="mountain.php" allowfullscreen></iframe>
    
    <!--<div class="rotating-text">
        <p>Study</p><br>
        <p>
            <span class="word alizarin">Smarter</span>
            <span class="word wisteria">faster.</span>
            <span class="word peter-river">efficiently.</span>
            <span class="word emerald">focused.</span>
            <span class="word sun-flower">productively.</span>
        </p>
    </div>-->
    <div id="form-container">
    <div id="bar">
        <div id="title">Numerical Leitner System</div>
    </div>
        <form method="post">
            Connect to your account:<br><br>
            <input name="email" value="<?php echo $email ?>" type="text" id="text" placeholder="Email"><br>
            <input name="password" value="<?php echo $password ?>" type="password" id="text" placeholder="Password"><br>
            <input type="submit" id="button" value="Log in">
        </form>
        <div class="footer">
            Forgot your password? <a href="mailto:numericalleitnersystem@gmail.com">Contact us</a>
        </div>
        <div class="footer">
            Create an account: <a href="index.php">Signup</a>
        </div>
    </div>
    <script>
        // JavaScript for rotating text animation
        let words = document.querySelectorAll(".word");
        words.forEach(word => {
            let letters = word.textContent.split("");
            word.textContent = "";
            letters.forEach(letter => {
                let span = document.createElement("span");
                span.textContent = letter;
                span.className = "letter";
                word.append(span);
            });
        });

        let currentWordIndex = 0;
        let maxWordIndex = words.length - 1;
        words[currentWordIndex].style.opacity = "1";

        let rotateText = () => {
            let currentWord = words[currentWordIndex];
            let nextWord =
                currentWordIndex === maxWordIndex ? words[0] : words[currentWordIndex + 1];

            // Rotate out letters of current word
            Array.from(currentWord.children).forEach((letter, i) => {
                setTimeout(() => {
                    letter.className = "letter out";
                }, i * 80); // Transition speed remains the same
            });

            // Reveal and rotate in letters of next word
            nextWord.style.opacity = "1";
            Array.from(nextWord.children).forEach((letter, i) => {
                letter.className = "letter behind";
                setTimeout(() => {
                    letter.className = "letter in";
                }, 340 + i * 80); // Transition speed remains the same
            });

            currentWordIndex = (currentWordIndex === maxWordIndex) ? 0 : currentWordIndex + 1;
        };

        rotateText();
        setInterval(rotateText, 3000); // Reduced interval to show each word for less time
    </script>
</body>
</html>
