#!/usr/local/bin/php

<?php

// simple php form that interacts with the dataset

// define variables and set to empty values
$origin = $destination = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $origin = test_input($_POST["origin"]);
  $destination = test_input($_POST["destination"]);
}

// helps prevent XSS
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>

<h2>JetBlue Flight Browser</h2>
<p>Enter the origin and destination airport codes and see all the 2016 JetBlue flights on your browser!</p>
<p>Also, yes, this is ugly, but I'll clean it up soon, I promise.</p>
<br>

<form method="post" action="display.php">
  Origin Airport: <input type="text" name="origin">
  <br><br>
  Destination Airport: <input type="text" name="destination">
  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>