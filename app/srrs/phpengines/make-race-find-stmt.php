<?php
include_once $engineslocation . 'srrs-required-functions.php';

//Base query
$racefindsql = "SELECT";
$racefindbaseconstraints = array($regattaid);

if ($searchtype == "rows")
  $racefindsql = $racefindsql . " r.`Key`, r.`Regatta`, r.`Boat`, r.`Dist`, r.`R`, r.`D`, r.`FreeText`";
elseif ($searchtype == "count")
  $racefindsql = $racefindsql . " COUNT(*)";

$racefindsql = $racefindsql . " FROM `races` r";

//Join classes if needed
$racefindsql = $racefindsql . " RIGHT JOIN `classes` c ON c.`Race` = r.`Key`";

//Join paddlers if needed
if (($club != "") OR ($paddler != ""))
  $racefindsql = $racefindsql . " RIGHT JOIN `paddlers` p ON p.`Race` = r.`Key`";

$racefindsql = $racefindsql . " WHERE r.`Regatta` = ?";

//Search paddlers if needed
if ($club != '')
  {
  $club = str_replace(" ","",$club);
  $clubarray = explode(",",$club);
  //Make each club into a wildcard
  foreach ($clubarray as $clubkey=>$clubvalue)
    {
    $clubarray[$clubkey] = "%" . $clubvalue . "%";
    }

  $clubsql = elementlisttoconstraint($clubarray,"Club","p","LIKE");
  $racefindsql = $racefindsql . " AND " . $clubsql['SQLText'];
  $racefindbaseconstraints = array_merge($racefindbaseconstraints,$clubsql['SQLValues']);
  }

if ($paddler != '')
  {
  $altpaddlernames = paddlertopossibilities($paddler);
  $clubsql = elementlisttoconstraint($altpaddlernames,"Crew","p","LIKE");
  $racefindsql = $racefindsql . " AND " . $clubsql['SQLText'];
  $racefindbaseconstraints = array_merge($racefindbaseconstraints,$clubsql['SQLValues']);
  }

//Search class
$racefindsql = $racefindsql . " AND c.`JSV` LIKE ?
AND c.`MW` LIKE ?
AND c.`CK` LIKE ?
AND c.`Abil` LIKE ?
AND c.`Spec` LIKE ?
AND c.`Ages` LIKE ?";

//Prepare the statement
$racesfindstmt = dbprepare($srrsdblink,$racefindsql);
?>
