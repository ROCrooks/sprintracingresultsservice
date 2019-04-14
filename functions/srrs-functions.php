<?php
//---FunctionBreak---
/**/
//---DocumentationBreak---
function sanitisesrrsinputs($jsv,$mw,$ck,$abil,$spec,$club,$paddler,$padmw,$padck,$regatta)
	{
	//Legal characters
	$legaljsv = str_split("JSV");
	$legalmw = str_split("MW");
	$legalck = str_split("CKV");
	$legalabil = str_split("ABCDOLT123");
	$legalspec = str_split("UO12345678ISLTPCDSP");
	$legalcharacters = str_split("ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890");
	//$legalpaddler = str_split("ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890");
	$legalnumbers = str_split("1234567890");

	//Filter out non-legal characters from variables
	$jsv = legalcharactersonly($jsv,$legaljsv);
	$mw = legalcharactersonly($mw,$legalmw);
	$ck = legalcharactersonly($ck,$legalck);
	$abil = legalcharactersonly($abil,$legalabil);
	$spec = legalcharactersonly($spec,$legalspec);
	$club = legalcharactersonly($club,$legalcharacters);
	//$paddler = legalcharactersonly($paddler,$legalcharacters);
	$padmw = legalcharactersonly($padmw,$legalmw);
	$padck = legalcharactersonly($padck,$legalck);
	$regatta = legalcharactersonly($regatta,$legalnumbers);

	//Output sanitized inputs
	$output = array("jsv"=>$jsv,"mw"=>$mw,"ck"=>$ck,"abil"=>$abil,"spec"=>$spec,"club"=>$club,"paddler"=>$paddler,"padmw"=>$padmw,"padck"=>$padck,"regatta"=>$regatta);
	Return $output;
	}
//---FunctionBreak---
/**/
//---DocumentationBreak---
function getkeysasquery($findfield,$returnfield,$table,$searchsql,$dblink)
	{
	$keys = array();
	$sql = "SELECT DISTINCT `" . $findfield . "` FROM `" . $table . "`" . $searchsql;
	$query = mysqli_query($dblink,$sql);
	while ($result = mysqli_fetch_array($query))
		{
		$key = $result[$findfield];
		array_push($keys,$key);
		}
	$constraint = array();
	$group = false;
	$key = 0;
	$count = count($keys);
	while ($key != $count)
		{
		$prekey = $key-1;
		$postkey = $key+1;
		//Keys for previous and next element

		$currentvalue = $keys[$key];
		//Get current array value

		if ($prekey == -1)
			$lookupprevalue = "Start";
		else
			$lookupprevalue = $keys[$prekey];
		//Get lookup prevalue

		if ($postkey >= $count)
			$lookuppostvalue = "End";
		else
			$lookuppostvalue = $keys[$postkey];
		//Get lookup postvalue

		$expectedprevalue = $currentvalue-1;
		$expectedpostvalue = $currentvalue+1;
		//Expected pre- and post- values

		if ((($lookupprevalue != $expectedprevalue) OR ($lookupprevalue == "Start")) AND (($lookuppostvalue != $expectedpostvalue) OR ($lookuppostvalue == "End")))
			{
			$subconstraint = "`" . $returnfield . "` = " . $currentvalue;
			array_push($constraint,$subconstraint);
			}
			//Find isolated value
		elseif ((($lookupprevalue != $expectedprevalue) OR ($lookupprevalue == "Start")) AND ($lookuppostvalue == $expectedpostvalue))
			$subconstraint = "(`" . $returnfield . "` >= " . $currentvalue;
			//Find begining of sequence
		elseif (($lookupprevalue == $expectedprevalue) AND (($lookuppostvalue != $expectedpostvalue) OR ($lookuppostvalue == "End")))
			{
			$subconstraint = $subconstraint . " AND `" . $returnfield . "` <= " . $currentvalue . ")";
			array_push($constraint,$subconstraint);
			}
			//Find end of sequence
		$key++;
		}
	$constraint = implode($constraint," OR ");
	$constraint = "(" . $constraint . ")";
	Return $constraint;
	}
//---FunctionBreak---
/**/
//---DocumentationBreak---
function arrayoffields($input,$fieldname)
	{
	$stop = count($input);
	$key = 0;
	$output = array();
	//Make loop parameters
	while ($key < $stop)
		{
		$line = $input[$key];
		$field = $line[$fieldname];
		$output[$key] = $field;
		$key++;
		}
	//Retrieve race keys
	Return $output;
	}
//---FunctionBreak---
/**/
//---DocumentationBreak---
function preferedname($jsv,$mw)
	{
	if ($jsv == "J")
		{
		if ($mw == "M")
			$salute = "Boys";
		elseif ($mw == "W")
			$salute = "Girls";
		}
	//Junior Names
	elseif ($jsv == "S")
		{
		if ($mw == "M")
			$salute = "Mens";
		elseif ($mw == "W")
			$salute = "Womens";
		}
	//Senior Names
	elseif ($jsv == "V")
		{
		if ($mw == "M")
			$salute = "Masters";
		elseif ($mw == "W")
			$salute = "Ladies";
		}
	//Veteran Names
	Return $salute;
	}
//---FunctionBreak---
/**/
//---DocumentationBreak---
function simpleclass($jsv,$mw,$ck,$size)
	{
	if ($jsv == "J")
		$jsv = "Junior ";
	elseif ($jsv == "J")
		$jsv = "Senior ";
	elseif ($jsv == "V")
		$jsv = "Veteran ";
	if ($mw == "M")
		$mw = "Men's ";
	elseif ($mw == "W")
		$mw = "Women's ";
	if ($ck == "C")
		$ck = "C";
	elseif ($ck == "K")
		$ck = "K";
	elseif ($ck == "V")
		$ck = "V";
	$output = $jsv . $mw . $ck . $size;
	Return $output;
	}
//---FunctionBreak---
/**/
//---DocumentationBreak---
function displaytimetosecs($time)
	{
	str_replace(":",":",$time,$divs);
	if ($divs > 0)
		{
		$time = explode(":",$time);

		$secs = array_pop($time);
		$mins = array_pop($time);
		if (count($time) == 1)
			$hours = array_pop($time);
		else
			$hours = 0;

		$hours = $hours*60*60;
		$mins = $mins*60;
		$time =	$hours+$mins+$secs;
		//Convert time to seconds
		}
	Return $time;
	}
