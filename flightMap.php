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

    // write your SQL query here (you may use parameters from $_GET or $_POST if you need them)
    $query = oci_parse($connection, "SELECT * FROM AIRPORTS" );

    $table = array();
    $table['cols'] = array(
        /* define your DataTable columns here
        * each column gets its own array
        * syntax of the arrays is:
        * label => column label
        * type => data type of column (string, number, date, datetime, boolean)
        */
        array('label' => 'Label of column 1', 'type' => 'string'),
        array('label' => 'Label of column 2', 'type' => 'number'),
        array('label' => 'Label of column 3', 'type' => 'number')
        // etc...
    );

    $rows = array();
    while($r = oci_fetch_row($query)) {
        $temp = array();
        // each column needs to have data inserted via the $temp array
        $temp[] = array('v' => $r['column1']);
        $temp[] = array('v' => $r['column2']);
        $temp[] = array('v' => $r['column3']);
        // etc...

        // insert the temp array into $rows
        $rows[] = array('c' => $temp);
    }

    oci_free_statement($query);
    oci_close($connection);

    // populate the table with rows of data
    $table['rows'] = $rows;

    // encode the table as JSON
    $jsonTable = json_encode($table);

    // return the JSON data
    echo $jsonTable;
    ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['geochart']});
        google.charts.setOnLoadCallback(drawRegionsMap);

        function drawRegionsMap() {
            var data = google.visualization.arrayToDataTable([
                ['Country',   'Latitude'],
                ['Algeria', 36], ['Angola', -8], ['Benin', 6], ['Botswana', -24],
                ['Burkina Faso', 12], ['Burundi', -3], ['Cameroon', 3],
                ['Canary Islands', 28], ['Cape Verde', 15],
                ['Central African Republic', 4], ['Ceuta', 35], ['Chad', 12],
                ['Comoros', -12], ['Cote d\'Ivoire', 6],
                ['Democratic Republic of the Congo', -3], ['Djibouti', 12],
                ['Egypt', 26], ['Equatorial Guinea', 3], ['Eritrea', 15],
                ['Ethiopia', 9], ['Gabon', 0], ['Gambia', 13], ['Ghana', 5],
                ['Guinea', 10], ['Guinea-Bissau', 12], ['Kenya', -1],
                ['Lesotho', -29], ['Liberia', 6], ['Libya', 32], ['Madagascar', null],
                ['Madeira', 33], ['Malawi', -14], ['Mali', 12], ['Mauritania', 18],
                ['Mauritius', -20], ['Mayotte', -13], ['Melilla', 35],
                ['Morocco', 32], ['Mozambique', -25], ['Namibia', -22],
                ['Niger', 14], ['Nigeria', 8], ['Republic of the Congo', -1],
                ['Réunion', -21], ['Rwanda', -2], ['Saint Helena', -16],
                ['São Tomé and Principe', 0], ['Senegal', 15],
                ['Seychelles', -5], ['Sierra Leone', 8], ['Somalia', 2],
                ['Sudan', 15], ['South Africa', -30], ['South Sudan', 5],
                ['Swaziland', -26], ['Tanzania', -6], ['Togo', 6], ['Tunisia', 34],
                ['Uganda', 1], ['Western Sahara', 25], ['Zambia', -15],
                ['Zimbabwe', -18]
            ]);

            var options = {
                region: 'US', // USA
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
                    View all of the delays in a heatmap across the United States.
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
