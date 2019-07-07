<style>
.tooltip {
  position: relative;
  display: inline-block;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 120px;
  background-color: black;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;

  /* Position the tooltip */
  position: absolute;
  z-index: 1;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
}
</style>
<?php
include 'engines/user-input-processing.php';

//Names for generating the paddler descriptions
$boattypenames = array();
$boattypenames['JSV']['J'] = "Junior";
$boattypenames['JSV']['S'] = "Senior";
$boattypenames['JSV']['V'] = "Masters";
$boattypenames['MW']['M'] = "Mens";
$boattypenames['MW']['W'] = "Womens";
$boattypenames['CK']['C'] = "Canoe";
$boattypenames['CK']['K'] = "Kayak";
$boattypenames['CK']['V'] = "Va'a";
$boattypenames['CK']['P'] = "SUP";
$boattypenames['CK']['T'] = "Touring Canoe";

//Get the details for the single race
include 'engines/get-single-race.php';

echo '<div class="item">';

echo '<p style="font-size: 200%; text-align: center;">' . $racedetails['Name'] . '</p>';

//Print results table
foreach($racedetails['Paddlers'] as $paddlerrace)
  {
  //Format crew boats onto multiple lines
  $paddlerrace['Club'] = str_replace("/","<br>",$paddlerrace['Club']);
  $paddlerrace['Crew'] = str_replace("/","<br>",$paddlerrace['Crew']);

  //Create hover text for boat types
  $hovertext = $boattypenames['JSV'][$paddlerrace['JSV']] . " " . $boattypenames['MW'][$paddlerrace['MW']] . " " . $boattypenames['CK'][$paddlerrace['CK']];

  $userinputs = array("Club"=>$club,"Paddler"=>$paddler,"PadJSV"=>$padjsv,"PadMW"=>$padmw,"PadCK"=>$padck);
  $highlight = highlightcheck($userinputs,$paddlerrace);

  if ($highlight == true)
    echo '<div style="display: table; margin: auto; width: 520px; background-color: yellow;">';
  else
    echo '<div style="display: table; margin: auto; width: 520px;">';
  echo '<div style="display: table-cell; width: 20px;"><p>' . $paddlerrace['Position'] . '</p></div>';
  echo '<div style="display: table-cell; width: 20px;"><p>' . $paddlerrace['Lane'] . '</p></div>';
  echo '<div style="display: table-cell; width: 40px;"><p>' . $paddlerrace['Club'] . '</p></div>';
  echo '<div style="display: table-cell; width: 300px;"><p>' . $paddlerrace['Crew'] . '</p></div>';
  echo '<div style="display: table-cell; width: 100px;"><p>' . $paddlerrace['Time'] . '</p></div>';
  echo '<div style="display: table-cell; width: 40px;"><div class="tooltip"><p>' . $paddlerrace['JSV'] . $paddlerrace['MW'] . $paddlerrace['CK'] . '<span class="tooltiptext">' . $hovertext . '</span></p></div></div>';
  echo '</div>';
  }

echo '</div>';
?>
