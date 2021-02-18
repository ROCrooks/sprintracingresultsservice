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
$defaulturls['Analytics'] = array("URL"=>"analytics.php","PageName"=>"RegattaAnalytics");
$defaulturls['EventRecords'] = array("URL"=>"event-records.php","PageName"=>"EventRecords");
$defaulturls['ClubSearch'] = array("URL"=>"club-search.php","PageName"=>"ClubSearch");
$defaulturls['PaddlerSearch'] = array("URL"=>"paddler-search.php","PageName"=>"PaddlerSearch");
$defaulturls['RegattasList'] = array("URL"=>"regattalist.php","PageName"=>"RegattaList");
$defaulturls['RegattaLookup'] = array("URL"=>"regatta-results-lookup.php","PageName"=>"ResultsLookup");
$defaulturls['RegattaResults'] = array("URL"=>"regatta-results.php","PageName"=>"RegattaResults");
$defaulturls['RaceResults'] = array("URL"=>"race-display.php","PageName"=>"RaceView");
$defaulturls['PaddlerPage'] = array("URL"=>"paddler-page.php","PageName"=>"PaddlerPage");
$defaulturls['ClubPage'] = array("URL"=>"club-page.php","PageName"=>"ClubHome");
$defaulturls['TopNTimes'] = array("URL"=>"toptimes.php","PageName"=>"");
$defaulturls['TopNTimesBrowser'] = array("URL"=>"eventbesttimes.php","PageName"=>"");
$defaulturls['RestInstructions'] = array("URL"=>"","PageName"=>"RESTInfo");
$defaulturls['TimesAnalysis'] = array("URL"=>"","PageName"=>"");
$defaulturls['TimesAnalysisBrowser'] = array("URL"=>"","PageName"=>"");

//Get the appropriate URL or page name
foreach ($defaulturls as $defaultkey=>$options)
  {
  //Put the ?page= onto the URL
  if ($urlcell == "PageName")
    $options[$urlcell] = "?page=" . $options[$urlcell];

  $defaulturls[$defaultkey] = $options[$urlcell];
  }
?>
