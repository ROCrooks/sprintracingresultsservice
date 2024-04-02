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
      $distance = $distances[0];
      
      //Remove the m from the distance
      $distance = str_ireplace("m","",$distance);
      
      //Check if the distance is a km distance
      if ((str_contains($distance,"k") == true) OR (str_contains($distance,"K") == true))
        {
        $distance = str_ireplace("k","",$distance);
        $distance = $distance*1000;
        }

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
    $paddlerdetails = array();
    
    //Preg to extract the position, lane and club
    //Get the position, lane and club, from the preamble of the line
    $linestartscount = count($regex['linestarts']);
    $linestartskey = 0;
    $foundlinestart = array();
    
    //Test and extract each time format
    while (($linestartskey < $linestartscount) AND (count($foundlinestart) == 0))
      {
      //Get the regex for the time format, in priority format
      $linestartformat = $regex['linestarts'][$linestartskey];
      
      //Get the formatted time
      preg_match($linestartformat,$raceline,$foundlinestart);

      $linestartskey++;
      }
    
    //Make the line starts
    if (count($foundlinestart) > 0)
      $foundlinestart = $foundlinestart[0];
    else
      $foundlinestart = "";
    
    //Explode the preamble into an array to separate out the parts
    $foundlinestartarray = explode(" ",$foundlinestart);
    $noresultflag = "";
    //Extract the position, lane and club depending on the format
    //This uses the key the loop stops on so that the format of the preamble is known
    if ($linestartskey == 1)
      {
      $position = $foundlinestartarray[0];
      $lane = $foundlinestartarray[1];
      $defaultclub = $foundlinestartarray[2];
      }
    elseif (($linestartskey == 2) OR ($linestartskey == 3))
      {
      //Default club is always the second element
      $defaultclub = $foundlinestartarray[1];
      
      //Find out if the lone is likely to be a lane or a position
      $notfinishfound = false;
      foreach($regex['notfinishings'] as $notfinishings)
        {
        if(str_contains($raceline,$notfinishings) == true)
          {
          $notfinishfound = true;
          $noresultflag = $notfinishings;
          }
        }
      
      //Assign the lane and position
      if ($notfinishfound == true)
        {
        $position = "";
        $lane = $foundlinestartarray[0];
        }
      elseif ($notfinishfound == false)
        {
        $position = $foundlinestartarray[0];
        $lane = "";
        }
      }
    elseif ($linestartskey == 4)
      {
      //Default club is always the first element
      $defaultclub = $foundlinestartarray[0];
      
      //Position and lane are always blank in this format
      $position = "";
      $lane = "";
      }
    elseif (($linestartskey == 5) OR ($linestartskey == 6))
      {
      //Default club is blank in this format
      $defaultclub = "???";
      
      //Position and lane are first and second in this format
      $position = $foundlinestartarray[0];
      $lane = $foundlinestartarray[1];
      }
    elseif (($linestartskey == 7) OR ($linestartskey == 7))
      {
      //Default club is blank in this format
      $defaultclub = "???";
      
      //Position and lane are first and second in this format
      $position = $foundlinestartarray[0];
      $lane = "";
      }
    
    //Specify a default club if it's missing
    if (isset($defaultclub) == false)
      {
      preg_match($regex['defaultclub'],$raceline,$defaultclub);
      $defaultclub = $defaultclub[0];
      $defaultclub = str_replace(" ","",$defaultclub);
      if ($defaultclub == "")
        $defaultclub = "???";
      }
    
    //Get the time from the paddler line
    $timeformatscount = count($regex['timeformats']);
    $timeformatskey = 0;
    $foundtime = array();
    
    //Test and extract each time format
    while (($timeformatskey < $timeformatscount) AND (count($foundtime) == 0))
      {
      //Get the regex for the time format, in priority format
      $timeformat = $regex['timeformats'][$timeformatskey];
      
      //Get the formatted time
      preg_match($timeformat,$raceline,$foundtime);

      $timeformatskey++;
      }
    
    //Assigned the time if it is found
    if (isset($foundtime[0]) == true)
      $foundtime = $foundtime[0];
    else
      $foundtime = "";
    
    $paddlers = $raceline;

    //Remove the start of the paddler line
    $paddlers = str_replace($foundlinestart,"",$paddlers);
    //Remove the time from the paddler line and replace with /
    if ($foundtime != "")
      $paddlers = str_replace($foundtime,"/",$paddlers);
    //Remove the NR from the paddler line and replace with /
    if ($noresultflag != "")
      $paddlers = str_replace($noresultflag,"/",$paddlers);
    
    //Remove any double spaces
    $doublespaces = 1;
    while ($doublespaces > 0)
      {
      $paddlers = str_replace("  "," ",$paddlers,$doublespaces);
      }

    //Remove weird slashes
    $paddlers = str_replace(" / ","/",$paddlers);
    $paddlers = str_replace("//","/",$paddlers);

    //Remove spaces and and slashes from the start and finish of the paddlers
    while ((substr($paddlers,0,1) == " ") OR (substr($paddlers,0,1) == "/"))
      {
      $paddlers = substr($paddlers,1);
      }
    while ((substr($paddlers,-1) == " ") OR (substr($paddlers,-1) == "/"))
      {
      $paddlers = substr($paddlers,0,-1);
      }
    
    //Remove errors in paddler names, and split paddlers into an array
    $paddlers = str_replace($faultsfind,$faultsreplace,$paddlers);
    $paddlers = explode("/",$paddlers);

    //Find the paddlers and clubs from the paddlers array
    $foundpaddlers = array();
    $foundclubs = array();
    foreach ($paddlers as $foundpaddler)
      {
      if (strlen($foundpaddler) > 0)
        {
        //Make the space better the initial and surname a space and period
        $foundpaddler = explode(" ",$foundpaddler);
        if (strlen($foundpaddler[0]) == 1)
          $foundpaddler[0] = $foundpaddler[0] . ".";
        $foundpaddler = implode(" ",$foundpaddler);

        //Extract any extra club from the paddler name
        preg_match($regex['individualclub'],$foundpaddler,$foundclub);
        if (count($foundclub) == 1)
          {
          $foundclub = $foundclub[0]; 
          //Remove the club in brackets from the found paddler string
          $foundpaddler = str_replace($foundclub,"",$foundpaddler);
          $foundclub = substr($foundclub,1,-1);
          }        
        else
          $foundclub = $defaultclub;
        
        //Add the club and paddlers to the found clubs and paddlers arrays
        array_push($foundclubs,$foundclub);
        array_push($foundpaddlers,$foundpaddler);
        }
      }

    //Pad paddlers and club out with unknown ?. ?????? when the crew is too short
    $paddlerpadinsertkey = count($foundpaddlers);
    while ($paddlerpadinsertkey < $racedetails['Boat'])
      {
      array_push($foundpaddlers,"?. ??????");
      array_push($foundclubs,$defaultclub);
      $paddlerpadinsertkey++;
      }
    
    //Format club as either a single club or a mixed club crew
    $checkclub = array_unique($foundclubs);
    if (count($checkclub) == 1)
      $foundclubs = $checkclub[0];
    else
      $foundclubs = implode("/",$foundclubs);

    //Turn the found paddlers into a string
    $foundpaddlers = implode("/",$foundpaddlers);

    //Add the position and lane to the paddlerdetails line
    $paddlerdetails['Position'] = $position;
    $paddlerdetails['Lane'] = $lane;
    
    //Add the club and paddler to the paddlerdetails line
    $paddlerdetails['Club'] = $foundclubs;
    $paddlerdetails['Crew'] = $foundpaddlers;

    //Add the found time to the paddlerdetails line
    $paddlerdetails['Time'] = $foundtime;
    $paddlerdetails['NR'] = $noresultflag;

    //Define the JSV/MW/CK from the defaults for the race
    $paddlerdetails['JSV'] = $racedetails['defJSV'];
    $paddlerdetails['MW'] = $racedetails['defMW'];
    $paddlerdetails['CK'] = $racedetails['defCK'];

    $paddlerdetails['Lane'] = $lane;
    
    array_push($allpaddlerdetails,$paddlerdetails);
    }
  }
?>
