<?php
//List of links
$subsectionurls = array();
$subsectionurls[0] = array("URL"=>"ViewClasses","Text"=>"View Classes","Description"=>"View classes and whether they are automatically assigned or not.");
$subsectionurls[1] = array("URL"=>"AddClass","Text"=>"Add Classes","Description"=>"Add classes to races which do not have classes automatically assigned.");

//Make the HTML for the management tools
$pagehtml = '<section>';
$pagehtml = $pagehtml . '<p class="blockheading">Class Management Tools</p>';
$pagehtml = $pagehtml . '<p>Manage race classes in the sprint racing results service.</p>';
foreach($subsectionurls as $listurl)
  {
  $pagehtml = $pagehtml . '<p><a href="' . $listurl['URL'] . '"';
  if (isset($listurl['Target']) == true)
    $pagehtml = $pagehtml . ' target="' . $listurl['Target'] . '"';
  $pagehtml = $pagehtml . '>' . $listurl['Text'] . '</a>';

  if (isset($listurl['Description']) == true)
    $pagehtml = $pagehtml . " - " . $listurl['Description'];

  $pagehtml = $pagehtml . '</p>';
  }

$pagehtml = $pagehtml . '</section>';
?>
