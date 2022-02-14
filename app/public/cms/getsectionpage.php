<?php
//Allowed tags in the URL, everything else is removed
$urlallowed = array(
"srrs",
"admin",
"api"
);

//Get the details of the page to serve from the URL
$url = ltrim($_SERVER['REQUEST_URI'],'/');

//Split URL to read and remove prohibited terms from the URL
$urlsplit = explode("/",$url);

//Get the last element of the URL from which the page is derived
$lastelement = array_pop($urlsplit);
//Remove and GET variables
$lastelement = explode("?",$lastelement);
$lastelement = $lastelement[0];

//Check if the page exists
if (file_exists('meta/' . $lastelement . '.json') === true)
  $page = $lastelement;
else
  //Default to index page
  $page = "Index";

//Reattach last element to array
array_push($urlsplit,$lastelement);

//Process the URL to determine the section
//Unset the terms in the URL if they're not allowed
$processedurl = array();
foreach($urlsplit as $urlkey=>$urlitem)
  {
  //Make the URL lower case
  $urlitem = strtolower($urlitem);

  //Only add the URL to the output array if it's good
  if ((in_array($urlitem,$urlallowed) === true) AND (in_array($urlitem,$processedurl) === false))
    {
    if (($urlitem == "srrs") AND (in_array("admin",$processedurl) === false))
      array_push($processedurl,"srrs");
    elseif (($urlitem == "admin") AND (in_array("srrs",$processedurl) === false))
      array_push($processedurl,"admin");
    elseif (($urlitem == "api") AND (in_array("srrs",$processedurl) === true))
      array_push($processedurl,"api");
    }
  }

//Find the section from the processed URL
if (count($processedurl) == 0)
  $section = "Main";
elseif ($processedurl[0] == "admin")
  {
  $section = "Admin";

  //Check user is logged in
  include 'adminlogin.php';

  if ($loggedin == false)
    {
    //Go to the login page to allow the user to log in
    $forwardpage = $page;
    $page = "Login";

    if ($forwardpage == "Login")
      $forwardpage = "AdminIndex";
    }
  }
elseif ($processedurl[0] == "srrs")
  {
  //If the section is the SRRS
  if (isset($processedurl[1]) == true)
    {
    if ($processedurl[1] == "api")
      //If the section is the API
      $section = "API";
    else
      $section = "SRRS";
    }
  else
    $section = "SRRS";
  }

if (($section != "Main") AND ($page == "Index"))
  $page = $section . $page;
?>
