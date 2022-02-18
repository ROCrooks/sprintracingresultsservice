<?php
include $engineslocation . 'race-reading-regexs.php';

//Turn the segment of text into an array of lines
$racetext = explode("\n",$racetext);

//Get the first lines of each paddler
$firstlines = array();
$poslanes = preg_grep($regex['positionandlane'],$racetext);
foreach ($poslanes as $racelinekey=>$raceline)
  {
  array_push($firstlines,$racelinekey);
  }
$onenumber = preg_grep($regex['positionorlane'],$racetext);
foreach ($onenumber as $racelinekey=>$raceline)
  {
  array_push($firstlines,$racelinekey);
  }

//Merge line into a standard of 1 line for race info with subsequent lines for paddlers
$firstlinekey = 0;
$racerkey = $firstlines[$firstlinekey];
$firstlinekey++;
$mergekey = 0;
foreach($racetext as $racetextkey=>$raceline)
  {
  //Specify keys for merging lines
  if ($racetextkey == $racerkey)
    {
    $mergekey = $racerkey;
    if (isset($firstlines[$firstlinekey]) == true)
      $racerkey = $firstlines[$firstlinekey];
    else
      $racerkey = "";

    $firstlinekey++;
    }

  //Merge lines where needed
  if ($racetextkey != $mergekey)
    {
    $racetext[$mergekey] = $racetext[$mergekey] . " " . $raceline;
    unset($racetext[$racetextkey]);
    }
  }

//Containers to store details in
$racedetails = array();
$allpaddlerdetails = array();

//Common faults to find and replace
$faultsfind = array(" / ","//");
$faultsreplace = array("/","/");

