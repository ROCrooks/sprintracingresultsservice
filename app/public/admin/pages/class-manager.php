<?php
//Get the directory of the engines
$currentdirectory = getcwd();
$removedirs = array("/pages","/engines","/admin","/srrs");
$currentdirectory = str_replace($removedirs,"",$currentdirectory);

//Get the admin and public engines directories
$adminenginesrelativepath = $currentdirectory . "/admin/engines/";
$publicenginesrelativepath = $currentdirectory . "/srrs/engines/";

//Get default URLs
include $adminenginesrelativepath . 'srrsadmindefaulturls.php';

//Get classes list engine
include $adminenginesrelativepath . 'class-getallclasses.php';

//Widths
$racenamewidth = 200;
$numberraceswidth = 20;
$editlinkwidth = 20;
$fullwidthtable = $racenamewidth+$numberraceswidth+$editlinkwidth;

$allclasseslisthtml = '<div style="display: table; width: ' . $fullwidthtable . ';">';
foreach($uniqueclassnames as $classitem)
  {
  //Encode the input class name as HTML entity
  $urlclass = urlencode($classitem['InputClass']);

  $allclasseslisthtml = $allclasseslisthtml . '<div style="display: table-row; width: ' . $fullwidthtable . 'px;">';
  $allclasseslisthtml = $allclasseslisthtml . '<div style="display: table-cell; width: ' . $racenamewidth . 'px;"><p>' . $classitem['InputClass'] . '<br>' . $classitem['AutoClass'] . '</p></div>';
  $allclasseslisthtml = $allclasseslisthtml . '<div style="display: table-cell; width: ' . $numberraceswidth . 'px; vertical-align: middle;"><p>' . $classitem['RaceCount'] . '</p></div>';
  $allclasseslisthtml = $allclasseslisthtml . '<div style="display: table-cell; width: ' . $editlinkwidth . 'px; vertical-align: middle;"><p><a href="' . $defaulturls['EditClass'] . $ahrefjoin . 'class=' . $urlclass . '">Edit</a></p></div>';
  $allclasseslisthtml = $allclasseslisthtml . '</div>';
  }
$allclasseslisthtml = $allclasseslisthtml . '</div>';

$addclasslinkhtml = '<p><a href="' . $defaulturls['AddClass'] . '">Add Classes</a></p>';

?>
<div class="item">
<p class="blockheading">Class Manager</p>
<?php echo $addclasslinkhtml; ?>
<?php echo $allclasseslisthtml; ?>
</div>
