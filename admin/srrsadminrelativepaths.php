<?php

//Get current directory
//This makes the location independent of the location of the calling script
$directory = dirname(__DIR__);
$directory = explode("admin",$directory);
$directory = $directory[0];

//The relative path of all the public engines
$publicenginesrelativepath = $directory . "/public/engines/";
$adminenginesrelativepath = $directory . "/admin/engines/";
?>
