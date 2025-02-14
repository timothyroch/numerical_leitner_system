<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("classes/connect.php");

// Decode parameters
$systemName = isset($_GET['b9f34a0e7f8d6c1a0e9b3d5e7c8a1d2f']) ? base64_decode($_GET['b9f34a0e7f8d6c1a0e9b3d5e7c8a1d2f']) : 'No system selected';
$systemId = isset($_GET['d3f45b2c8e9d7a0f3c6b4d1e0a9e7b2c']) ? base64_decode($_GET['d3f45b2c8e9d7a0f3c6b4d1e0a9e7b2c']) : null;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['new_name'])) {

    $new_name = $_POST['new_name'];

    if ($systemId) {
                // Establishing database connection
                $DB = new Database();
                $connection = $DB->connect(); // Assuming $DB->connection gives you the mysqli connection

                $newname = mysqli_real_escape_string($connection, $new_name);

        $DB = new Database();

        $query = "UPDATE system SET name = '$newname' WHERE id = '$systemId'";
        $success = $DB->save($query);

        if ($success) {
            header("Location: view_system.php?YzRlYjFhMDYxY2ZjYmQzZTYxZmY5M2Y1YmQzNTM3NzI=" . urlencode(base64_encode($new_name)) . "&f4e8d9a4b2c1d4e5f6a7b8c9d0e1f2a3=" . urlencode(base64_encode($systemId)));
            exit();
            
        } else {
            echo "Error updating system name.";
        }
    } else {
        echo "Invalid system ID.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rename System</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        .container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .container input[type="text"] {
            width: 80%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .container input[type="submit"] {
            background-color: #0078d4; /* Microsoft blue */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: opacity 0.3s ease;
        }

        .container input[type="submit"]:hover {
            opacity: 0.8;
        }

        .container a {
            display: block;
            margin-top: 20px;
            color: #0078d4; /* Microsoft blue */
            text-decoration: none;
            font-size: 14px;
            transition: opacity 0.3s ease;
        }

        .container a:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Rename System</h1>
        <a href="view_system.php?YzRlYjFhMDYxY2ZjYmQzZTYxZmY5M2Y1YmQzNTM3NzI=<?php echo urlencode(base64_encode($systemName)); ?>&f4e8d9a4b2c1d4e5f6a7b8c9d0e1f2a3=<?php echo urlencode(base64_encode($systemId)); ?>">Cancel</a>


        <form method="POST" action="rename_system.php?b9f34a0e7f8d6c1a0e9b3d5e7c8a1d2f=<?php echo urlencode(base64_encode($systemName)); ?>&d3f45b2c8e9d7a0f3c6b4d1e0a9e7b2c=<?php echo urlencode(base64_encode($systemId)); ?>">


            <input type="hidden" name="id" value="<?php echo $systemId; ?>">
            <input type="text" name="new_name" value="<?php echo $systemName; ?>">
            <br><br>
            <input type="submit" value="Update System Name">
        </form>
    </div>
</body>
</html>
