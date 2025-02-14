<?php
include("classes/connect.php");

$cardId = isset($_GET['e1f7b6d9']) ? base64_decode($_GET['e1f7b6d9']) : null;
$level = isset($_GET['c3d8e5f2']) ? base64_decode($_GET['c3d8e5f2']) : null;
$systemName = isset($_GET['a7b9c4d8']) ? base64_decode($_GET['a7b9c4d8']) : 'No system selected';
$systemId = isset($_GET['b1e3f5d6']) ? base64_decode($_GET['b1e3f5d6']) : null;

if ($cardId !== null && $level !== null && $level < 3) {
    $lev = $level + 1;

    // Update the card's level in the database
    $query = "UPDATE cards SET level = '$lev' WHERE cardid = '$cardId'";
    $DB = new Database();
    $success = $DB->save($query);

}
header("Location: view_system.php?YzRlYjFhMDYxY2ZjYmQzZTYxZmY5M2Y1YmQzNTM3NzI=" . urlencode(base64_encode($systemName)) . "&f4e8d9a4b2c1d4e5f6a7b8c9d0e1f2a3=" . urlencode(base64_encode($systemId)));
die();

?>
