<?php
include("classes/connect.php");

// Decode the parameters
$cardId = isset($_GET['d2a8b5c6']) ? base64_decode($_GET['d2a8b5c6']) : null;
$level = isset($_GET['f3e1d7a2']) ? base64_decode($_GET['f3e1d7a2']) : null;
$systemName = isset($_GET['a5b9c3e7']) ? base64_decode($_GET['a5b9c3e7']) : 'No system selected';
$systemId = isset($_GET['c6d4e8f1']) ? base64_decode($_GET['c6d4e8f1']) : null;



if (isset($cardId)) {
  $number = $cardId;
  
  // Delete system from database
  $query = "DELETE FROM cards WHERE cardid = '$number'";
  $DB = new Database();
  $success = $DB->save($query);


  if ($success) {
    header("Location: view_system.php?YzRlYjFhMDYxY2ZjYmQzZTYxZmY5M2Y1YmQzNTM3NzI=" . urlencode(base64_encode($systemName)) . "&f4e8d9a4b2c1d4e5f6a7b8c9d0e1f2a3=" . urlencode(base64_encode($systemId)));


    die;
      echo "System deleted successfully.";
  } else {
      echo "Error deleting system.";
  }
} else {
  echo "System ID not provided.";
}




?>








