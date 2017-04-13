#!/usr/local/bin/php

<!doctype html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang=""> <!--<![endif]-->

<?php include("includes/header.php"); ?>
<?php include("includes/solid_navbar.html"); ?>

<body>

<div class="container">
    <!-- Example row of columns -->
    <div class="row">
        <h4>View live delay information. All activities are updated when new information
        is laoded into the database.</h4>

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Most Delayed Airports</div>
                <div class="panel-body">
                    <?php
						$connection = oci_connect($username = 'oraclepassword', $password = 'oraclepassword', $connection_string = '//oracle.cise.ufl.edu/orcl');

						$connection = oracle_startup();
						$stid = oci_parse($connection, "SELECT airportName FROM ((SELECT originAirport, AVG(TO_NUMBER(TO_CHAR(deptTimeActual, 'DD-MON-YYYY HH24:MI:SS')) - TO_NUMBER(TO_CHAR(deptTimeScheduled, 'DD-MON-YYYY HH24:MI:SS'))) AS Delay FROM flights) JOIN airports)");
						oci_execute($stid);
                    	for($i=1; $i<=3; $i++) {
                            $airport = oci_fetch_object($stid);
                            echo "<li>" . $airport["airportName"] . "</li>"
                    	}
                    ?>
                </div>
            </div>
        </div>

    </div>

    <hr>

</div> <!-- /container -->

<?php include("includes/footer.html"); ?>

</body>
</html>
