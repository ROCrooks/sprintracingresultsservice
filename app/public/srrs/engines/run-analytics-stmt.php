<?php
include_once 'required-functions.php';

//Definitions of how the data is defined
$datalabels = array();
$datalabels['JSV']['J'] = "Juniors";
$datalabels['JSV']['S'] = "Seniors";
$datalabels['JSV']['V'] = "Masters";
$datalabels['MW']['M'] = "Mens";
$datalabels['MW']['W'] = "Womens";
$datalabels['CK']['C'] = "Canoes";
$datalabels['CK']['K'] = "Kayaks";
$datalabels['CK']['V'] = "Va'as";
$datalabels['CK']['P'] = "SUPs";
$datalabels['CK']['T'] = "Touring Canoes";
$datalabels['BoatSize'][1] = "Singles";
$datalabels['BoatSize'][2] = "Doubles";
$datalabels['BoatSize'][4] = "Fours";
$datalabels['Distance'][200] = "200m";
$datalabels['Distance'][500] = "500m";
$datalabels['Distance'][1000] = "1000m";
$datalabels['Distance']['LD'] = "Long Distance";

if ($analyticsby == "JSV")
  $breakdown = $analyticsjsv;
elseif ($analyticsby == "MW")
  $breakdown = $analyticsmw;
elseif ($analyticsby == "CK")
  $breakdown = $analyticsck;
elseif ($analyticsby == "Distance")
  $breakdown = $analyticsdistances;
elseif ($analyticsby == "All")
  $breakdown = array("All");

$year = $startyear;
$analyticsresults = array();
//Search by year
while ($year <= $endyear)
  {
  //The results line
  $analyticsresultsline = array("Year"=>$year);

  //Create year date ranges
  $firstday = $year . "-01-01";
  $lastday = $year . "-12-31";
  $yearvalues = array($firstday,$lastday);
  //Search by subset
  if ($analyticsby == "All")
    {
    $totalpaddlercount = 0;
    foreach ($analyticsboatsizes as $boatsize)
      {
      //Run SQL query for each boat size
      $sqlconstraints = $yearvalues;
      array_push($sqlconstraints,$boatsize);
      $sqlconstraints = array_merge($baseconstraintvalues,$sqlconstraints);
      $paddlercount = dbexecute($analyticsstmt,$sqlconstraints);
      $paddlercount = $paddlercount[0]['COUNT(*)']*$boatsize;

      //Add paddler count for this onto total paddler count
      $totalpaddlercount = $totalpaddlercount+$paddlercount;
      }
    //Put paddler count into output array
    $analyticsresultsline['All'] = $totalpaddlercount;
    }
  elseif ($analyticsby == "BoatSize")
    {
    foreach ($analyticsboatsizes as $boatsize)
      {
      //Run SQL query for each boat size
      $sqlconstraints = $yearvalues;
      array_push($sqlconstraints,$boatsize);
      $sqlconstraints = array_merge($baseconstraintvalues,$sqlconstraints);
      $paddlercount = dbexecute($analyticsstmt,$sqlconstraints);
      $paddlercount = $paddlercount[0]['COUNT(*)']*$boatsize;

      //Put paddler count into output array
      $datalabel = $datalabels['BoatSize'][$boatsize];
      $analyticsresultsline[$datalabel] = $paddlercount;
      }
    }
  else
    {
    //Loop through each subset
    foreach ($breakdown as $subset)
      {
      $sqlsubsetconstraints = $yearvalues;
      $totalpaddlercount = 0;

      //Races in lanes where a distance is specified
      if ($subset != "LD")
        {
        //Add the subset to the constraints array
        array_push($sqlsubsetconstraints,$subset);

        //Loop through each boat size
        foreach ($analyticsboatsizes as $boatsize)
          {
          //Prepare variables and execute
          $sqlboatsizesconstraints = $sqlsubsetconstraints;
          array_push($sqlboatsizesconstraints,$boatsize);
          $sqlconstraints = array_merge($baseconstraintvalues,$sqlboatsizesconstraints);
          $paddlercount = dbexecute($analyticsstmt,$sqlconstraints);
          $paddlercount = $paddlercount[0]['COUNT(*)']*$boatsize;

          //Add paddler count for this onto total paddler count
          $totalpaddlercount = $totalpaddlercount+$paddlercount;
          }
        }
      //Long distance races
      elseif ($subset == "LD")
        {
        //Loop through each boat size
        foreach ($analyticsboatsizes as $boatsize)
          {
          //Prepare variables and execute
          $sqlboatsizesconstraints = $sqlsubsetconstraints;
          array_push($sqlboatsizesconstraints,$boatsize);
          $sqlconstraints = array_merge($baseconstraintvalues,$sqlboatsizesconstraints);
          $paddlercount = dbexecute($analyticslongstmt,$sqlconstraints);
          $paddlercount = $paddlercount[0]['COUNT(*)']*$boatsize;

          //Add paddler count for this onto total paddler count
          $totalpaddlercount = $totalpaddlercount+$paddlercount;
          }
        }
      $datalabel = $datalabels[$analyticsby][$subset];
      $analyticsresultsline[$datalabel] = $totalpaddlercount;
      }
    }
  //Put the results for the year onto a new line
  array_push($analyticsresults,$analyticsresultsline);
  $year++;
  }

?>
