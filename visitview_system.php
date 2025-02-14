<?php
include("classes/create_card.php");
include("classes/connect.php");

$systemName = isset($_GET['Z5N1R8L3T7J4K9X2M6']) ? base64_decode($_GET['Z5N1R8L3T7J4K9X2M6']) : 'No system selected';
$systemId = isset($_GET['B7Q3P9F2L6T1X8R4M5']) ? base64_decode($_GET['B7Q3P9F2L6T1X8R4M5']) : null;
$userid =  base64_decode($_GET['Y8K2N4T9L5J1X3R6M7']);
$username = base64_decode($_GET['C6R1L9T4J2K8X7M3Q5']);




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
        }
        .background-iframe {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
            z-index: -1; /* Place it behind other content */
        }
        .container {
    width: 100%;
    min-height: 520px;
    height: auto;
    margin-top: 10px;
    display: flex;
    justify-content: space-around;

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
  .options{
    flex: 1;
     display: flex;
      align-items: center;
      display:flex;
      align-items:center;
  }
  .options svg{
    margin-right: 8px; 
    vertical-align: middle; 
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
  .systemname{
    display:block;
    flex: 2; 
    display: flex;
     justify-content: center; 
     align-items: center; 
     font-size: 18px; 
     font-weight: bold;
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
    @media (max-width: 520px) {
   .systemname{
    display:none;
   }
    }
  }
    </style>
</head>
<body>

<iframe class="background-iframe" src="techbg.php" allowfullscreen></iframe>




<div style="" id="page">
 

    <div style="height: 50px; width: 100%; display: flex; background-color: #0078d4; color: white; justify-content: space-between;">


        <div class="options">
            &nbsp&nbsp;<a href="visit.php?A9R4V2k8T7L1X5M3Q=<?php echo base64_encode($userid) ?>&J6N8W1F9C2P7D4L0Z=<?php echo base64_encode($username) ?>" style="text-decoration: none; color: white; font-size: 14px; font-weight: bold;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-door-open"><path d="M13 4h3a2 2 0 0 1 2 2v14"/><path d="M2 20h3"/><path d="M13 20h9"/><path d="M10 12v.01"/><path d="M13 4.562v16.157a1 1 0 0 1-1.242.97L5 20V5.562a2 2 0 0 1 1.515-1.94l4-1A2 2 0 0 1 13 4.561Z"/></svg>    
            Exit</a>



            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href="visitplay.php?G4K8N1T7L3J9X2R5M6=<?php echo urlencode(base64_encode($systemName)); ?>&H7L3P9F1T6X8R2M4J5=<?php echo base64_encode($systemId); ?>&V8K2N5T9L4J1X3R7M6=<?php echo base64_encode($userid); ?>&B6R1L8T4J3K9X7M2Q5=<?php echo base64_encode($username); ?>" style="text-decoration: none; color: white; font-size: 14px; font-weight: bold;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-play"><polygon points="6 3 20 12 6 21 6 3"/></svg>    
            Play</a>


        </div>
        <div class="systemname">
            <?php echo htmlspecialchars($systemName); ?>
        </div>
        <div style="flex: 1; display: flex; align-items: center; justify-content: flex-end;">

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
                        include("viewcard_Add_Card.php");
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
                        include("viewcard_Add_Card.php");
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
                        include("viewcard_Add_Card.php");
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
                        include("viewcard_Add_Card.php");
                    }
                }
            } else {
                echo "";
            }
            ?>
        </div>
    </div>
    </div>
</div>






    <script>
        function showbar() {
            var div = document.getElementById('myDiv');
            div.style.left = '0%';
        }

        function hidebar() {
            var div = document.getElementById('myDiv');
            div.style.left = '-50%';
        }

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
        
        function modify() {
            var finish = document.getElementById('finish');
            var modify = document.getElementById('modify');
            finish.style.visibility = 'visible';
            modify.style.visibility = 'hidden';
            var deletecards = document.getElementsByClassName('deletecard');
            var hidelevel = document.getElementsByClassName('cardlevel');
            for (var i = 0; i < deletecards.length; i++) {
                deletecards[i].style.visibility = 'visible';
                deletecards[i].style.float = 'right';
            }
            for (var i = 0; i < hidelevel.length; i++) {
                hidelevel[i].style.visibility = 'hidden';
            }
        }

        function finish() {
            var finish = document.getElementById('finish');
            var modify = document.getElementById('modify');
            finish.style.visibility = 'hidden';
            modify.style.visibility = 'visible';
            var deletecards = document.getElementsByClassName('deletecard');
            var hidelevel = document.getElementsByClassName('cardlevel');
            for (var i = 0; i < deletecards.length; i++) {
                deletecards[i].style.visibility = 'hidden';
                deletecards[i].style.float = '';
            }
            for (var i = 0; i < hidelevel.length; i++) {
                hidelevel[i].style.visibility = 'visible';
            }
        }
    </script>
</body>
</html>
