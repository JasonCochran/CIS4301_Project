#!/usr/local/bin/php

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->

<?php
// TODO remove this
ini_set('display_errors', 1);
$validForm = true;
$submitted = false;
$input = false;
$numFilters = 0;
?>

<?php
function runQuery($departureAirportClean, $arrivalAirportClean, $dayClean, $monthClean, $yearClean)
{
    include('globalVariables.php');

    $connection = oci_connect($username = $GLOBALS['username'],
        $password = $GLOBALS['password'],
        $connection_string = '//oracle.cise.ufl.edu/orcl');

    // $departureAirportClean = "JFK";
    // $arrivalAirportClean = "MCO";
    // $dayClean = "2016-12-21";
    $dateClean = $yearClean . "-" . $monthClean . "-" . $dayClean;

    echo $yearClean, $monthClean, $dayClean;

// TODO write the query for this
    $statement = oci_parse($connection, "SELECT * FROM FLIGHTS, CANCELLATIONS
 WHERE FLIGHTS.FLIGHTNUMBER = CANCELLATIONS.FLIGHTNUMBER
   AND FLIGHTS.FLIGHTDATE = CANCELLATIONS.FLIGHTDATE
   AND FLIGHTS.ORIGINAIRPORT =:departureAirport_bv
   AND FLIGHTS.DESTINATIONAIRPORT =:arrivalAirport_bv 
   AND FLIGHTS.FLIGHTDATE =:date_bv");

    $statement_2 = oci_parse($connection, "SELECT * FROM 
FLIGHTS WHERE FLIGHTS.ORIGINAIRPORT=:departureAirport_bv
   AND FLIGHTS.DESTINATIONAIRPORT=:arrivalAirport_bv 
   AND FLIGHTS.FLIGHTDATE =:date_bv");

// AND FLIGHTS.FLIGHTDATE = 'YEAR-MONTH_DAY'
// TODO need to actually define the $dateClean variable
    oci_bind_by_name($statement, ":date_bv", $dateClean);
    oci_bind_by_name($statement, ":departureAirport_bv", $departureAirportClean);
    oci_bind_by_name($statement, ":arrivalAirport_bv", $arrivalAirportClean);
    oci_execute($statement);

    oci_bind_by_name($statement_2, ":date_bv", $dateClean);
    oci_bind_by_name($statement_2, ":departureAirport_bv", $departureAirportClean);
    oci_bind_by_name($statement_2, ":arrivalAirport_bv", $arrivalAirportClean);
    oci_execute($statement_2);

    $delays = oci_fetch_array($statement);
    $flightDelayCount = count($delays);

    $flights = oci_fetch_array($statement_2);
    $flightCount = count($flights, COUNT_NORMAL);

    echo $flightDelayCount;
    echo $flightCount;

    $prediction = 100 * $flightDelayCount / $flightCount;

    echo $prediction;

    oci_free_statement($statement);
    oci_free_statement($statement_2);
    oci_close($connection);
}

?>
<?php
 include("includes/header.php");
include("includes/solid_navbar.html");
?>
<?php
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$monthClean = $dayClean = $yearClean = $arrivalAirportClean = $departureAirportClean = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $monthClean = test_input($_POST["month-filter"]);
    if (!is_numeric($monthClean) && !empty($monthClean)) {
        $validForm = false;
        $monthErr = "Only numeric characters accepted";
    }

    $dayClean = test_input($_POST["day-filter"]);
    if (!is_numeric($dayClean) && !empty($dayClean)) {
        $validForm = false;
        $dayErr = "Only numeric characters accepted";
    }

    $yearClean = test_input($_POST["year-filter"]);
    if (!is_numeric($yearClean) && !empty($yearClean)) {
        $validForm = false;
        $yearErr = "Only numeric characters accepted";
    }

    $departureAirportClean = test_input($_POST["departureAirport-filter"]);
    if (!preg_match("/^[a-zA-Z0-9 ]*$/", $departureAirportClean)) {
        $validForm = false;
        $departureAirportErr = "Only alphanumeric characters accepted";
    }

    $arrivalAirportClean = test_input($_POST["arrivalAirport-filter"]);
    if (!preg_match("/^[a-zA-Z0-9 ]*$/", $arrivalAirportClean)) {
        $validForm = false;
        $arrivalAirportErr = "Only alphanumeric characters accepted";
    }
}

?>

<body>

<div class="container">

            <div class="panel panel-default">
                <div class="panel-heading">Search Settings</div>
                <div class="panel-body">
                    <form method="post" action="">
                        <div class="form-group">
                            <br>
                            <label for="carrierInput">Departure Date:</label>
                            <div class="input-group">

                                <input type="text" class="form-control" name="filter[]" id="filter" value="Month"
                                       onclick="displayCheck(this);">
                                <input type="text" id="Month" name="Month-filter" style="display:none">
                                <span class="error"><?php echo $monthErr; ?></span>

                                <span class="input-group-addon">-</span>

                                <input type="text" class="form-control" name="filter[]" id="filter" value="Day"
                                       onclick="displayCheck(this);">
                                <input type="text" id="Day" name="Day-filter" style="display:none">
                                <span class="error"><?php echo $dayErr; ?></span>

                                <span class="input-group-addon">-</span>

                                <input type="text" class="form-control" name="filter[]" id="filter" value="Year"
                                       onclick="displayCheck(this);">
                                <input type="text" id="Year" name="Year-filter" style="display:none">
                                <span class="error"><?php echo $yearErr; ?></span>
                            </div>
                            <br>
                            <label for="carrierInput">Airport Departure and Arrival:</label>
                            <div class="input-group">

                                <input type="text" name="filter[]" id="filter"
                                       value="Departure Airport" onclick="displayCheck(this);">
                                <input type="text" id="Departure Airport" name="DepartureAirport-filter"
                                       style="display:none">
                                <span class="error"><?php echo $departureAirportErr; ?></span>

                                <span class="input-group-addon">-</span>

                                <input type="text"= name="filter[]" id="filter"
                                       value="Arrival Airport" onclick="displayCheck(this);">
                                <input type="text" id="Arrival Airport" name="ArrivalAirport-filter"
                                       style="display:none">
                                <span class="error"><?php echo $arrivalAirportErr; ?></span>

                            </div>
                            <br>
                            <input type="submit" class="btn" name="submit" value="Submit">
                        </div>
                    </form>
                    <?php
                    if (isset($_POST['submit'])) {
                        $stack = array();
                        array_push($stack, $departureAirportClean);
                        array_push($stack, $arrivalAirportClean);
                        array_push($stack, $dayClean);
                        array_push($stack, $monthClean);
                        array_push($stack, $yearClean);

                        if ($validForm) {
                            $submitted = true;
                        }
                    }

                    if ($validForm && $submitted) {
                        runQuery($departureAirportClean, $arrivalAirportClean, $dayClean, $monthClean, $yearClean);
                    }

                    $validForm = true;
                    $submitted = false;
                    $input = false;
                    ?>
                </div>
    </div>

</div> <!-- /container -->
<div class="container">
    <hr>
    <?php include("includes/footer.html"); ?>
</div>
</body>
</html>