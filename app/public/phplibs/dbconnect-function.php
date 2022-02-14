<?php
function createdbconnection($dbchoice)
	{
	//Find where this script is located
	$hostis = $_SERVER['HTTP_HOST'];

	if ($hostis == "live.v.je")
		{
		//Details for connecting to database on virtual machine
		$details['Main'] = array("Host"=>"v.je","User"=>"v.je","Password"=>"v.je","DB"=>"main");
		$details['SRRS'] = array("Host"=>"v.je","User"=>"v.je","Password"=>"v.je","DB"=>"sprintcanoeing");
		$details['WRGL'] = array("Host"=>"v.je","User"=>"v.je","Password"=>"v.je","DB"=>"wrgl");
		$details['Misc'] = array("Host"=>"v.je","User"=>"v.je","Password"=>"v.je","DB"=>"misc");
		}
	if ($hostis == "development.v.je")
		{
		//Details for connecting to database on virtual machine
		$details['Main'] = array("Host"=>"v.je","User"=>"v.je","Password"=>"v.je","DB"=>"main");
		$details['SRRS'] = array("Host"=>"v.je","User"=>"v.je","Password"=>"v.je","DB"=>"sprintcanoeing");
		$details['WRGL'] = array("Host"=>"v.je","User"=>"v.je","Password"=>"v.je","DB"=>"wrgl");
		$details['Misc'] = array("Host"=>"v.je","User"=>"v.je","Password"=>"v.je","DB"=>"misc");
		}
	elseif ($hostis == "www.rocrooks.co.uk")
		{
		//Details for connecting to database on server
		$details = array();
		$details['Main'] = array("Host"=>"db593703957.db.1and1.com","User"=>"dbo593703957","Password"=>"P!16lmudWB1990f","DB"=>"db593703957");
		$details['SRRS'] = array("Host"=>"db494720712.db.1and1.com","User"=>"dbo494720712","Password"=>"mur18ils/Ft222g","DB"=>"db494720712");
		$details['WRGL'] = array("Host"=>"db689527181.db.1and1.com","User"=>"dbo689527181","Password"=>"G-53gre982lo33b","DB"=>"db689527181");
		$details['Misc'] = array("Host"=>"db556056298.db.1and1.com","User"=>"dbo556056298","Password"=>"915gghm734hth-P","DB"=>"db556056298");
		}

	//Choose details based on database selected
	$details = $details[$dbchoice];

	//Connect to database using MySQLi
	$dblink = mysqli_connect($details['Host'],$details['User'],$details['Password'],$details['DB']);

	//Error if cannot connect
	if (!$dblink)
		{
	    echo "Error: Unable to connect to MySQL." . PHP_EOL;
	    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
	    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
	    exit;
		}
	else
		return $dblink;

	//Unset details about the connection
	unset($details);
	}

?>
