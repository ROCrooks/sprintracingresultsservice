<?php
include_once $engineslocation . 'srrs-required-functions.php';
include_once $engineslocation . 'srrs-user-input-processing.php';

//Get minimum year
$minyearsql = "SELECT DISTINCT `Year` FROM `regattas` WHERE `Year` > 0 ORDER BY `Year` ASC LIMIT 0, 1 ";
$minyearquery = mysqli_query($srrsdblink,$minyearsql);
$minyearresult = mysqli_fetch_array($minyearquery);
$minyear = $minyearresult['Year'];

//Get maximum year
$maxyearsql = "SELECT DISTINCT `Year` FROM `regattas` ORDER BY `Year` DESC LIMIT 0, 1 ";
$maxyearquery = mysqli_query($srrsdblink,$maxyearsql);
$maxyearresult = mysqli_fetch_array($maxyearquery);
$maxyear = $maxyearresult['Year'];

$pagehtml = '';

if (isset($_POST['submit']) == true)
	{
	$startyear = $_POST['minyear'];
	if ($startyear < $minyear)
		$startyear = $minyear;
	$endyear = $_POST['maxyear'];
	if ($startyear > $maxyear)
		$endyear = $maxyear;

	//Get display type
	$analyticsby = $_POST['displayas'];

	//Find distances and add to distances array
	$find200 = $_POST['find200'];
	$find500 = $_POST['find500'];
	$find1000 = $_POST['find1000'];
	$findld = $_POST['findld'];

	//Array with text for distances selected for figure
	$distancetext = array();

	//Populate distances array
	$analyticsdistances = array();
	if ($find200 == 'true')
		{
		array_push($analyticsdistances,"200");
		array_push($distancetext,"200m");
		}

	if ($find500 == 'true')
		{
		array_push($analyticsdistances,"500");
		array_push($distancetext,"500m");
		}

	if ($find1000 == 'true')
		{
		array_push($analyticsdistances,"1000");
		array_push($distancetext,"1000m");
		}

	if ($findld == 'true')
		{
		array_push($analyticsdistances,"LD");
		array_push($distancetext,"Long Distance");
		}

	//Create text for distances
	if (count($distancetext) < 4)
		{
		//Last element of array
		$lastelement = array_pop($distancetext);

		//List separated by commas
		$distancetext = implode(", ",$distancetext);

		//Create distance text
		$distancetext = " " . $distancetext . " and " . $lastelement . " races only.";
		}
	else
		$distancetext = "";

	//Find men/women to men/women array
	$findmen = getandprocessinput("findmen");
	$findwomen = getandprocessinput("findwomen");

	//Array with text for sexes selected for figure
	$mwstext = array();

	//Populate men/women array
	$analyticsmw = array();
	if ($findmen == 'true')
		{
		array_push($analyticsmw,"M");
		array_push($mwstext,"Men");
		}

	if ($findwomen == 'true')
		{
		array_push($analyticsmw,"W");
		array_push($mwstext,"Women");
		}

	//Create text for sexes
	if (count($mwstext) < 2)
		{
		//Create sexes text
		$mwstext = " " . $mwstext[0] . " only.";
		}
	else
		$mwstext = "";

	//Find canoes/kayaks to canoe/kayak array
	$findcanoe = getandprocessinput("findcanoe");
	$findkayak = getandprocessinput("findkayak");

	//Array with text for canoes or kayaks selected for figure
	$ckstext = array();

	//Populate canoes/kayaks array
	$analyticsck = array();
	if ($findcanoe == 'true')
		{
		array_push($analyticsck,"C");
		array_push($ckstext,"Canoes/Va'as");
		}

	if ($findkayak == 'true')
		{
		array_push($analyticsck,"K");
		array_push($ckstext,"Kayaks");
		}

	//Create text for canoes or kayaks
	if (count($ckstext) < 2)
		{
		//Create sexes text
		$ckstext = " " . $ckstext[0] . " only.";
		}
	else
		$ckstext = "";

	//Find singles, doubles and fours to singles, doubles and fours array
	$find1s = getandprocessinput("find1s");
	$find2s = getandprocessinput("find2s");
	$find4s = getandprocessinput("find4s");

	//Array with text for boats selected for figure
	$boatstext = array();

	//Populate singles, doubles, fours array
	$analyticsboatsizes = array();
	if ($find1s == 'true')
		{
		array_push($analyticsboatsizes,"1");
		array_push($boatstext,"Singles");
		}

	if ($find2s == 'true')
		{
		array_push($analyticsboatsizes,"2");
		array_push($boatstext,"Doubles");
		}

	if ($find4s == 'true')
		{
		array_push($analyticsboatsizes,"4");
		array_push($boatstext,"Fours");
		}

	//Create text for distances
	if (count($boatstext) < 3)
		{
		//Last element of array
		$lastelement = array_pop($boatstext);

		//List separated by commas
		$boatstext = implode(", ",$boatstext);

		//Create distance text
		$boatstext = " " . $boatstext . " and " . $lastelement . " races only.";
		}
	else
		$boatstext = "";

	//Find singles, doubles and fours to singles, doubles and fours array
	$findjuniors = getandprocessinput("findjuniors");
	$findseniors = getandprocessinput("findseniors");
	$findveterans = getandprocessinput("findveterans");

	//Array with text for boats selected for figure
	$jsvstext = array();

	//Populate juniors, seniors, veterans array
	$analyticsjsv = array();
	if ($findjuniors == 'true')
		{
		array_push($analyticsjsv,"J");
		array_push($jsvstext,"Juniors");
		}

	if ($findseniors == 'true')
		{
		array_push($analyticsjsv,"S");
		array_push($jsvstext,"Seniors");
		}

	if ($findveterans == 'true')
		{
		array_push($analyticsjsv,"V");
		array_push($jsvstext,"Veterans");
		}

	//Create text for distances
	if (count($jsvstext) < 3)
		{
		//Last element of array
		$lastelement = array_pop($jsvstext);

		//List separated by commas
		$jsvstext = implode(", ",$jsvstext);

		//Create distance text
		$jsvstext = " " . $jsvstext . " and " . $lastelement . " races only.";
		}
	else
		$jsvstext = "";

	//Begin echoing results
	$pagehtml = $pagehtml . '<section>';

	if ((count($analyticsdistances) == 0) OR (count($analyticsmw) == 0) OR (count($analyticsck) == 0) OR (count($analyticsboatsizes) == 0) OR (count($analyticsjsv) == 0))
		{
		$pagehtml = $pagehtml . "<p>Sorry, you can't search for an absolute lack of anything, which is what you do if you deselect all types of a particular way of defining something!</p>";
		}
	else
		{
		include $engineslocation . 'analytics-engine.php';

		$pagehtml = $pagehtml . '<p class="blockheading">Analytics Results</p>';

		//Default text for legend
		$pagehtml = $pagehtml . '<p>Total number of seats racing in regattas from ' . $minyear . ' to ' . $maxyear . '.';

		//Text for if only certain paddlers were included
		$pagehtml = $pagehtml . $distancetext;
		$pagehtml = $pagehtml . $mwstext;
		$pagehtml = $pagehtml . $ckstext;
		$pagehtml = $pagehtml . $boatstext;
		$pagehtml = $pagehtml . $jsvstext;

		//End paragraph for figure legend
		$pagehtml = $pagehtml . '</p>';

		$pagehtml = $pagehtml . '<p>Raw data for this series</p>';

		//Data in an HTML table
		$pagehtml = $pagehtml . '<table class="scientific">';

		//Heading
		$pagehtml = $pagehtml . '<tr>';

		//Loop of table headings
		$keyskey = 0;
		$plotheadings = array_keys($analyticsresults[0]);
		$keyscount = count($plotheadings);
		while ($keyskey < $keyscount)
			{
			//Table headings
			$pagehtml = $pagehtml . '<th>' . $plotheadings[$keyskey] . '</th>';
			$keyskey++;
			}

		//Loop of data
		$datakey = 0;
		$datacount = count($analyticsresults);
		while ($datakey < $datacount)
			{
			//Turn line into table datas
			$line = $analyticsresults[$datakey];
			$line = implode("</td><td>",$line);
			$line = "<tr><td>" . $line . "</td></tr>";

			//Output line
			$pagehtml = $pagehtml . $line;

			$datakey++;
			}
		$pagehtml = $pagehtml . '</table>';

		$pagehtml = $pagehtml . '<p>Raw data for this series for copying into MS Excel</p>';

		//Data in an HTML table
		$pagehtml = $pagehtml . '<textarea style="width: 50%;" rows="10">';

		//Table headings
		$textareatableheadings = implode("\t",$plotheadings);
		$pagehtml = $pagehtml . $textareatableheadings;

		//Loop of data
		$datakey = 0;
		$datacount = count($analyticsresults);
		while ($datakey < $datacount)
			{
			//Turn line into table datas
			$line = $analyticsresults[$datakey];
			$line = implode("\t",$line);
			$line = "\r\n" . $line;

			//Output line
			$pagehtml = $pagehtml . $line;

			$datakey++;
			}

		$pagehtml = $pagehtml . '</textarea>';
		}

	include $engineslocation . 'analytics-chart.php';

	$pagehtml = $pagehtml . '<p>Series chart</p>';

	$pagehtml = $pagehtml . $canvas;

	$pagehtml = $pagehtml . '</section>';

	$pagehtml = $pagehtml . $js;
	}

