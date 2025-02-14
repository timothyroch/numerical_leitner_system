<?php
include("classes/connect.php");

$cardName = isset($_GET['A3K7N1T9L5J8X2R6M4']) ? base64_decode($_GET['A3K7N1T9L5J8X2R6M4']) : 'No card selected';
$cardid = isset($_GET['D7R1L9T6J4K8X3M2Q5']) ? base64_decode($_GET['D7R1L9T6J4K8X3M2Q5']) : null;
$systemQ = isset($_GET['H4K9N2T8L5J1X7R3M6']) ? base64_decode($_GET['H4K9N2T8L5J1X7R3M6']) : 'no q';
$systemA = isset($_GET['Y1L7P9T4J2K6X8R5M3']) ? base64_decode($_GET['Y1L7P9T4J2K6X8R5M3']) : 'no a';
$systemId = isset($_GET['M3K8N2T9L5J7X1R6Q4']) ? base64_decode($_GET['M3K8N2T9L5J7X1R6Q4']) : 'no sid';
$systemName = isset($_GET['S7L9P1T4J6K8X2R5M3']) ? base64_decode($_GET['S7L9P1T4J6K8X2R5M3']) : 'no sname';
$userid =  base64_decode($_GET['G9L4P8T1X7R2M5J3K6']);
$username = base64_decode($_GET['V2K6N9T5L3J1X8R7M4']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Card</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        #ADD {
            background-color: #ffffff;
            width: 90%;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        #ADD header {
            background-color: #0078D7;
            color: #ffffff;
            padding: 15px;
            text-align: center;
            font-size: 24px;
            font-weight: 500;
        }
        #ADD div {
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        #ADD div label {
            width: 100%;
            margin-top: 10px;
            font-size: 18px;
            font-weight: 500;
            text-align: left;
        }
        #ADD div .card-text {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #dcdcdc;
            border-radius: 5px;
            font-size: 16px;
            background-color: #f9f9f9;
        }
        #cancelButton {
            padding: 10px 15px;
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
            display:flex;
            align-items:center;
        }
        #cancelButton svg{
            margin-right: 8px; 
            vertical-align: middle; 

        }
        #cancelButton:hover {
            opacity:60%;
            background-color:white;
        }
        @media (max-width: 1100px) {
            #cancelButton {
                top: 10px;
                left: 10px;
                padding: 8px 14px;
                font-size: 26px;
            }
            #ADD header {
                font-size: 20px;
            }
            #ADD div label {
                font-size: 16px;
            }
            #ADD div .card-text {
                font-size: 24px;
            }
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
    </style>
</head>
<body>
<iframe class="background-iframe" src="techbg.php" allowfullscreen></iframe>

    <a id="cancelButton" href="visitview_system.php?Z5N1R8L3T7J4K9X2M6=<?php echo urlencode(base64_encode($systemName)); ?>&B7Q3P9F2L6T1X8R4M5=<?php echo base64_encode($systemId); ?>&Y8K2N4T9L5J1X3R6M7=<?php echo base64_encode($userid); ?>&C6R1L9T4J2K8X7M3Q5=<?php echo base64_encode($username); ?>">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0078D7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
    Back</a>

    <div id="ADD">
        <header>View Card</header>
        <div>
            <label for="namecard">Name:</label>
            <div class="card-text" id="namecard" name="namecard"><?php echo htmlspecialchars($cardName); ?></div>
            <label for="question">Question:</label>
            <div class="card-text" id="question" name="question"><?php echo htmlspecialchars($systemQ); ?></div>
            <label for="answer">Answer:</label>
            <div class="card-text" id="answer" name="answer"><?php echo htmlspecialchars($systemA); ?></div>
        </div>
    </div>
</body>
</html>

