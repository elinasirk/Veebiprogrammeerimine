<?php

  require("../../../config_vp2019.php");
  require("functions_main.php");
  require("functions_user.php");
  $database = "if19_elina_si_1";

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
  $myDescription = null;

	if(isset($_POST["submitProfile"])){
	$notice = storeUserProfile($_POST["description"], $_POST["bgcolor"], $_POST["txtcolor"]);
	if(!empty($_POST["description"])){
	  $myDescription = test_input($_POST["description"]);
	}
	$_SESSION["bgcolor"] = $_POST["bgcolor"];
	$_SESSION["txtcolor"] = $_POST["txtcolor"];
	} else {
	$myProfileDesc = showMyDesc();
	if($myProfileDesc != ""){
	  $myDescription = $myProfileDesc;
	}
	}

 /* 	if(isset($_POST["submitNewPassword"])){
		if (isset($_POST["oldPassword"]) and !empty($_POST["oldPassword"])){
		  $oldPassword = test_input($_POST["oldPassword"]);
		} else {
		  $oldPasswordError = "Palun sisesta oma kehtiv salasõna!";
		}

		}
		if (isset($_POST["newPassword"]) and !empty($_POST["newPassword"]){
		  $newPassword = test_input($_POST["newPassword"]);
		} else {
		  $newPasswordError = "Palun sisesta uus salasõna!";
		}

		if (!isset($_POST["newPassword"]) or strlen($_POST["newPassword"]) < 8){
		  $newPasswordError = "Palun sisesta parool, vähemalt 8 märki!";
		}

    	if (isset($_POST["confirmNewPassword"]) and !empty($_POST["confirmNewPassword"]){
		  $newPassword = test_input($_POST["confirmNewPassword"]);
		} else {
		  $newPasswordError = "Korda uut salasõna!";
		}
		
		if(empty($oldPasswordError) and empty($newPasswordError) and empty($confirmNewPasswordError) ){
		   $notice = signIn($email, $_POST["password"]);
		} else {
			$notice = "Ei saa parooli salvestada!";
		}
	  }  */

 

  require("header.php");
?>
<body>
  <?php
    echo "<h1>" .$userName ." kasutaja profiili muutmine</h1>";
  ?>
  <p>See leht on loodud koolis õppetöö raames
  ja ei sisalda tõsiseltvõetavat sisu!</p>
  <hr>
  <p><a href="?logout=1">Logi välja!</a>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <label>Minu kirjeldus</label><br>
	  <textarea rows="10" cols="80" name="description"><?php echo $myDescription; ?></textarea>
	  <br>
	  <label>Minu valitud taustavärv: </label><input name="bgcolor" type="color" value="<?php echo $mybgcolor; ?>"><br>
	  <label>Minu valitud tekstivärv: </label><input name="txtcolor" type="color" value="<?php echo $mytxtcolor; ?>"><br>
	  <input name="submitProfile" type="submit" value="Salvesta profiil">&nbsp;<span><?php echo $notice; ?>
	</form>

<p> Muuda salasõna: </p>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <label>Kehtiv salasõna:</label><br>
	  <input name="oldPassword" type="password"><span><?php echo $oldPasswordError; ?></span><br>
	  <label>Uus salasõna:</label><br>
	  <input name="newPassword" type="password"><span><?php echo $newPasswordError; ?></span><br>
	  <label>Korrake salasõna:</label><br>
	  <input name="confirmNewPassword" type="password"><span><?php echo $confirmNewPasswordError; ?></span><br>
	  <input name="submitNewPassword" type="submit" value="Salvesta salasõna"><span><?php echo $notice; ?></span>
	</form>

</body>
</html>
