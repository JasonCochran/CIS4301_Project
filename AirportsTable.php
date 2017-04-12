#!/usr/local/bin/php

<html>
<head>
	<title>JetBlue Flight Browser</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
</html>

<?php


include('globalVariables.php');

$connection = oci_connect($username = $GLOBALS['username'],
    $password = $GLOBALS['password'],
    $connection_string = '//oracle.cise.ufl.edu/orcl');

	$statement = oci_parse($connection, 'SELECT * FROM airports');
	oci_execute($statement);

	// HTML Table declaration
	echo "
		<table class='table table-hover'>
		<thead>
		<tr>
		<th>IATA</th>
		<th>Airport Name</th>
		<th>City</th>
		<th>State</th>
		<th>Latitude</th>
		<th>Longitude</th>
		</tr>
		</thead>
	";

	// get data from table and format it on the table
	while (($row = oci_fetch_object($statement))) {
		echo "<tr>";
		echo "<td>" . $row->IATA . "</td>";
		echo "<td>" . $row->AIRPORTNAME . "</td>";
		echo "<td>" . $row->CITY . "</td>";
		echo "<td>" . $row->STATE . "</td>";
		echo "<td>" . $row->LATITUDE . "</td>";
		echo "<td>" . $row->LONGITUDE . "</td>";
		echo "</tr>";
	}
	echo "</table>";

	// close Oracle database connection and free statements
	oci_free_statement($statement);
	oci_close($connection);
?>