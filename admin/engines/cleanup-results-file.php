<?php
include 'race-reading-regexs.php';

//Define file to clean
$text = file_get_contents($filename);

//Find full names for rounds in the text and replace them
$roundnamesfind = array("heat ","semi-final ","semi final ","final ","final");
$roundnamesreplace = array("H","SF","SF","F","F");
$text = str_ireplace($roundnamesfind,$roundnamesreplace,$text);

//Replace all gaps between slashes with single slashes
$text = str_replace("\\","/",$text);
$text = str_replace(" / ","/",$text);

$text = preg_replace($regex['pagedetails'],"",$text);

//Standardise new lines
$text = str_replace("\r","\n",$text);
//Make one new line between each line
$doubles = 1;
while ($doubles > 0)
  {
  $text = str_replace("\n\n","\n",$text,$doubles);
  }
//Remove terminal \ns if found
while (substr($text,0,2) == "/n")
  {
  $text = substr($text,2);
  }
while (substr($text,-2) == "/n")
  {
  $text = substr($text,0,-2);
  }

$text = explode("\n",$text);
$afterraceline = false;
foreach ($text as $textkey=>$line)
  {
  //Remove spaces from beginning and end of line
  while (substr($line,0,1) == " ")
    {
    $line = substr($line,1);
    }
  while (substr($line,-1) == " ")
    {
    $line = substr($line,0,-1);
    }

  //Detect if the line is a race description using distance or round
  if ((preg_match($regex['distance'],$line) == true) OR (preg_match($regex['round'],$line) == true))
    {
    if (strpos($line,"Race:") === false)
      $line = "Race: " . $line;
    }

  //Remove lines with classes in them
  if (substr($line,0,6) == "Class:")
    $line = "";

  if ($line != "")
    {
    $text[$textkey] = $line;
    }
  else
    unset($text[$textkey]);
  }

//Echo text
$text = implode("\n",$text);
file_put_contents($filename,$text);
?>
