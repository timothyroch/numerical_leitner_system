<?php
include("classes/connect.php");

// Decode the parameters
$cardName = isset($_GET['8f0a1c9d']) ? base64_decode($_GET['8f0a1c9d']) : 'No card selected';
$cardid = isset($_GET['f7d1b3a4']) ? base64_decode($_GET['f7d1b3a4']) : null;
$systemQ = isset($_GET['e3c5d7b6']) ? base64_decode($_GET['e3c5d7b6']) : 'no q';
$systemA = isset($_GET['d2a4f8b1']) ? base64_decode($_GET['d2a4f8b1']) : 'no a';
$systemId = isset($_GET['c9b3e7f2']) ? base64_decode($_GET['c9b3e7f2']) : 'no sid';
$systemName = isset($_GET['a6c8d1f5']) ? base64_decode($_GET['a6c8d1f5']) : 'no sname';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['namecard']) && isset($_POST['question']) && isset($_POST['answer'])) {
    $new_name = $_POST['namecard'];
    $new_question = $_POST['question'];
    $new_answer = $_POST['answer'];

    if ($systemId) {
        $DB = new Database();
        $query = "UPDATE cards SET namecard = ?, question = ?, answer = ? WHERE cardid = ?";
        $params = [$new_name, $new_question, $new_answer, $cardid];
        $types = 'ssss'; // four string parameters
        $success = $DB->saveWithPreparedStatement($query, $params, $types);

        if ($success) {
            header("Location: view_system.php?YzRlYjFhMDYxY2ZjYmQzZTYxZmY5M2Y1YmQzNTM3NzI=" . urlencode(base64_encode($systemName)) . "&f4e8d9a4b2c1d4e5f6a7b8c9d0e1f2a3=" . urlencode(base64_encode($systemId)));
            die();
        } else {
            echo "Error modifying the card";
        }
    } else {
        echo "Invalid system ID";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Card</title>
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
            height: 100vh;
        }
        #ADD {
            background-color: #ffffff;
            width: 70%;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        #ADD header {
            background-color: #0078D7;
            color: #ffffff;
            padding: 15px;
            text-align: center;
            font-size: 20px;
            font-weight: 500;
        }
        #ADD form {
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        #ADD form input[type="text"],
        #ADD form textarea {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #dcdcdc;
            border-radius: 5px;
            font-size: 16px;
        }
        #ADD form input[type="submit"] {
            background-color: #0078D7;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        #ADD form input[type="submit"]:hover {
            background-color: #005a9e;
        }
        #cancelButton {
            padding: 5px 10px;
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
        }
        #cancelButton:hover {
            background-color: #0078D7;
            color: #ffffff;
        }
        #question{
            font-family: 'Roboto', sans-serif;
        }
        #answer{
            font-family: 'Roboto', sans-serif;
        }
       
    </style>
</head>
<body>
    <a id="cancelButton" href="view_system.php?YzRlYjFhMDYxY2ZjYmQzZTYxZmY5M2Y1YmQzNTM3NzI=<?php echo urlencode(base64_encode($systemName)); ?>&f4e8d9a4b2c1d4e5f6a7b8c9d0e1f2a3=<?php echo urlencode(base64_encode($systemId)); ?>">Cancel</a>





    <div id="ADD">
        <header>Modify Your Card</header>
        <form method="post" action="info_card.php?8f0a1c9d=<?php echo urlencode(base64_encode($cardName)); ?>&f7d1b3a4=<?php echo urlencode(base64_encode($cardid)); ?>&e3c5d7b6=<?php echo urlencode(base64_encode($systemQ)); ?>&d2a4f8b1=<?php echo urlencode(base64_encode($systemA)); ?>&c9b3e7f2=<?php echo urlencode(base64_encode($systemId)); ?>&a6c8d1f5=<?php echo urlencode(base64_encode($systemName)); ?>">
            <label for="namecard">Name:</label>
            <input type="text" id="namecard" name="namecard" value="<?php echo htmlspecialchars($cardName); ?>">
            <label for="question">Question:</label>
            <textarea id="question" name="question" rows="5"><?php echo htmlspecialchars($systemQ); ?></textarea>
            <label for="answer">Answer:</label>
            <textarea id="answer" name="answer" rows="5"><?php echo htmlspecialchars($systemA); ?></textarea>
            <input type="submit" value="Modify">
        </form>
    </div>
</body>
</html>
