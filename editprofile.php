<?php
session_start();

include("classes/connect.php");
include("classes/login.php");

$login = new Login();
$user_data = $login->check_login($_SESSION['nls_db_userid']);
$userid = $_SESSION['nls_db_userid'];

$show_success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit']) && isset($_POST['username']) && isset($_POST['school']) && isset($_POST['biography'])) {
    $new_username = $_POST['username'];
    $new_school = $_POST['school'];
    $new_bio = $_POST['biography'];

    if ($userid) {
        // Establishing database connection
        $DB = new Database();
        $connection = $DB->connect();

        // Escaping special characters
        $new_username = mysqli_real_escape_string($connection, $new_username);
        $new_school = mysqli_real_escape_string($connection, $new_school);
        $new_bio = mysqli_real_escape_string($connection, $new_bio);
        $userid = mysqli_real_escape_string($connection, $userid);

        $query = "UPDATE users SET username = '$new_username', university = '$new_school', biography = '$new_bio' WHERE userid = '$userid'";
        $success = $DB->save($query);

        if ($success) {
            // Redirect with a success parameter to trigger the toast
            header("Location: editprofile.php?success=1");
            die();
        } else {
            echo "Error modifying the profile";
        }
    } else {
        echo "Invalid system ID";
    }
}

// Check if the success parameter is set in the URL to show the toast
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $show_success = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            min-height: 100vh;
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        .main {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: 500px;
            border-radius: 8px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            box-sizing: border-box;
        }

        form {
            display: flex;
            width: 100%;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: 600;
            margin-bottom: 5px;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
            height: 100px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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

        .modify {
            color: white;
            background-color: #0078D7;
            padding: 10px;
            border-radius: 4px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s, opacity 0.3s;
        }

        .modify:hover {
            background-color: #005a9e;
        }

        /* Toast Notification */
        .toast {
            visibility: hidden;
            max-width: 50%;
            margin: 0 auto;
            background-color: #0078D7;
            color: white;
            text-align: center;
            border-radius: 5px;
            padding: 16px;
            position: fixed;
            z-index: 1;
            left: 0;
            right: 0;
            bottom: 30px;
            font-size: 17px;
            box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.2);
        }

        .toast.show {
            visibility: visible;
            animation: fadeInOut 3s ease-in-out;
        }

        @keyframes fadeInOut {
            0% { bottom: 0; opacity: 0; }
            20% { bottom: 30px; opacity: 1; }
            80% { bottom: 30px; opacity: 1; }
            100% { bottom: 0; opacity: 0; }
        }

        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            #cancelButton {
                top: 10px;
                left: 10px;
                padding: 5px 8px;
                font-size: 12px;
            }
            .modify {
                font-size: 14px;
                padding: 8px;
            }
            .toast {
                max-width: 80%;
                font-size: 15px;
            }
        }
    </style>
</head>
<body>

<a id="cancelButton" href="Add_System.php">Back</a>

<div class="main">
    <form method="post" action="editprofile.php">
        <input type="hidden" name="edit" value="<?php echo $userid ?>">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $user_data['username']; ?>">
        </div>
        <div class="form-group">
            <label for="school">School:</label>
            <input type="text" id="school" name="school" value="<?php echo $user_data['university']; ?>">
        </div>
        <div class="form-group">
            <label for="biography">Biography:</label>
            <textarea id="biography" name="biography"><?php echo $user_data['biography']; ?></textarea>
        </div>
        <input type="submit" class="modify" value="Modify">
    </form>
</div>

<?php if ($show_success): ?>
    <div id="toast" class="toast">Profile updated successfully!</div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toast = document.getElementById('toast');
            toast.className = 'toast show';

            // Wait for the animation to complete before refreshing the page
            // Automatically hide the toast after it fades out without refreshing the page
            setTimeout(function() {
                toast.className = toast.className.replace("show", "");
            }, 3000); // Matches the duration of the toast animation
        });
    </script>
<?php endif; ?>

</body>
</html>
