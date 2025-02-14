<?php
include("classes/create_card.php");
include("classes/connect.php");


$encoded_name = $_GET['YzRlYjFhMDYxY2ZjYmQzZTYxZmY5M2Y1YmQzNTM3NzI'];
$systemName = base64_decode($encoded_name);




$encoded_id = $_GET['f4e8d9a4b2c1d4e5f6a7b8c9d0e1f2a3'];
$systemId = base64_decode($encoded_id);



if ($systemId) {
    $DB = new Database();
    $query = "SELECT visibility FROM system WHERE id = '$systemId'";
    $result = $DB->read($query);
    $visibility = (!empty($result) && isset($result[0]['visibility'])) ? $result[0]['visibility'] : 0;
} else {
    $visibility = 0; // Default to private if no systemId
}




if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['namecard']) && isset($_POST['question']) && isset($_POST['answer'])) {
    $card = new Card();
    $card->create_card($systemId, $_POST);
    header("Location: view_system.php?YzRlYjFhMDYxY2ZjYmQzZTYxZmY5M2Y1YmQzNTM3NzI=" . urlencode(base64_encode($systemName)) . "&f4e8d9a4b2c1d4e5f6a7b8c9d0e1f2a3=" . urlencode(base64_encode($systemId)));

    die;
} elseif (isset($_POST['form_type'])) {
    // Create new Database object
    $DB = new Database();
    $conn = $DB->connect();

    $id = mysqli_real_escape_string($conn, $systemId);

    // Determine visibility based on checkbox presence
    $visibility = isset($_POST['visibility']) && $_POST['visibility'] === 'on' ? 1 : 0;

    $query = "UPDATE system SET visibility = '$visibility' WHERE id = '$id'";
    $DB->save($query);
    header("Location: view_system.php?YzRlYjFhMDYxY2ZjYmQzZTYxZmY5M2Y1YmQzNTM3NzI=" . urlencode(base64_encode($systemName)) . "&f4e8d9a4b2c1d4e5f6a7b8c9d0e1f2a3=" . urlencode(base64_encode($systemId)));
    die;
}
}

// Fetch all cards for the system
$DB = new Database();

$query = "SELECT * FROM cards WHERE id = '$systemId'";
$cards = $DB->read($query);


?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo htmlspecialchars($systemName); ?></title>
    <style>
        a:hover {
            opacity: 70%;
        }
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f0f0; /* Light gray background */
            margin: 0;
            padding: 0;

            height: 100vh; /* Full viewport height */
            animation: fadeIn 1s;
        }
        @keyframes fadeIn {
  0% { opacity: 0; }
  100% { opacity: 1; }
}
        .privateupdate {
            background-color: #0078d4;
            border: 1px solid white;
            color: white;
            border-radius: 2px;
        }

        .center{
            flex: 2; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            font-size: 18px; 
            font-weight: bold;
        }



        .info-icon {
            font-size: 18px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            border: 1px solid white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            text-align: center;
            line-height: 18px;
            display: inline-block;
            position: relative;
        }
        #sidebaruseri {
    display: visible; 
    display: flex;
    flex-direction: column; 
    width: 100%; 
    margin-top: 20px; 
}

