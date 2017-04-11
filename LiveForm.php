#!/usr/local/bin/php

<!-- testform2 (the dank one). Live Queries in one page, conditional input, form validation, input sanitization, and SQL injection prevention in one -->

<?php
	ini_set('display_errors', 1);
	$validForm = true;
	$submitted = false;
	$input = false;
	$numFilters = 0;
?>

<!-- db stuff -->
<?php
	function runQuery($org, $dest) {
		$connection = oci_connect($username = 'oraclepassword',
	                          $password = 'oraclepassword',
	                          $connection_string = '//oracle.cise.ufl.edu/orcl');

		$stid = oci_parse($connection,"SELECT * FROM flightscopy WHERE originairport=:org_bv AND destinationairport=:dest_bv");
		oci_bind_by_name($stid, ":org_bv", $org);
		oci_bind_by_name($stid, ":dest_bv", $dest);
		oci_execute($stid);

		echo "
			<table class='table table-hover'>
			<thead>
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
			</tr>
			</thead>
		";

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
		//oci_free_statement($statement);
		oci_free_statement($stid);
		oci_close($connection);
	}
?>

<!-- form validation -->
<?php
	// helps prevent malicious HTML input
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	// input variables that will be sanitized
	$flightDateClean = $tailNumClean = $flightNumClean = $originClean = $destClean = $schDepClean = $actualDepClean = $schArrClean = $actualArrClean = $distanceClean = "";

	// validates each variable
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$flightDateClean = test_input($_POST["flight-date-filter"]);

		// DONE - tail number
		$tailNumClean = test_input($_POST["tail-number-filter"]);
		if (!preg_match("/^[a-zA-Z0-9 ]*$/", $tailNumClean)) {
			$validForm = false;
			$tailNumErr = "Only alphanumeric characters accepted";
		}

		// DONE - flight number
		$flightNumClean = test_input($_POST["flight-number-filter"]);
		if (!is_numeric($flightNumClean) && !empty($flightNumClean)) {
			$validForm = false;
			$flightNumErr = "Only numbers accepted";
		}

		// DONE - origin
		$originClean = test_input($_POST["origin-filter"]);
		if (!preg_match("/^[a-zA-Z0-9 ]*$/", $originClean)) {
			$validForm = false;
			$orgErr = "Only alphanumeric characters accepted";
		}

		// DONE - destination
		$destClean = test_input($_POST["destination-filter"]);
		if (!preg_match("/^[a-zA-Z0-9 ]*$/", $destClean)) {
			$validForm = false;
			$destErr = "Only alphanumeric characters accepted";
		}

		// TO DO
		$schDepClean = test_input($_POST["sch-dep-filter"]);
		$actualDepClean = test_input($_POST["actual-dep-filter"]);
		$schArrClean = test_input($_POST["sch-arr-filter"]);
		$actualArrClean = test_input($_POST["actual-arr-filter"]);

		// DONE - distance
		$distanceClean = test_input($_POST["distance-filter"]);
		if (!is_numeric($distanceClean) && !empty($distanceClean)) {
			$validForm = false;
			$distanceErr = "Only numbers accepted";
		}
	}
?>

<html>
<head>
	<title>JetBlue Flight Browser</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- BootStrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
</html>

