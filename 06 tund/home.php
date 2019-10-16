
<?php
  require("../../../config_vp2019.php");
  require("functions_main.php");
  require("functions_user.php");
  $database = "if19_elina_si_1";
  
  //kontrollime kas on sisseloginud
  if(!isset($_SESSION["userId"])){
	  header("Location: myindex.php");
	  exit();
  }
  
  //väljalogimine
  if(isset($_GET["logout"])){
	 //sessioon kinni
	 session_unset();
	 session_destroy();
	 header("Location: myindex.php");
	 exit();	
  }
  
  $userName = $_SESSION["userFirstname"] ." " .$_SESSION["userLastname"];
   
  require("header.php");
  
  echo "<h1>" .$userName .", veebiprogrammeerimine 2019</h1>"; 
	  ?>
  <p> See veebileht on valminud õppetöö käigus ning ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
  <hr>
  <p> Olete sisse loginud! Logi <a href="?logout=1">välja</a>!</p>
  
</body>
</html>