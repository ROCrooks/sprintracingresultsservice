<?php
//Get the directory of the engines
$currentdirectory = getcwd();
$removedirs = array("/pages","/engines","/admin","/srrs");
$currentdirectory = str_replace($removedirs,"",$currentdirectory);
$enginesdirectory = $currentdirectory . "/srrs/engines/";

include $enginesdirectory . 'defaulturls.php';

//List of links
$subsectionurls1 = array();
$subsectionurls1[0] = array("URL"=>$defaulturls['RegattasList'],"Text"=>"Browse Regattas","Description"=>"Browse all regattas in the database.");
$subsectionurls1[1] = array("URL"=>$defaulturls['ClubSearch'],"Text"=>"Club Search","Description"=>"Search for results from a specific club in the regatta database.");
$subsectionurls1[2] = array("URL"=>$defaulturls['PaddlerSearch'],"Text"=>"Paddler Search","Description"=>"Search for results from a specific paddler in the regatta database.");
$subsectionurls1[3] = array("URL"=>$defaulturls['EventRecords'],"Text"=>"Event Records","Description"=>"Show the fastest times ever achieved in each event at regattas.");
$subsectionurls1[4] = array("URL"=>$defaulturls['Analytics'],"Text"=>"Regatta Analytics","Description"=>"Get paddler entry statistics for different events at regattas.");
$subsectionurls1[5] = array("URL"=>$defaulturls['TopNTimesBrowser'],"Text"=>"Top Results","Description"=>"Get a ranking of the fastest paddlers ever in each event at regattas.");
$subsectionurls1[6] = array("URL"=>$defaulturls['TimesAnalysisBrowser'],"Text"=>"Time Statistics","Description"=>"Get metrics about the time distributions for each year for each event at regattas.");


$subsectionurls2 = array();
$subsectionurls2[0] = array("URL"=>"https://github.com/ROCrooks/sprintracingresultsservice","Text"=>"Git Repository","Target"=>"blank");

echo '<div class="item">';
echo '<p class="blockheading">Homepage</p>';
echo '<p>Welcome to sprint racing results service, an online, searchable database of sprint canoe racing results from British national sprint regattas.<p>';
echo '<p class="blockheading">Available Features</p>';
echo '<p>Tools for searching the data in the sprint racing results service.<p>';
foreach($subsectionurls1 as $listurl)
  {
  echo '<p><a href="' . $listurl['URL'] . '"';
  if (isset($listurl['Target']) == true)
    echo ' target="' . $listurl['Target'] . '"';
  echo '>' . $listurl['Text'] . '</a>';

  if (isset($listurl['Description']) == true)
    echo " - " . $listurl['Description'];

  echo '</p>';
  }

echo '<p class="blockheading">Support</p>';
echo '<p>Technical information about the sprint racing results service.<p>';
foreach($subsectionurls2 as $listurl)
  {
  echo '<p><a href="' . $listurl['URL'] . '"';
  if (isset($listurl['Target']) == true)
    echo ' target="' . $listurl['Target'] . '"';
  echo '>' . $listurl['Text'] . '</a></p>';
  }
echo '</div>';
?>
