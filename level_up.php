<?php
include("classes/connect.php");

$cardId = isset($_GET['f8d7a9b3']) ? base64_decode($_GET['f8d7a9b3']) : null;
$level = isset($_GET['a2e1c5d8']) ? base64_decode($_GET['a2e1c5d8']) : null;
$systemName = isset($_GET['b9f3e2d4']) ? base64_decode($_GET['b9f3e2d4']) : 'No system selected';
$systemId = isset($_GET['c7a8b6d5']) ? base64_decode($_GET['c7a8b6d5']) : null;

if ($cardId !== null && $level !== null && $level > 0) {
    $lev = $level - 1;

    // Update the card's level in the database
    $query = "UPDATE cards SET level = '$lev' WHERE cardid = '$cardId'";
    $DB = new Database();
    $success = $DB->save($query);



      
   
}
header("Location: view_system.php?YzRlYjFhMDYxY2ZjYmQzZTYxZmY5M2Y1YmQzNTM3NzI=" . urlencode(base64_encode($systemName)) . "&f4e8d9a4b2c1d4e5f6a7b8c9d0e1f2a3=" . urlencode(base64_encode($systemId)));
die();
?>
