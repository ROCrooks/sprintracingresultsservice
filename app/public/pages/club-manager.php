<?php
include_once $engineslocation . 'srrs-required-functions.php';

include $engineslocation . 'club-list-engine.php';

//print_r($clubdetailsresult);
//echo "<br>";
//print_r($orphanclubs);
//echo "<br>";

//Widths of the columns
$codewidth = 100;
$clubnamewidth = 400;
$colourswidth = 200;

//Make the table heading
$pagehtml = "";
$pagehtml = $pagehtml . '<div style="display: table">';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $codewidth . 'px;"><p>Code</p></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $clubnamewidth . 'px;"><p>Club</p></div>';
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

    $pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $colourswidth . 'px;"><p><img src=' . $coloursfile . '></p></div>';
    
    if ($column == 2)
        $pagehtml = $pagehtml . '</div>';

    //Change the column from 1 to 2
    if ($column == 1)
        $column = 2;
    elseif ($column == 2)
        $column = 1;
    }

/*$pagehtml = $pagehtml . '<div style="display: table-cell; width: 20px;"><p>' . $paddlerrace['Position'] . '</p></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: 20px;"><p>' . $paddlerrace['Lane'] . '</p></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: 40px;"><p>' . $paddlerrace['Club'] . '</p></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: 300px;"><p>' . $paddlerrace['Crew'] . '</p></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: 100px;"><p>' . $paddlerrace['Time'] . '</p></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: 40px;"><div class="tooltip"><p>' . $paddlerrace['JSV'] . $paddlerrace['MW'] . $paddlerrace['CK'] . '<span class="tooltiptext">' . $hovertext . '</span></p></div></div>';*/




$pagehtml = "<section>" . $pagehtml . "</section>";
?>