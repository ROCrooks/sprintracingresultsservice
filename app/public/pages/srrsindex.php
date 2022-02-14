<?php
//List of links
$subsectionurls1 = array();
$subsectionurls1[0] = array("URL"=>"RegattaList","Text"=>"Browse Regattas","Description"=>"Browse all regattas in the database.");
$subsectionurls1[1] = array("URL"=>"ClubSearch","Text"=>"Club Search","Description"=>"Search for results from a specific club in the regatta database.");
$subsectionurls1[2] = array("URL"=>"PaddlerSearch","Text"=>"Paddler Search","Description"=>"Search for results from a specific paddler in the regatta database.");
$subsectionurls1[3] = array("URL"=>"EventRecords","Text"=>"Event Records","Description"=>"Show the fastest times ever achieved in each event at regattas.");
$subsectionurls1[4] = array("URL"=>"RegattaAnalytics","Text"=>"Regatta Analytics","Description"=>"Get paddler entry statistics for different events at regattas.");
$subsectionurls1[5] = array("URL"=>"TopPerformancesBrowser","Text"=>"Top Results","Description"=>"Get a ranking of the fastest paddlers ever in each event at regattas.");
$subsectionurls1[6] = array("URL"=>"TimeStatisticsBrowser","Text"=>"Time Statistics","Description"=>"Get metrics about the time distributions for each year for each event at regattas.");

$subsectionurls2 = array();
$subsectionurls2[0] = array("URL"=>"https://github.com/ROCrooks/sprintracingresultsservice","Text"=>"Git Repository","Target"=>"blank");

$pagehtml = '<section>';
$pagehtml = $pagehtml . '<p class="blockheading">Homepage</p>';
$pagehtml = $pagehtml . '<p>Welcome to sprint racing results service, an online, searchable database of sprint canoe racing results from British national sprint regattas.<p>';
$pagehtml = $pagehtml . '<p class="blockheading">Available Features</p>';
$pagehtml = $pagehtml . '<p>Tools for searching the data in the sprint racing results service.<p>';
foreach($subsectionurls1 as $listurl)
  {
  $pagehtml = $pagehtml . '<p><a href="' . $listurl['URL'] . '"';
  if (isset($listurl['Target']) == true)
    $pagehtml = $pagehtml . ' target="' . $listurl['Target'] . '"';
  $pagehtml = $pagehtml . '>' . $listurl['Text'] . '</a>';

  if (isset($listurl['Description']) == true)
    $pagehtml = $pagehtml . " - " . $listurl['Description'];

  $pagehtml = $pagehtml . '</p>';
  }

$pagehtml = $pagehtml . '<p class="blockheading">Support</p>';
$pagehtml = $pagehtml . '<p>Technical information about the sprint racing results service.<p>';
foreach($subsectionurls2 as $listurl)
  {
  $pagehtml = $pagehtml . '<p><a href="' . $listurl['URL'] . '"';
  if (isset($listurl['Target']) == true)
    $pagehtml = $pagehtml . ' target="' . $listurl['Target'] . '"';
  $pagehtml = $pagehtml . '>' . $listurl['Text'] . '</a></p>';
  }
$pagehtml = $pagehtml . '</section>';
?>
