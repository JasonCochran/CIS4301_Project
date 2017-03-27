#!/usr/local/bin/php

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->

<?php include("includes/header.html"); ?>

<body>

<div class="container">
    <!-- Example row of columns -->
    <div class="row">
        <div class="col-md-4">
            <!-- Search side bar -->
            <h3>Search Settings</h3>
            <form>
                <div class="form-group">
                    <label for="carrierInput">Carrier:</label>
                    <select class="form-control" id="carrierInput">
                        <option>JetBlue</option>
                    </select>
                    <br>
                    <label for="carrierInput">Departure Date:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Month" id="month"/>
                        <span class="input-group-addon">-</span>
                        <input type="text" class="form-control" placeholder="Day" id="day"/>
                        <span class="input-group-addon">-</span>
                        <input type="text" class="form-control" placeholder="Year" id="year"/>
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

                </div>
            </form>
        </div>
        <div class="col-md-8">
            <h2> There is a ___% chance your flight will be delayed. </h2>
        </div>
    </div>

    <hr>

</div> <!-- /container -->

<?php include("includes/footer.html"); ?>

</body>
</html>