foreach($racetext as $racetextkey=>$raceline)
  {
  $raceline = strtoupper($raceline);
  if ($racetextkey == 0)
    {
    $raceline = explode(" ",$raceline);

    //Get distance from details line
    $distances = preg_grep($regex['distance'],$raceline);
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
      unset($raceline[$distancekey]);

      $racedetails['Distance'] = $distance;
      }
    else
      $racedetails['Distance'] = "";

    //Get boats from details line
    $boats = preg_grep($regex['boats'],$raceline);
    $boatclasses = array();
    $boatsizes = array();
    foreach ($boats as $boatskey=>$boatname)
      {
      $boatname = str_split($boatname);
      array_push($boatclasses,$boatname[0]);
      array_push($boatsizes,$boatname[1]);

      unset($raceline[$boatskey]);
      }
    //If unique
    $boatclasses = array_unique($boatclasses);
    $boatsizes = array_unique($boatsizes);
    if (count($boatclasses) == 1)
      $racedetails['defCK'] = $boatclasses[0];
    if (count($boatsizes) == 1)
      $racedetails['Boat'] = $boatsizes[0];

    //Format round and draw
    $rounds = preg_grep($regex['round'],$raceline);
    if (count($rounds) == 1)
      {
      $round = reset($rounds);

      $racedetails['Draw'] = substr($round,1);
      $racedetails['Round'] = substr($round,0,1);

      $roundkey = key($rounds);
      unset($raceline[$roundkey]);
      }
    elseif (in_array("F",$raceline) !== false)
      {
      $roundkey = array_search("F",$raceline);
      unset($raceline[$roundkey]);
      $racedetails['Draw'] = 0;
      $racedetails['Round'] = "F";
      }
    else
      {
      $racedetails['Draw'] = 0;
      $racedetails['Round'] = "F";
      }

    //Unset empty lines
    unset($raceline[0]);
    if (is_numeric($raceline[1]) == true)
      unset($raceline[1]);

    $racedetails['RaceName'] = implode(" ",$raceline);

    if ($racedetails['defCK'] == "K")
      $racedetails['RaceName'] = $racedetails['RaceName'] . " K";
    elseif ($racedetails['defCK'] == "C")
      $racedetails['RaceName'] = $racedetails['RaceName'] . " C";
    elseif ($racedetails['defCK'] == "V")
      $racedetails['RaceName'] = $racedetails['RaceName'] . " V";
    else
      $racedetails['RaceName'] = $racedetails['RaceName'] . " C/K";

    //Read the race classes to work out what sort of race it is
    include 'race-classes.php';
    }
  else
    {
    $paddlerdetails = array("Time"=>0,"NR"=>"");

    $raceline = str_replace($faultsfind,$faultsreplace,$raceline);
    $notfinishing = array("dsq","???","dnf","dns"," err");
    str_ireplace($notfinishing,$notfinishing,$raceline,$notfinishingcount);
    if (($notfinishingcount > 0) AND (preg_match($regex['positionorlane'],$raceline) == true))
      $raceline = "0 " . $raceline;
    elseif (($notfinishingcount == 0) AND (preg_match($regex['positionorlane'],$raceline) == true))
      {
      $raceline = explode(" ",$raceline);
      $raceline[-1] = $raceline[0];
      $raceline[0] = "0";
      ksort($raceline);
      $raceline = implode(" ",$raceline);
      }

    $raceline = explode(" ",$raceline);

    //Extract time from line
    $regulartime = preg_grep($regex['regulartime'],$raceline);
    $shorttime = preg_grep($regex['shorttime'],$raceline);
    $longtime = preg_grep($regex['longtime'],$raceline);

    //Find time or no result
    if (count($regulartime) > 0)
      {
      $paddlerdetails['Time'] = reset($regulartime);
      $timekey = key($regulartime);
      unset($raceline[$timekey]);
      }
    elseif (count($shorttime) > 0)
      {
      $paddlerdetails['Time'] = reset($shorttime);
      $timekey = key($shorttime);
      unset($raceline[$timekey]);
      }
    elseif (count($longtime) > 0)
      {
      $paddlerdetails['Time'] = reset($longtime);
      $time = explode(":",$time);
      //Reformat the long time format used for long distance races
      $time = $time[0] . ":" . $time[1] . "." . $time[2];
      $timekey = key($longtime);
      unset($raceline[$timekey]);
      }
    elseif ($notfinishingcount > 0)
      {
      //Format different forms of no result
      if (in_array("DNF",$raceline) !== false)
        {
        $nrkey = array_search("DNF",$raceline);
        $paddlerdetails['NR'] = "DNF";
        unset($raceline[$nrkey]);
        }
      elseif (in_array("DNS",$raceline) !== false)
        {
        $nrkey = array_search("DNS",$raceline);
        $paddlerdetails['NR'] = "DNS";
        unset($raceline[$nrkey]);
        }
      elseif (in_array("DSQ",$raceline) !== false)
        {
        $nrkey = array_search("DSQ",$raceline);
        $paddlerdetails['NR'] = "DSQ";
        unset($raceline[$nrkey]);
        }
      elseif (in_array("DISQ",$raceline) !== false)
        {
        $nrkey = array_search("DISQ",$raceline);
        $paddlerdetails['NR'] = "DSQ";
        unset($raceline[$nrkey]);
        }
      elseif (in_array("???",$raceline) !== false)
        {
        $nrkey = array_search("???",$raceline);
        $paddlerdetails['NR'] = "???";
        unset($raceline[$nrkey]);
        }
      elseif (in_array("ERR",$raceline) !== false)
        {
        $nrkey = array_search("ERR",$raceline);
        $paddlerdetails['NR'] = "ERR";
        unset($raceline[$nrkey]);
        }
      }

    //Resolve to ??? if still ambiguous time
    if (($paddlerdetails['Time'] == 0) AND ($paddlerdetails['NR'] == ""))
      $paddlerdetails['NR'] = "???";

    //Get position, lane and club
    $paddlerdetails['Position'] = $raceline[0];
    if ($racedetails['Distance'] > 1000)
      $paddlerdetails['Lane'] = 0;
    else
      $paddlerdetails['Lane'] = $raceline[1];

    $masterclub = $raceline[2];
    unset($raceline[0]);
    unset($raceline[1]);
    unset($raceline[2]);

    //Explode line by paddler
    $raceline = implode(" ",$raceline);
    $raceline = explode("/",$raceline);

    $allclubs = array();
    $allpaddlers = array();
    foreach($raceline as $paddler)
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
?>