$pagehtml = $pagehtml . '<section>';
$pagehtml = $pagehtml . '<p class="blockheading">Data Search</p>';
$pagehtml = $pagehtml . '<p>Search the regatta results for the number of paddlers of a particular type, or in a particular type of race</p>';
$pagehtml = $pagehtml . '<form action="RegattaAnalytics';

if ($club != "")
	$pagehtml = $pagehtml . "?club=" . $club;

$pagehtml = $pagehtml . '" method="post">';
$pagehtml = $pagehtml . '<input type="hidden" name="lookup" value="regattas">';
$pagehtml = $pagehtml . '<p>Years: <input type="number" name="minyear" min="' . $minyear . '" max="' . $maxyear . '" value="' . $minyear . '" size="4" style="width: 60px;"> - <input type="number" name="maxyear" min="' . $minyear . '" max="' . $maxyear . '" value="' . $maxyear . '" size="4" style="width: 60px;"></p>';
$pagehtml = $pagehtml . '<p><input type="submit" name="submit" value="Find"> <input type="reset" name="reset" value="Reset"></p>';

$includeboxwidth = 5;
$rownamewidth = 10;
$includeswidth = 18;

$pagehtml = $pagehtml . '<div style="margins: auto; display: flex; overflow: hidden;">';
$pagehtml = $pagehtml . '<div style="float: left; width: ' . $includeboxwidth . '%;"><p>Display</p></div>';
$pagehtml = $pagehtml . '<div style="float: left; width: ' . $rownamewidth . '%;"></div>';
$pagehtml = $pagehtml . '<div style="float: left; width: ' . $includeswidth . '%;"><p>Include</p></div>';
$pagehtml = $pagehtml . '</div>';

