<?php
include_once 'required-functions.php';

//Standard that all SQL texts have
$paddlersql = "SELECT DISTINCT `Race` FROM `paddlers`";

//Containers for storing text and values for constraints
$paddlerconstraintstext = array();
$paddlerconstraintsvalues = array();

//Add constraints if a paddler is specified
if ($paddler != "")
  {
  //Add SQL to constraints
  $namessql = "(`Crew` LIKE ? OR `Crew` LIKE ? OR `Crew` LIKE ? OR `Crew` LIKE ?)";
  array_push($paddlerconstraintstext,$namessql);

  //Format surname
  $surname = explode(".",$paddler);
  $surname = $surname[1];
  $surname = str_replace(" ","",$surname);

  //Add constraint values
  array_push($paddlerconstraintsvalues,"%" . $paddler . "%");
  array_push($paddlerconstraintsvalues,$surname . "/%");
  array_push($paddlerconstraintsvalues,"%/" . $surname . "/%");
  array_push($paddlerconstraintsvalues,"%/" . $surname);
  }

//Add JSV, MW, CK status to query
if ($padjsv != "")
  {
  array_push($paddlerconstraintstext,"`JSV` = ?");
  array_push($paddlerconstraintsvalues,$padjsv);
  }
if ($padmw != "")
  {
  array_push($paddlerconstraintstext,"`MW` = ?");
  array_push($paddlerconstraintsvalues,$padmw);
  }
if ($padck != "")
  {
  array_push($paddlerconstraintstext,"`CK` = ?");
  array_push($paddlerconstraintsvalues,$padck);
  }

//Add club details to search constraint
if ($club != "")
  {
  $clubs = str_replace(" ","",$club);
  $clubs = explode(",",$clubs);

  //Turn all the clubs into constraints
  $clubsconstraint = array();
  foreach ($clubs as $singleclub)
    {
    array_push($clubsconstraint,"`Club` LIKE ?");
    array_push($paddlerconstraintsvalues,$singleclub);
    }

  if (count($clubsconstraint) == 0)
    $clubsconstraint = $clubsconstraint[0];
  else
    $clubsconstraint = "(" . implode(" OR ",$clubsconstraint) . ")";

  array_push($paddlerconstraintstext,$clubsconstraint);
  }

if (count($paddlerconstraintsvalues) > 0)
  {
  $paddlersql = $paddlersql . " WHERE " . implode(" AND ",$paddlerconstraintstext);
  }

//Get race IDs for races with these classes
$getids = dbprepareandexecute($srrsdblink,$paddlersql,$paddlerconstraintsvalues);
$paddlerraceids = resulttocolumn($getids,"Race");
?>
