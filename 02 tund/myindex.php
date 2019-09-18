<?php
  $userName = "Elina Sirk";
  $fullTimeNow = date("d.m.Y H:i:s");
  $hourNow = date("H");
  $partOfDay = "hägune aeg";
  
  {if($hourNow < 10 and $hourNow > 6)
    $partOfDay = "on hommik";
  if($hourNow == 12)
    $partOfDay = "on keskpäev";
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
?>
<!DOCTYPE html>
<html lang="et">
<head>
  <meta charset="utf-8">
  <title>
  <?php
    echo $userName;
  ?>
  programmeerib veebi</title>
</head>
<body>
  <?php
    echo "<h1>" .$userName .", veebiprogrammeerimine 2019</h1>"; 
  ?>
  <p> See veebileht on valminud õppetöö käigus ning ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
  <p> See siin on teine lõik sellel veebilehel. </p>
<?php
  echo "<p>See on minu esimene PHP!</p>";
  echo "<p>Lehe avamise hetkel oli " .$fullTimeNow .", " .$partOfDay .".</p>";
?>

</body>
</html>