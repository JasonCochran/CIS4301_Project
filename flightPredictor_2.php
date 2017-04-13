#!/usr/local/bin/php

<html>
<head>
    <title>JetBlue Delay Predictor Calendar</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- BootStrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Raleway & Roboto -->
    <link href="https://fonts.googleapis.com/css?family=Raleway|Roboto" rel="stylesheet">
</head>

</html>

<?php
include("includes/solid_navbar.html");
include('globalVariables.php');
ini_set('display_errors', 1);
$validForm = true;			// form is valid unless an invalid value is input
$submitted = false;			// if the whole form is valid, then this will become true and form can be submitted
$input = false;				// to prevent an empty form from running a blank query
?>

<!-- db stuff -->
<?php
function runQuery($originClean, $destClean) {
    $connection = oci_connect($username = $GLOBALS['username'], $password = $GLOBALS['password'], $connection_string = '//oracle.cise.ufl.edu/orcl');

    $monsterQuery = "SELECT FLIGHTS.FLIGHTDATE, FLIGHTS.FLIGHTNUMBER FROM FLIGHTS, CANCELLATIONS
 WHERE FLIGHTS.FLIGHTNUMBER = CANCELLATIONS.FLIGHTNUMBER
   AND FLIGHTS.FLIGHTDATE = CANCELLATIONS.FLIGHTDATE
   AND FLIGHTS.ORIGINAIRPORT =:departureAirport_bv
   AND FLIGHTS.DESTINATIONAIRPORT =:arrivalAirport_bv";

    $statement = oci_parse($connection, $monsterQuery);

    oci_bind_by_name($statement, ":departureAirport_bv",$destClean );
    oci_bind_by_name($statement, ":arrivalAirport_bv", $originClean);
    oci_execute($statement);

    // output result as a table
    echo "
			<table class='table table-hover'>
			<thead>
			<tr>
			<th>Flight Date</th>
			<th>Flight Number</th>
			</tr>
			</thead>
			<tbody class='list'>
		";

    while (($row = oci_fetch_object($statement))) {
        echo "<tr>";
        echo "<td>" . $row->FLIGHTDATE . "</td>";
        echo "<td>" . $row->FLIGHTNUMBER . "</td>";
        echo "</tr>";
    }

    echo "
			</tbody>
			</table>
		";

    oci_free_statement($statement);
    oci_close($connection);
}
?>

<!-- form validation -->
<?php
// helps prevent malicious HTML input
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// input variables that will be sanitized
$originClean = $destClean = "";

// validates each variable
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // DONE - origin
    $originClean = test_input($_POST["origin-filter"]);
    if (!preg_match("/^[a-zA-Z0-9 ]*$/", $originClean)) {
        $validForm = false;
        $orgErr = "Only alphanumeric characters accepted";
    }

    // DONE - destination
    $destClean = test_input($_POST["destination-filter"]);
    if (!preg_match("/^[a-zA-Z0-9 ]*$/", $destClean)) {
        $validForm = false;
        $destErr = "Only alphanumeric characters accepted";
    }
}
?>
<div class="container">
    <form method="post" action="">
        <!-- Origin -->
        <input type="checkbox" name="filter[]" id="filter" value="Origin" onclick="displayCheck(this);"> Origin
        <input type="text" id="Origin" name="origin-filter" placeholder='JFK'>
        <span class="error"><?php echo $orgErr; ?></span><br>

        <!-- Destination -->
        <input type="checkbox" name="filter[]" id="filter" value="Destination" onclick="displayCheck(this);"> Destination
        <input type="text" id="Destination" name="destination-filter" placeholder="JAX">
        <span class="error"><?php echo $destErr; ?></span>

        <input type="submit" class="btn" name="submit" value="Submit">
    </form>
</div>

<!-- After form has been submitted -->
<?php
if(isset($_POST['submit'])) {

    $stack = array();
    array_push($stack, $originClean);
    array_push($stack, $destClean);

    foreach ($stack as $value) {
        // if there's at least one input, we can submit the query
        if(!empty($value)) {
            $input = true;
        }
    }

    // if the form is valid, then it can be submitted
    if($validForm) {
        $submitted = true;
    }
}

// if form is valid and submit has been clicked, run the query
if ($validForm && $submitted && $input) {
    runQuery($originClean, $destClean);
}

// reset form
$validForm = true;
$submitted = false;
$input = false;
?>

<?php
//
//include("includes/footer.html");
?>