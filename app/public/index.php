<?php
$functionslocation = '/app/public/phplibs/';
session_start();

//Get the section and page to view
include '/app/public/cms/getsectionpage.php';

//Get the page content
include '/app/public/cms/getpagecontent.php';

//Construct the page
include '/app/public/cms/constructpage.php';
?>
