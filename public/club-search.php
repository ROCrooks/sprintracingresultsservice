<?php
include 'defaulturls.php';
include 'engines/required-functions.php';

if (isset($_POST['Submit']) == true)
  {
  //Get search term
  $search = "%" . $_POST['Search'] . "%";

  //Search for clubs
  $clubsearchsql = "SELECT `Code`, `LongName` FROM `clubs` WHERE `Code` LIKE ? OR `ShortName` LIKE ? OR `LongName` LIKE ? ";
  $searchvalues = array($search,$search,$search);
  $searchresults = dbprepareandexecute($srrsdblink,$clubsearchsql,$searchvalues);

  //Make HTML of clubs found
  $clubshtml = "";
  foreach ($searchresults as $clubfound)
    {
    //Define join to attach club variable
    if (strpos($defaulturls['ClubPage'],"?") === false)
      $join = "?";
    else
      $join = "&";

    $clubshtml = $clubshtml . '<p><a href="' . $defaulturls['ClubPage'] . $join . 'club=' . $clubfound['Code'] . '">' . $clubfound['LongName'] . '</a></p>';
    }
  if ($clubshtml == "")
    {
    $clubshtml = '<p>No clubs found that match the query "' . $_POST['Search'] . '"!</p>';
    }

  echo '<div class="item">' . $clubshtml . '</div>';
  }
?>

<div class="item">
<form action="<?php echo $defaulturls['ClubSearch']; ?>" method="post">
<p>Search for results from a particular club.</p>
<p>Type the name of a club or a 3 letter code and search for results of that club.</p>
<p><input type="text" size="20" name="Search"> <input type="submit" name="Submit" value="Go"></p>
</form>
</div>