//---FunctionBreak---
/**/
//---DocumentationBreak---
function classname($detailsarray,$mixedboat,$mixedspecial)
	{
	$jsv = $detailsarray['JSV'];
	$mw = $detailsarray['MW'];
	$ck = $detailsarray['CK'];
	$abil = $detailsarray['Abil'];
	$spec = $detailsarray['Spec'];
	//Get class name fields

	if (($jsv == "J") AND ($mw == "M"))
		$agesex = "Boys";
	elseif (($jsv == "J") AND ($mw == "W"))
		$agesex = "Girls";
	elseif (($jsv == "J") AND ($mw == "") AND ($spec == ""))
		$agesex = "Junior";
	elseif (($jsv == "S") AND ($mw == "") AND ($spec == ""))
		$agesex = "Senior";
	elseif ((($jsv == "S") OR ($jsv == "")) AND ($mw == "M"))
		{
		if (($spec == "IS") OR ($spec == "PC"))
			$agesex = "Men";
		//Improve format for Inter-services of Paracanoe
		else
			$agesex = "Mens";
		}
	elseif ((($jsv == "S") OR ($jsv == "")) AND ($mw == "W"))
		{
		if (($spec == "IS") OR ($spec == "PC"))
			$agesex = "Women";
		//Improve format for Inter-services of Paracanoe
		else
			$agesex = "Womens";
		}
	elseif (($jsv == "V") AND ($mw == "M"))
		$agesex = "Masters";
	elseif (($jsv == "V") AND ($mw == "W"))
		$agesex = "Womens Masters";
	elseif (($ck == "C") AND ($jsv == "") AND ($mw == ""))
		$agesex = "Canoe";
	else
		$agesex = "";

	$classname = $agesex;
	//Make Paddler Type

	if (($abil == "A") OR ($abil == "B") OR ($abil == "C") OR ($abil == "D") OR ($abil == "AB") OR ($abil == "BC") OR ($abil == "CD") OR ($abil == "ABC") OR ($abil == "BCD") OR ($abil == "ABCD"))
		{
		$abil = str_split($abil);
		$abil = implode("/",$abil);
		}
	//Make ability (split if neccesary
	if ($abil == "O")
		{
		$abil = "Open";
		if ($jsv == "S")
			$classname = "Senior " . $classname;
		}
	//Convert open tag to "open" phrase

	if ($mixedspecial == 1)
		{
		if ($spec == "PC")
			$classname = "Paracanoe " . $classname;
		if ($spec == "PD")
			$classname = "Paddleability " . $classname;
		if ($spec == "IS")
			$classname = "Inter-Services " . $classname;
		if ($spec == "LT")
			$classname = "Mini-Kayak " . $classname;
		}

	if ($abil != "")
		$classname = $classname . " " . $abil;
	//Add ability

	$ages = array("U","O");
	$newages = array("Under ","Over ");

	$spec = str_replace($ages,$newages,$spec,$agerace);

	if ($agerace > 0)
		$classname = $classname . " " . $spec;
	//Make an age group race

	if ($mixedboat != "0")
		{
		if ($mixedboat == "N")
			{
			if ($ck == "K")
				$boat = " Kayak";
			elseif ($ck == "C")
				$boat = " Canoe";
			elseif ($ck == "V")
				$boat = " Va'a";
			else
				$boat = "";
			}
		//Add boat as name
		elseif ($spec != "PC")
			$boat = " " . $ck . $mixedboat;
		else
			$boat = "";
		//Add type of exact boat if known
		$classname = $classname . $boat;
		}
	//Add type of boat if not universal

	//Remove repeats in class names
	$duplicates = array("Kayak Kayak","Canoe Canoe","Va'a Va'a","  ");
	$singles = array("Kayak","Canoe","Va'a"," ");
	$classname = str_replace($duplicates,$singles,$classname,$times);
	while ($times > 0)
		{
		$classname = str_replace($duplicates,$singles,$classname,$times);
		}

	Return $classname;
	}
