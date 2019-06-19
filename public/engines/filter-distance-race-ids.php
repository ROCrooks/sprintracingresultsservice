<?php
include_once 'required-functions.php';

$findvalues = array(200,500,1000,"LD");
$selectas = "Group";

$distanceraceids = array();

//Get race IDs for individual distances or boat sizes
if ($selectas == "Individual")
  {
  foreach($findvalues as $racedistance)
    {
    if ($racedistance != "LD")
      {
      //Create SQL statement if needed
      if (isset($findracesstmt) == false)
        {
        $findracessql = "SELECT `Key` FROM `races` WHERE `Dist` = ?";
        $findracesstmt = dbprepare($srrsdblink,$findracessql);
        }

      $result = dbexecute($findracesstmt,$racedistance);
      }
    //Prepare a different statement for long distance races
    elseif ($racedistance == "LD")
      {
      $findracessql = "SELECT `Key` FROM `races` WHERE `Dist` > ?";
      $findracesstmt = dbprepare($srrsdblink,$findracessql);

      $result = dbexecute($findracesstmt,1000);

      //Unset the statement as it is only used for long distances, and should only occur once
      unset($findracesstmt);
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
  foreach($findvalues as $racedistance)
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
    $findracessql = "SELECT `Key` FROM `races` WHERE " . implode(" OR ",$distanceconstraintssql);
    $result = dbprepareandexecute($srrsdblink,$findracessql,$distanceconstraintsvalues);
    $result = resulttocolumn($result,"Key");
    }
  else
    $result = array();

  $distanceraceids['All'] = $result;
  }
?>
