<?php
include_once $engineslocation . 'srrs-required-functions.php';

//If delete a club is picked, delete it
if (isset($_GET['deleteclub']) == true)
    include $engineslocation . 'delete-club-engine.php';

include $engineslocation . 'club-list-engine.php';

//Widths of the columns
$codewidth = 100;
$clubnamewidth = 300;
$colourswidth = 180;
$buttonwidth = 100;

$pagehtml = "";

if (isset($deletemessage) == true)
$pagehtml = $pagehtml . $deletemessage;

//Make the table of clubs
$pagehtml = $pagehtml . '<div style="display: table">';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $codewidth . 'px;"><p>Code</p></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $clubnamewidth . 'px;"><p>Club</p></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $colourswidth . 'px;"><p style="text-align: center;">Colours</p></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $buttonwidth . 'px;"></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $buttonwidth . 'px;"></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $codewidth . 'px;"><p>Code</p></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $clubnamewidth . 'px;"><p>Club</p></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $colourswidth . 'px;"><p style="text-align: center;">Colours</p></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $buttonwidth . 'px;"></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $buttonwidth . 'px;"></div>';
$pagehtml = $pagehtml . '</div>';

//Start the column on 1
$column = 1;
foreach($clubdetailsresult as $clubdetails)
    {
    if ($column == 1)
        $pagehtml = $pagehtml . '<div style="display: table">';

    $pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $codewidth . 'px; vertical-align: middle;"><p>' . $clubdetails['Code'] . '</p></div>';
    $pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $clubnamewidth . 'px; vertical-align: middle;"><p>' . $clubdetails['LongName'] . '</p></div>';
    
    //Get the club colours file, or a plain colours if not found
    $coloursfile = $clubcoloursfileslocation . $clubdetails['Code'] . ".png";
    if (file_exists($coloursfile) == true)
        $coloursfile = "../clubcolours/" . $clubdetails['Code'] . ".png";
    else
        $coloursfile = "../clubcolours/" . "unknown.png";
    
    //The column for the club colours
    $pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $colourswidth . 'px;"><p style="text-align: center;"><img src=' . $coloursfile . '></p></div>';

    //The columns for the edit buttons
    $pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $buttonwidth . 'px; vertical-align: middle;"><p><a href="EditClub?club=' . $clubdetails['Code'] . '">Edit</a></p></div>';
    $pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $buttonwidth . 'px; vertical-align: middle;"><p><a href="ClubManager?deleteclub=' . $clubdetails['Code'] . '" onclick="return confirm(\'This will delete the club ' . $clubdetails['LongName'] . '. Are you sure you want to continue?\')">Delete</a></p></div>';

    if ($column == 2)
        $pagehtml = $pagehtml . '</div>';

    //Change the column from 1 to 2
    if ($column == 1)
        $column = 2;
    elseif ($column == 2)
        $column = 1;
    }

$sqlquerywidth = "600";

//Break into a new section
$pagehtml = $pagehtml . "</section><section>";

//Section of orphan club codes
$pagehtml = $pagehtml . "<h2>Orphan Clubs</h2>";
$pagehtml = $pagehtml . "<p>The following club codes have been found which are not in the database. It is recommended to either add a database entry for them, or to update them to a correct club code.</p>";

//Make a list of orphan clubs, and SQL queries to find them in the database to correct them
foreach ($orphanclubs as $orphanclub)
    {
    $orphansql = "SELECT * FROM `paddlers` WHERE `club` LIKE '%" . $orphanclub . "%' ";

    $pagehtml = $pagehtml . '<div style="display: table">';
    $pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $codewidth . 'px;"><p>' . $orphanclub . '</p></div>';
    $pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $sqlquerywidth . 'px;"><p style="font-family: Courier, monospace;">' . $orphansql . '</p></div>';
    $pagehtml = $pagehtml . '</div>';
    }

//Break into a new section
$pagehtml = $pagehtml . "</section><section>";

//Section of orphan club codes
$pagehtml = $pagehtml . "<h2>Orphan Colours</h2>";
$pagehtml = $pagehtml . "<p>The following club colours have no database entry associated with them. Recommend creating a database entry for these clubs.</p>";

foreach($orphancolours as $orphancolour)
    {
    //Create the URL of the orphan club colour file
    $orphancolourfile = "../clubcolours/" . $orphancolour . ".png";
    
    $pagehtml = $pagehtml . '<div style="display: table">';
    $pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $codewidth . 'px;"><p>' . $orphancolour . '</p></div>';
    $pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $colourswidth . 'px;"><p><img src=' . $orphancolourfile . '></p></div>';
    $pagehtml = $pagehtml . '</div>';
    }

$pagehtml = "<section>" . $pagehtml . "</section>";
?>