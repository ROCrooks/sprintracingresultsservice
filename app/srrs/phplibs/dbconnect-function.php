<?php
function createdbconnection($dbchoice)
	{
	//Find where this script is located
	$hostis = $_SERVER['HTTP_HOST'];

	//Details for connecting to database on virtual machine
	$details['SRRS'] = array("Host"=>"mysql","User"=>"srrs","Password"=>"sprintcanoeing--1234password5678","DB"=>"srrs");

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
