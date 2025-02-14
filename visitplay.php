<?php
include("classes/connect.php");

$systemName = isset($_GET['G4K8N1T7L3J9X2R5M6']) ? base64_decode($_GET['G4K8N1T7L3J9X2R5M6']) : 'No system selected';
$systemId = isset($_GET['H7L3P9F1T6X8R2M4J5']) ? base64_decode($_GET['H7L3P9F1T6X8R2M4J5']) : null;
$userid =  base64_decode($_GET['V8K2N5T9L4J1X3R7M6']);
$username = base64_decode($_GET['B6R1L8T4J3K9X7M2Q5']);
$DB = new Database();


// Level up the card if required
if (isset($level) && $level > 0) {
    $newLevel = $level - 1;
    $query = "UPDATE cards SET level = '$newLevel' WHERE id = '$systemId' AND cardid = '$cardId' AND level = '$level'";
    $DB->execute($query);
}

// Fetch a random card from all levels at once
$query = "SELECT * FROM cards WHERE id = '$systemId' AND level > 0 ORDER BY RAND() LIMIT 1";
$randomCard = $DB->readSingle($query);

// Fetch level counts
$queryCount = "SELECT level, COUNT(*) AS count FROM cards WHERE id = '$systemId' GROUP BY level";
$cardCounts = $DB->read($queryCount);

$levelCounts = ['1' => 0, '2' => 0, '3' => 0];
if ($cardCounts !== false) {
    foreach ($cardCounts as $count) {
        $levelCounts[$count['level']] = $count['count'];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($systemName); ?></title>
    <style>
      body {
            font-family: 'Roboto', sans-serif;
            background-color: #fff; /* Light gray background */
            color: #333; /* Darker text color */
            margin: 0;
            padding: 0;
            display:flex;
            align-items:center;
            justify-content:center;
        }
        .container {
            width: 100%;
            padding: 20px;
            min-height: 100vh;
            max-height: auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            animation: fadeIn 0.5s;
            display:flex;
            flex-direction:column;
            justify-content:center;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #0078d4; /* Microsoft Blue */
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .header a {
            color: white;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            display:flex;
            align-items:center;
        }
        .header a svg{
            margin-right: 8px; 
            vertical-align: middle; 
        }
        .header h1 {
            display:block;
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }
        .card {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 8px 20px rgba(0,0,0,1.1);
            position: relative;
            animation: fadeIn 3s;
        }

        .card #card-question{
            white-space: pre-wrap;
             }
        .card-level {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 5px;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border-radius: 5px;
            font-size: 12px;
        }
        .card h3 {
            font-size: 22px;
            margin-bottom: 10px;
        }
        .card p {
            font-size: 18px;
            line-height: 1.6;

        }
        .card .answer {
            display: none;
            margin-top: 20px;
            font-size: 10px;
        }
        .card #answer p{
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid #696969;
            margin-bottom: 30px;
            padding-bottom: 30px;
            border: 1px solid #696969;
            border-radius: 15px;
            font-size: 16px;
            box-shadow: 0 5px 16px rgba(0,0,0,0.1);
            padding: 30px;
            animation: fadeIn 0.7s;
          }
          @keyframes fadeIn {
  0% { opacity: 0; }
  100% { opacity: 1; }
}


 
        .card .show-answer {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 18px;
            background-color: #0078d4; /* Microsoft Blue */
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.8s ease;
            display:flex;
            align-items:center;
        }
        .card .show-answer svg{
            margin-right: 8px; 
            vertical-align: middle; 
        }
        
        .card .show-answer:hover {
            background-color: #005a9e; /* Darker Microsoft Blue on hover */
        }
        button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            font-size: 18px;
            background-color: #0078d4; /* Microsoft Blue */
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #005a9e; /* Darker Microsoft Blue on hover */
        }
        #level-counts {
            display:block;
            margin-top: 20px;
            font-size: 18px;
        }
        .cardlevel {
            background-color: green;
            color: white;
            padding: 3px;
            text-decoration: none;
            border-radius: 2px;
        }
        .cardlevel:hover {
            opacity: 80%;
            background-color: green;
            color: white;
            padding: 3px;
            text-decoration: none;
            border-radius: 2px;
        }

        @media (max-width: 900px) {
            .container {
            width: 100%;
            min-height: 100vh;
            height: auto;
            padding: 20px;
            background-color: #fff;
            animation: fadeIn 0.5s;
            display:flex;
            flex-direction:column;
            justify-content:center;
        }
            .header h1 {
            display:none;

        }
        #level-counts {


        }

        .header a {
            color: white;
            text-decoration: none;
            font-size: 20px;
            cursor: pointer;
            display:flex;
            align-items:center;
        }
        .card p{
            font-size 20px;
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
        .next{
            display:flex;
            align-items:center;
        }
        .next svg{
            margin-left: 8px; 
            vertical-align: middle; 

        }
    </style>
    <script>
        function fetchNewCard(systemId) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_card.php?id=' + systemId, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var card = JSON.parse(xhr.responseText);
                    if (card) {
                        document.getElementById('card-name').innerText = card.namecard;
                        document.getElementById('card-question').innerText = card.question;
                        
                        // Set the card answer for later use
                        cardAnswer = card.answer;
                        
                        // Clear any previously shown answer and reset the button
                        document.getElementById('answer').innerHTML = '<button class="show-answer" onclick="showAnswer();"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down"><path d="m6 9 6 6 6-6"/></svg>Show Answer</button>';
                        
                        // Update card level
                        document.getElementById('card-level').innerText = 'Level ' + card.level;


                    } else {
                        document.getElementById('card-container').innerHTML = '<p>No more cards found in the system.</p>';
                    }
                }
            };
            xhr.send();
        }



        var cardAnswer = <?php echo json_encode($randomCard['answer']); ?>;
        function showAnswer() {
            var answerElement = document.getElementById('answer');
            var formattedAnswer = cardAnswer.replace(/\n/g, '<br>');
            answerElement.innerHTML = '<p>' + formattedAnswer + '</p>';
        }
    </script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<iframe class="background-iframe" src="techbg.php" allowfullscreen></iframe>
