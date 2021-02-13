<?php
//Get the current directory
$currentdirectory = getcwd();
$removedirs = array("/pages","/engines","/admin","/srrs");
$currentdirectory = str_replace($removedirs,"",$currentdirectory);

if ((strpos($currentdirectory,"rocrooks.ca") === false) AND (strpos($currentdirectory,"live") === false) AND (strpos($currentdirectory,"newcms") === false))
  {
  $ahrefjoin = "?";
  $urlcell = "URL";
  }
else
  {
  $ahrefjoin = "&";
  $urlcell = "PageName";
  }

//Format URL variables
if (isset($urlvariables) == true)
  $urlvariables = "?" . implode("&",$urlvariables);

//The URLs and Page Names
$defaulturls['Analytics'] = array("URL"=>"analytics.php","PageName"=>"");
$defaulturls['EventRecords'] = array("URL"=>"event-records.php","PageName"=>"");
$defaulturls['ClubSearch'] = array("URL"=>"club-search.php","PageName"=>"");
$defaulturls['PaddlerSearch'] = array("URL"=>"paddler-search.php","PageName"=>"");
$defaulturls['RegattasList'] = array("URL"=>"regattalist.php","PageName"=>"");
$defaulturls['RegattaLookup'] = array("URL"=>"regatta-results-lookup.php","PageName"=>"");
$defaulturls['RegattaResults'] = array("URL"=>"regatta-results.php","PageName"=>"");
$defaulturls['RaceResults'] = array("URL"=>"race-display.php","PageName"=>"");
$defaulturls['PaddlerPage'] = array("URL"=>"paddler-page.php","PageName"=>"");
$defaulturls['ClubPage'] = array("URL"=>"club-page.php","PageName"=>"");
$defaulturls['TopNTimes'] = array("URL"=>"toptimes.php","PageName"=>"");
$defaulturls['TopNTimesBrowser'] = array("URL"=>"eventbesttimes.php","PageName"=>"");

//Get the appropriate URL or page name
foreach ($defaulturls as $defaultkey=>$options)
  {
  $defaulturls[$defaultkey] = $options[$urlcell];
  }
?>