//---FunctionBreak---
/**/
//---DocumentationBreak---
function racename($raceid,$dblink)
	{
	//echo $raceid . "<br>";

	//$sql = "SELECT `racename` FROM `specialraces` WHERE `Race` = $raceid ";
	//$query = mysqli_query($dblink,$sql);
	//$result = mysqli_fetch_array($query);
	//$racename = $result['racename'];
	$racename = "";

	if ($racename == '')
		{
		if (is_numeric($raceid) == true)
			{
			//Prepare racedetailsget query
			$racedetailsgetquery = "SELECT `Boat`, `Dist`, `R`, `D` FROM `races` WHERE `Key` = ?";
			$racedetailsgetstmt = mysqli_prepare($dblink,$racedetailsgetquery)
				or die("MySQLi Error in preparing query to retrieve racedetailsget data: " . $dblink->error);

			//Execute racedetailsget query
			mysqli_stmt_bind_param($racedetailsgetstmt,"i",$raceid);
			mysqli_stmt_execute($racedetailsgetstmt)
				or die("MySQLi Error in executing query to retrieve racedetailsget data: " . $racedetailsgetstmt->error);

			//Get results of racedetailsget query
			$racedetailsgetresult = mysqli_stmt_get_result($racedetailsgetstmt);
			$racedetailsgetrow = mysqli_fetch_array($racedetailsgetresult);
			$boat = $racedetailsgetrow['Boat'];
			$dist = $racedetailsgetrow['Dist'];
			$round = $racedetailsgetrow['R'];
			$draw = $racedetailsgetrow['D'];

			//Format race distance
			if ($dist > 1000)
				{
				$dist = $dist/1000;
				$dist = $dist . "km";
				}
			else
				$dist = $dist . "m";

			//Format Round Name
			if (($round == "F") OR ($round == 4))
				$round = "Final";
			elseif (($round == "H") OR ($round == 1))
				$round = "Heat";
			elseif (($round == "SF") OR ($round == 3))
				$round = "Semi-Final";
			elseif (($round == "QF") OR ($round == 2))
				$round = "Quarter-Final";

			$racename = $dist . " " . $round;
			if ($draw <> 0)
				$racename = $racename . " " . $draw;

			$getclassdetailsquery = "SELECT `JSV`, `MW`, `CK`, `Abil`, `Spec` FROM `classes` WHERE `Race` = ?";
			//Prepare getclassdetails query
			$getclassdetailsstmt = mysqli_prepare($dblink,$getclassdetailsquery)
				or die("MySQLi Error in preparing query to retrieve getclassdetails data: " . $dblink->error);

			//Execute getclassdetails query
			mysqli_stmt_bind_param($getclassdetailsstmt,"i",$raceid);
			mysqli_stmt_execute($getclassdetailsstmt)
				or die("MySQLi Error in executing query to retrieve getclassdetails data: " . $getclassdetailsstmt->error);

			$mixedboat = $boat;
			//Specify name as mixed boat
			}
		else
			{
			$boat = "";
			$dist = "";
			$round = "";
			$draw = "";

			$getclassdetailsquery = "SELECT `JSV`, `MW`, `CK`, `Abil`, `Spec` FROM `autoclasses` WHERE `RaceName` = ?";
			//Prepare getclassdetails query
			$getclassdetailsstmt = mysqli_prepare($dblink,$getclassdetailsquery)
				or die("MySQLi Error in preparing query to retrieve getclassdetails data: " . $dblink->error);

			//Execute getclassdetails query
			mysqli_stmt_bind_param($getclassdetailsstmt,"s",$raceid);
			mysqli_stmt_execute($getclassdetailsstmt)
				or die("MySQLi Error in executing query to retrieve getclassdetails data: " . $getclassdetailsstmt->error);

			$mixedboat = "N";
			//Specify name as mixed boat
			}
		//Discriminate between class and autoclass table

		//An array of classes found
		$foundclasses = array();

		//Get results of getclassdetails query
		$getclassdetailsresult = mysqli_stmt_get_result($getclassdetailsstmt);
		while($getclassdetailsrow = mysqli_fetch_array($getclassdetailsresult))
			{
			array_push($foundclasses,$getclassdetailsrow);
			}
		//Retrieve classes from DB

		$count = count($foundclasses);
		//End of array

		$key = 0;
		//Array start

		$getboat = array();
		$getspec = array();
		//Make array for boat and specific

		while ($key < $count)
			{
			$class = $foundclasses[$key];
			array_push($getboat,$class['CK']);
			array_push($getspec,$class['Spec']);
			$key++;
			}
		//Get special classes and boat type

		$getboat = implode("-",$getboat);
		$getspec = implode("-",$getspec);
		//Make array for boat and special

		str_replace("C","C",$getboat,$canoefound);
		str_replace("K","K",$getboat,$kayakfound);
		str_replace("V","V",$getboat,$vaafound);
		//Find canoes, kayaks and vaas

		if (($canoefound > 0) AND ($kayakfound == 0) AND ($vaafound == 0))
			{
			if ($mixedboat != "N")
				$globalboat = " C" . $mixedboat;
			else
				$globalboat = " Canoe";
			//Specify global canoe race
			$mixedboat = 0;
			}
		elseif (($canoefound == 0) AND ($kayakfound > 0) AND ($vaafound == 0))
			{
			if ($mixedboat != "N")
				$globalboat = " K" . $mixedboat;
			else
				$globalboat = " Kayak";
			//Specify global kayak race
			$mixedboat = 0;
			}
		elseif (($canoefound == 0) AND ($kayakfound == 0) AND ($vaafound > 0))
			{
			if ($mixedboat != "N")
				$globalboat = " V" . $mixedboat;
			else
				$globalboat = " Va'a";
			//Specify global Va'a race
			$mixedboat = 0;
			}
		else
			$globalboat = "";
		//Blank global boat if mixed is true

		$key = 0;
		//Reset array counter to 0

		//echo $mixedboat . "<br>";

		str_replace("LT","LT",$getspec,$ltfound);
		str_replace("PD","PD",$getspec,$pdfound);
		str_replace("PC","PC",$getspec,$pcfound);
		str_replace("IS","IS",$getspec,$isfound);
		//Find special classes

		if (($ltfound == 0) AND ($pdfound == 0) AND ($pcfound == 0) AND ($isfound == 0))
			{
			$specialclass = "";
			$mixedspecial = 0;
			}
		elseif (($ltfound > 0) AND ($pdfound == 0) AND ($pcfound == 0) AND ($isfound == 0))
			{
			$specialclass = "Mini-Kayak ";
			$mixedspecial = 0;
			}
		elseif (($ltfound == 0) AND ($pdfound > 0) AND ($pcfound == 0) AND ($isfound == 0))
			{
			$specialclass = "Paddleability ";
			$mixedspecial = 0;
			}
		elseif (($ltfound == 0) AND ($pdfound == 0) AND ($pcfound > 0) AND ($isfound == 0))
			{
			$specialclass = "Paracanoe ";
			$mixedspecial = 0;
			}
		elseif (($ltfound == 0) AND ($pdfound == 0) AND ($pcfound == 0) AND ($isfound > 0))
			{
			$specialclass = "Inter-Services ";
			$mixedspecial = 0;
			}
		else
			{
			$specialclass = "";
			$mixedspecial = 1;
			}
		//Put flag for special race class

		//echo $specialclass . "<br>";
		//echo $globalboat . "<br>";

		$classeslist = array();
		//Make classes list array

		while ($key < $count)
			{
			$class = $foundclasses[$key];
			$classname = classname($class,$mixedboat,$mixedspecial);
			array_push($classeslist,$classname);
			//echo $classname . "<br>";
			$key++;
			}
		//Make race classes

		$classeslist = implode(" + ",$classeslist);
		$racename = $specialclass . $classeslist . $globalboat;
		if ($dist != "")
			$racename = $racename . " " . $dist;
			//Add distance
		if ($round != "")
			{
			$racename = $racename . " " . $round;
			//Add round
			if (($draw != "") AND ($draw != 0))
				$racename = $racename . " " . $draw;
				//Add draw
			}
		}
	Return $racename;
	}
