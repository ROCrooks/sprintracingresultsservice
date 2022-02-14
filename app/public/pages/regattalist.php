<?php
//Get the directory of the engines
$currentdirectory = getcwd();
$removedirs = array("/pages","/engines","/admin","/srrs");
$currentdirectory = str_replace($removedirs,"",$currentdirectory);
$enginesdirectory = $currentdirectory . "/srrs/engines/";

include $enginesdirectory . 'user-input-processing.php';
include $enginesdirectory . 'defaulturls.php';

//Define join to attach club variable
if (strpos($defaulturls['RegattaLookup'],"?") === false)
  $ahrefjoin = "?";
else
  $ahrefjoin = "&";

$getallregattas = false;
include $enginesdirectory . 'list-regattas.php';

usort($allregattaslist,'sortregattas');

$namesection = 400;
$datesection = 100;
$boxheight = 50;
$totalwidth = $namesection+$datesection;

$js = "";

//Make the appropriate hyperlinks
$hyperlink1 = $defaulturls['RegattaLookup'] . $ahrefjoin . "regatta=";
$hyperlink2 = "";
if ($club != '')
  $hyperlink2 = $hyperlink2 . "&club=" . $club;
if ($paddler != '')
  $hyperlink2 = $hyperlink2 . "&paddler=" . $paddler;

echo '<div class="item">';
echo '<p>Browse the regattas stored in SRRS. Click on a year to expand the list of regattas in that year.</p>';

//Display all regatta details
$startyear = "NULL";
foreach ($allregattaslist as $regattadetails)
  {
  //Make the year beginning
  if ($regattadetails['Year'] != $startyear)
    {
    if ($startyear != "NULL")
      echo '</div>';

    $startyear = $regattadetails['Year'];
    echo '<div style="border-style: solid; border-color: #000000; width: ' . $totalwidth . 'px; height: ' . $boxheight . 'px;" onclick="show' . $startyear . '()">' . $regattadetails['Year'] . '</div>';
    //Make section that toggles between visible and invisible
    echo '<div id="' . $startyear . 'races" style="display: none;">';
    $js = $js . 'function show' . $startyear . '()
      {
      var raceblock = document.getElementById("' . $startyear . 'races");
      if (raceblock.style.display === "none")
        {
        raceblock.style.display = "block";
        }
      else
        {
        raceblock.style.display = "none";
        }
      }';
    }

  //Make the row with the regatta details
  echo '<div style="display: table; width: ' . $totalwidth . 'px; height: ' . $boxheight . 'px;">';
  echo '<div style="display: table-cell; width: ' . $namesection . 'px; height: ' . $boxheight . 'px;"><p><a href="' . $hyperlink1 . $regattadetails['Key'] . $hyperlink2 . '">' . $regattadetails['Name'] . '</a></p></div>';
  echo '<div style="display: table-cell; width: ' . $datesection . 'px; height: ' . $boxheight . 'px;"><p>' . $regattadetails['Date'] . '</p></div>';
  echo '</div>';
  }
echo '</div>';
echo '</div>';
?>

<script>
<?php echo $js; ?>
</script>
