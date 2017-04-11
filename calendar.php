#!/usr/local/bin/php

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->

<?php

include('globalVariables.php');

$connection = oci_connect($username = $GLOBALS['username'],
    $password = $GLOBALS['password'],
    $connection_string = '//oracle.cise.ufl.edu/orcl');

// TODO write query for this
$statement = oci_parse($connection, 'queryHere');
oci_bind_by_name($statement, ":month_dv", $monthClean);
oci_bind_by_name($statement, ":arrivalAirport_dv", $arrivalAirportClean);
oci_bind_by_name($statement, ":departureAirport_dv", $departureAirportClean);
oci_execute($statement);

$calendarDelays = oci_fetch_array($statement);

oci_free_statement($statement);
oci_close($connection);

ini_set('display_errors', 1);
$validForm = true;
$submitted = false;
$input = false;
$numFilters = 0;
?>

<?php include("includes/header.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

 $departureAirportClean = $monthClean = $arrivalAirportClean = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $departureAirportClean = test_input($_POST["departure-airport-filter"]);
    if (!preg_match("/^[a-zA-Z ]*$/", $departureAirportClean)) {
        $validForm = false;
        $departureAirportErr = "Only alphanumeric characters accepted";
    }

    $arrivalAirportClean = test_input($_POST["arrival-airport-filter"]);
    if (!preg_match("/^[a-zA-Z0-9 ]*$/", $arrivalAirportClean)) {
        $validForm = false;
        $arrivalAirportErr = "Only alphanumeric characters accepted";
    }

    $monthClean = test_input($_POST["month-filter"]);
    if (!preg_match("/^[a-zA-Z ]*$/", $monthClean)) {
        $validForm = false;
        $monthErr = "Only alphanumeric characters accepted";
    }
}
?>

<body>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p>Input a month to view how delay times change over the month.  </p>
                    <form>
                        <div class="form-group">
                            <input type="month" name="filter[]" id="filter" value="Month" onclick="displayCheck(this);">
                            <input type="month" id="Month" name="month-filter" style="display:none">
                            <span class="error"><?php echo $monthErr; ?></span>

                            </select>
                            <br>
                            <label for="carrierInput">Airport Departure and Arrival:</label>
                            <div class="input-group">
                                <form method="post" action="">
                                    <input type="text" class="form-control" name="filter[]" id="filter" value="Departure Airport" onclick="displayCheck(this);">
                                    <input type="text" id="Departure Airport" name="departure-airport-filter" style="display:none">
                                    <span class="error"><?php echo $departureAirportErr; ?></span>
                                    <span class="input-group-addon">-</span>
                                    <input type="text" class="form-control" name="filter[]" id="filter" value="Arrival Airport" onclick="displayCheck(this);">
                                    <input type="text" id="Arrival Airport" name="arrival-airport-filter" style="display:none">
                                    <span class="error"><?php echo $arrivalAirportErr; ?></span>
                                </form>
                            </div>
                            <br>
                            <input type="submit" class="btn" name="submit" value="Submit">
                            <br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <h1 class="text-center">Monthly Heatmap of Flight Delays</h1>
            <table class="table table-bordered">
                <tr>
                    <th>Sat.</th>
                    <th>Mon.</th>
                    <th>Tues.</th>
                    <th>Wed.</th>
                    <th>Thur.</th>
                    <th>Fri.</th>
                    <th>Sun.</th>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>

    <hr>

</div> <!-- /container -->

<?php include("includes/footer.html"); ?>

</body>
</html>
