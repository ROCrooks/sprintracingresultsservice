<?php
//Required functions
include 'required-functions.php';

//Container for the base SQL constraints
$sqlcheckbaseconstraints = array();

//Create the SQL to check if the
$sqlcheckforevent = "SELECT COUNT(*) FROM `paddlers` p
LEFT JOIN `races` r ON r.`Key` = p.`Race` WHERE ";

//Attach the club constraint to the URL and SQL
if (isset($club) == true)
  {
  if ($club != '')
    {
    //Add club to URL
    $lookupurl = $lookupurl . $ahrefjoin . "club=" . $club;
    $ahrefjoin = "&";

    //Add club wildcard to constraint
    $clubwildcard = "*" . $club . "*";
    array_push($sqlcheckconstraints);

    //Add the club to the SQL query
    $sqlcheckforevent = $sqlcheckforevent . " p.`Club` LIKE ? AND ";
    }
  }

//Finish the SQL
$sqlcheckforevent = $sqlcheckforevent . "p.`MW` = ? AND p.`CK` = ? AND r.`Boat` = ? AND r.`Dist` = ?";

//Make the SQL for the JV searches
$sqlcheckforeventjv = $sqlcheckforevent . " AND p.`JSV` = ?";

//Prepare SQL queries
$stmtcheckforevent = dbprepare($srrsdblink,$sqlcheckforevent);
$stmtcheckforeventjv = dbprepare($srrsdblink,$sqlcheckforeventjv);

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
$jsvs = array("","J","V");

//Column widths for the
$columnwidths = array();
$columnwidths['Name'] = 100;
$columnwidths['Distance'] = 100;
$totalwidth = $columnwidths['Name']+($columnwidths['Distance']*4);

//Make the HTML for the output table
$eventslisthtml = '<div style="display: table; margin: auto; width: ' . $totalwidth . 'px;">';

//Make the HTML for the output table
$eventslisthtml = $eventslisthtml . '<div style="display: table-row; margin: auto;">';
$eventslisthtml = $eventslisthtml . '</div>';

foreach ($searches as $search)
  {
  //The standard URL constraints
  $standardurlconstraints = "mw=" . $search['MW'] . "&ck=" . $search['CK'] . "&boat=" . $search['Boat'] . "&find=10";

  //The SQL constraints based on the class
  $baseclasssqlconstraints = $sqlcheckbaseconstraints;
  array_push($baseclasssqlconstraints,$search['MW']);
  array_push($baseclasssqlconstraints,$search['CK']);
  array_push($baseclasssqlconstraints,$search['Boat']);

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

    //Make the final SQL constraint, including the distance
    $finalsqlconstraints = $baseclasssqlconstraints;
    array_push($finalsqlconstraints,$distance);

    //Attach the distance to the URL
    $distanceurl = $standardurlconstraints . "&distance=" . $distance;

    //Loop each top N times list and put them below the distance
    $jsvshtml = array();
    foreach ($jsvs as $jsv)
      {
      $fullurl = $lookupurl . $ahrefjoin . $distanceurl;
      //Add the search
      if ($jsv != "")
        $fullurl = $fullurl . "&jsv=" . $jsv;

      if ($jsv == "")
        $linkname = "Overall";
      if ($jsv == "J")
        $linkname = "Junior";
      if ($jsv == "V")
        $linkname = "Masters";

      if ($jsv != "")
        {
        $lookupconstraints = $finalsqlconstraints;
        array_push($lookupconstraints,$jsv);
        $lookupstmt = $stmtcheckforeventjv;
        }
      else
        {
        $lookupconstraints = $finalsqlconstraints;
        $lookupstmt = $stmtcheckforevent;
        }

      //Run the query to count number of paddlers
      $countpaddlers = dbexecute($lookupstmt,$lookupconstraints);
      $countpaddlers = $countpaddlers[0]['COUNT(*)'];
      echo $countpaddlers . "<br>";

      //Make the HTML link for finding the top N results if there are paddlers
      if ($countpaddlers > 0)
        $linkname = '<a href="' . $fullurl . '">' . $linkname . '</a>';

      array_push($jsvshtml,$linkname);
      }
    $jsvshtml = '<p>' . implode("<br>",$jsvshtml) . '</p>';
    $cellhtml = $cellhtml . $jsvshtml;

    $eventslisthtml = $eventslisthtml . '<div style="display: table-cell; width: ' . $columnwidths['Distance'] . 'px;">' . $cellhtml . '</div>';
    }

  $eventslisthtml = $eventslisthtml . '</div>';
  }

$eventslisthtml = $eventslisthtml . '</div>';
?>
