#!/usr/local/bin/php

<?php

// another example of pulling info from database

// database connection
$connection = oci_connect($username = 'oracleusername',
                          $password = 'oraclepassword',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');

$statement = oci_parse($connection, 'SELECT * FROM airports');
oci_execute($statement);

// HTML Table declaration
echo "
<table border=1>
<tr>
<th>IATA</th>
<th>Airport Name</th>
<th>City</th>
<th>State</th>
<th>Latitude</th>
<th>Longitude</th>
</tr>";

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

// finish table
echo "</table>";

// close Oracle database connection and free statements
oci_free_statement($statement);
oci_close($connection);

?>