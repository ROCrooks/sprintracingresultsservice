<?php
include $engineslocation . 'srrs-required-functions.php';
include $engineslocation . 'srrs-user-input-processing.php';

//Get races
include $engineslocation . 'get-races.php';

//print_r($regattaresults);

$pagehtml = '<section>';
$pagehtml = $pagehtml . '<p style="font-size: 200%; text-align: center;">' . $regattaresults['Details']['Name'] . '</p>';

$pagehtml = $pagehtml . '<p>Showing a summary of the results of the regatta. Click on the name of any race to give a detailed view of the race.</p>';

//Containers for HTML text in columns and heights of the columns
$leftcolumn = '<div style="float: left; padding-left: 20px; padding-right: 20px;">';
$rightcolumn = '<div style="float: left; padding-left: 20px; padding-right: 20px;">';
$leftfill = 0;
$rightfill = 0;

//Convert each race to HTML
foreach($regattaresults['Races'] as $raceelement)
  {
  //Create race description line
  $racehtml = "<div>";
  $racehtml = $racehtml . '<p style="font-size: 120%;"><a href="RaceView?race=' . $raceelement['Key'];
  if ($club != '')
    $racehtml = $racehtml . '&club=' . $club;
  if ($paddler != '')
    $racehtml = $racehtml . '&paddler=' . $paddler;
  if ($jsv != '')
    $racehtml = $racehtml . '&jsv=' . $jsv;
  if ($mw != '')
    $racehtml = $racehtml . '&mw=' . $mw;
  if ($ck != '')
    $racehtml = $racehtml . '&ck=' . $ck;
  if ($abil != '')
    $racehtml = $racehtml . '&abil=' . $abil;
  if ($spec != '')
    $racehtml = $racehtml . '&spec=' . $spec;
  if ($ages != '')
    $racehtml = $racehtml . '&ages=' . $ages;
  $racehtml = $racehtml . '">' . $raceelement['Name'] . '</a></p>';
  $racehtml = $racehtml . "</div>";
  foreach($raceelement['Paddlers'] as $paddlerelement)
    {
    //Calculate the number of pixels that the race takes up
    //This may need amending on live version
    $setracepixels = 60;
    $perpaddlerpixels = 18;

    //Highlight row if needed
    $userinputs = array("Club"=>$club,"Paddler"=>$paddler,"PadJSV"=>$padjsv,"PadMW"=>$padmw,"PadCK"=>$padck);
    $highlight = highlightcheck($userinputs,$paddlerelement);

    //Widths of the cells in the races
    $widths = array("Position"=>20,"Club"=>80,"Crew"=>250,"Time"=>60);
    $totalwidth = array_sum($widths);

    //Process crew and club onto 2 lines if a 4s race
    if ($raceelement['BoatSize'] == 4)
      {
      $paddlerelement['Crew'] = explode("/",$paddlerelement['Crew']);

      //Update all unidentified paddlers if needed to display correctly
      $checkfield = 0;
      while ($checkfield < 4)
        {
        if (isset($paddlerelement['Crew'][$checkfield]) == false)
          $paddlerelement['Crew'][$checkfield] = "??????";
        $checkfield++;
        }

      $paddlerelement['Crew'] = $paddlerelement['Crew'][0] . "/" . $paddlerelement['Crew'][1] . "<br>" . $paddlerelement['Crew'][2] . "/" . $paddlerelement['Crew'][3];

      //Process club onto 2 lines if there are 4 clubs
      $paddlerelement['Club'] = explode("/",$paddlerelement['Club']);
      if (count($paddlerelement['Club']) == 4)
        $paddlerelement['Club'] = $paddlerelement['Club'][0] . "/" . $paddlerelement['Club'][1] . "<br>" . $paddlerelement['Club'][2] . "/" . $paddlerelement['Club'][3];
      else
        $paddlerelement['Club'] = implode("",$paddlerelement['Club']);
      }

    //Make HTML of race line
    if ($highlight == true)
      $racehtml = $racehtml . '<div style="display: table; width: ' . $totalwidth . 'px; background-color: yellow;">';
    else
      $racehtml = $racehtml . '<div style="display: table; width: ' . $totalwidth . 'px; padding-bottom: 0px;">';
    $racehtml = $racehtml . '<div style="display: table-cell; width: ' . $widths['Position'] . 'px;"><p style="margin: 0px;">' . $paddlerelement['Position'] . '</p></div>';
    $racehtml = $racehtml . '<div style="display: table-cell; width: ' . $widths['Club'] . 'px; padding-bottom: 0px; padding-top: 0px;"><p style="margin: 0px;">' . $paddlerelement['Club'] . '</p></div>';
    $racehtml = $racehtml . '<div style="display: table-cell; width: ' . $widths['Crew'] . 'px; padding-bottom: 0px; padding-top: 0px;"><p style="margin: 0px;">' . $paddlerelement['Crew'] . '</p></div>';
    $racehtml = $racehtml . '<div style="display: table-cell; width: ' . $widths['Time'] . 'px; padding-bottom: 0px; padding-top: 0px;"><p style="margin: 0px;">' . $paddlerelement['Time'] . '</p></div>';
    $racehtml = $racehtml . '</div>';
    }

  //Work out how much space the race takes up to put a column
  if ($raceelement['BoatSize'] == 4)
    $weighting = 2;
  else
    $weighting = 1;
  $racenopixels = ($perpaddlerpixels*$weighting)+$setracepixels;

  //Place HTML into columns
  if ($leftfill > $rightfill)
    {
    $rightcolumn = $rightcolumn . $racehtml;
    $rightfill = $rightfill+$racenopixels;
    }
  elseif ($leftfill <= $rightfill)
    {
    $leftcolumn = $leftcolumn . $racehtml;
    $leftfill = $leftfill+$racenopixels;
    }
  }

//Close left and right columns of flex boxes
$leftcolumn = $leftcolumn . '</div>';
$rightcolumn = $rightcolumn . '</div>';

//Echo HTML
$pagehtml = $pagehtml . '<div style="display: flex;">';
$pagehtml = $pagehtml . $leftcolumn;
$pagehtml = $pagehtml . $rightcolumn;
$pagehtml = $pagehtml . '</div>';
$pagehtml = $pagehtml . '</section>';
?>
