<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disconnection</title>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        body {
            position: relative;
            background-color: #0a1d28;
            overflow: hidden;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        .bb {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 250px;
            height: 250px;
            background: rgba(0, 0, 0, 0.2);
            color: #0078d4;
            box-shadow: 0 4px 8px rgba(0, 120, 212, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 20px;
            font-weight: 600;
            border-radius: 8px;
        }

        .bb::before,
        .bb::after {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            content: '';
            z-index: -1;
            border-radius: 8px;
            box-shadow: inset 0 0 0 2px rgba(0, 120, 212, 0.4);
            animation: clipMe 8s linear infinite;
        }

        .bb::before {
            animation-delay: -4s;
        }

        @keyframes clipMe {
            0%, 100% {clip: rect(0px, 250px, 20px, 0px);}
            25% {clip: rect(0px, 20px, 250px, 0px);}
            50% {clip: rect(230px, 250px, 250px, 0px);}
            75% {clip: rect(0px, 250px, 250px, 220px);}
        }

        .message {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            color: #0078d4;
            font-size: 20px;
            font-weight: 600;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="bb">
        <div>Numerical</div>
        <div>Leitner</div>
        <div>System</div>
    </div>
    <div class="message">Disconnecting you...</div>

    <script>
        setTimeout(() => {
            window.location.href = "bye.php";
        }, 2000);
    </script>
</body>
</html>
