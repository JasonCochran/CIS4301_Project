#!/usr/local/bin/php


<?php

// displays some information from the flights table
// please keep in mind you have to have that table in your acct for this to work

// database connection
$connection = oci_connect($username = 'oracleusername',
                          $password = 'oraclepassword',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');

$statement = oci_parse($connection, "SELECT * FROM flights WHERE ORIGINAIRPORT='MCO' ");
oci_execute($statement);

// HTML Table declaration
echo "
<table border=1>
<tr>
<th>Flight Date</th>
<th>Tail #</th>
<th>Flight #</th>
<th>Origin</th>
<th>Destination</th>
<th>Sched Dep Time</th>
<th>Actual Dep Time</th>
<th>Sched Arr Time</th>
<th>Actual Arr Time</th>
<th>Distance</th>
</tr>";

// get data from table and format it on the table
while (($row = oci_fetch_object($statement))) {
	echo "<tr>";
	echo "<td>" . $row->FLIGHTDATE . "</td>";
	echo "<td>" . $row->TAILNUMBER . "</td>";
	echo "<td>" . $row->FLIGHTNUMBER . "</td>";
	echo "<td>" . $row->ORIGINAIRPORT . "</td>";
	echo "<td>" . $row->DESTINATIONAIRPORT . "</td>";
	echo "<td>" . $row->DEPTTIMESCHEDULED . "</td>";
	echo "<td>" . $row->DEPTTIMEACTUAL . "</td>";
	echo "<td>" . $row->ARRTIMESCHEDULED . "</td>";
	echo "<td>" . $row->ARRTIMEACTUAL . "</td>";
	echo "<td>" . $row->DISTANCE . "</td>";
	echo "</tr>";
}

// finish table
echo "</table>";

// close Oracle database connection and free statements
oci_free_statement($statement);
oci_close($connection);

?>