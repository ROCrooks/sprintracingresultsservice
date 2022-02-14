<?php
//Default to not logged in if it is not set
if (isset($loggedin) == false)
  $loggedin = false;

if (file_exists('meta/' .  $page . '.json') == true)
  {
  //Get the page meta details
  $pagedetailsjson = file_get_contents('meta/' .  $page . '.json');
  $pagedetails = json_decode($pagedetailsjson,true);

  //Set a flag that the page isn't private if it's not specified
  if (isset($pagedetails['PageSecurity']) == true)
    $pagesecurity = $pagedetails['PageSecurity'];
  else
    $pagesecurity = false;

  //Get the page meta data
  if (isset($pagedetails['PageTitle']) == true)
    $pagetitle = $pagedetails['PageTitle'];
  if (isset($pagedetails['PageDescription']) == true)
    $pagemeta = $pagedetails['PageDescription'];

  if ((file_exists('pages/' . $pagedetails['PageAddress']) == true) AND (($loggedin == true) OR ($pagesecurity == false)))
    {
    //Get page HTML from HTML page
    if ($pagedetails['PageFormat'] == "html")
      $pagehtml = file_get_contents('pages/' . $pagedetails['PageAddress']);
    //Run a PHP script
    elseif ($pagedetails['PageFormat'] == "php")
      include 'pages/' . $pagedetails['PageAddress'];
    }

  //Define an error page if looked up page cannot be found
  if (isset($pagetitle) == false)
    $pagetitle = "Untitled Page";
  if (isset($pagemeta) == false)
    $pagemeta = "No page information found";
  }
?>
