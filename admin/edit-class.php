<?php
include 'srrsadminrelativepaths.php';
include 'srrsadmindefaulturls.php';

//Get class name from URL
$findclassname = $_GET['class'];

//Get details about how this race is named in the records
include $adminenginesrelativepath . "class-getoneclass.php";
$autoclassdetails = $classdetails;

//Get details about how this race is named in the records
include $adminenginesrelativepath . "class-getraceclassnames.php";
?>
<div class="item">
<p><?php echo $findclassname;?></p>

<p><?php echo $autoclassname;?></p>
</div>
