<?php


?>

<!DOCTYPE html>
<html>
<head>
    <title>NLS | Leitner System</title>
    <style>
        a:hover {
            opacity: 70%;
        }
        body {
  font-family: 'Roboto', sans-serif;
  background-color: black;
}


#bar{
  height: 95px;
  background-color: black;
  color: white;
  border-bottom: 1.3px solid white;
  display: flex;
  margin-top: 0px;
  opacity: 100%;
}
#signup_button{
  background-color: black;
  font-size: 13px;

  flex: 1;
  text-decoration: none;
  color: white;
    </style>
</head>
<body>

<div style="height: 40%; width: 35%; z-index: 1000; position: absolute; top: 30%; right:32.5%; visibility: hidden;" id="popup">

    <div style="height: 20%; width: 100%; background-color: black; font-size: 15px; font-weight: bold; display:flex; justify-content: center; align-items: center; color: white; border-radius: 5px 5px 0 0; ">
        Create Your New System
    </div>

    <div style="height: 50%; width: 100%; background-color: black; display:flex; justify-content: center; align-items: center; opacity: 120%; border-radius: 0 0 5px 5px;">

        <div style="height:25px; width: 25px; background-color: black; font-size: 25px; border: none; color: white; font-weight: bold; display:flex; justify-content: center; align-items: center; position: absolute; top: 1%; right: 0%;">

            <button type="button" onclick="hideAdd()" style="height: 100%; width: 100%; background-color: black; color: white; font-weight: bold; font-size: 20px; border: none;">
                x
            </button>

        </div>
        <form method="post" action="Add_System.php">
            <span style="color: white;">Name:</span> &nbsp;
            <input value="<?php echo $name; ?>" type="text" placeholder="Type here..." id="text" name="name" style="height: 30px; width: 200px; font-size: 15px; border-radius: 3px; border: none; font-family: 'Roboto', sans-serif;"> &nbsp;&nbsp;

            <input type="submit" id="button" value="Create" style="color: white; border: 1px solid white; border-radius: 3px; background-color: black; font-size: 16px;">
        </form>
    </div>
</div>













<div id="core">


<div id="bar" >


           <div style=" font-size: 15px;  flex: 2; display: flex; justify-content: left; align-items: center; font-weight: bold; ">
            
           &nbspNumerical<br> &nbspLeitner<br> &nbspSystem
          
          </div> 
           
           <div style=" flex: 1; display: flex; justify-content: right; align-items: flex-end; font-size: 11px;">
            
           User:&nbsp&nbsp|&nbsp&nbsp
           
          <div><a href="login.php" id="signup_button" >Logout</a></div>&nbsp&nbsp|&nbsp&nbsp

          <button onclick="showAdd()" style="background-color: black; color: white; border: none;">
            Add a system
        </button>

          
           </div> </div>




    <div style="margin-top: 30px; display: flex; flex-direction: column; align-items: center;">
        
        <div style="background-color: #DCDCDC; flex: 1; width: 98%; min-height: 475px; overflow-y: auto; border-radius: 5px;">
        <?php
            if ($systems) {
                foreach ($systems as $system) {
                    include("card.php"); // Include card template
                }
            } else {
                echo "You have no systems.";
            }
            ?>

       
    </div>
</div>


</div>














<script>
function showAdd(){
    var div1 = document.getElementById('core');
    div1.style.opacity = '10%';
    var div2 = document.getElementById('popup');
    div2.style.visibility = 'visible';
}

function hideAdd(){
    var div1 = document.getElementById('core');
    div1.style.opacity = '100%';
    var div2 = document.getElementById('popup');
    div2.style.visibility = 'hidden';
}
</script>

</body>
</html>
