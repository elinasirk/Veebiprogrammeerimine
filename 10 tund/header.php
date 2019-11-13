<?php
  $pageHeaderHTML = "<!DOCTYPE html> \n";
  $pageHeaderHTML .= '<html lang="et">'. "\n";
  $pageHeaderHTML .= "<head> \n";
  $pageHeaderHTML .= "\t" .'<meta charset="utf-8">' ."\n \t<title>" .$userName ." programmeerib veebi</title> \n";
  $pageHeaderHTML .= "\t" ."<style> \n";
  $pageHeaderHTML .= "\t \t body{background-color: " .$_SESSION["bgcolor"] ."; \n";
  $pageHeaderHTML .= "\t \t color: " .$_SESSION["txtcolor"] ."\n";
  $pageHeaderHTML .= "\t }";
  $pageHeaderHTML .= "</style> \n";
  $pageHeaderHTML .= "</head> \n";
  echo $pageHeaderHTML;