#sidebaruseri a {
    display: block; 
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    margin: 10px 0; 
    padding: 10px 15px; 
    border-radius: 5px; 
    transition: background-color 0.3s, color 0.3s; 
    display: flex;
    align-items:center;
}
#sidebaruseri a svg{
    margin-right: 8px; 
    vertical-align: middle; 

}
#sidebaruseri div {

    display: flex;
    align-items:center;
}
#sidebaruseri div svg{
    margin-right: 8px; 
    vertical-align: middle; 
}
        .info-icon::after {
            font-size: 14px;
            text-shadow:
    -1px -1px 0 #000,  
    1px -1px 0 #000,
    -1px 1px 0 #000,
    1px 1px 0 #000;
            content: 'Private mode will make your system invisible to visitors.';
            visibility: hidden;
            width: auto;
            background-color: #555;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            top: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0s;
            z-index: 1;
            white-space: nowrap;
        }

        .info-icon::after::before {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #555 transparent transparent transparent;
        }

        .info-icon:hover::after {
            visibility: visible;
            opacity: 1;
        }
        .formprivate{
            border: 1px solid #f0f0f0;
            padding: 5px;
            border-radius: 3px;
        }

        .actions{
            flex: 1;
             display: flex;
              align-items: center;
              display:flex;
              align-items:center;
        }

        #actionicon{
            display: none;
        }

        .refresh{
            text-decoration: none;
             color: white;
              font-size: 14px;
               font-weight: bold;
                margin-right: 10px;
                 display:flex; 
                 align-items:center;
        }
        .refresh svg{
            margin-right: 8px; 
            vertical-align: middle; 
        }
       .rename{
        font-size: 12px;
         color: white;
          background-color: #0078D7;
           padding: 3px 6px;
            border-radius: 3px;
 text-decoration:none;
       }

       #pen{
        display:none;
    }



        .container {
    width: 100%;
    min-height: 520px;
    height: auto;
    margin-top: 10px;
    display: flex;
    justify-content: space-around;
    margin-left: -10px;
    flex-wrap: wrap;
  }

  .column {
    width:23%;
    margin-bottom: 10px;
  }

  .header {
    height: 45px;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #0078d4;
    border-bottom: 2px solid black;
    padding: 10px;
    color: white;
    border-radius: 5px 5px 0 0;
    box-sizing: border-box;
  }
  #sidebari{
    display:none;
  }
  .menu-toggle {
    display: none; /* Hidden by default */
}
#sidepen{
        display:none;
    }

  .content {
    height:80vh;
    background-color: white;
    width: 100%;
    padding: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
    overflow-y: auto;
    border-radius: 0 0 5px 5px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    box-sizing: border-box;
  }

  @media (min-width: 1301px) {
    .column {
      flex: 1 1 23%; /* 4 columns on large screens */
    }
  }

  @media (max-width: 1300px) and (min-width: 768px) {
    .column {
      flex: 1 1 48%; /* 2 columns on medium screens */
    }
  }
  @media (max-width: 1200px) {

    .center p{
        display:none;
    }
    #pen{
        display:block;
    }

  }
  @media (max-width: 1090px) {
    #buttonlg {
        display: none;
    }

}
@media (max-width: 1090px) {

    #actionicon {
        display: block;
    }
}


  @media (max-width: 900px) {
    .column {
      flex: 1 1 100%; /* 1 column on small screens */
    }
  }
  @media (max-width: 768px) {
        #ADD {
            width: 90vw;
            right: 5%;
            height: 80vh;
        }

        #ADD div:first-child {
            height: 10vh;
        }

        form span input {
            width: 100%;
        }

        form textarea {
            height: 20vh;
            width: 100%;
        }

        form input[type="submit"] {
            padding: 8px 15px;
            font-size: 1em;
        }
    }
  @media (max-width: 500px) {
    .column {
      flex: 1 1 100%; /* 1 column on small screens */
    }
    #actionicon {
        display: none;
    }
    .refresh{
        display:none;
    }
    .center{
        display:none;
    }
    .menu-toggle {
    position: fixed;
    top: 5px;
    left: 15px;
    z-index: 200; 
    font-size: 24px;
    color: #0078d4;
    cursor: pointer;
    background: #fff;
    border: 1px solid #0078d4;
    border-radius: 5px;
    padding: 5px;
}
.menu-toggle {
        display: block; 
    }

            #sidebari {
                width: 90%;
    height: 100vh; /* Full viewport height */
    position: fixed;
    top: 0;
    left: 0;
    z-index: 100;
    padding: 20px;
    display: flex;
    flex-direction: column; 
    justify-content: flex-start; 
    align-items: flex-start; 
    background-color: #0078d4; 
    color: white;
    border-radius: 0 10px 10px 0; 
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1); 
    left: -110%; 
    transition: left 0.3s ease; 
}
#sidebari h2 {
    margin: 0;
    font-size: 16px; 
    text-align: center; 
    border-bottom: 2px solid #005a9e; 
    padding-bottom: 10px;
    width: 100%; 
    display:flex;
    align-items:center;
    margin-top:35px;
}

#sidebaruseri {
    display: visible; 
    display: flex;
    flex-direction: column; 
    width: 100%; 
    margin-top: 20px; 
}

#sidebaruseri a {
    display: block; 
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    margin: 10px 0; 
    padding: 10px 15px; 
    border-radius: 5px; 
    transition: background-color 0.3s, color 0.3s; 
    display: flex;
    align-items:center;
}
#sidebaruseri a svg{
    margin-right: 8px; 
    vertical-align: middle; 

}
#sidebaruseri div {

    display: flex;
    align-items:center;
}
#sidebaruseri div svg{
    margin-right: 8px; 
    vertical-align: middle; 
}

#sidebaruseri a:hover {
    background-color: #005a9e; 
    color: #fff; 
}

#core {
                margin-top: 80px;
                padding: 20px;
                background-color: #fff;
                border-radius: 10px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                min-height: 100vh;
            }


    #sidebari.open {
        left: 0; 
    }
    #sidepen{
        display:block;
    }
  }
    </style>
