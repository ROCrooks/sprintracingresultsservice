<?php
include_once 'required-functions.php';

$listregattassql = "SELECT DISTINCT " . $regattafieldswanted . " FROM `regattas` g";

//Join races and paddlers if a club search or paddler search is needed
if (($club != '') OR ($paddler != ''))
  {
  $listregattassql = $listregattassql . " RIGHT JOIN `races` r ON r.`Regatta` = g.`Key`";
  $listregattassql = $listregattassql . " RIGHT JOIN `paddlers` p ON p.`Race` = r.`Key`";
  }

//Append WHERE
$listregattassql = $listregattassql . " WHERE g.`Key` != ''";

//Only find all regattas if requested
if ($getallregattas == true)
  $listregattassql = $listregattassql . " AND g.`Hide` = 0";

//Make regatta constraints for club
$regattaconstraints = array();
if ($club != '')
  {
  //Make the list of clubs as a constraint
  $clubslist = str_replace(" ","",$club);
  $clubslist = explode(",",$clubslist);
  foreach($clubslist as $clubslistkey=>$clubslistvalue)
    {
    $clubslist[$clubslistkey] = "%" . $clubslistvalue . "%";
    }

  //Add club constraints
  $clubsql = elementlisttoconstraint($clubslist,"Club","p",$comparison="LIKE");
  $listregattassql = $listregattassql . " AND " . $clubsql['SQLText'];
  $regattaconstraints = array_merge($regattaconstraints,$clubsql['SQLValues']);
  }

//Make regatta constraints for paddler
if ($paddler != '')
  {
  //Make the list of paddler possibilites
  $paddlerpossibilities = paddlertopossibilities($paddler);

  //Add paddler constraints
  $paddlersql = elementlisttoconstraint($paddlerpossibilities,"Crew","p",$comparison="LIKE");
  $listregattassql = $listregattassql . " AND " . $paddlersql['SQLText'];
  $regattaconstraints = array_merge($regattaconstraints,$paddlersql['SQLValues']);
  }

if (count($regattaconstraints) == 0)
  $regattaconstraints = false;

//Get regattas and process
$allregattaslist = dbprepareandexecute($srrsdblink,$listregattassql,$regattaconstraints);
?>
