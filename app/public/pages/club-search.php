<?php
include_once $engineslocation . 'srrs-required-functions.php';
include_once $engineslocation . 'srrs-user-input-processing.php';

$pagehtml = "";

if (isset($_POST['Submit']) == true)
  {
  //Get search term
  $search = "%" . $_POST['Search'] . "%";

  //Search for clubs
  $clubsearchsql = "SELECT `Code`, `LongName` FROM `clubs` WHERE `Code` LIKE ? OR `ShortName` LIKE ? OR `LongName` LIKE ? ";
  $searchvalues = array($search,$search,$search);
  $searchresults = dbprepareandexecute($srrsdblink,$clubsearchsql,$searchvalues);

  //Make HTML of clubs found
  if (count($searchresults) > 0)
    {
    foreach ($searchresults as $resultskey=>$clubfound)
      {
      $searchresults[$resultskey] = '<p><a href="ClubHome?club=' . $clubfound['Code'] . '">' . $clubfound['LongName'] . '</a></p>';
      }

    $clubshtml = '<p>Found ' . count($searchresults) . ' clubs matching the search term ' . $_POST['Search'] . '</p>';
    $clubshtml = $clubshtml . implode("",$searchresults);
    }
  else
    $clubshtml = '<p>No clubs found that match the query "' . $_POST['Search'] . '"!</p>';

  $pagehtml = $pagehtml . '<section>' . $clubshtml . '</section>';
  }

$pagehtml = $pagehtml . '<section>
<form action="ClubSearch" method="post">
<p>Search for results from a particular club.</p>
<p>Type the name of a club or a 3 letter code and search for results of that club.</p>
<p><input type="text" size="20" name="Search"> <input type="submit" name="Submit" value="Go"></p>
</form>
</section>';
?>
