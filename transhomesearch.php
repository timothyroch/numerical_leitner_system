<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NLS | Leitner System</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap');

        body {
            margin: 0;
            padding: 0;
            text-align: center;
            background: #f3f3f3; /* Soft light background */
            color: #333; /* Dark text for contrast */
            font-family: 'Roboto', sans-serif;
            font-weight: 400;
            font-size: 18px;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .container {
            text-align: center;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 600px;
            width: 100%;
        }

        .headline {
            font-size: 24px;
            color: #0078d4; /* Microsoft blue */
            margin-bottom: 20px;
            animation: fadeInOut 3s forwards;
        }

        .subheadline {
            font-size: 20px;
            color: #333;
            animation: slideUp 3s forwards;
        }

        @keyframes fadeInOut {
            0% { opacity: 0; }
            20% { opacity: 1; }
            80% { opacity: 1; }
            100% { opacity: 0; }
        }

        @keyframes slideUp {
            0% { transform: translateY(50px); opacity: 0; }
            20% { transform: translateY(50px); opacity: 0; }
            50% { transform: translateY(0); opacity: 1; }
            100% { transform: translateY(0); opacity: 1; }
        }

        p {
            font-size: 14px;
            color: #666;
            margin-top: 20px;
        }

        @media (max-width: 600px) {
            body {
                font-size: 16px;
            }

            .headline {
                font-size: 20px;
            }

            .subheadline {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="headline">Home</div>
        <div class="subheadline">Welcome back!</div>
        <p>Redirecting you in a moment...</p>
    </div>

    <script>
        setTimeout(function() {
            window.location.href = 'Add_System.php';
        }, 3000); // Match the duration of the animation
    </script>
</body>
</html>
