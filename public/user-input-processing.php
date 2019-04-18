<?php
include_once 'required-functions.php';

//Details of user inputs
$inputrules = array();
$inputrules['jsv'] = array("Whitelist"=>"JSV");
$inputrules['mw'] = array("Whitelist"=>"MW");
$inputrules['ck'] = array("Whitelist"=>"CK");
$inputrules['abil'] = array("Whitelist"=>"ABCDOLT123");
$inputrules['spec'] = array("AllowedValues"=>array("LT","PC","PD","SP","IS"));
$inputrules['ages'] = array("AllowedValues"=>array("U10","U12","U14","U16","U17","U18","JUN","U23","SEN","VET","O34","O35","O44","O45","O54","O55","O64","O65"));
$inputrules['raceregatta'] = array("Whitelist"=>"1234567890");

$raceid = getandprocessinput("race",$inputrules['raceregatta']);
$jsv = getandprocessinput("jsv",$inputrules['jsv']);
$mw = getandprocessinput("mw",$inputrules['mw']);
$ck = getandprocessinput("ck",$inputrules['ck']);
$abil = getandprocessinput("abil",$inputrules['abil']);
$spec = getandprocessinput("spec",$inputrules['spec']);
$ages = getandprocessinput("ages",$inputrules['ages']);
$club = getandprocessinput("club");
$paddler = getandprocessinput("paddler");
$padjsv = getandprocessinput("padjsv",$inputrules['jsv']);
$padmw = getandprocessinput("padmw",$inputrules['mw']);
$padck = getandprocessinput("padck",$inputrules['ck']);
$regattaid = getandprocessinput("regatta",$inputrules['raceregatta']);

$variabletransmissioninputs['race'] = $raceid;
$variabletransmissioninputs['jsv'] = $jsv;
$variabletransmissioninputs['mw'] = $mw;
$variabletransmissioninputs['ck'] = $ck;
$variabletransmissioninputs['abil'] = $abil;
$variabletransmissioninputs['spec'] = $spec;
$variabletransmissioninputs['ages'] = $ages;
$variabletransmissioninputs['club'] = $club;
$variabletransmissioninputs['paddler'] = $paddler;
$variabletransmissioninputs['padck'] = $padjsv;
$variabletransmissioninputs['padmw'] = $padmw;
$variabletransmissioninputs['padck'] = $padck;
$variabletransmissioninputs['regatta'] = $regattaid;
?>
