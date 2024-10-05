<?php
include_once $engineslocation . 'srrs-required-functions.php';

include $engineslocation . 'club-list-engine.php';

print_r($clubdetailsresult);
echo "<br>";
print_r($orphanclubs);
echo "<br>";

//Widths of the columns
$codewidth = 150;
$clubnamewidth = 3000;
$colourswidth = 150;

//Make the table heading
$pagehtml = "";
$pagehtml = $pagehtml . '<div style="display: table">';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $codewidth . 'px;"><p>Code</p></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $clubnamewidth . 'px;"><p>Club</p></div>';
$pagehtml = $pagehtml . '</div>';

foreach($clubdetailsresult as $clubdetails)
    {
    $pagehtml = $pagehtml . '<div style="display: table">';
    $pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $codewidth . 'px;"><p>' . $clubdetails['Code'] . '</p></div>';
    $pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $clubnamewidth . 'px;"><p>' . $clubdetails['LongName'] . '</p></div>';
    $pagehtml = $pagehtml . '</div>';
    }

/*$pagehtml = $pagehtml . '<div style="display: table-cell; width: 20px;"><p>' . $paddlerrace['Position'] . '</p></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: 20px;"><p>' . $paddlerrace['Lane'] . '</p></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: 40px;"><p>' . $paddlerrace['Club'] . '</p></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: 300px;"><p>' . $paddlerrace['Crew'] . '</p></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: 100px;"><p>' . $paddlerrace['Time'] . '</p></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: 40px;"><div class="tooltip"><p>' . $paddlerrace['JSV'] . $paddlerrace['MW'] . $paddlerrace['CK'] . '<span class="tooltiptext">' . $hovertext . '</span></p></div></div>';*/




$pagehtml = "<section>" . $pagehtml . "</section>";
?>