<?php
include_once $engineslocation . 'srrs-required-functions.php';
include_once $engineslocation . 'srrs-user-input-processing.php';

$pagehtml = "";
if (isset($_POST['Submit']) == true)
  {
  //Get club and paddler from form
  $paddler = strtoupper($_POST['Paddler']);
  $club = str_replace(" ","",strtoupper($_POST['Clubs']));

  if ($club != '')
    {
    //Make club and paddler constraints
    $clublist = explode(",",$club);
    foreach ($clublist as $clubkey=>$clubitem)
      {
      $clublist[$clubkey] = "%" . $clubitem . "%";
      }
    $clubconstraint = elementlisttoconstraint($clublist,"Club","paddlers","LIKE");
    }
  $paddlerconstraint = paddlertopossibilities($paddler);

  //Run database query
  $paddlerfindsql = "SELECT COUNT(*) FROM `paddlers` WHERE (`Crew` LIKE ? OR `Crew` LIKE ? OR `Crew` LIKE ? OR `Crew` LIKE ? OR `Crew` LIKE ? OR `Crew` = ?)";
  if (isset($clubconstraint) == true)
    {
    //Attach clubs to query
    $paddlerfindsql = $paddlerfindsql . " AND " . $clubconstraint['SQLText'];
    $paddlerconstraints = array_merge($paddlerconstraint,$clubconstraint['SQLValues']);
    }
  else
    $paddlerconstraints = $paddlerconstraint;

  $paddlercount = dbprepareandexecute($srrsdblink,$paddlerfindsql,$paddlerconstraints);
  $paddlercount = $paddlercount[0]['COUNT(*)'];

  //Format text to describe paddler query
  $paddlertext = $paddler;
  if ($club != '')
    {
    $paddlertext = $paddlertext . " (" . $club . ")";
    }

  $pagehtml = $pagehtml . '<section>';
  $pagehtml = $pagehtml . '<p>Searched for ' . $paddlertext . '.</p>';
  if ($paddlercount > 0)
    {
    $pagehtml = $pagehtml . '<p>Found ' . $paddlercount . ' matching race results.<p>';
    $pagehtml = $pagehtml . '<p><a href="PaddlerPage?paddler=' . $paddler . '&club=' . $club . '">Click here</a> to go to the paddler index.</p>';
    }
  else
    {
    $pagehtml = $pagehtml . '<p>Couldn&#39;t find any results! Search again.<p>';
    }
  $pagehtml = $pagehtml . '</section>';
  }

$pagehtml = $pagehtml . '<section>
<form action="PaddlerSearch" method="post">
<p>Search for results from a particular paddler.</p>
<p>Search for a paddler based on their name (I. SURNAME) and club(s).</p>
<p>Multiple clubs are supported by separating club codes with commas.</p>
<p>Paddler: <input type="text" size="20" name="Paddler"></p>
<p>Club(s): <input type="text" size="20" name="Clubs"></p>
<p><input type="submit" name="Submit" value="Go"></p>
</form>
</section>';
?>
