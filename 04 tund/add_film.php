<?php
  require("../../../config_vp2019.php");
  require("functions_film.php");
  // echo $serverHost;
  $userName = "Elina Sirk";
  $database = "if19_elina_si_1";
  //var_dump($_POST);
  
  if(isset($_POST["submitFilm"])){
    if(!empty($_POST["filmTitle"])){
	  storeFilmInfo($_POST["filmTitle"], $_POST["filmYear"], $_POST["filmDuration"], $_POST["filmGenre"], $_POST["filmStudio"], $_POST["filmDirector"]);
	}
  }
  //$filmInfoHtml = readAllFilms();
 
  require("header.php");
  echo "<h1>" .$userName .", veebiprogrammeerimine 2019</h1>"; 

  ?>
  <p> See veebileht on valminud õppetöökäigus ja ei sisalda tõsiseltvõetavat infot! </p>
  <hr>
  <h2>Eesti filmi info lisamine</h2>
  <p> Meie andmebaasi uue filmi lisamine: </p>
  <hr>
  <form method="POST">
    <label>Filmi pealkiri: </label>
	<input type="text" name="filmTitle">
	<br>
	<label>Filmi tootmisaasta: </label>
	<input type="number" min="1912" max="2019" value="2019" name="filmYear">
	<br>
	<label>Filmi kestus (min): </label>
	<input type="number" min="1" max="300" value="80" name="filmDuration">
	<br>
	<label>Filmi žanr: </label>
	<input type="text" name="filmGenre">
	<br>
	<label>Filmi tootja: </label>
	<input type="text" name="filmCompany">
	<br>
	<label>Filmi lavastaja: </label>
	<input type="text" name="filmDirector">
	<br>
	<input type="submit" value="Talleta filmi info" name="submitFilm">
	</form>
  
  </body>
  </html>