$pagehtml = $pagehtml . '<div style="margins: auto; display: flex; overflow: hidden;">';
$pagehtml = $pagehtml . '<div style="float: left; width: ' . $includeboxwidth . '%;"><p><input type="radio" name="displayas" value="All" checked></p></div>';
$pagehtml = $pagehtml . '<div style="float: left; width: ' . $rownamewidth . '%;"><p>Combined</p></div>';
$pagehtml = $pagehtml . '</div>';

$pagehtml = $pagehtml . '<div style="margins: auto; display: flex; overflow: hidden;">';
$pagehtml = $pagehtml . '<div style="float: left; width: ' . $includeboxwidth . '%;"><p><input type="radio" name="displayas" value="Distance"></p></div>';
$pagehtml = $pagehtml . '<div style="float: left; width: ' . $rownamewidth . '%;"><p>Distance</p></div>';
$pagehtml = $pagehtml . '<div style="float: left; width: ' . $includeswidth . '%;"><p>200m: <input type="checkbox" name="find200" value="true" checked></p></div>';
$pagehtml = $pagehtml . '<div style="float: left; width: ' . $includeswidth . '%;"><p>500m: <input type="checkbox" name="find500" value="true" checked></p></div>';
$pagehtml = $pagehtml . '<div style="float: left; width: ' . $includeswidth . '%;"><p>1000m: <input type="checkbox" name="find1000" value="true" checked></p></div>';
$pagehtml = $pagehtml . '<div style="float: left; width: ' . $includeswidth . '%;"><p>Long Distance: <input type="checkbox" name="findld" value="true" checked></p></div>';
$pagehtml = $pagehtml . '</div>';

