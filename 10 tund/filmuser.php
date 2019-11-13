<?php 

  require("../../../config_vp2019.php");
  require("functions_main.php");
  require("functions_user.php");
  require("functions_film.php");
  $database = "if19_elina_si_1";
  require("header.php");
  
     //kui pole sisseloginud
  if(!isset($_SESSION["userId"])){
	  //siis jõuga sisselogimise lehele
	  header("Location: myindex.php");
	  exit();
  }
  
  //väljalogimine
  if(isset($_GET["logout"])){
	  session_destroy();
	  header("Location: myindex.php");
	  exit();
  }
  $userName = $_SESSION["userFirstname"] ." " .$_SESSION["userLastname"];
  
  $notice = null;
  $filmSearchError = null;
  $filmSearch = null;
  
  
  ?>
  <p>See leht on loodud koolis õppetöö raames ja ei sisalda tõsiseltvõetavat sisu!</p>
  <hr>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <label>Otsi andmebaasist:</label><br>
	  <input name="filmSearch" type="text" value="<?php echo $filmSearch; ?>"><span><?php echo $filmSearchError; ?></span><br>
	  <input name="submitSearch" type="submit" value="Otsi andmebaasist"><span><?php echo $notice; ?></span>
  <hr>
  <h2>Eesti filmid</h2>
  <p>Praegu on andmebaasis järgmised filmid:</p>
  <?php
    $filmInfoHTML = readAllFilms();
		echo $filmInfoHTML;