</head>
<body>






<div style="height: 90vh; width: 60vw; max-width: 100%; z-index: 1000; position: fixed; right: 20%; top: 5%; visibility: hidden;" id="ADD">
    <div style="height: 7vh; width: 100%; background-color: #0078d4; font-size: 1.5em; font-weight: bold; display: flex; justify-content: center; align-items: center; color: white; border-radius: 5px 5px 0 0;">
        Create Your New Card
    </div>
    <div style="height: 83vh; width: 100%; background-color: white; text-align: center; color: black; border-radius: 0 0 5px 5px; position: relative;">
        <div style="height:25px; width: 25px; background-color: red; font-size: 25px; border: none; color: white; font-weight: bold; display:flex; justify-content: center; align-items: center; position: absolute; top: 1%; right: 1%;">
            <button onclick="hideadd()" style="color: white; background-color: red; font-size: 25px; border: none; text-align: center;">x</button>
        </div>
        
        <form method="post" action="view_system.php?YzRlYjFhMDYxY2ZjYmQzZTYxZmY5M2Y1YmQzNTM3NzI=<?php echo urlencode(base64_encode($systemName)); ?>&f4e8d9a4b2c1d4e5f6a7b8c9d0e1f2a3=<?php echo urlencode(base64_encode($systemId)); ?>" style="height: 100%; max-height: 100%; display: flex; justify-content: center; align-items: center; flex-direction: column; padding: 20px; box-sizing: border-box;">
            <br><span style="display: inline-block;">Name: &nbsp;&nbsp;<input type="text" placeholder="Type here..." name="namecard" style="padding: 5px; border: 1px solid #ccc; border-radius: 3px; width: 80%;"></span><br><br>
            Question:<br> 
            <textarea name="question" placeholder="Type here..." style="height: 25vh; width: 80%; padding: 5px; border: 1px solid #ccc; border-radius: 3px; font-family: 'Roboto', sans-serif;"></textarea><br><br>
            Answer:<br> 
            <textarea name="answer" placeholder="Type here..." style="height: 20vh; width: 80%; padding: 5px; border: 1px solid #ccc; border-radius: 3px; font-family: 'Roboto', sans-serif;"></textarea><br><br>
            <input type="submit" value="Create" style="border: 1px solid #0078d4; color: white; background-color: #0078d4; padding: 10px 20px; border-radius: 3px; cursor: pointer;">
        </form>
    </div>
</div>

                <!-- Mobile Menu Button -->
                <div id="menu-toggle" class="menu-toggle">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-align-left"><line x1="21" x2="3" y1="6" y2="6"/><line x1="15" x2="3" y1="12" y2="12"/><line x1="17" x2="3" y1="18" y2="18"/></svg>
        </div>
<!-- Sidebar iphones -->
<div id="sidebari">
    <h2><?php echo htmlspecialchars($systemName); ?>
    &nbsp; <a href="rename_system.php?b9f34a0e7f8d6c1a0e9b3d5e7c8a1d2f=<?php echo urlencode(base64_encode($systemName)); ?>&d3f45b2c8e9d7a0f3c6b4d1e0a9e7b2c=<?php echo urlencode(base64_encode($systemId)); ?>" id="sidepen"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pen"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/></svg></a>
</h2>
   
    <div id="sidebaruseri">
        <div>
            <a href="Add_System.php" id="homeButton" style="text-decoration: none; color: #ffffff; font-size: 20px; font-weight: bold;">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-house">
                    <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/>
                    <path d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                </svg>
                Home
            </a>
        </div>
        <div>
            <button id="addCardButton" onclick="showadd()" style="text-decoration: none; color: #ffffff; font-size: 20px; font-weight: bold; background: none; border: none; margin-left:5px;" aria-label="Add Card">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus">
                    <path d="M5 12h14"/>
                    <path d="M12 5v14"/>
                </svg>
                Add Card
            </button>
        </div>
        <div class="">
        <a href="play.php?4c8d2e1b9a7f3c5e0d6a8b9c4f2e7d1a=<?php echo $encoded_name; ?>&a1b9c8d2e4f7a3b6d0e5c8a9f1b2c7d3=<?php echo $encoded_id ?>" id="buttonlg" style="text-decoration: none; color: #fff; font-size: 20px; font-weight: bold; ">
        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-play"><polygon points="6 3 20 12 6 21 6 3"/></svg>    
            Play</a>
        </div>
<div>
<?php
$systemQuery = "SELECT * FROM system WHERE id = '$systemId'";
$systemResult = $DB->read($systemQuery);
$system = (!empty($systemResult)) ? $systemResult[0] : null;