//---FunctionBreak---
/**/
//---DocumentationBreak---
function regattadate($we,$month,$year)
	{
	$monthsnumbers = array(1=>"January",
	2=>"February",
	3=>"March",
	4=>"April",
	5=>"May",
	6=>"June",
	7=>"July",
	8=>"August",
	9=>"September",
	10=>"Octember",
	11=>"November",
	12=>"December");
	//Month Names

	$numbers = array("0 ",
	"1 ",
	"2 ",
	"3 ",
	"4 ",
	"5 ",
	"6 ",
	"7 ",
	"8 ",
	"9 ");

	$words = array("0th&nbsp;",
	"1<sup>st</sup> ",
	"2<sup>nd</sup> ",
	"3<sup>rd</sup> ",
	"4<sup>th</sup> ",
	"5<sup>th</sup> ",
	"6<sup>th</sup> ",
	"7<sup>th</sup> ",
	"8<sup>th</sup> ",
	"9<sup>th</sup> ");

	$less10find = array("01",
	"02",
	"03",
	"04",
	"05",
	"06",
	"07",
	"08",
	"09");

	$less10replace = array("1",
	"2",
	"3",
	"4",
	"5",
	"6",
	"7",
	"8",
	"9");

	$errorwords = array("11<sup>st</sup>",
	"12<sup>nd</sup>",
	"13<sup>rd</sup>");

	$correctwords = array("11<sup>th</sup>",
	"12<sup>th</sup>",
	"13<sup>th</sup>");

	$we = str_replace($less10find,$less10replace,$we);
	$we = str_replace("-"," and ",$we);

	$month = $monthsnumbers[$month];
	//Make month as word

	$longdate = $we . " " . $month;
	$longdate = str_replace($numbers,$words,$longdate);
	$longdate = str_replace($errorwords,$correctwords,$longdate);
	$longdate = $longdate . " " . $year;
	//Construct Date

	$longdate = str_replace(" ","&nbsp;",$longdate);

	$shortdate = $month . " " . $year;

	$date = array("LongDate"=>$longdate,"ShortDate"=>$shortdate);

	Return $date;
	}
//---FunctionBreak---
/**/
//---DocumentationBreak---
function clubconstraint($club)
	{
	if ($club != '')
		{
		$clublist = str_getcsv($club,",",'','');
		$stop = count($clublist);
		if ($stop == 1)
			{
			$clubconstraint = " AND `Club` LIKE '%" . $club . "%'";
			}
		else
			{
			$key = 0;
			while ($key < $stop)
				{
				$clublist[$key] = "`Club` LIKE '%" . $clublist[$key] . "%'";
				$key++;
				}
			$clubconstraint = implode($clublist," OR ");
			$clubconstraint = " AND (" . $clubconstraint . ")";
			}
		}
	else
		$clubconstraint = "";
	Return $clubconstraint;
	}
//---FunctionBreak---
/**/
//---DocumentationBreak---
function countpaddlersyearrace($dblink,$query)
	{
	//Prepare analyticsfindraces query
	$analyticsfindracesstmt = mysqli_prepare($dblink,$query)
		or die("MySQLi Error in preparing query to retrieve analyticsfindraces data: " . $dblink->error);

	//Execute analyticsfindraces query
	mysqli_stmt_execute($analyticsfindracesstmt)
		or die("MySQLi Error in executing query to retrieve analyticsfindraces data: " . $analyticsfindracesstmt->error);

	$racekeys = array();

	//Get results of analyticsfindraces query
	$analyticsfindracesresult = mysqli_stmt_get_result($analyticsfindracesstmt);
	while($analyticsfindracesrow = mysqli_fetch_array($analyticsfindracesresult))
		{
		array_push($racekeys,$analyticsfindracesrow['Key']);
		}

	$raceconstraint = turnintegerarraytoconstraint($racekeys,"Race");
	Return $raceconstraint;
	}
//---FunctionBreak---
/**/
//---DocumentationBreak---
function countpaddlersyearpaddlers($dblink,$query,$club)
	{
	//Make club a wildcard
	$club = "%" . $club . "%";

	str_replace("()","()",$query,$blankconstraint);

	if ($blankconstraint == 1)
		{
		$numberpaddlers = 0;
		}
	else
		{
		//Prepare analyticsfindpaddlers query
		$analyticsfindpaddlersstmt = mysqli_prepare($dblink,$query)
			or die("MySQLi Error in preparing query to retrieve analyticsfindpaddlers data: " . $dblink->error);

		//Execute analyticsfindpaddlers query
		mysqli_stmt_bind_param($analyticsfindpaddlersstmt,"s",$club);
		mysqli_stmt_execute($analyticsfindpaddlersstmt)
			or die("MySQLi Error in executing query to retrieve analyticsfindpaddlers data: " . $analyticsfindpaddlersstmt->error);

		//Get results of classlookup query
		mysqli_stmt_store_result($analyticsfindpaddlersstmt);
		$numberpaddlers = mysqli_stmt_num_rows($analyticsfindpaddlersstmt);
		}

	Return $numberpaddlers;
	}
