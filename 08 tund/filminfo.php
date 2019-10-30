<?php
  require("../../../config_vp2019.php");
  require("functions_film.php");
  // echo $serverHost;
  $userName = "Elina Sirk";
  $database = "if19_elina_si_1";
  
  $filmInfoHTML = readAllFilms();
  $filmAge = 30;
  $oldFilmInfoHTML = readOldFilms($filmAge);
	
  //lisame lehe päise
  require("header.php");
?>


<body>
  <?php
    echo "<h1>" .$userName ." Veebiprogrammeerimine </h1>";
  ?>
  <p>See leht on loodud koolis õppetöö raames ja ei sisalda tõsiseltvõetavat sisu!</p>
  <hr>
  <h2>Eesti filmid</h2>
  <p>Praegu on andmebaasis järgmised filmid:</p>
  <?php
	//echo "Server: " .$serverHost .", kasutaja: " .$serverUsername;
	echo $filmInfoHTML;
	echo "<hr>";
	echo "<h2>Filmid, mis on vanemad, kui " .$filmAge ." aastat.</h2>";
	echo $oldFilmInfoHTML;
  ?>
</body>
</html>