if ($system) {
?>
<form action="view_system.php?YzRlYjFhMDYxY2ZjYmQzZTYxZmY5M2Y1YmQzNTM3NzI=<?php echo urlencode(base64_encode($system['name'])); ?>&f4e8d9a4b2c1d4e5f6a7b8c9d0e1f2a3
=<?php echo urlencode(base64_encode($system['id'])); ?>" method="post" class="formprivate" style="border:none; font-size:20px;">
    <input type="hidden" name="form_type" value="<?php echo $systemId ?>">
    <input type="checkbox" id="visibility-<?php echo $systemId ?>" name="visibility" <?php echo $system['visibility'] ? 'checked' : ''; ?>>
    <label for="visibility-<?php echo $systemId ?>">Private</label>
    <span class="info-icon">i</span>
    <input type="submit" class="privateupdate" value="Update">
</form>
<?php
}
?>
</div>
<div>
<a href="refresh.php?6d1e7f8a=<?php echo base64_encode($systemName); ?>&5c9b2d3e=<?php echo base64_encode($systemId); ?>" class="refresh" style="font-size:20px">
        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rotate-cw"><path d="M21 12a9 9 0 1 1-9-9c2.52 0 4.93 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/></svg>
        Refresh Cards</a>
</div>
    </div>
</div>



<div style="" id="page">
    <div id="myDiv" style="height: 100%; width: 180px; background-color: white; position: absolute; left: -50%; border: 2px solid #DCDCDC; border-radius: 0 5px 0 5px">
        <button onclick="hidebar()" style="height: 25px; width: 45px; position: absolute; top: 1%; right: 2%; color: black; border: none; background-color: white; font-weight: bold; font-size: 20px;">x</button>
        <br><br>

        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="Add_System.php" style="text-decoration: none; color: black; font-size: 18px; font-weight: bold;">Home</a>



        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button onclick="showadd()" style="text-decoration: none; color: black; font-size: 18px; font-weight: bold; background-color: #0078D7; border: none; margin-left: -6px; font-size: 17px; ">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
        Add Card</button>

        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="play.php?name=<?php echo $systemName; ?>&id=<?php echo $systemId ?>" style="text-decoration: none; color: black; font-size: 18px; font-weight: bold;">Play</a>

    </div>

    <div style="height: 50px; width: 100%; display: flex; background-color: #0078d4; color: white; justify-content: space-between; ">
        <div class="actions">
        &nbsp;<a href="Add_System.php" id="buttonlg" style="text-decoration: none; color: #0078d4; font-size: 14px; font-weight: bold; border: 0.5px solid white; padding: 4px; border-radius: 4px; background-color:#fff;">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-house">
        <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/>
        <path d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
    </svg>    
    Home
</a>

<a href="Add_System.php" id="actionicon" style="text-decoration: none;">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-house"><path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/><path d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
</a>&nbsp;&nbsp;&nbsp;&nbsp;



            <button id="buttonlg" onclick="showadd()" style="text-decoration: none; color: #0078d4; font-size: 14px; font-weight: bold;background-color:#fff;border: 0.5px solid white; padding: 4px; border-radius: 4px; margin-left: -6px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            Add Card</button>
            <button id="actionicon" onclick="showadd()" style="text-decoration: none; margin-left: -6px; background: none; border: none;">
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
</button>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href="play.php?4c8d2e1b9a7f3c5e0d6a8b9c4f2e7d1a=<?php echo $encoded_name; ?>&a1b9c8d2e4f7a3b6d0e5c8a9f1b2c7d3=<?php echo $encoded_id ?>" id="buttonlg" style="text-decoration: none; color: #0078d4; font-size: 14px; font-weight: bold; border: 0.5px solid white; padding: 4px; border-radius: 4px; background-color:#fff;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="white" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-play"><polygon points="6 3 20 12 6 21 6 3"/></svg>    
            Play</a>
            <a href="play.php?4c8d2e1b9a7f3c5e0d6a8b9c4f2e7d1a=<?php echo $encoded_name; ?>&a1b9c8d2e4f7a3b6d0e5c8a9f1b2c7d3=<?php echo $encoded_id ?>" id="actionicon" style="text-decoration: none; ">
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-play"><polygon points="6 3 20 12 6 21 6 3"/></svg>  
            </a>
        </div>

        <div class="center">
            <p><?php echo htmlspecialchars($systemName); ?>
                    
            <a href="rename_system.php?b9f34a0e7f8d6c1a0e9b3d5e7c8a1d2f=<?php echo urlencode(base64_encode($systemName)); ?>&d3f45b2c8e9d7a0f3c6b4d1e0a9e7b2c=<?php echo urlencode(base64_encode($systemId)); ?>" class="rename"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pen"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/></svg>Rename</a>


            &nbsp;&nbsp;&nbsp;&nbsp;

        
        </p>
        <a href="rename_system.php?b9f34a0e7f8d6c1a0e9b3d5e7c8a1d2f=<?php echo urlencode(base64_encode($systemName)); ?>&d3f45b2c8e9d7a0f3c6b4d1e0a9e7b2c=<?php echo urlencode(base64_encode($systemId)); ?>" id="pen"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pen"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/></svg></a>&nbsp;&nbsp;



            <?php
