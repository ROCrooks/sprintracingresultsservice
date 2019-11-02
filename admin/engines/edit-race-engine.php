<?php
echo "<p>Form submitted</p>";

//Get from the form
function getfromform($input)
  {
  if (isset($_POST[$input]) == true)
    $output = $_POST[$input];
  else
    $output = "";

  Return $output;
  }

echo getfromform("JSV") . "<br>";
echo getfromform("MW") . "<br>";
echo getfromform("CK") . "<br>";
echo getfromform("Regatta") . "<br>";
echo getfromform("BoatSize") . "<br>";
echo getfromform("Distance") . "<br>";
echo getfromform("RoundDraw") . "<br>";
echo getfromform("FreeText") . "<br>";
echo getfromform("Abil") . "<br>";
echo getfromform("Spec") . "<br>";
echo getfromform("Ages") . "<br>";
echo getfromform("Position") . "<br>";
echo getfromform("Lane") . "<br>";
echo getfromform("Crew") . "<br>";
echo getfromform("Club") . "<br>";
echo getfromform("Result") . "<br>";
echo getfromform("PaddlerKey") . "<br>";
?>
