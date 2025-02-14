<?php

$encoded_name = $_GET['7f4b9d2e3c8a1f0e9d7a4b3c6e8d9f7b'];
$systemName = base64_decode($encoded_name);



$encoded_id = $_GET['a5c3e1b8d2f4a9c7b6d0e2a4f8c9b3d1'];
$systemId = base64_decode($encoded_id);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm System Removal</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600&display=swap');

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 600px;
            width: 100%;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            color: #0078d4; /* Microsoft blue */
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            margin-bottom: 30px;
        }

        a {
            color: #0078d4; /* Microsoft blue */
            text-decoration: none;
            font-weight: 600;
            margin: 0 15px;
        }

        a:hover {
            text-decoration: underline;
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Confirm System Removal</h1>
        <p>Are you sure you want to delete the system: <strong><?php echo htmlspecialchars($systemName); ?></strong>?</p>
        <div class="button-container">
            <a href="Add_System.php">Cancel</a>


            <a href="delete_system.php?F9K3N7T1L6J8X4R2M5=<?php echo urlencode(base64_encode($systemName)); ?>&H5L8P2T9J3K7X1R6M4=<?php echo base64_encode($systemId); ?>">Remove</a>


        </div>
    </div>
</body>
</html>
