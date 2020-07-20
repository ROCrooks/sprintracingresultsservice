<?php
//Get the default URLs
include 'defaulturls.php';

//Define join to attach URL variables
if (strpos($defaulturls['RegattaLookup'],"?") === false)
  $ahrefjoin = "?";
else
  $ahrefjoin = "&";

//Loop through MK, WK, MC, WC
$searches = array();
$searches[0] = array("MW"=>"M","CK"=>"K","Boat"=>1);
$searches[1] = array("MW"=>"M","CK"=>"K","Boat"=>2);
$searches[2] = array("MW"=>"M","CK"=>"K","Boat"=>4);
$searches[3] = array("MW"=>"W","CK"=>"K","Boat"=>1);
$searches[4] = array("MW"=>"W","CK"=>"K","Boat"=>2);
$searches[5] = array("MW"=>"W","CK"=>"K","Boat"=>4);
$searches[6] = array("MW"=>"M","CK"=>"C","Boat"=>1);
$searches[7] = array("MW"=>"M","CK"=>"C","Boat"=>2);
$searches[8] = array("MW"=>"M","CK"=>"C","Boat"=>4);
$searches[9] = array("MW"=>"W","CK"=>"C","Boat"=>1);
$searches[10] = array("MW"=>"W","CK"=>"C","Boat"=>2);
$searches[11] = array("MW"=>"W","CK"=>"C","Boat"=>4);

//Distances and tops to loop
$distances = array(200,500,1000,5000);
$tops = array(10,20,50);

//Column widths for the
$columnwidths = array();
$columnwidths['Name'] = 100;
$columnwidths['Distance'] = 100;
$totalwidth = $columnwidths['Name']+($columnwidths['Distance']*4);

//Make the HTML for the output table
$eventslisthtml = '<div style="display: table; margin: auto; width: ' . $totalwidth . 'px;">';

//Make the HTML for the output table
$eventslisthtml = $eventslisthtml . '<div style="display: table-row; margin: auto;">';
$eventslisthtml = $eventslisthtml . '<div style="display: table-cell; width: ' . $columnwidths['Name'] . 'px; cellspan: 5;"><p>Overall</p></div>';
$eventslisthtml = $eventslisthtml . '</div>';

foreach ($searches as $search)
  {
  //The standard URL constraints
  $standardurlconstraints = "mw=" . $search['MW'] . "&ck=" . $search['CK'] . "&boat=" . $search['Boat'];

  //Make name of the event class
  if ($search['MW'] == "M")
    $name = "Mens";
  if ($search['MW'] == "W")
    $name = "Womens";

  $name = $name . " " . $search['CK'] . $search['Boat'];

  $eventslisthtml = $eventslisthtml . '<div style="display: table-row; margin: auto;">';
  $eventslisthtml = $eventslisthtml . '<div style="display: table-cell; width: ' . $columnwidths['Name'] . 'px;"><p>' . $name . '</p></div>';

  //Loop each distance for finding top times
  foreach($distances as $distance)
    {
    $cellhtml = '<p>' . $distance . 'm</p>';

    //Attach the distance to the URL
    $distanceurl = $standardurlconstraints . "&distance=" . $distance;

    //Loop each top N times list and put them below the distance
    $topshtml = array();
    foreach ($tops as $top)
      {
      $fullurl = $defaulturls['TopNTimes'] . $ahrefjoin . $distanceurl . "&find=" . $top;
      $top = "Top " . $top;
      //Make the HTML link for finding the top N results
      $tophtml = '<a href="' . $fullurl . '">' . $top . '</a>';
      array_push($topshtml,$tophtml);
      }
    $topshtml = '<p>' . implode("<br>",$topshtml) . '</p>';
    $cellhtml = $cellhtml . $topshtml;

    $eventslisthtml = $eventslisthtml . '<div style="display: table-cell; width: ' . $columnwidths['Distance'] . 'px;">' . $cellhtml . '</div>';
    }

  $eventslisthtml = $eventslisthtml . '</div>';
  }

$eventslisthtml = $eventslisthtml . '</div>';
?>

<?php echo $eventslisthtml; ?>
