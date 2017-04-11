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

include('globalVariables.php');

$connection = oci_connect($username = $GLOBALS['username'],
    $password = $GLOBALS['password'],
    $connection_string = '//oracle.cise.ufl.edu/orcl');

// TODO write the query for this
$statement = oci_parse($connection, 'QUERYHERE');
oci_bind_by_name($statement, ":day_dv", $dayClean);
oci_bind_by_name($statement, ":month_bv", $monthClean);
oci_bind_by_name($statement, ":year_bv", $yearClean);
oci_execute($statement);

$calendarDelays = oci_fetch_array($statement);

oci_free_statement($statement);
oci_close($connection);

?>

<?php include("includes/header.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$monthClean = $dayClean = $yearClean = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $monthClean = test_input($_POST["month-filter"]);
    if (!preg_match("/^[0-9]*$/", $monthClean)) {
        $validForm = false;
        $monthErr = "Only numeric characters accepted";
    }

    $dayClean = test_input($_POST["day-filter"]);
    if (!preg_match("/^[0-9]*$/", $dayClean)) {
        $validForm = false;
        $dayErr = "Only numeric characters accepted";
    }

    $yearClean = test_input($_POST["year-filter"]);
    if (!preg_match("/^[0-9]*$/", $yearClean)) {
        $validForm = false;
        $yearErr = "Only numeric characters accepted";
    }
}

?>

<body>

<div class="container">
    <!-- Example row of columns -->
    <div class="row">
        <div class="col-md-4">

            <div class="panel panel-default">
                <div class="panel-heading">Search Settings</div>
                <div class="panel-body">
                    <form>
                        <div class="form-group">
                            <br>
                            <label for="carrierInput">Departure Date:</label>
                            <div class="input-group">

                                <input type="text" class="form-control" name="filter[]" id="filter" value="Month" onclick="displayCheck(this);">
                                <input type="text" id="Month" name="Month-filter" style="display:none">
                                <span class="error"><?php echo $monthErr; ?></span>

                                <span class="input-group-addon">-</span>

                                <input type="text" class="form-control" name="filter[]" id="filter" value="Day" onclick="displayCheck(this);">
                                <input type="text" id="Day" name="Day-filter" style="display:none">
                                <span class="error"><?php echo $dayErr; ?></span>

                                <span class="input-group-addon">-</span>

                                <input type="text" class="form-control" name="filter[]" id="filter" value="Year" onclick="displayCheck(this);">
                                <input type="text" id="Year" name="Year-filter" style="display:none">
                                <span class="error"><?php echo $yearErr; ?></span>
                            </div>
                            <br>
                            <label for="carrierInput">Airport Departure and Arrival:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Departure Airport" id="departure"/>
                                <span class="input-group-addon">-</span>
                                <input type="text" class="form-control" placeholder="Arrival Airport" id="airport"/>
                            </div>
                            <br>
                            <label>
                                <input type="checkbox" id="weatherBool"> Account for inclement weather
                            </label>
                            <br>
                            <input type="submit" class="btn" name="submit" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row">
                <p>The query return itself</p>
            </div>
            <div class="row">
                <p>Some random information about the query</p>
            </div>
        </div>
    </div>

    <hr>

</div> <!-- /container -->

<?php include("includes/footer.html"); ?>

</body>
</html>
