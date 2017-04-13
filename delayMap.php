#!/usr/local/bin/php

<html>
<?php include("includes/header.php"); ?>
<?php include("includes/solid_navbar.html"); ?>
<head>

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

    $query = oci_parse($connection, "SELECT STATE, COUNT(*) AS AIRPORTSTOTAL FROM AIRPORTS GROUP BY STATE");
    oci_execute($query);

    $rows = array();
    $table = array();
    $table['cols'] = array( array('label' => 'State', 'type' => 'string'),
    array('label' => 'Delay %', 'type' => 'number') );

$rows = array();
while ($r = oci_fetch_array($query, OCI_ASSOC + OCI_RETURN_NULLS)) {
    $temp = array();
//The below col names have to be in upper caps.
    // echo $r["STATE"];
    $temp[] = array('v' => (string)$r["STATE"]);

$temp[] = array('v' => (int)$r["AIRPORTSTOTAL"]);
$rows[] = array('c' => $temp);
}

$table['rows'] = $rows;
$jsonTable = json_encode($table);

    ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['geochart']});
        google.charts.setOnLoadCallback(drawRegionsMap);



        function drawRegionsMap() {
            var data = new google.visualization.DataTable(<?=$jsonTable?>);

            var options = {
                region: 'US',
                resolution: 'provinces',
                colorAxis: {colors: ['#C7FFAD', '#015FB2']},
                backgroundColor: 'white',
                datalessRegionColor: '#C7FFAD',
                defaultColor: '#f5f5f5',
            };

            var chart = new google.visualization.GeoChart(document.getElementById('geochart-colors'));
            chart.draw(data, options);
        };
    </script>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-lg-5">
            <div class="panel panel-default">
                <div class="panel-heading">Map of Delays</div>
                <div class="panel-body">
                    View all of the delays in a heatmap across the United States. This table allows you to visualize
                    how delays change across the country. Additionally,
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div id="geochart-colors" style="width: 700px; height: 433px;"></div>
        </div>
    </div>
</div>
</div>
<div class="container">
    <?php include("includes/footer.html"); ?>
</body>
</html>
