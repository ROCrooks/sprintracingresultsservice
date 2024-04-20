<?php
include $engineslocation . 'race-reading-regexs.php';

//Turn the segment of text into an array of lines
$racetext = explode("\n",$racetext);

//Get the first lines of each paddler by preg_grep matching to the positon and lane
$firstlines = array();

//Get position and lane regular expressions
$postitionlaneregexs = $regex['linestarts'];
$notfinishingregexs = $regex['notfinishings'];

//Find the first lines of crew details which match the regular expression
foreach ($postitionlaneregexs as $postitionlaneregex)
  {
  $poslanes = preg_grep($postitionlaneregex,$racetext);
  $foundfirstlines = array_keys($poslanes);
  $firstlines = array_merge($firstlines,$foundfirstlines);
  }

//Find if no race code is present and add to the first lines array
foreach ($notfinishingregexs as $notfinishregex)
  {
  $poslanes = preg_grep($postitionlaneregex,$racetext);
  $foundfirstlines = array_keys($poslanes);
  $firstlines = array_merge($firstlines,$foundfirstlines);
  }

//Make unique and sort the first line array
$firstlines = array_unique($firstlines);
sort($firstlines);

//Merge line into a standard of 1 line for race info with subsequent lines for paddlers
$firstlinekey = 0;
$racerkey = $firstlines[$firstlinekey];
$firstlinekey++;
$mergekey = 0;

foreach ($racetext as $racetextkey=>$raceline)
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
    $racetext[$mergekey] = $racetext[$mergekey] . "/" . $raceline;
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
      //Get the distance from the 
      $distances = array_values($distances);
      $distancetext = $distances[0];

      //Remove the m from the distance
      $distance = str_ireplace("m","",$distancetext);
      
      //Check if the distance is a km distance
      if (substr($distance,-1) == "K")
        {
        $distance = str_ireplace("K","",$distance);
        $distance = $distance*1000;
        }

      $racedetails['Distance'] = $distance;
      }
    else
      {
      $racedetails['Distance'] = "";
      $distancetext = '';
      }
      

    //Get boats from details line
    $boats = preg_grep($regex['boats'],$raceline);
    $boatclasses = array();
    $boatsizes = array();
    foreach ($boats as $boatskey=>$boatname)
      {
      //Split the boat name into parts, as combined boat types are not separated otherwise
      $boatname = explode("/",$boatname);

      //Add the unique boat types to the array
      foreach($boatname as $boatnamepart)
        {
        $boatnamepart = str_split($boatnamepart);
        array_push($boatclasses,$boatnamepart[0]);
        array_push($boatsizes,$boatnamepart[1]);
        }

      unset($raceline[$boatskey]);
      }
    
    //If unique
    $boatclasses = array_unique($boatclasses);
    $boatsizes = array_unique($boatsizes);
    if (count($boatclasses) == 1)
      $racedetails['defCK'] = $boatclasses[0];
    else
      $racedetails['defCK'] = "";
    if (count($boatsizes) == 1)
      $racedetails['Boat'] = $boatsizes[0];
    else
      $racedetails['Boat'] = "";

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
    
    //Remove the text that describes the race distance
    $racedetails['RaceName'] = str_ireplace($distancetext,"",$racedetails['RaceName']);

    if ($racedetails['defCK'] == "K")
      $racedetails['RaceName'] = $racedetails['RaceName'] . " K";
    elseif ($racedetails['defCK'] == "C")
      $racedetails['RaceName'] = $racedetails['RaceName'] . " C";
    elseif ($racedetails['defCK'] == "V")
      $racedetails['RaceName'] = $racedetails['RaceName'] . " V";
    else
      $racedetails['RaceName'] = $racedetails['RaceName'] . " C/K";
    
    //Remove double spaces
    $spacesremoved = 1;
    while ($spacesremoved > 0)
      {
      $racedetails['RaceName'] = str_ireplace("  "," ",$racedetails['RaceName'],$spacesremoved);
      }
    
    //Read the race classes to work out what sort of race it is
    include 'race-classes.php';
    }
  else
    {
    include 'process-paddler-input.php';
    }
  }
?>