<style>
.error {color: #FF0000;}
</style>

<!-- If the checkbox is checked, it brings up a text field -->
<script type="text/javascript">
	function displayCheck(checkbox) {
		// get the name for the checkbox
		var name = checkbox.value;

		// if the box is now checked, display the hidden text field
		if (checkbox.checked) {
			document.getElementById(name).style.display='inline';
		}
		// else, hide it
		else {
			document.getElementById(name).style.display='none';
		}
	}
</script>

<h2>The Dank JetBlue Flight Browser</h2>
<p>You're not supposed to be here. This one is really experimental. Expect bugs and weird output.</p>
<p><span class="error">* required field.</span></p>

<form method="post" action="">

	<p>Filter by:</p>

	<!-- Flight Date -->
	<input type="checkbox" name="filter[]" id="filter" value="Flight Date" onclick="displayCheck(this);">Flight Date
	<input type="text" id="Flight Date" name="flight-date-filter" style="display:none"><br>

	<!-- Tail Number -->
	<input type="checkbox" name="filter[]" id="filter" value="Tail Number" onclick="displayCheck(this);">Tail Number
	<input type="text" id="Tail Number" name="tail-number-filter" style="display:none">
	<span class="error"><?php echo $tailNumErr; ?></span>
	<br>

	<!-- Flight Number -->
	<input type="checkbox" name="filter[]" id="filter" value="Flight Number" onclick="displayCheck(this);">Flight Number
	<input type="text" id="Flight Number" name="flight-number-filter" style="display:none">
	<span class="error"><?php echo $flightNumErr; ?></span>
	<br>

	<!-- Origin -->
	<input type="checkbox" name="filter[]" id="filter" value="Origin" onclick="displayCheck(this);">Origin
	<input type="text" id="Origin" name="origin-filter" style="display:none">
	<span class="error"> * <?php echo $orgErr; ?></span>
	<br>

	<!-- Destination -->
	<input type="checkbox" name="filter[]" id="filter" value="Destination" onclick="displayCheck(this);">Destination
	<input type="text" id="Destination" name="destination-filter" style="display:none">
	<span class="error"> * <?php echo $destErr; ?></span>
	<br>

	<!-- Scheduled Departure Time -->
	<input type="checkbox" name="filter[]" id="filter" value="Scheduled Departure Time" onclick="displayCheck(this);">Scheduled Departure Time
	<input type="text" id="Scheduled Departure Time" name="sch-dep-filter" style="display:none"><br>

	<!-- Actual Departure Time -->
	<input type="checkbox" name="filter[]" id="filter" value="Actual Departure Time" onclick="displayCheck(this);">Actual Departure Time
	<input type="text" id="Actual Departure Time" name="actual-dep-filter" style="display:none"><br>

	<!-- Scheduled Arrival Time -->
	<input type="checkbox" name="filter[]" id="filter" value="Scheduled Arrival Time" onclick="displayCheck(this);">Scheduled Arrival Time
	<input type="text" id="Scheduled Arrival Time" name="sch-arr-filter" style="display:none"><br>

	<!-- Actual Arrival Time -->
	<input type="checkbox" name="filter[]" id="filter" value="Actual Arrival Time" onclick="displayCheck(this);">Actual Arrival Time
	<input type="text" id="Actual Arrival Time" name="actual-arr-filter" style="display:none"><br>

	<!-- Distance -->
	<input type="checkbox" name="filter[]" id="filter" value="Distance" onclick="displayCheck(this);">Distance
	<input type="text" id="Distance" name="distance-filter" style="display:none">
	<span class="error"><?php echo $distanceErr; ?></span>
	<br>

	<br>
	<input type="submit" class="btn" name="submit" value="Submit">
	<br><br>  
</form>

<!-- After form has been submitted -->
<?php
	if(isset($_POST['submit'])) {

		$stack = array();
		array_push($stack, $flightDateClean);
		array_push($stack, $tailNumClean);
		array_push($stack, $flightNumClean);
		array_push($stack, $originClean);
		array_push($stack, $destClean);
		array_push($stack, $schDepClean);
		array_push($stack, $actualDepClean);
		array_push($stack, $schArrClean);
		array_push($stack, $actualArrClean);
		array_push($stack, $distanceClean);

		foreach ($stack as $value) {
			// if there's at least one input, we can submit the query
			if(!empty($value)) {
				$numFilters++;
				$input = true;
			}
			echo "value: " . $value . "<br>";
		}

		echo "total number of filters: " . $numFilters . "<br>";
		
		// if the form is valid, then it can be submitted
		if($validForm) {
			$submitted = true;
		}
	}
	

	// if form is valid and submit has been clicked, run the query
	if ($validForm && $submitted && $input) {
		echo "<br>" . "Running query!" . "<br>";
		runQuery($originClean, $destClean);
	}

	// reset form
	$validForm = true;
	$submitted = false;
	$input = false;
?>