<div class="container">
    <div class="header">
        <a href="visit.php?A9R4V2k8T7L1X5M3Q=<?php echo base64_encode($userid) ?>&J6N8W1F9C2P7D4L0Z=<?php echo base64_encode($username) ?>" style="font-size: 13px; margin-left: 1%;">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-door-open"><path d="M13 4h3a2 2 0 0 1 2 2v14"/><path d="M2 20h3"/><path d="M13 20h9"/><path d="M10 12v.01"/><path d="M13 4.562v16.157a1 1 0 0 1-1.242.97L5 20V5.562a2 2 0 0 1 1.515-1.94l4-1A2 2 0 0 1 13 4.561Z"/></svg>    
        Exit Game</a>
        <h1><?php echo htmlspecialchars($systemName); ?></h1>
        <a href="visitview_system.php?Z5N1R8L3T7J4K9X2M6=<?php echo urlencode(base64_encode($systemName)); ?>&B7Q3P9F2L6T1X8R4M5=<?php echo base64_encode($systemId); ?>&Y8K2N4T9L5J1X3R6M7=<?php echo base64_encode($userid); ?>&C6R1L9T4J2K8X7M3Q5=<?php echo base64_encode($username); ?>" style="font-size: 13px; margin-right: 1%;">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-binoculars"><path d="M10 10h4"/><path d="M19 7V4a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v3"/><path d="M20 21a2 2 0 0 0 2-2v-3.851c0-1.39-2-2.962-2-4.829V8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v11a2 2 0 0 0 2 2z"/><path d="M 22 16 L 2 16"/><path d="M4 21a2 2 0 0 1-2-2v-3.851c0-1.39 2-2.962 2-4.829V8a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v11a2 2 0 0 1-2 2z"/><path d="M9 7V4a1 1 0 0 0-1-1H6a1 1 0 0 0-1 1v3"/></svg>    
        View Cards</a>
    </div>
    
    <div id="level-counts"></div>
    <?php if ($randomCard): ?>
        <div id="card-container" class="card">
            <span id="card-level" class="card-level">Level <?php echo $randomCard['level']; ?></span>
            <h3 id="card-name"><?php echo htmlspecialchars($randomCard['namecard']); ?></h3>
            <p><strong>Question:</strong> <span id="card-question" style="white-space: pre-wrap;"><?php echo htmlspecialchars($randomCard['question']); ?></span></p>
            <div id="answer" style="">
                <button class="show-answer" onclick="showAnswer();">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down"><path d="m6 9 6 6 6-6"/></svg>    
                Show Answer</button>
            </div>
           
            
        </div>
    <?php else: ?>
        <p>No cards found in the system.</p>
    <?php endif; ?>
    <button onclick="fetchNewCard(<?php echo htmlspecialchars($systemId); ?>)" class="next">   
    Next Card
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-big-right"><path d="M6 9h6V5l7 7-7 7v-4H6V9z"/></svg> 
</button>
</div>
<script>
    document.getElementById('level-counts').innerHTML = '<strong>Cards in levels:</strong><br> Level 3: <?php echo $levelCounts['3']; ?><br> Level 2: <?php echo $levelCounts['2']; ?><br> Level 1: <?php echo $levelCounts['1']; ?>';
</script>
</body>
</html>