//---FunctionBreak---
/**/
//---DocumentationBreak---
function countpaddlersyear($dblink,$year,$distances,$boats,$jsvs,$mws,$cks,$club)
	{
	//Prepare yearsql query
	$yearsqlquery = "SELECT `Key` FROM `regattas` WHERE `Year` = ?";
	$constraints = array();
	$constraints[0] = array("Data"=>$year,"Type"=>"i");
	$regattakeys = dbprepareandexecute($dblink,$yearsqlquery,$constraints,"Flat");

	/*
	$yearsqlstmt = mysqli_prepare($dblink,$yearsqlquery)
		or die("MySQLi Error in preparing query to retrieve yearsql data: " . $dblink->error);

	//Execute yearsql query
	mysqli_stmt_bind_param($yearsqlstmt,"i",$year);
	mysqli_stmt_execute($yearsqlstmt)
		or die("MySQLi Error in executing query to retrieve yearsql data: " . $yearsqlstmt->error);

	//Make array of regatta keys
	$regattakeys = array();

	//Get results of yearsql query
	$yearsqlresult = mysqli_stmt_get_result($yearsqlstmt);
	while($yearsqlrow = mysqli_fetch_array($yearsqlresult))
		{
		array_push($regattakeys,$yearsqlrow['Key']);
		}
	*/

	//Regatta constraints
	$regattaconstraints = turnintegerarraytoconstraint($regattakeys,"Regatta");

	//Constraints for distances
	$distancesconstraints = array();

	//Only add distance if specified in distances array
	if (in_array("200",$distances) == true)
		{
		$constraint = "`Dist` = '200'";
		array_push($distancesconstraints,$constraint);
		}

	if (in_array("500",$distances) == true)
		{
		$constraint = "`Dist` = '500'";
		array_push($distancesconstraints,$constraint);
		}

	if (in_array("1000",$distances) == true)
		{
		$constraint = "`Dist` = '1000'";
		array_push($distancesconstraints,$constraint);
		}

	if (in_array("LD",$distances) == true)
		{
		$constraint = "`Dist` = '2500'";
		array_push($distancesconstraints,$constraint);
		$constraint = "`Dist` = '3000'";
		array_push($distancesconstraints,$constraint);
		$constraint = "`Dist` = '5000'";
		array_push($distancesconstraints,$constraint);
		$constraint = "`Dist` = '6000'";
		array_push($distancesconstraints,$constraint);
		$constraint = "`Dist` = '10000'";
		array_push($distancesconstraints,$constraint);
		}

	//Make distance constraint string
	$distancesconstraints = implode(" OR ",$distancesconstraints);
	$distancesconstraints = "(" . $distancesconstraints . ")";

	//Make base race key query for constraining paddler queries later
	$baseracekeysquery = "SELECT * FROM `races` WHERE " . $regattaconstraints . " AND " . $distancesconstraints;

	//Constraints for junior, senior or veteran
	$jsvconstraints = array();

	//Only add JSV if specified in JSV array
	if (in_array("J",$jsvs) == true)
		{
		$constraint = "`JSV` = 'J'";
		array_push($jsvconstraints,$constraint);
		}

	if (in_array("S",$jsvs) == true)
		{
		$constraint = "`JSV` = 'S'";
		array_push($jsvconstraints,$constraint);
		}

	if (in_array("V",$jsvs) == true)
		{
		$constraint = "`JSV` = 'V'";
		array_push($jsvconstraints,$constraint);
		}

	//Make JSV constraint string
	$jsvconstraints = implode(" OR ",$jsvconstraints);
	$jsvconstraints = "(" . $jsvconstraints . ")";

	//Constraints for canoe or kayak
	$mwconstraints = array();

	//Only add MW if specified in MW array
	if (in_array("M",$mws) == true)
		{
		$constraint = "`MW` = 'M'";
		array_push($mwconstraints,$constraint);
		}

	if (in_array("W",$mws) == true)
		{
		$constraint = "`MW` = 'W'";
		array_push($mwconstraints,$constraint);
		}

	//Make CK constraint string
	$mwconstraints = implode(" OR ",$mwconstraints);
	$mwconstraints = "(" . $mwconstraints . ")";

	//Constraints for canoe or kayak
	$ckconstraints = array();

	//Only add CK if specified in distances array
	if (in_array("K",$cks) == true)
		{
		$constraint = "`CK` = 'K'";
		array_push($ckconstraints,$constraint);
		}

	if (in_array("C",$cks) == true)
		{
		$constraint = "`CK` = 'C'";
		array_push($ckconstraints,$constraint);
		$constraint = "`CK` = 'V'";
		array_push($ckconstraints,$constraint);
		}

	//Make CK constraint string
	$ckconstraints = implode(" OR ",$ckconstraints);
	$ckconstraints = "(" . $ckconstraints . ")";

	//Variable to store total number of paddlers
	$totalpaddlers = 0;

	if (in_array("1",$boats) == true)
		{
		//Make race query for 1 person boats
		$racekeysquery = $baseracekeysquery . " AND `Boat` = 1";

		//Get race constraints for only paddlers in the specified year/distance/boat type
		$raceconstraint = countpaddlersyearrace($dblink,$racekeysquery);

		//Build Query
		$paddlerquery = "SELECT * FROM `paddlers` WHERE " . $raceconstraint . " AND " . $jsvconstraints . " AND " . $mwconstraints . " AND " . $ckconstraints . " AND `Club` LIKE ?";

		//Get number of singles paddlers
		$numberofpaddlers = countpaddlersyearpaddlers($dblink,$paddlerquery,$club);
		$totalpaddlers = $totalpaddlers+$numberofpaddlers;
		}

	if (in_array("2",$boats) == true)
		{
		//Make race query for 2 person boats
		$racekeysquery = $baseracekeysquery . " AND `Boat` = 2";

		//Get race constraints for only paddlers in the specified year/distance/boat type
		$raceconstraint = countpaddlersyearrace($dblink,$racekeysquery);

		//Build Query
		$paddlerquery = "SELECT * FROM `paddlers` WHERE " . $raceconstraint . " AND " . $jsvconstraints . " AND " . $mwconstraints . " AND " . $ckconstraints . " AND `Club` LIKE ?";

		//Get number of doubles paddlers
		$numberofpaddlers = countpaddlersyearpaddlers($dblink,$paddlerquery,$club);
		$numberofpaddlers = $numberofpaddlers*2;
		$totalpaddlers = $totalpaddlers+$numberofpaddlers;
		}

	if (in_array("4",$boats) == true)
		{
		//Make race query for 4 person boats
		$racekeysquery = $baseracekeysquery . " AND `Boat` = 4";

		//Get race constraints for only paddlers in the specified year/distance/boat type
		$raceconstraint = countpaddlersyearrace($dblink,$racekeysquery);

		//Build Query
		$paddlerquery = "SELECT * FROM `paddlers` WHERE " . $raceconstraint . " AND " . $jsvconstraints . " AND " . $mwconstraints . " AND " . $ckconstraints . " AND `Club` LIKE ?";

		//Get number of doubles paddlers
		$numberofpaddlers = countpaddlersyearpaddlers($dblink,$paddlerquery,$club);
		$numberofpaddlers = $numberofpaddlers*4;
		$totalpaddlers = $totalpaddlers+$numberofpaddlers;
		}

	Return $totalpaddlers;
	}
