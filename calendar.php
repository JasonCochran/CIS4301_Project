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
            <div class="panel panel-default">
                <div class="panel-heading">Calendar</div>
                <div class="panel-body">
                    <p>View delay information as a heatmap. Specify constraints below to further
                        refine the view displayed. </p>
                    <form>
                        <div class="form-group">
                            <label for="carrierInput">Carrier:</label>
                            <select class="form-control" id="carrierInput">
                                <option>JetBlue</option>
                            </select>
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
