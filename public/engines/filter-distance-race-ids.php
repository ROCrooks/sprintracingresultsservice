<?php
include_once 'required-functions.php';

$finddistances = array(200,500,1000,"LD");
$selectas = "Group";

$distanceraceids = array();

//Get race IDs for individual distances or boat sizes
if ($selectas == "Individual")
  {
  foreach($finddistances as $racedistance)
    {
    if ($racedistance != "LD")
      {
      //Create SQL statement if needed
      if (isset($finddistanceracesstmt) == false)
        {
        $finddistanceracessql = "SELECT `Key` FROM `races` WHERE `Dist` = ?";
        $finddistanceracesstmt = dbprepare($srrsdblink,$finddistanceracessql);
        }

      $result = dbexecute($finddistanceracesstmt,$racedistance);
      }
    //Prepare a different statement for long distance races
    elseif ($racedistance == "LD")
      {
      $finddistanceracessql = "SELECT `Key` FROM `races` WHERE `Dist` > ?";
      $finddistanceracesstmt = dbprepare($srrsdblink,$finddistanceracessql);

      $result = dbexecute($finddistanceracesstmt,1000);

      //Unset the statement as it is only used for long distances, and should only occur once
      unset($finddistanceracesstmt);
      }

    //Get result as a single array
    $result = resulttocolumn($result,"Key");
    $distanceraceids[$racedistance] = $result;
    }
  }
if ($selectas == "Group")
  {
  //Make distance constraints
  $distanceconstraintssql = array();
  $distanceconstraintsvalues = array();
  foreach($finddistances as $racedistance)
    {
    if ($racedistance != "LD")
      {
      array_push($distanceconstraintssql,"`Dist` = ?");
      array_push($distanceconstraintsvalues,$racedistance);
      }
    elseif ($racedistance == "LD")
      {
      array_push($distanceconstraintssql,"`Dist` > ?");
      array_push($distanceconstraintsvalues,1000);
      }
    }

  //Run if there are any constraints, if not return an empty array
  if (count($distanceconstraintssql) > 0)
    {
    $finddistanceracessql = "SELECT `Key` FROM `races` WHERE " . implode(" OR ",$distanceconstraintssql);
    $result = dbprepareandexecute($srrsdblink,$finddistanceracessql,$distanceconstraintsvalues);
    $result = resulttocolumn($result,"Key");
    }
  else
    $result = array();

  $distanceraceids['All'] = $result;
  }
?>
