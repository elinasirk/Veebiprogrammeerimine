
<?php
  require("../../../config_vp2019.php");
  require("functions_main.php");
  require("functions_user.php");
  $database = "if19_elina_si_1";
  
  $userName = "Sisselogimata kasutaja";
  
  $notice = "";
  $email = "";
  $emailError = "";
  $passwordError = "";
  
  
  $photoDir = "../photos/";
  $photoTypesAllowed = ["image/jpeg", "image/png"];
  
  $weekdayNamesET = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
  $monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
  $weekdayNow = date("N");
  $dateNow = date("d");
  $monthNow = date("m");
  $yearNow = date("Y");
  $timeNow = date("H:i:s");
  $fullTimeNow = date("d.m.Y H:i:s");
  $hourNow = date("H");
  $partOfDay = "hägune aeg";

  
  {if($hourNow < 10 and $hourNow > 6)
	$partOfDay = "on hommik";
  if($hourNow == 12)
    $partOfDay = "on päev";
  if($hourNow > 10 and $hourNow < 12)
    $partOfDay = "on ennelõuna";
  if($hourNow > 12 and $hourNow < 18)
	$partOfDay = "on pärastlõuna";
  if($hourNow >= 18 and $hourNow < 24)
	$partOfDay = "on õhtu";
  if($hourNow == 24)
	$partOfDay = "on kesköö"; 
  if($hourNow < 6)
	$partOfDay = "on öö";}


  
  //info semestri kulgemise kohta
  $semesterStart = new DateTime ("2019-9-2");
  $semesterEnd = new DateTime ("2019-12-13");
  $semesterDuration = $semesterStart -> diff($semesterEnd);
  //echo $semesterStart; //objekti nii näidata ei saa!!!
  //var_dump ($semesterStart);
  //echo $semesterStart -> timezone;
  $today = new DateTime("now");
  $fromSemesterStart = $semesterStart -> diff($today);
  //var_dump($fromSemesterStart);
  //echo $fromSemesterStart -> days;
  //echo "Päevi:" .$fromSemesterStart -> format("%r%a");
  //<p> Semester on täies hoos: <meter min="0" max="110" value="15" > 17% </meter></p>
  if ($fromSemesterStart -> format("%r%a") >= 0 and $fromSemesterStart -> format("%r%a") <= $semesterDuration -> format("%r%a")){
	  $semesterInfoHTML = "<p> Semester on täies hoos: ";
	  $semesterInfoHTML .= '<meter min="0" ';
	  $semesterInfoHTML .= 'max="'. $semesterDuration -> format ("%r%a") .'" ';
	  $semesterInfoHTML .= 'value="' .$fromSemesterStart -> format("%r%a") .'">';
	  $semesterInfoHTML .= round($fromSemesterStart -> format("%r%a") / $semesterDuration -> format("%r%a") * 100, 1) ."%";
	  $semesterInfoHTML .= "</meter></p>";  
      }
 if($fromSemesterStart -> format("%r%a") < 0){
		$semesterInfoHTML = "<p>Semester veel ei käi.</p>";
	}
	if($fromSemesterStart -> format("%r%a") > $semesterDuration -> format("%r%a")){
		$semesterInfoHTML = "<p>Semester on läbi</p>";
	}
   
     //juhusliku foto kasutamine
     $photoList = [];//array ehk massiiv
	 
	 $allFiles = array_slice (scandir($photoDir), 2);
	 //kontrollin, kas on pildid
	 //var_dump($allFiles);
	 foreach ($allFiles as $file){
		 $fileInfo = getimagesize($photoDir .$file);
		 //var_dump($fileInfo);
		 if (in_array($fileInfo["mime"],$photoTypesAllowed) == true){
			 array_push($photoList, $file);
		 }
	 }
	 
	 $photoCount = count($photoList);
	 $randomImgHTML = "";
	 if ($photoCount > 0){
	 $photoNum = mt_rand(0, $photoCount - 1);
	 //echo $photoNum;
	 $randomImgHTML = '<img src="' .$photoDir .$photoList[$photoNum] .'" alt="Juhuslik foto">';
	 } else {
		 $randomImgHTML = "<p>Kahjuks pilte pole!</p>";
	 }
	 
	 //sisselogimise vorm
	if(isset($_POST["login"])){
		if (isset($_POST["email"]) and !empty($_POST["email"])){
		  $email = test_input($_POST["email"]);
		} else {
		  $emailError = "Palun sisesta kasutajatunnusena e-posti aadress!";
		}
	  
		if (!isset($_POST["password"]) or strlen($_POST["password"]) < 8){
		  $passwordError = "Palun sisesta parool, vähemalt 8 märki!";
		}
	  
		if(empty($emailError) and empty($passwordError)){
		   $notice = signIn($email, $_POST["password"]);
		} else {
			$notice = "Ei saa sisse logida!";
		}
	  }
	 
	 require("header.php");
    
  
    echo "<h1>" .$userName .", veebiprogrammeerimine 2019</h1>"; 
	  ?>
  <p> See veebileht on valminud õppetöö käigus ning ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
  <p> See siin on teine lõik sellel veebilehel. </p>
  
<?php
  echo $semesterInfoHTML;
  echo "<p>See on minu esimene PHP!</p>";
  echo "<p> Lehe avamise hetkel oli aeg: " .$weekdayNamesET[$weekdayNow - 1] .", " .$dateNow .". " .$monthNamesET[$monthNow - 1] ." " .$yearNow ." kell " .$timeNow ." , ". $partOfDay ."</p>";
?>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <label>E-mail (kasutajatunnus):</label><br>
	  <input type="email" name="email" value="<?php echo $email; ?>">&nbsp;<span><?php echo $emailError; ?></span><br>
	  
	  <label>Salasõna:</label><br>
	  <input name="password" type="password">&nbsp;<span><?php echo $passwordError; ?></span><br>
	  
	  <input name="login" type="submit" value="Logi sisse">&nbsp;<span><?php echo $notice; ?>
	</form>
<hr>
  
  <?php
  echo $randomImgHTML;
  ?>
  
</body>
</html>