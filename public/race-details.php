<?php
//Get race details from regatta database
//$getracedetailssql = "SELECT `Regatta`, `Boat`, `Dist`, `R`, `D` FROM `races` WHERE `Key` = ? ";
//mysqli_prepare();
//mysqli_stmt_bind_param();

$regatta = 5;
$boat = 1;
$distance = 10000;
$round = "H";
$draw = 1;

//Format name of round and draw
if (($round == "H") OR ($round == 1))
  $rounddraw = "Heat " . $draw;
if (($round == "QF") OR ($round == "Q") OR ($round == 2))
  $rounddraw = "Quarter-Final " . $draw;
if (($round == "SF") OR ($round == "S") OR ($round == 3))
  $rounddraw = "Semi-Final " . $draw;
if (($round == "F") OR ($round == 4))
  $rounddraw = "Final " . $draw;

//Format distance
if ($distance <= 1000)
  $distance = $distance . "m";
if ($distance > 1000)
  $distance = $distance/1000 . "km";
?>
