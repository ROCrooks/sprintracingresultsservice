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

//Config file with default URLs for SRRS
$defaulturls = array();
$defaulturls['AddRegatta'] = array("URL"=>"add-regatta.php","PageName"=>"AddRegatta");
$defaulturls['EditRegatta'] = array("URL"=>"edit-regatta.php","PageName"=>"EditRegatta");
$defaulturls['EditRace'] = array("URL"=>"edit-race.php","PageName"=>"EditRace");
$defaulturls['ManageRegattas'] = array("URL"=>"manage-regattas.php","PageName"=>"ManageRegattas");
$defaulturls['ManageClasses'] = array("URL"=>"class-manager.php","PageName"=>"ManageClasses");
$defaulturls['EditClass'] = array("URL"=>"edit-class.php","PageName"=>"EditClass");
$defaulturls['AddClass'] = array("URL"=>"add-class.php","PageName"=>"AddClass");

//Get the appropriate URL or page name
foreach ($defaulturls as $defaultkey=>$options)
  {
  //Put the ?page= onto the URL
  if ($urlcell == "PageName")
    $options[$urlcell] = "?page=" . $options[$urlcell];

  $defaulturls[$defaultkey] = $options[$urlcell];
  }
?>
