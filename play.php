<?php
include("classes/connect.php");

// Ensure you properly validate and sanitize inputs
$encoded_name = isset($_GET['4c8d2e1b9a7f3c5e0d6a8b9c4f2e7d1a']) ? $_GET['4c8d2e1b9a7f3c5e0d6a8b9c4f2e7d1a'] : '';
$encoded_id = isset($_GET['a1b9c8d2e4f7a3b6d0e5c8a9f1b2c7d3']) ? $_GET['a1b9c8d2e4f7a3b6d0e5c8a9f1b2c7d3'] : '';

// Decode the parameters
$systemName = base64_decode($encoded_name);
$systemId = base64_decode($encoded_id);

// Ensure you properly validate and sanitize inputs
$encoded_cardId = isset($_GET['f1a2b3c4d5e6f7g8h9i0j1k2l3m4n5o6p']) ? $_GET['f1a2b3c4d5e6f7g8h9i0j1k2l3m4n5o6p'] : '';
$encoded_level = isset($_GET['g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1v']) ? $_GET['g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1v'] : '';

// Decode the parameters
$cardId = base64_decode($encoded_cardId);
$level = base64_decode($encoded_level);

$DB = new Database();

// Level up the card if required
if ($level > 0) {
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
            width: 90%;
            padding: 20px;
            min-height: 100vh;
            max-height: auto;
            background-color: #fff;
            border-radius: 10px;
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
            padding: 10px;
            text-decoration: none;
            border-radius: 4px;
        }
        .cardlevel a {
            display:flex;
            align-items:center;
            }
        .cardlevel a svg{
            margin-left: 8px; 
            vertical-align: middle; 
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
                        document.getElementById('answer').innerHTML = '<button class="show-answer" onclick="showAnswer();">                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down"><path d="m6 9 6 6 6-6"/></svg> Show Answer</button>';
                        
                        // Update card level
                        document.getElementById('card-level').innerText = 'Level ' + card.level;

 // Update the level-up link
 document.getElementById('level-up-link').href = "level_up_card.php?a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6=" + btoa(card.cardid) + "&q7r8s9t0u1v2w3x4y5z6a7b8c9d0e1f2=" + btoa(card.level) + "&z3x4c5v6b7n8m9o0p1q2r3s4t5u6v7w=<?php echo urlencode(base64_encode($systemName)); ?>&y1x2z3a4b5c6d7e8f9g0h1i2j3k4l5m=<?php echo urlencode(base64_encode($systemId)); ?>";
                    } else {
                        document.getElementById('card-container').innerHTML = '<p>No more cards found in the system.</p>';
                    }
                }
            };
            xhr.send();
        }

        function updateLevelCounts(systemId) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_level_counts.php?id=' + systemId, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var levelCounts = JSON.parse(xhr.responseText);
                    if (levelCounts) {
                        document.getElementById('level-counts').innerHTML = '<strong>Level Counts:</strong> Level 3: ' + levelCounts['3'] + ', Level 2: ' + levelCounts['2'] + ', Level 1: ' + levelCounts['1'];
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
<div class="container">
    <div class="header">
        <a href="Add_System.php" style=" margin-left: 1%;">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-door-open"><path d="M13 4h3a2 2 0 0 1 2 2v14"/><path d="M2 20h3"/><path d="M13 20h9"/><path d="M10 12v.01"/><path d="M13 4.562v16.157a1 1 0 0 1-1.242.97L5 20V5.562a2 2 0 0 1 1.515-1.94l4-1A2 2 0 0 1 13 4.561Z"/></svg>
        Exit Game</a>
        <h1><?php echo htmlspecialchars($systemName); ?></h1>
        <a href="view_system.php?YzRlYjFhMDYxY2ZjYmQzZTYxZmY5M2Y1YmQzNTM3NzI=<?php echo urlencode(base64_encode($systemName)); ?>&f4e8d9a4b2c1d4e5f6a7b8c9d0e1f2a3=<?php echo urlencode(base64_encode($systemId)); ?>" style=" margin-right: 1%;">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>
        Modify Cards</a>
    </div>
    
    <div id="level-counts"></div>
    <?php if ($randomCard): ?>
        <div id="card-container" class="card">
            <span id="card-level" class="card-level">Level <?php echo $randomCard['level']; ?></span>
            <h3 id="card-name"><?php echo htmlspecialchars($randomCard['namecard']); ?></h3>
            <p><strong>Question:</strong> <span id="card-question"><?php echo htmlspecialchars($randomCard['question']); ?></span></p>
            <div id="answer" >
                <button class="show-answer" onclick="showAnswer();">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down"><path d="m6 9 6 6 6-6"/></svg>    
                Show Answer</button>
            </div>
            <a id="level-up-link" href="level_up_card.php?a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6=<?php echo urlencode(base64_encode(htmlspecialchars($randomCard['cardid']))); ?>&q7r8s9t0u1v2w3x4y5z6a7b8c9d0e1f2=<?php echo urlencode(base64_encode(htmlspecialchars($randomCard['level']))); ?>&z3x4c5v6b7n8m9o0p1q2r3s4t5u6v7w=<?php echo urlencode(base64_encode($systemName)); ?>&y1x2z3a4b5c6d7e8f9g0h1i2j3k4l5m=<?php echo urlencode(base64_encode($systemId)); ?>" class="cardlevel">
            Level Up
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-up-narrow-wide"><path d="m3 8 4-4 4 4"/><path d="M7 4v16"/><path d="M11 12h4"/><path d="M11 16h7"/><path d="M11 20h10"/></svg>
        </a>
            
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
