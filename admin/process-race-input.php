<?php
include 'race-reading-regexs.php';


$text = file_get_contents("clean-results.txt");
$text = explode("Race:",$text);
$text = $text[4];

//Turn the segment of text into an array of lines
$text = explode("\n",$text);

//Get the first lines of each paddler
$firstlines = array();
$poslanes = preg_grep($regex['positionandlane'],$text);
foreach ($poslanes as $linekey=>$line)
  {
  array_push($firstlines,$linekey);
  }
$onenumber = preg_grep($regex['positionorlane'],$text);
foreach ($onenumber as $linekey=>$line)
  {
  array_push($firstlines,$linekey);
  }

//Merge line into a standard of 1 line for race info with subsequent lines for paddlers
$firstlinekey = 0;
$racerkey = $firstlines[$firstlinekey];
$firstlinekey++;
$mergekey = 0;
foreach($text as $textkey=>$line)
  {
  //Specify keys for merging lines
  if ($textkey == $racerkey)
    {
    $mergekey = $racerkey;
    if (isset($firstlines[$firstlinekey]) == true)
      $racerkey = $firstlines[$firstlinekey];
    else
      $racerkey = "";

    $firstlinekey++;
    }

  //Merge lines where needed
  if ($textkey != $mergekey)
    {
    $text[$mergekey] = $text[$mergekey] . " " . $line;
    unset($text[$textkey]);
    }
  }

//Containers to store details in
$racedetails = array();
$allpaddlerdetails = array();

//Common faults to find and replace
$faultsfind = array(" / ","//");
$faultsreplace = array("/","/");

foreach($text as $textkey=>$line)
  {
  if ($textkey == 0)
    {
    $line = explode(" ", $line);

    //Get distance from details line
    $distances = preg_grep($regex['distance'],$line);
    if (count($distances) == 1)
      {
      $distance = reset($distances);
      //Format distance into an integer
      $chars = array("m","k");
      if (strpos($distance,"k") !== false)
        {
        $distance = str_ireplace($chars,"",$distance);
        $distance = $distance*1000;
        }
      else
        $distance = str_ireplace($chars,"",$distance);

      $distancekey = key($distances);
      unset($line[$distancekey]);

      $racedetails['Distance'] = $distance;
      }
    else
      $racedetails['Distance'] = "";

    //Get boats from details line
    $boats = preg_grep($regex['boats'],$line);
    $boatclasses = array();
    $boatsizes = array();
    foreach ($boats as $boatskey=>$boatname)
      {
      $boatname = str_split($boatname);
      array_push($boatclasses,$boatname[0]);
      array_push($boatsizes,$boatname[1]);

      unset($line[$boatskey]);
      $racedetails['Distance'] = $distance;
      }
    //If unique
    $boatclasses = array_unique($boatclasses);
    $boatsizes = array_unique($boatsizes);
    if (count($boatclasses) == 1)
      $racedetails['defCK'] = $boatclasses[0];
    if (count($boatsizes) == 1)
      $racedetails['Boat'] = $boatsizes[0];

    //Format round and draw
    $rounds = preg_grep($regex['round'],$line);
    if (count($rounds) == 1)
      {
      $round = reset($rounds);

      $racedetails['Draw'] = substr($round,1);
      $racedetails['Round'] = substr($round,0,1);

      $distancekey = key($distances);
      unset($line[$distancekey]);
      }
    elseif (in_array("F",$line) !== false)
      {
      $roundkey = array_search("F",$line);
      unset($line[$roundkey]);
      $racedetails['Draw'] = 0;
      $racedetails['Round'] = "F";
      }
    else
      {
      $racedetails['Draw'] = 0;
      $racedetails['Round'] = "F";
      }

    //Unset empty lines
    unset($line[0]);
    if (is_numeric($line[1]) == true)
      unset($line[1]);

    $racedetails['RaceName'] = implode(" ",$line);
    }
  else
    {
    $line = str_replace($faultsfind,$faultsreplace,$line);
    $notfinishing = array("dsq","???","dnf","dns");
    str_ireplace($notfinishing,$notfinishing,$line,$notfinishingcount);
    if ($notfinishingcount > 0)
      $line = "0 " . $line;

    echo $line . "<br>";
    }
  }

print_r($racedetails);
echo "<br>";

$text = implode("<br>",$text);
echo $text;
?>
