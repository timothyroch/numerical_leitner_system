<?php
include("classes/connect.php");
$systemName = isset($_GET['F9K3N7T1L6J8X4R2M5']) ? base64_decode($_GET['F9K3N7T1L6J8X4R2M5']) : 'No system selected';
$systemId = isset($_GET['H5L8P2T9J3K7X1R6M4']) ? base64_decode($_GET['H5L8P2T9J3K7X1R6M4']) : null;
$systemNum = isset($_GET['number']) ? $_GET['number'] : null;

if (isset($systemId)) {
    $number = $systemId;

    // Create a new instance of Database
    $DB = new Database();

    // Delete form cards associated with the system from the database
    $queryCards = "DELETE FROM cards WHERE id = '$number'";
    $successCards = $DB->save($queryCards);

    // Delete system from the database
    $querySystem = "DELETE FROM system WHERE id = '$number'";
    $successSystem = $DB->save($querySystem);

    if ($successSystem && $successCards) {
        header("Location: Add_System.php");
        die;
        echo "System and associated form cards deleted successfully.";
    } else {
        echo "Error deleting system and/or associated form cards.";
    }
} else {
    echo "System ID not provided.";
}
?>
