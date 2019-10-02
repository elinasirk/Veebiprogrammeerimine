<?php
  require("../../../config_vp2019.php");
  require("functions_film.php");
  // echo $serverHost;
  $userName = "Elina Sirk";
  $database = "if19_elina_si_1";
  
  
  $filmInfoHTML = readAllFilms();
 
  require("header.php");
  echo "<h1>" .$userName .", veebiprogrammeerimine 2019</h1>"; 

  ?>
  <p> See veebileht on valminud õppetöökäigus ja ei sisalda tõsiseltvõetavat infot! </p>
  <hr>
  <h2>Eesti filmid</h2>
  <p> Meie andmebaasi filmid: </p>
  <hr>
  <?php
    echo $filmInfoHTML
	?>
  
  </body>
  </html>
  