//---FunctionBreak---
/**/
//---DocumentationBreak---
function displaytime($time)
	{
	if (is_numeric($time) == true)
		{
		//Get the number of minutes, floor in order to make whole minutes
		$mins = $time/60;
		$mins = floor($mins);

		//Remove whole minutes
		$removedtime = $mins*60;
		$secmilsecs = $time-$removedtime;
		$secmilsecs = number_format($secmilsecs,2);

		//Find number of minutes
		if ($mins > 60)
			{
			$hours = $mins/60;
			$hours = floor($hours);
			$removedmins = $hours*60;
			$mins = $mins-$removedmins;
			if ($mins < 10)
				$mins = "0" . $mins;
			//Convert to :0n format
			$secmilsecs = round($secmilsecs);
			if ($secmilsecs < 10)
				$secmilsecs = "0" . $secmilsecs;
			//Convert to :0n format
			$output = $hours . ":" . $mins . ":" . $secmilsecs;
			}
		//Output hours if minutes greater than 60
		elseif (($mins > 0) AND ($mins < 60))
			{
			if ($secmilsecs < 10)
				$secmilsecs = "0" . $secmilsecs;
			$output = $mins . ":" . $secmilsecs;
			}
		//Output minutes if minutes less than 60 and greater than 0
		else
			$output = $secmilsecs;
		}
	else
		$output = $time;

	Return $output;
	}
//---FunctionBreak---
/**/
//---DocumentationBreak---
function regattadetails($dblink,$id)
	{
	//Month Names
	$monthsarray = array();
	$monthsarray['1'] = "January";
	$monthsarray['2'] = "February";
	$monthsarray['3'] = "March";
	$monthsarray['4'] = "April";
	$monthsarray['5'] = "May";
	$monthsarray['6'] = "June";
	$monthsarray['7'] = "July";
	$monthsarray['8'] = "August";
	$monthsarray['9'] = "September";
	$monthsarray['10'] = "October";
	$monthsarray['11'] = "November";
	$monthsarray['12'] = "December";

	//Prepare SQL and constraints for regatta details query
	$sql = "SELECT `Name`, `Date`, `Days`, `WE`, `Month`, `Year` FROM `regattas` WHERE `Key` = ?";
	$constraints = array();
	$constraints[0] = array("Type"=>"i","Data"=>$id);

	//Run query to get regatta details
	$regattadetails = dbprepareandexecute($dblink,$sql,$constraints,"Single");

	//Output array of regatta details
	$output = array();

	//Format date
	$regattadate = $regattadetails['Date'];
	$regattadate = explode("-",$regattadate);

	$year = $regattadetails['Year'];
	$month = $regattadetails['Month'];
	$day = $regattadetails['WE'];

	//Format month as a name
	$monthname = $monthsarray[$month];

	//Create outputs
	$output['LongDate'] = $day . "/" . $month . "/" . $year;
	$output['ShortDate'] = $monthname . " " . $year;
	$output['Name'] = $regattadetails['Name'];

	//Return regatta details
	Return $output;
	}
//---FunctionBreak---
/**/
//---DocumentationBreak---
function assignage($ages)
	{
	//Split age into 3 letter codes
	$ages = str_split($ages,3);
	$ages = implode("/",$ages);

	//Find and replace Us and Os with Unders and Overs
	$finds = array("U","O","SEN","JUN","VET");
	$replaces = array("Under ","Over ","Senior","Junior","Masters");
	$ages = str_replace($finds,$replaces,$ages);

	Return $ages;
	}
//---FunctionBreak---
/**/
//---DocumentationBreak---
function assignability($ability)
	{
	//Paracanoe numbers format
	if (($ability == 1) OR ($ability == 2) OR ($ability == 3) OR ($ability == 12) OR ($ability == 23) OR ($ability == 123))
		{
		if ($ability == 123)
			$ability = "L1-3";
		else
			{
			$ability = str_split($ability);
			$ability = "L" . implode("+",$ability);
			}
		}
	//Paracanoe the letters format
	elseif (($ability == "A") OR ($ability == "TA") OR ($ability == "LTA"))
		{
		$ability = $ability;
		}
	//Regular A-D format
	elseif (($ability == "A") OR ($ability == "B") OR ($ability == "C") OR ($ability == "D") OR ($ability == "AB") OR ($ability == "BC") OR ($ability == "CD") OR ($ability == "ABC") OR ($ability == "BCD") OR ($ability == "ABCD"))
		{
		$ability = str_split($ability);
		$ability = implode("/",$ability);
		}
	elseif ($ability == "O")
		$ability = "Open";
	else
		$ability = "";

	Return $ability;
	}
//---FunctionBreak---
/**/
//---DocumentationBreak---
function assignspecial($boat,$special)
	{
	//Assign name if it is a special class
	if ($special == "IS")
		$output = "Inter Services";
	elseif ($special == "PD")
		$output = "Paddleability";
	elseif (($special == "PC") AND ($boat == "K"))
		$output = "K-Para";
	elseif (($special == "PC") AND ($boat == "V"))
		$output = "V-Para";
	elseif (($special == "PC") AND ($boat == ""))
		$output = "Paracanoe";
	elseif (($special == "LT") AND (($boat == "K") OR ($boat == "")))
		$output = "Mini-Kayak";
	elseif (($special == "LT") AND ($boat == "C"))
		$output = "Mini-Canoe";
	elseif (($special != "NC") AND ($boat == "C"))
		$output = "Canoe";
	elseif (($special == "NC") AND ($boat != "C"))
		$output = "National Championship";
	elseif (($special == "NC") AND ($boat == "C"))
		$output = "National Championship Canoe";
	else
		$output = "";

	Return $output;
	}
//---FunctionBreak---
/**/
//---DocumentationBreak---
function assignagename($jsv,$mw)
	{
	if (($jsv == "J") AND ($mw == "M"))
		$type = "Boys";
	elseif ((($jsv == "S") OR ($jsv == "")) AND ($mw == "M"))
		$type = "Mens";
	elseif (($jsv == "V") AND ($mw == "M"))
		$type = "Mens Masters";
	elseif (($jsv == "J") AND ($mw == "W"))
		$type = "Girls";
	elseif ((($jsv == "S") OR ($jsv == "")) AND ($mw == "W"))
		$type = "Womens";
	elseif (($jsv == "V") AND ($mw == "W"))
		$type = "Womens Masters";
	elseif (($jsv == "JS") AND ($mw == "M"))
		$type = "Boys/Mens";
	elseif (($jsv == "SV") AND ($mw == "M"))
		$type = "Senior/Masters Mens";
	elseif (($jsv == "JS") AND ($mw == "M"))
		$type = "Girls/Womens";
	elseif (($jsv == "SV") AND ($mw == "M"))
		$type = "Senior/Masters Womens";
	elseif (($jsv == "J") AND ($mw == "MW"))
		$type = "Boys/Girls";
	elseif (($jsv == "S") AND ($mw == "MW"))
		$type = "Mens/Womens";
	elseif (($jsv == "V") AND ($mw == "MW"))
		$type = "Mens/Womens Masters";
	elseif (($jsv == "J") AND ($mw == ""))
		$type = "Junior";
	elseif (($jsv == "S") AND ($mw == ""))
		$type = "Senior";
	elseif (($jsv == "V") AND ($mw == ""))
		$type = "Masters";
	elseif (($jsv == "JSV") AND ($mw == "MW"))
		$type = "Mens/Womens Junior/Senior/Masters";
	elseif (($mw == "X") AND ($jsv == ""))
		$type = "Mixed";
	elseif (($mw == "M") AND ($jsv == ""))
		$type = "Male";
	elseif (($mw == "W") AND ($jsv == ""))
		$type = "Female";
	elseif (($mw == "MW") AND ($jsv == ""))
		$type = "Male/Female";
	else
		$type = "";

	Return $type;
	}
