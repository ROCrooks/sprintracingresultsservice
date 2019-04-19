<?php
//---FunctionBreak---
/*Prepare but do not execute a query using a prepared statement. Useful for preparing a statement in advance and populating it with data

$dblink is the database link to use
$sql is the SQL query to use

Output is an SQL statement which can be passed to dbexecute with data*/
//---DocumentationBreak---
function dbprepare($dblink,$sql)
	{
	//Prepare finishers query
	$stmt = mysqli_prepare($dblink,$sql)
		or die("MySQLi Error in preparing query: " . $dblink->error);

	Return $stmt;
	}
//---FunctionBreak---
/*Executes the SQL query from a prepared statement

$stmt is the prepared statement made by dbprepare
$constraints are the constraints of the query

Output is a 2 dimensional array with the query results*/
//---DocumentationBreak---
function dbexecute($stmt,$constraints)
	{
  //Make the constraints into an array if they are a single item of data
	if (is_array($constraints) == false)
    $constraints = array($constraints);

  //Identify data type for each piece of data and add to types variable
  $types = "";
  foreach($constraints as $value)
    {
    if (is_int($value) == true)
      $types = $types . "i";
    elseif (is_numeric($value) == true)
      $types = $types . "d";
    elseif (is_string($value) == true)
      $types = $types . "s";
    }

	//Bind parameters to query
	mysqli_stmt_bind_param($stmt,$types,...$constraints);

	mysqli_stmt_execute($stmt)
		or die("MySQLi Error in preparing query " . $sql . ": : " . $stmt->error);

  //Get results of query and send to output array
  $result = mysqli_stmt_get_result($stmt);

  if (is_bool($result) == false)
    {
    //Convert mysql results to array
    $results = array();
    while ($sqlrow = mysqli_fetch_array($result))
  		{
      $row = array();
      //Removes duplicated numeric column headings
      foreach ($sqlrow as $column=>$element)
        {
        if (is_int($column) == false)
          $row[$column] = $element;
        }

      array_push($results,$row);
      }
  	Return $results;
    }
	}
//---FunctionBreak---
/*Executes the SQL query from a prepared statement

$stmt is the prepared statement made by dbprepare
$constraints are the constraints of the query

Output is a 2 dimensional array with the query results*/
//---DocumentationBreak---
function dbprepareandexecute($dblink,$sql,$constraints)
  {
  $stmt = dbprepare($dblink,$sql);
  $results = dbexecute($stmt,$constraints);
  if (is_array($results) == true)
    Return $results;
  }
//---FunctionBreak---
/*Get the values from one column of an SQL result as an array

$dbresult is the database query result
$column is the column to extract from the database result

Output is an array with all the values in the column*/
//---DocumentationBreak---
function resulttocolumn($dbresult,$column="Key")
  {
  $output = array();

	//Get field from each row
	foreach ($dbresult as $dbrow)
		{
		if (isset($dbrow[$column]) == true)
			array_push($output,$dbrow[$column]);
		}

	Return $output;
  }
//---FunctionBreak---
/*Make a BETWEEN SQL constraint from a list of integers

$integers is the list of integers
$fieldname is the field name that the query is going to relate to

Output is an array of ['SQLText'] which can be concatenated into the SQL, and
['SQLValues'] is an array of values that can be merged into the*/
//---DocumentationBreak---
function makesqlrange($integers,$fieldname)
  {
  //Sort and make unique
  $integers = array_unique($integers);
  sort($integers);

  $inrange = false;
  $constraintstext = array();
  $constraintsvalues = array();
  $integerskey = 0;
  $end = count($integers);
  while ($integerskey < $end)
    {
    if (is_int($integers[$integerskey]) == true)
      {
      //Define next number
      if (isset($integers[$integerskey+1]) == true)
        $nextno = $integers[$integerskey+1];
      else
        $nextno = "";

      if ($inrange == false)
        {
        //Open a range
        if ($nextno == $integers[$integerskey]+1)
          {
          $inrange = true;
          $constraint = "(`" . $fieldname . "` BETWEEN ? AND ";
          array_push($constraintsvalues,$integers[$integerskey]);
          }
        else
          {
          $constraint = "`" . $fieldname . "` = ?";
          array_push($constraintsvalues,$integers[$integerskey]);
          array_push($constraintstext,$constraint);
          }
        }
      elseif ($inrange == true)
        {
        //Close a range
        if ($nextno != $integers[$integerskey]+1)
          {
          $constraint = $constraint . "?)";
          array_push($constraintsvalues,$integers[$integerskey]);
          array_push($constraintstext,$constraint);
          $inrange = false;
          }
        }
      }
    $integerskey++;
    }

  $constraintstext = "(" . implode(" OR ",$constraintstext) . ")";
  $output = array("SQLText"=>$constraintstext,"SQLValues"=>$constraintsvalues);
  Return $output;
  }
//---FunctionBreak---
?>