$systemQuery = "SELECT * FROM system WHERE id = '$systemId'";
$systemResult = $DB->read($systemQuery);
$system = (!empty($systemResult)) ? $systemResult[0] : null;

if ($system) {
?>
<form action="view_system.php?YzRlYjFhMDYxY2ZjYmQzZTYxZmY5M2Y1YmQzNTM3NzI=<?php echo urlencode(base64_encode($system['name'])); ?>&f4e8d9a4b2c1d4e5f6a7b8c9d0e1f2a3
=<?php echo urlencode(base64_encode($system['id'])); ?>" method="post" class="formprivate">
    <input type="hidden" name="form_type" value="<?php echo $systemId ?>">
    <input type="checkbox" id="visibility-<?php echo $systemId ?>" name="visibility" <?php echo $system['visibility'] ? 'checked' : ''; ?>>
    <label for="visibility-<?php echo $systemId ?>">Private</label>
    <span class="info-icon">i</span>
    <input type="submit" class="privateupdate" value="Update">
</form>
<?php
}
?>




        </div>





        <div style="flex: 1; display: flex; align-items: center; justify-content: flex-end;">


        <a href="refresh.php?6d1e7f8a=<?php echo base64_encode($systemName); ?>&5c9b2d3e=<?php echo base64_encode($systemId); ?>" class="refresh">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rotate-cw"><path d="M21 12a9 9 0 1 1-9-9c2.52 0 4.93 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/></svg>
        Refresh Cards</a>


        </div>
    </div>



    <div class="container">
    <div class="column">
        <div class="header">Level 3 - Difficult</div>
        <div class="content">
            <?php
            if (is_array($cards) && !empty($cards)) {
                foreach ($cards as $card) {
                    if ($card['level'] == 3) {
                        // Display each card in Level 3 (modify as needed)
                        include("card_Add_Card.php");
                    }
                }
            } else {
                echo "";
            }
            ?>
        </div>
    </div>
    <div class="column">
        <div class="header">Level 2 - Medium</div>
        <div class="content">
            <?php
            if (is_array($cards) && !empty($cards)) {
                foreach ($cards as $card) {
                    if ($card['level'] == 2) {
                        // Display each card in Level 2 (modify as needed)
                        include("card_Add_Card.php");
                    }
                }
            } else {
                echo "";
            }
            ?>
        </div>
    </div>
    <div class="column">
        <div class="header">Level 1 - Easy</div>
        <div class="content">
            <?php
            if (is_array($cards) && !empty($cards)) {
                foreach ($cards as $card) {
                    if ($card['level'] == 1) {
                        // Display each card in Level 1 (modify as needed)
                        include("card_Add_Card.php");
                    }
                }
            } else {
                echo "";
            }
            ?>
        </div>
    </div>
    <div class="column">
        <div class="header">Mastered</div>
        <div class="content">
            <?php
            if (is_array($cards) && !empty($cards)) {
                foreach ($cards as $card) {
                    if ($card['level'] == 0) {
                        // Display each card in Mastered (modify as needed)
                        include("card_Add_Card.php");
                    }
                }
            } else {
                echo "";
            }
            ?>
        </div>
    </div>
</div>






    <script>
        function showadd() {
            var div1 = document.getElementById('myDiv');
            div1.style.left = '-50%';

            var div2 = document.getElementById('page');
            div2.style.opacity = '10%';

            var div3 = document.getElementById('ADD');
            div3.style.visibility = 'visible';
        }

        function hideadd() {
            var div1 = document.getElementById('myDiv');
            div1.style.left = '-50%';

            var div2 = document.getElementById('page');
            div2.style.opacity = '100%';

            var div3 = document.getElementById('ADD');
            div3.style.visibility = 'hidden';
        }
        
        document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menu-toggle');
    const sidebari = document.getElementById('sidebari');

    menuToggle.addEventListener('click', function() {
        sidebari.classList.toggle('open');
    });
});
      
    </script>
</body>
</html>