$pagehtml = $pagehtml . '<div style="margins: auto; display: flex; overflow: hidden;">';
$pagehtml = $pagehtml . '<div style="float: left; width: ' . $includeboxwidth . '%;"><p><input type="radio" name="displayas" value="MW"></p></div>';
$pagehtml = $pagehtml . '<div style="float: left; width: ' . $rownamewidth . '%;"><p>Men/Women</p></div>';
$pagehtml = $pagehtml . '<div style="float: left; width: ' . $includeswidth . '%;"><p>Men: <input type="checkbox" name="findmen" value="true" checked></p></div>';
$pagehtml = $pagehtml . '<div style="float: left; width: ' . $includeswidth . '%;"><p>Women: <input type="checkbox" name="findwomen" value="true" checked></p></div>';
$pagehtml = $pagehtml . '</div>';

$pagehtml = $pagehtml . '<div style="margins: auto; display: flex; overflow: hidden;">';
$pagehtml = $pagehtml . '<div style="float: left; width: ' . $includeboxwidth . '%;"><p><input type="radio" name="displayas" value="CK"></p></div>';
$pagehtml = $pagehtml . '<div style="float: left; width: ' . $rownamewidth . '%;"><p>Canoe/Kayak</p></div>';
$pagehtml = $pagehtml . '<div style="float: left; width: ' . $includeswidth . '%;"><p>Canoe: <input type="checkbox" name="findcanoe" value="true" checked></p></div>';
$pagehtml = $pagehtml . '<div style="float: left; width: ' . $includeswidth . '%;"><p>Kayak: <input type="checkbox" name="findkayak" value="true" checked></p></div>';
$pagehtml = $pagehtml . '</div>';

$pagehtml = $pagehtml . '<div style="margins: auto; display: flex; overflow: hidden;">';
$pagehtml = $pagehtml . '<div style="float: left; width: ' . $includeboxwidth . '%;"><p><input type="radio" name="displayas" value="BoatSize"></p></div>';
$pagehtml = $pagehtml . '<div style="float: left; width: ' . $rownamewidth . '%;"><p>Boat Size</p></div>';
$pagehtml = $pagehtml . '<div style="float: left; width: ' . $includeswidth . '%;"><p>Singles: <input type="checkbox" name="find1s" value="true" checked></p></div>';
$pagehtml = $pagehtml . '<div style="float: left; width: ' . $includeswidth . '%;"><p>Doubles: <input type="checkbox" name="find2s" value="true" checked></p></div>';
$pagehtml = $pagehtml . '<div style="float: left; width: ' . $includeswidth . '%;"><p>Fours: <input type="checkbox" name="find4s" value="true" checked></p></div>';
$pagehtml = $pagehtml . '</div>';

$pagehtml = $pagehtml . '<div style="margins: auto; display: flex; overflow: hidden;">';
$pagehtml = $pagehtml . '<div style="float: left; width: ' . $includeboxwidth . '%;"><p><input type="radio" name="displayas" value="JSV"></p></div>';
$pagehtml = $pagehtml . '<div style="float: left; width: ' . $rownamewidth . '%;"><p>Age</p></div>';
$pagehtml = $pagehtml . '<div style="float: left; width: ' . $includeswidth . '%;"><p>Juniors: <input type="checkbox" name="findjuniors" value="true" checked></p></div>';
$pagehtml = $pagehtml . '<div style="float: left; width: ' . $includeswidth . '%;"><p>Seniors: <input type="checkbox" name="findseniors" value="true" checked></p></div>';
$pagehtml = $pagehtml . '<div style="float: left; width: ' . $includeswidth . '%;"><p>Veterans: <input type="checkbox" name="findveterans" value="true" checked></p></div>';
$pagehtml = $pagehtml . '</div>';
$pagehtml = $pagehtml . '</form>';

$pagehtml = $pagehtml . '<p>Display chooses how you would like to display the results of the search. Default is combined, which displays a total for all paddlers in all races (bums on seats/knees on blocks) for each year in the range. Selecting the other categories will allow you to display separate totals for each distance, age classification, type of boat or gender.</p>';

$pagehtml = $pagehtml . '<p>You can select or deselect types of paddler or types of race using the include boxes. E.g. if you would only like to display the number of canoes who raced each year then you should deselect kayaks.</p>';
$pagehtml = $pagehtml . '</section>';
?>
