<?php
include_once 'required-functions.php';

//Only run the engine if there are any races available
if (count($raceids) > 0)
  {
  if (isset($countjsv) == false)
    $countjsv = array();
  if (isset($countmw) == false)
    $countmw = array();
  if (isset($countck) == false)
    $countck = array();
  if (isset($club) == false)
    $club = "";

  //Default count
  $paddlerseatssql = "SELECT COUNT(*) FROM `paddlers` ";

  $paddlersqltext = array();
  $paddlerconstraints = array();

  //Add constraints to paddler query if specified
  //Raceids are used to select races (and from that paddlers) that meet boat size, distance or race class
  if (count($countjsv) > 0)
    {
    $sqlconstraint = elementlisttoconstraint($countjsv,"JSV");
    $paddlerconstraints = array_merge($paddlerconstraints,$sqlconstraint['SQLValues']);
    array_push($paddlersqltext,$sqlconstraint['SQLText']);
    }
  if (count($countmw) > 0)
    {
    $sqlconstraint = elementlisttoconstraint($countmw,"MW");
    $paddlerconstraints = array_merge($paddlerconstraints,$sqlconstraint['SQLValues']);
    array_push($paddlersqltext,$sqlconstraint['SQLText']);
    }
  if (count($countck) > 0)
    {
    $sqlconstraint = elementlisttoconstraint($countck,"CK");
    $paddlerconstraints = array_merge($paddlerconstraints,$sqlconstraint['SQLValues']);
    array_push($paddlersqltext,$sqlconstraint['SQLText']);
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
    $paddlerconstraints = array_merge($paddlerconstraints,$raceidssql['SQLValues']);
    }

  //Combine the constraints into the SQL query
  if (count($paddlersqltext) > 0)
    {
    $paddlersqltext = implode(" AND ",$paddlersqltext);
    $paddlerseatssql = $paddlerseatssql . " WHERE " . $paddlersqltext;
    }

  //Count the number of races of this type
  $paddlerscount = dbprepareandexecute($srrsdblink,$paddlerseatssql,$paddlerconstraints);
  $paddlerscount = $paddlerscount[0]['COUNT(*)'];
  }
else
  $paddlerscount = 0;
?>
