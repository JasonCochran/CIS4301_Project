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
<div class="container">
<!-- db stuff -->
<?php
function runQuery($originClean, $destClean, $dayClean, $monthClean) {
    $connection = oci_connect($username = $GLOBALS['username'], $password = $GLOBALS['password'], $connection_string = '//oracle.cise.ufl.edu/orcl');

    $date = $dayClean."-".$monthClean."-"."16";
/*
    $alterSession = "ALTER SESSION SET NLS_DATE_FORMAT = DD-MM-YYYY";
    $query = oci_parse($connection,$alterSession );
    oci_execute($query);
 */

    $monsterQuery = "SELECT FLIGHTS.FLIGHTDATE, FLIGHTS.FLIGHTNUMBER FROM FLIGHTS, CANCELLATIONS
 WHERE FLIGHTS.FLIGHTNUMBER = CANCELLATIONS.FLIGHTNUMBER
   AND FLIGHTS.FLIGHTDATE = CANCELLATIONS.FLIGHTDATE
   AND FLIGHTS.ORIGINAIRPORT =:departureAirport_bv
   AND FLIGHTS.DESTINATIONAIRPORT =:arrivalAirport_bv 
   AND FLIGHTS.FLIGHTDATE =:date_bv";

    $monsterQuery_2 = "SELECT * FROM
FLIGHTS WHERE FLIGHTS.ORIGINAIRPORT=:departureAirport_bv
 AND FLIGHTS.DESTINATIONAIRPORT=:arrivalAirport_bv 
 AND FLIGHTS.FLIGHTDATE =:date_bv";


    $statement = oci_parse($connection, $monsterQuery);
    $statement_2 = oci_parse($connection, $monsterQuery_2);

    oci_bind_by_name($statement, ":departureAirport_bv",$destClean );
    oci_bind_by_name($statement, ":arrivalAirport_bv", $originClean);
    oci_bind_by_name($statement, ":date_bv", $date);
    oci_execute($statement);

    oci_bind_by_name($statement_2, ":departureAirport_bv",$destClean );
    oci_bind_by_name($statement_2, ":arrivalAirport_bv", $originClean);
    oci_bind_by_name($statement_2, ":date_bv", $date);
    oci_execute($statement_2);

    $allFlights = oci_fetch_object($statement_2);
    $allFlightsCount = count($allFlights);

    // output result as a table

    $count = 0;
    while (($row = oci_fetch_object($statement))) {
        $count++;
    }

    $GLOBALS['predictorResult'] = $count / $allFlightsCount * 100;
    echo $count / $allFlightsCount * 100;

    oci_free_statement($statement);
    oci_free_statement($statement_2);
    oci_close($connection);



}
?>
</div>
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

    $dayClean = test_input($_POST["day-filter"]);
    if (!preg_match("/^[a-zA-Z0-9 ]*$/", $dayClean)) {
        $validForm = false;
        $dayErr = "Only alphanumeric characters accepted";
    }

    $monthClean = test_input($_POST["month-filter"]);
    if (!preg_match("/^[a-zA-Z0-9 ]*$/", $monthClean)) {
        $validForm = false;
        $monthErr = "Only alphanumeric characters accepted";
    }
}
?>
<div class="container">
    <form method="post" action="">
        <!-- Origin -->
        <h4>Type in the origin Airport, Destination Airport, Day and Month to see the delay prediction for your flight.</h4>
        <input type="checkbox" name="filter[]" id="filter" value="Origin" onclick="displayCheck(this);"> Origin
        <input type="text" id="Origin" name="origin-filter" placeholder='JFK'>
        <span class="error"><?php echo $orgErr; ?></span>

        <!-- Destination -->
        <input type="checkbox" name="filter[]" id="filter" value="Destination" onclick="displayCheck(this);"> Destination
        <input type="text" id="Destination" name="destination-filter" placeholder="MCO">
        <span class="error"><?php echo $destErr; ?></span>
        <br>
        <!-- Day -->
        <input type="checkbox" name="filter[]" id="filter" value="Destination" onclick="displayCheck(this);"> Day
        <input type="text" id="Day" name="day-filter" placeholder="22">
        <span class="error"><?php echo $dayErr; ?></span>

        <!-- Month -->
        <input type="checkbox" name="filter[]" id="filter" value="Month" onclick="displayCheck(this);"> Month
        <input type="text" id="Month" name="month-filter" placeholder="NOV">
        <span class="error"><?php echo $monthErr; ?></span>
        <br>
        <br>
        <input type="submit" class="btn" name="submit" value="Submit">

    </form>
</div>

<!-- After form has been submitted -->
<?php
if(isset($_POST['submit'])) {

    $stack = array();
    array_push($stack, $originClean);
    array_push($stack, $destClean);
    array_push($stack, $dayClean);
    array_push($stack, $monthClean);

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
    runQuery($originClean, $destClean, $dayClean, $monthClean);
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