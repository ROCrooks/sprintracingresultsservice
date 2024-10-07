<?php
include_once $engineslocation . 'srrs-required-functions.php';

//Get the clubs from the club table
$clubdetailssql = "SELECT * FROM `clubs` ORDER BY `code` ASC";
$clubdetailsstmt = dbprepare($srrsdblink,$clubdetailssql);
$clubdetailsresult = dbexecute($clubdetailsstmt,"");
//Make a list of clubs found in the database
$clubcodesfound = resulttocolumn($clubdetailsresult,"Code");

//Get the clubs from the paddlers table
$allclubssql = "SELECT DISTINCT `Club` FROM `paddlers` WHERE `Club` != '' ";
$allclubsstmt = dbprepare($srrsdblink,$allclubssql);
$allclubsresult = dbexecute($allclubsstmt,"");
//Make the clubs into an array of club codes
$allclubscodeslist = resulttocolumn($allclubsresult,"Club");

$paddlerclubs = array();
//Process results to find a single array of found clubs
foreach ($allclubscodeslist as $crewclub)
    {
    //Explode the club to find the individual clubs of the class
    $crewclub = explode("/",$crewclub);
    $paddlerclubs = array_merge($paddlerclubs,$crewclub);
    }
//Make a unique club array
$paddlerclubs = array_unique($paddlerclubs);

//Orphan clubs array
$orphanclubs = array();

//Add found clubs to the database clubs array if they're not already present
foreach ($paddlerclubs as $paddlerclub)
    {
    //Check to see if the club code is missing from the array, and if not, add to orphan club array
    if ((in_array($paddlerclub,$allclubscodeslist) === false) AND ($paddlerclub != ''))
        {
        array_push($orphanclubs,$paddlerclub);
        }
    }

//Make a list of club colour files
$clubcolourfiles = array();
if (is_dir($clubcoloursfileslocation))
    {
    if ($dh = opendir($clubcoloursfileslocation))
        {
        while (($file = readdir($dh)) !== false)
            {
            $filetype = filetype($clubcoloursfileslocation . $file);
            $filename = $file;

            if (($filetype == 'file') AND ($file != "unknown.png"))
                {
                $file = substr($file,0,3);
                array_push($clubcolourfiles,$file);
                }
            }
        closedir($dh);
        }
    }

//Orphan colours array
$orphancolours = array();

//Add found clubs to the database clubs array if they're not already present
foreach ($clubcolourfiles as $clubcolour)
    {
    //Check to see if the club code is missing from the array, and if not, add to orphan club array
    if ((in_array($clubcolour,$allclubscodeslist) === false) AND ($clubcolour != ''))
        {
        array_push($orphancolours,$clubcolour);
        }
    }

//Unset unneeded arrays
unset($clubcolourfiles);
unset($clubcodesfound);
unset($allclubscodeslist);
unset($paddlerclubs);
?>