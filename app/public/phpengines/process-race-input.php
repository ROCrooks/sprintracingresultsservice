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

    print_r($racedetails);
    echo "<br>";
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
    
    $paddlers = str_replace($faultsfind,$faultsreplace,$paddlers);

    echo $paddlers . "<br>";
    
    //Add the position and lane to the paddlerdetails line
    $paddlerdetails['Position'] = $position;
    $paddlerdetails['Lane'] = $lane;
    
    //Add the club and paddler to the paddlerdetails line
    $paddlerdetails['Club'] = $defaultclub;
    //$paddlerdetails['Lane'] = $lane;

    //Add the found time to the paddlerdetails line
    $paddlerdetails['Time'] = $foundtime;
    $paddlerdetails['NR'] = $noresultflag;

    //Define the JSV/MW/CK from the defaults for the race
    $paddlerdetails['JSV'] = $racedetails['defJSV'];
    $paddlerdetails['MW'] = $racedetails['defMW'];
    $paddlerdetails['CK'] = $racedetails['defCK'];

    $paddlerdetails['Lane'] = $lane;

    print_r($paddlerdetails);
    echo "<br>";

    /*
    //Default the time and NR 
    $paddlerdetails = array("Time"=>0,"NR"=>"");
    
    //Find if the result is a time or not
    $raceline = str_replace($faultsfind,$faultsreplace,$raceline);
    $notfinishing = array("dsq","???","dnf","dns"," err");
    str_ireplace($notfinishing,$notfinishing,$raceline,$notfinishingcount);

    if (($notfinishingcount > 0) AND ((preg_match($regex['positionorlane'],$raceline) == true) OR (preg_match($regex['positionorlane'],$raceline) == true)))
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
    */
    }
  }
?>
