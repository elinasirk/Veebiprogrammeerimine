<?php
  
  function readAllFilms(){
	  //loome andmebaasi ühenduse
      $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	  //valmistame ette sql päringu, näiteks muutuja nimega $query või...
	  $stmt = $conn->prepare("SELECT pealkiri, aasta FROM film");
	  echo $conn->error;
	  //Seome saadava tulemuse muutujaga
	  $stmt->bind_result($filmTitle, $filmYear);
	  //täidame käsu ehk sooritame päringu
	  $stmt->execute();
	  echo $stmt->error;
	  $filmInfoHtml = null;
	  //võtan tulemuse (pinu ehk stack)
	  while($stmt->fetch()){
		//echo $filmTitle;
		$filmInfoHtml .= "<h3>" .$filmTitle ."</h3>";
		$filmInfoHtml .= "<p>" .$filmYear ."</p>";
	  }
	  //sulgeme ühendused
	  $stmt->close();
	  $conn->close();
	  return $filmInfoHtml;
  }
  
  function storeFilmInfo($filmTitle, $filmYear, $filmDuration, $filmGenre, $filmStudio, $filmDirector){
	  //echo "jee";
	  $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	  $stmt = $conn->prepare("INSERT INTO film (pealkiri, aasta, kestus, zanr, tootja, lavastaja) VALUES(?, ?, ?, ?, ?, ?)");
	  echo $conn->error;
	  // seon saadetava info muutujatega
	  //andmetüübid: s-string, i-integer, d-decimal
	  $stmt->bind_param("siisss", $filmTitle, $filmYear, $filmDuration, $filmGenre, $filmStudio, $filmDirector);
	  $stmt->execute();
	  
	  $stmt->close();
	  $conn->close();
	  //return $filmInfoHtml;
  }