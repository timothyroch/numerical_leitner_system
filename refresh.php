<?php
include("classes/connect.php");

// Decode the parameters
$systemName = isset($_GET['6d1e7f8a']) ? base64_decode($_GET['6d1e7f8a']) : 'No system selected';
$systemId = isset($_GET['5c9b2d3e']) ? base64_decode($_GET['5c9b2d3e']) : null;


if ($systemId) {
    $DB = new Database();
    $lev = 3;

    // Update the level of all cards associated with the given system ID to 3
    $query = "UPDATE cards SET level = '$lev' WHERE id = '$systemId'";
    $success = $DB->save($query);

    if ($success) {
        header("Location: view_system.php?YzRlYjFhMDYxY2ZjYmQzZTYxZmY5M2Y1YmQzNTM3NzI=" . urlencode(base64_encode($systemName)) . "&f4e8d9a4b2c1d4e5f6a7b8c9d0e1f2a3=" . urlencode(base64_encode($systemId)));
        die();
    } else {
        echo "Error updating card levels.";
    }
} else {
    echo "Invalid system ID.";
}
?>
