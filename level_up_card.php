<?php
include("classes/connect.php");

// Decode parameters
$cardId = isset($_GET['a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6']) ? base64_decode($_GET['a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6']) : null;
$level = isset($_GET['q7r8s9t0u1v2w3x4y5z6a7b8c9d0e1f2']) ? base64_decode($_GET['q7r8s9t0u1v2w3x4y5z6a7b8c9d0e1f2']) : null;
$systemName = isset($_GET['z3x4c5v6b7n8m9o0p1q2r3s4t5u6v7w']) ? base64_decode($_GET['z3x4c5v6b7n8m9o0p1q2r3s4t5u6v7w']) : 'No system selected';
$systemId = isset($_GET['y1x2z3a4b5c6d7e8f9g0h1i2j3k4l5m']) ? base64_decode($_GET['y1x2z3a4b5c6d7e8f9g0h1i2j3k4l5m']) : null;

if ($cardId !== null && $level !== null && $level > 0) {
    $DB = new Database();
    $newLevel = $level - 1;

    // Update the level of the specific card
    $query = "UPDATE cards SET level = '$newLevel' WHERE cardid = '$cardId'";
    $success = $DB->save($query);

    header("Location: play.php?4c8d2e1b9a7f3c5e0d6a8b9c4f2e7d1a=" . urlencode(base64_encode($systemName)) . "&a1b9c8d2e4f7a3b6d0e5c8a9f1b2c7d3=" . base64_encode($systemId));
    die(); 
} else {
    header("Location: play.php?4c8d2e1b9a7f3c5e0d6a8b9c4f2e7d1a=" . urlencode(base64_encode($systemName)) . "&a1b9c8d2e4f7a3b6d0e5c8a9f1b2c7d3=" . base64_encode($systemId));
    die(); 
}
?>
