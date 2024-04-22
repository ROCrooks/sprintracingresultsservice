<?php
$regex['boats'] = '(^[kcv][124])i';
$regex['distance'] = '([0-9][km])i';
$regex['round'] = '([s*f*h*][0-9])i';
$regex['raceno'] = '(^[0-9]$)';
$regex['paddler'] = '([a-z])i';
$regex['positionandlane'] = '(^[0-9] [0-9] )';
$regex['positionorlane'] = '(^[0-9] [0-9A-Z][0-9A-Z][0-9A-Z] )';
$regex['defaultclub'] = array('([0-9A-Z?][0-9A-Z?][0-9A-Z?]/[0-9A-Z?][0-9A-Z?][0-9A-Z?]/[0-9A-Z?][0-9A-Z?][0-9A-Z?]/[0-9A-Z?][0-9A-Z?][0-9A-Z?] )','([0-9A-Z?][0-9A-Z?][0-9A-Z?]/[0-9A-Z?][0-9A-Z?][0-9A-Z?] )','([0-9A-Z][0-9A-Z][0-9A-Z] )');
$regex['linestarts'] = array('([0-9][0-9] [0-9][0-9] [0-9A-Z?][0-9A-Z?][0-9A-Z?] )','([0-9][0-9] [0-9] [0-9A-Z?][0-9A-Z?][0-9A-Z?] )','([0-9] [0-9] [0-9A-Z?][0-9A-Z?][0-9A-Z?] )','([0-9][0-9] [0-9A-Z?][0-9A-Z?][0-9A-Z?] )','([0-9] [0-9A-Z?][0-9A-Z???][0-9A-Z?] )','([0-9A-Z?][0-9A-Z?][0-9A-Z?] )','([0-9][0-9] [0-9] )','([0-9] [0-9] )','([0-9][0-9] )','([0-9] )');
$regex['multiclubformats'] = array();
$regex['notfinishings'] = array('DNF','DSQ','DNS','NR','???','ERR','UNK');
$regex['pagedetails'] = '(page [0-9] of [0-9])i';
$regex['timeformats'] = array('( [0-9]:[0-5][0-9].[0-9][0-9])','( [2-5][0-9].[0-9][0-9])','( [0-9]:[0-5][0-9]:[0-5][0-9])','( [0-5][0-9]:[0-5][0-9].[0-9][0-9])','( [0-5][0-9]:[0-5][0-9])','( [0-9]:[0-5][0-9])');
$regex['differentclassflag'] = '(\[[JSV][MWX][CK]\])';
$regex['individualclub'] = '(\([0-9A-Z][0-9A-Z][0-9A-Z]\))';




//'(^[0-9] [0-9] )',
//'(^[0-9] [0-9] [0-9A-Z???][0-9A-Z???][0-9A-Z???] )',
//'(^[0-9] [0-9A-Z???][0-9A-Z???][0-9A-Z???] )',
//'(^[0-9] )',
//'(^[0-9][0-9] [0-9A-Z?][0-9A-Z?][0-9A-Z?] )',
?>
