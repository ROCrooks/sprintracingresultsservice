<?php
include 'race-reading-regexs.php';


$text = file_get_contents("clean-results.txt");
$text = explode("Race:",$text);
$text = $text[6];

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
  $line = strtoupper($line);
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

      $roundkey = key($rounds);
      unset($line[$roundkey]);
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

    //Read the race classes to work out what sort of race it is
    include 'race-classes.php';
    }
  else
    {
    $paddlerdetails = array("Time"=>0,"NR"=>"");

    $line = str_replace($faultsfind,$faultsreplace,$line);
    $notfinishing = array("dsq","???","dnf","dns"," err");
    str_ireplace($notfinishing,$notfinishing,$line,$notfinishingcount);
    if (($notfinishingcount > 0) AND (preg_match($regex['positionorlane'],$line) == true))
      $line = "0 " . $line;
    elseif (($notfinishingcount == 0) AND (preg_match($regex['positionorlane'],$line) == true))
      {
      $line = explode(" ",$line);
      $line[-1] = $line[0];
      $line[0] = "0";
      ksort($line);
      $line = implode(" ",$line);
      }

    $line = explode(" ",$line);

    //Extract time from line
    $regulartime = preg_grep($regex['regulartime'],$line);
    $shorttime = preg_grep($regex['shorttime'],$line);
    $longtime = preg_grep($regex['longtime'],$line);

    //Find time or no result
    if (count($regulartime) > 0)
      {
      $paddlerdetails['Time'] = reset($regulartime);
      $timekey = key($regulartime);
      unset($line[$timekey]);
      }
    elseif (count($shorttime) > 0)
      {
      $paddlerdetails['Time'] = reset($shorttime);
      $timekey = key($shorttime);
      unset($line[$timekey]);
      }
    elseif (count($longtime) > 0)
      {
      $paddlerdetails['Time'] = reset($longtime);
      $time = explode(":",$time);
      //Reformat the long time format used for long distance races
      $time = $time[0] . ":" . $time[1] . "." . $time[2];
      $timekey = key($longtime);
      unset($line[$timekey]);
      }
    elseif ($notfinishingcount > 0)
      {
      //Format different forms of no result
      if (in_array("DNF",$line) !== false)
        {
        $nrkey = array_search("DNF",$line);
        $paddlerdetails['NR'] = "DNF";
        unset($line[$nrkey]);
        }
      elseif (in_array("DNS",$line) !== false)
        {
        $nrkey = array_search("DNS",$line);
        $paddlerdetails['NR'] = "DNS";
        unset($line[$nrkey]);
        }
      elseif (in_array("DSQ",$line) !== false)
        {
        $nrkey = array_search("DSQ",$line);
        $paddlerdetails['NR'] = "DSQ";
        unset($line[$nrkey]);
        }
      elseif (in_array("DISQ",$line) !== false)
        {
        $nrkey = array_search("DISQ",$line);
        $paddlerdetails['NR'] = "DSQ";
        unset($line[$nrkey]);
        }
      elseif (in_array("???",$line) !== false)
        {
        $nrkey = array_search("???",$line);
        $paddlerdetails['NR'] = "???";
        unset($line[$nrkey]);
        }
      elseif (in_array("ERR",$line) !== false)
        {
        $nrkey = array_search("ERR",$line);
        $paddlerdetails['NR'] = "ERR";
        unset($line[$nrkey]);
        }
      }

    //Resolve to ??? if still ambiguous time
    if (($paddlerdetails['Time'] == 0) AND ($paddlerdetails['NR'] == ""))
      $paddlerdetails['NR'] = "???";

    //Get position, lane and club
    $paddlerdetails['Position'] = $line[0];
    $paddlerdetails['Lane'] = $line[1];
    $masterclub = $line[2];
    unset($line[0]);
    unset($line[1]);
    unset($line[2]);

    //Explode line by paddler
    $line = implode(" ",$line);
    $line = explode("/",$line);

    $allclubs = array();
    $allpaddlers = array();
    foreach($line as $paddler)
      {
      //Remove leading and trailing spaces from paddler name
      while (substr($paddler,0,1) == " ")
        {
        $paddler = substr($paddler,1);
        }
      while (substr($paddler,-1) == " ")
        {
        $paddler = substr($paddler,0,-1);
        }

      //Identify bracketed clubs if present
      if (strpos($paddler,"(") !== false)
        {
        $paddler = explode("(",$paddler);
        $paddlerclub = $paddler[1];
        $paddlerclub = str_replace(")","",$paddlerclub);
        $paddler = $paddler[0];
        }
      else
        $paddlerclub = $masterclub;

      //Initialise paddler name
      $paddler = explode(" ",$paddler);
      if (strlen($paddler[0]) == 1)
        $paddler[0] = $paddler[0] . ".";
      $paddler = implode(" ",$paddler);

      array_push($allclubs,$paddlerclub);
      array_push($allpaddlers,$paddler);
      }

    //Use mixed club, or master club as appropriate
    $uniqueclubs = array_unique($allclubs);
    if (count($uniqueclubs) > 1)
      $paddlerdetails['Club'] = implode("/",$allclubs);
    else
      $paddlerdetails['Club'] = $masterclub;
    $paddlerdetails['Crew'] = implode("/",$allpaddlers);

    $paddlerdetails['JSV'] = $racedetails['defJSV'];
    $paddlerdetails['MW'] = $racedetails['defMW'];
    $paddlerdetails['CK'] = $racedetails['defCK'];

    array_push($allpaddlerdetails,$paddlerdetails);
    }
  }

print_r($racedetails);
echo "<br>";
print_r($allpaddlerdetails);
?>
