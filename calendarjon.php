#!/usr/local/bin/php

<?php
	include('globalVariables.php');
	ini_set('display_errors', 1);
	$validForm = true;
	$submitted = false;
	$input = false;
	$numFilters = 0;
?>

<!-- db stuff -->
<?php
	$connection = oci_connect($username = $GLOBALS['username'], $password = $GLOBALS['password'], $connection_string = '//oracle.cise.ufl.edu/orcl');

	$monsterQuery = "SELECT t2.FLIGHTDATE,
	 coalesce(t1.numberOfCanceledFlights, 0) AS NumberOfCanceledFlights,
	 t2.TotalNumberOfFlightsPerDay AS TotalNumberOfFlightsPerDay,
	 coalesce((100 * numberOfCanceledFlights/TotalNumberOfFlightsPerDay), 0) AS percentDelayed
	FROM
	 (SELECT FLIGHTS.FLIGHTDATE, count(*) AS numberOfCanceledFlights
		FROM CANCELLATIONS, FLIGHTS
		WHERE FLIGHTS.FLIGHTNUMBER = CANCELLATIONS.FLIGHTNUMBER
			  AND FLIGHTS.FLIGHTDATE = CANCELLATIONS.FLIGHTDATE
			  AND FLIGHTS.ORIGINAIRPORT = 'BDL'
			  AND FLIGHTS.DESTINATIONAIRPORT = 'MCO'
			  AND EXTRACT(MONTH FROM Flights.FLIGHTDATE) = '1'
		   GROUP BY FLIGHTS.FLIGHTDATE) t1
	   RIGHT OUTER JOIN
	   (SELECT FLIGHTS.FLIGHTDATE, count(*) AS TotalNumberOfFlightsPerDay
		FROM FLIGHTS
		WHERE EXTRACT(MONTH FROM Flights.FLIGHTDATE) = '1'
			  AND FLIGHTS.ORIGINAIRPORT = 'BDL'
			  AND FLIGHTS.DESTINATIONAIRPORT = 'MCO'
		   GROUP BY FLIGHTS.FLIGHTDATE) t2
	   ON t1.FLIGHTDATE = t2.FLIGHTDATE 
	 ORDER BY t2.FLIGHTDATE ASC;
	 ";

	$statement = oci_parse($connection, $monsterQuery);

	oci_execute($statement);

	// output result as a table
	echo "
		<table class='table table-hover'>
		<thead>
		<tr>
		<th>Date</th>
		<th>Num of Cancelled Flights</th>
		<th>Total Flights per Day</th>
		<th>Percent Delayed</th>
		</tr>
		</thead>
		<tbody class='list'>
	";

	while (($row = oci_fetch_object($statement))) {
		echo "<tr>";
		echo "<td>" . $row->FLIGHTDATE . "</td>";
		echo "<td>" . $row->NUMBEROFCANCELEDFLIGHTS . "</td>";
		echo "<td>" . $row->TOTALNUMBEROFFLIGHTSPERDAY . "</td>";
		echo "<td>" . $row->PERCENTDELAYED . "</td>";
		echo "</tr>";
	}

	echo "
		</tbody>
		</table>
	";

	oci_free_statement($statement);
	oci_close($connection);
?>

<?php
	//include("includes/header.php");
	//include("includes/solid_navbar.html");
	//include("includes/footer.html");
?>