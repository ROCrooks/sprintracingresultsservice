<?php
include_once 'required-functions.php';

//Default count
$paddlerseatssql = "SELECT COUNT(*) FROM `paddlers` ";

$paddlersqltext = array();
$paddlerconstraints = array();

//Add constraints to paddler query if specified
//Raceids are used to select races (and from that paddlers) that meet boat size, distance or race class
if ($jsv != "")
  {
  array_push($paddlersqltext,"`JSV` = ?");
  array_push($paddlerconstraints,$jsv);
  }
if ($mw != "")
  {
  array_push($paddlersqltext,"`MW` = ?");
  array_push($paddlerconstraints,$mw);
  }
if ($ck != "")
  {
  array_push($paddlersqltext,"`CK` = ?");
  array_push($paddlerconstraints,$ck);
  }
if ($club != "")
  {
  array_push($paddlersqltext,"`Club` = ?");
  array_push($paddlerconstraints,$club);
  }
if (count($raceids) > 0)
  {
  $raceidssql = makesqlrange($raceids,"Race");
  array_push($paddlersqltext,$raceidssql['SQLText']);
  array_push($paddlerconstraints,$raceidssql['SQLValues']);
  }
if (count($paddlersqltext) > 0)
  {
  $paddlersqltext = implode(" AND ",$paddlersqltext);
  $paddlerseatssql = $paddlerseatssql . " WHERE " . $paddlersqltext;
  }

//Count the number of races of this type
$paddlerscount = dbprepareandexecute($srrsdblink,$paddlerseatssql,$paddlerconstraints);
$paddlerscount = $paddlerscount[0]['COUNT(*)'];
?>
