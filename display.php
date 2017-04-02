#!/usr/local/bin/php

<a href="http://www.cise.ufl.edu/~josorio/flight/form.php" class="button">Try another search</a>
<br>
<p>If no flights are displayed for the codes you provided, JetBlue might not have flights for those cases. Or the data is wrong.
Remember this is experimental anyway.</p>

<?php

// used by form.php to display the data requested

// database connection
$connection = oci_connect($username = 'oracleusername',
                          $password = 'oraclepassword',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');

// gets the values that were passed in form.php
$org = $_POST['origin'];
$dest = $_POST['destination'];

// this is huge. Prevents SQL injection by binding variables that were passed in
$stid = oci_parse($connection,"SELECT * FROM flightscopy WHERE originairport=:org_bv AND destinationairport=:dest_bv");
oci_bind_by_name($stid, ":org_bv", $org);
oci_bind_by_name($stid, ":dest_bv", $dest);
oci_execute($stid);

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
while (($row = oci_fetch_object($stid))) {
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
oci_free_statement($stid);
oci_close($connection);

?>