//---FunctionBreak---
/**/
//---DocumentationBreak---
function singleclass($classparams)
	{
	//Define name from codes
	$type = assignagename($classparams['JSV'],$classparams['MW']);
	$ability = assignability($classparams['Abil']);
	$age = assignage($classparams['Ages']);
	$special = assignspecial($classparams['CK'],$classparams['Spec']);

	$classname = $special . " " . $type . " " . $ability . " " . $age;

	$classname = str_replace("Mini-Kayak Junior","Mini-Kayak",$classname);

	//Remove double spaces
	$doublesremoved = 1;
	while ($doublesremoved > 0)
		{
		$classname = str_replace("  "," ",$classname,$doublesremoved);
		}

	Return $classname;
	}
//---FunctionBreak---
/**/
//---DocumentationBreak---
function racedetails($id,$dblink)
	{
	//Array of race details
	$racedetails = array();

	//Prepare SQL and constraints for class query
	$sql = "SELECT `JSV`, `MW`, `CK`, `Abil`, `Spec`, `Ages` FROM `classes` WHERE `Race` = ?";
	$constraints = array();
	$constraints[0] = array("Type"=>"i","Data"=>$id);

	//Run query to get all classes
	$classparamslist = dbprepareandexecute($dblink,$sql,$constraints);

	//Prepare SQL and constraints for race query
	$sql = "SELECT `Dist`, `R`, `D`, `Boat`, `Regatta` FROM `races` WHERE `Key` = ?";

	//Run query to get all classes
	$raceparamslist = dbprepareandexecute($dblink,$sql,$constraints);
	$raceparamslist = $raceparamslist[0];

	//Define distance and draw in output array
	$racedetails['Distance'] = $raceparamslist['Dist'];
	$racedetails['Draw'] = $raceparamslist['D'];
	$racedetails['Boat'] = $raceparamslist['Boat'];
	$racedetails['Regatta'] = $raceparamslist['Regatta'];

	//Define round as integer in output array
	if ($raceparamslist['R'] == "H")
		$racedetails['Round'] = 1;
	elseif (($raceparamslist['R'] == "S") OR ($raceparamslist['R'] == "SF"))
		$racedetails['Round'] = 2;
	elseif ($raceparamslist['R'] == "F")
		$racedetails['Round'] = 3;

	//Format class name
	$raceclasses = array();
	$raceboats = array();
	foreach ($classparamslist as $classparams)
		{
		//Get a single class and add to array
		$singleclass = singleclass($classparams);
		array_push($raceclasses,$singleclass);

		//Default to kayak if not specified
		if (($classparams['CK'] != "C") AND ($classparams['CK'] != "V"))
			$classparams['CK'] = "K";

		//Add boat types to boat type array
		array_push($raceboats,$classparams['CK']);
		}

	//Check for single boat
	$singleboatcheck = array_unique($raceboats);

	if (count($singleboatcheck) > 1)
		{
		//Assign boat type to each race class if there are specific boats for each subclass
		foreach ($raceclasses as $classkey=>$raceclass)
			{
			$raceclasses[$classkey] = $raceclass . " " . $raceboats[$classkey] . "*";
			}

		//Implode all race classes together
		$racedetails['Class'] = implode(" &#38; ",$raceclasses);
		}
	else
		{
		//Add boat class at the end if only one type of boat
		$racedetails['Class'] = implode(" &#38; ",$raceclasses);
		$racedetails['Class'] = $racedetails['Class'] . " " . $singleboatcheck[0] . "*";
		}

	//Race name, which is not as good for sorting
	$racedetails['RaceName'] = str_replace("*",$racedetails['Boat'],$racedetails['Class']);
	$racedetails['RaceName'] = $racedetails['RaceName'] . " " . $racedetails['Distance'] . "m";

	//Attach round to race name
	if ($racedetails['Round'] == 1)
		$racedetails['RaceName'] = $racedetails['RaceName'] . " Heat";
	elseif ($racedetails['Round'] == 2)
		$racedetails['RaceName'] = $racedetails['RaceName'] . " Semi-Final";
	elseif ($racedetails['Round'] == 3)
		$racedetails['RaceName'] = $racedetails['RaceName'] . " Final";

	//Attach draw to race name if specified
	if (($racedetails['Draw'] != '') AND ($racedetails['Draw'] != 0))
		$racedetails['RaceName'] = $racedetails['RaceName'] . " " . $racedetails['Draw'];

	Return $racedetails;
	}
