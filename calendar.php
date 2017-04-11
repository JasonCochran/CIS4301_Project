#!/usr/local/bin/php

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->

<?php
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
                <div class="panel-heading">Calendar</div>
                <div class="panel-body">
                    <p>View delay information as a heatmap. Specify constraints below to further
                        refine the view displayed. </p>
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
                                    <input type="text" name="filter[]" id="filter" value="Departure Airport" onclick="displayCheck(this);">
                                    <input type="text" id="Departure Airport" name="tail-number-filter" style="display:none">
                                    <span class="error"><?php echo $departureAirportErr; ?></span>
                                    <span class="input-group-addon">-</span>
                                    <input type="text" name="filter[]" id="filter" value="Arrival Airport" onclick="displayCheck(this);">
                                    <input type="text" id="Arrival Airport" name="airport-airport-filter" style="display:none">
                                    <span class="error"><?php echo $tailNumErr; ?></span>
                                    <br>
                                    <!-- TODO fix box going outside bounder -->
                                </form>
                            </div>
                            <br>
                            <!-- TODO implement weather functionality later
                            <label>
                                <input type="checkbox" id="weatherBool"> Account for inclement weather
                            </label>
                            -->
                            <input type="submit" class="btn" name="submit" value="Submit">
                            <br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <h1 class="text-center">Calendar Placeholder</h1>
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