//---FunctionBreak---
/**/
//---DocumentationBreak---
function getracetable($raceid,$dblink,$type="Short")
	{
	//Race table to populate
	$racetable = array();

	//Find race finishers
	if ($type == "Short")
		$racesql = "SELECT `Position`, `Club`, `Crew`, `Time`, `NR` FROM `paddlers` WHERE `Race` = ? AND `Position` > 0 ORDER BY `Position` ASC ";
	elseif ($type == "Long")
		$racesql = "SELECT `Lane`, `Position`, `Club`, `Crew`, `Time`, `NR`, `JSV`, `MW`, `CK` FROM `paddlers` WHERE `Race` = ? AND `Position` > 0 ORDER BY `Position` ASC ";

	$raceconstraint = array();
	$raceconstraint[0] = array("Data"=>$raceid,"Type"=>"i");
	$racefinishers = dbprepareandexecute($dblink,$racesql,$raceconstraint);

	foreach ($racefinishers as &$racefinisher)
		{
		//Put race information into line
		$raceline = array();

		//All results tables have these data
		$raceline['Club'] = $racefinisher['Club'];
		$raceline['Position'] = $racefinisher['Position'];
		$raceline['Crew'] = $racefinisher['Crew'];

		//Race result displayed as time, NR flag, or ???
		if ($racefinisher['Time'] > 0)
			$raceline['Result'] = displaytime($racefinisher['Time']);
		elseif ($racefinisher['NR'] != '')
			$raceline['Result'] = $racefinisher['NR'];
		else
			$raceline['Result'] = "???";

		//Only long results tables have these data
		if ($type == "Long")
			{
			$raceline['Lane'] = $racefinisher['Lane'];

			//Tag defining paddler type
			$raceline['PaddlerClass'] = $racefinisher['JSV'] . $racefinisher['MW'] . $racefinisher['CK'];
			}

		array_push($racetable,$raceline);
		}

	//Find race nonfinishers
	if ($type == "Short")
		$racesql = "SELECT `Position`, `Club`, `Crew`, `Time`, `NR` FROM `paddlers` WHERE `Race` = ? AND `Position` = 0 ORDER BY `Position` ASC ";
	elseif ($type == "Long")
		$racesql = "SELECT `Lane`, `Position`, `Club`, `Crew`, `Time`, `NR`, `JSV`, `MW`, `CK` FROM `paddlers` WHERE `Race` = ? AND `Position` = 0 ORDER BY `Position` ASC ";
	$racenonfinishers = dbprepareandexecute($dblink,$racesql,$raceconstraint);

	foreach ($racenonfinishers as &$racenonfinisher)
		{
		//Put race information into line
		$raceline = array();

		//All results tables have these data
		$raceline['Position'] = $racenonfinisher['Position'];
		$raceline['Club'] = $racenonfinisher['Club'];
		$raceline['Crew'] = $racenonfinisher['Crew'];

		//Race result displayed as NR flag, or ???
		if ($racenonfinisher['NR'] != '')
			$raceline['Result'] = $racenonfinisher['NR'];
		else
			$raceline['Result'] = "???";

		//Only long results tables have these data
		if ($type == "Long")
			{
			if (isset($racefinisher['Lane']) == true)
				$raceline['Lane'] = $racefinisher['Lane'];
			else
				$raceline['Lane'] = 0;

			//Tag defining paddler type
			$raceline['Paddler'] = $racenonfinisher['JSV'] . $racenonfinisher['MW'] . $racenonfinisher['CK'];
			}

		array_push($racetable,$raceline);
		}

	//Return race table
	Return $racetable;
	}
//---FunctionBreak---
/**/
//---DocumentationBreak---
function highlightingrules($club,$paddler)
	{
	if (($club != '') AND ($paddler == ''))
		{
		$highlighting = "Club";

		$surname = "";
		}
	elseif ($paddler != '')
		{
		$highlighting = "Paddler";

		$surname = explode(" ",$paddler);
		$surname = $surname[1];
		}
	else
		{
		$highlighting = "None";

		$surname = "";
		}

	$output = array("Highlighting"=>$highlighting,"Paddler"=>$paddler,"Surname"=>$surname,"Club"=>$club);
	Return $output;
	}
//---FunctionBreak---
/**/
//---DocumentationBreak---
function highlightracetable($racetable,$highlighting,$club,$paddler,$surname)
	{
	if ($highlighting == "Club")
		{
		//Constraints
		$searchtable = array();
		$searchtable[0] = array();
		$searchtable[0]['Cell'] = "Club";
		$searchtable[0]['Options'] = array();
		$searchtable[0]['Options'][0] = $club;
		}
	elseif ($highlighting == "Paddler")
		{
		$arraykey = 0;

		//Add club if specified
		if ($club != "")
			{
			$searchtable = array();
			$searchtable[$arraykey] = array();
			$searchtable[$arraykey]['Cell'] = "Club";

			//Turn club into club array if needed
			$clubarray = explode("/",$club);

			//Attach club array to search table
			$searchtable[$arraykey]['Options'] = $clubarray;

			$arraykey = 1;
			}

		//Paddler name to search for
		$searchtable[$arraykey] = array();
		$searchtable[$arraykey]['Cell'] = "Crew";

		//Different variation of paddler name added to search constraints
		$searchtable[$arraykey]['Options'][0] = $paddler;
		$searchtable[$arraykey]['Options'][1] = "/" . $surname;
		$searchtable[$arraykey]['Options'][2] = "/" . $surname . "/";
		$searchtable[$arraykey]['Options'][3] = $surname . "/";
		}

	if ($highlighting != "None")
		{
		$racetable = highlightrowssearch($racetable,$searchtable,"#FFFF00");
		}

	Return $racetable;
	}
//---FunctionBreak---
/*Adds row highlightling onto a race results table that can be read by divtable

$racetable is the race table in divtable format
$clubsearch is the array of club codes to search for
$paddlersearch is the paddler names to search for

Returns the div table with highlight parameters set*/
//---DocumentationBreak---
function addracehighlighting($racetable,$clubsearch,$paddlersearch)
	{
	foreach ($racetable as $paddlerkey=>$paddler)
		{
		$clubfound = false;
		$paddlerfound = false;

		//Search for club
		if (is_array($clubsearch) == true)
			{
			foreach ($clubsearch as $singleclub)
				{
				if (strpos($paddler['Club']['Data'],$singleclub) !== false)
					$clubfound = true;
				}
			}
		else
			$clubfound = true;

		//Search for paddler
		if (is_array($paddlersearch) == true)
			{
			foreach ($paddlersearch as $singlepaddler)
				{
				if (strpos($paddler['Crew']['Data'],$singlepaddler) !== false)
					$paddlerfound = true;
				}
			}
		else
			$paddlerfound = true;

		if (($clubfound == true) AND ($paddlerfound == true))
			$paddler['RowProperties']['Highlight'] = "rgb(255,255,0)";

		//Update line of race table
		$racetable[$paddlerkey] = $paddler;
		}

	Return $racetable;
	}
//---FunctionBreak---
?>
