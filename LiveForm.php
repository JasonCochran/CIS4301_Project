#!/usr/local/bin/php

<!-- Latest form. Live Queries in one page, conditional input, form validation, input sanitization, and SQL injection prevention in one -->
<!-- NOT FINISHED. Out of order. I'm working on a better one -->

<?php
	ini_set('display_errors', 1);
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

<!-- db stuff -->
<?php
	$validForm = true;
	$submitted = false;

	function runQuery($org, $dest) {
		$connection = oci_connect($username = 'oracleusername',
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
	// input variables that will be sanitized
	$flightDateClean = $tailNumClean = $flightNumClean = $originClean = $destClean = $schDepClean = $actualDepClean = $schArrClean = $actualArrClean = $distanceClean = "";

	// validates each variable
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$flightDateClean = test_input($_POST["flight-date-filter"]);
		$tailNumClean = test_input($_POST["tail-number-filter"]);
		/* tail number
		if (empty($_POST["tail-number-filter"])) {
			// if tail number is empty
			//$validForm = false;
			//$nameErr = "Origin is required";
		} else {
			$tailNumClean = test_input($_POST["tail-number-filter"]);

			if (!preg_match("/^[a-zA-Z0-9 ]*$/", $tailNumClean)) {
				$validForm = false;
				$nameErr = "Only alphanumeric characters accepted";
			}
		}
		*/
		$flightNumClean = test_input($_POST["flight-number-filter"]);
		/*
		if (empty($_POST["flight-number-filter"])) {
			$validForm = false;
			$flightNumErr = "Flight number not provided";
		}
		else {
			$flightNumClean = test_input($_POST["flight-number-filter"]);

			if (!preg_match('/^([0-9]+)$/', $flightNumClean)) {
				$validForm = false;
				$flightNumErr = "Only numbers accepted";
			}
		}
		*/

		// DONE - origin
		if (empty($_POST["origin-filter"])) {
			$validForm = false;
			$orgErr = "Origin is required";
		}
		else {
			$originClean = test_input($_POST["origin-filter"]);

			if (!preg_match("/^[a-zA-Z0-9 ]*$/", $originClean)) {
				$validForm = false;
				$orgErr = "Only alphanumeric characters accepted";
			}
		}

		// DONE - destination
		if (empty($_POST["destination-filter"])) {
			$validForm = false;
			$destErr = "Destination is required";
		}
		else {
			$destClean = test_input($_POST["destination-filter"]);

			if (!preg_match("/^[a-zA-Z0-9 ]*$/", $destClean)) {
				$validForm = false;
				$destErr = "Only alphanumeric characters accepted";
			}
		}

		$schDepClean = test_input($_POST["sch-dep-filter"]);
		$actualDepClean = test_input($_POST["actual-dep-filter"]);
		$schArrClean = test_input($_POST["sch-arr-filter"]);
		$actualArrClean = test_input($_POST["actual-arr-filter"]);
		$distanceClean = test_input($_POST["distance-filter"]);
		// DONE - distance
		/*
		if (empty($_POST["distance-filter"])) {
			// if distance is empty
			$validForm = false;
			$distanceErr = "Distance not provided";
		}
		else {
			$distanceClean = test_input($_POST["distance-filter"]);

			if (!preg_match('/^([0-9]+)$/', $distanceClean)) {
				$validForm = false;
				$distanceErr = "Only numbers accepted";
			}
		}
		*/
	}

	// helps prevent malicious HTML input
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	// check if form was submitted
	if(isset($_POST['submit'])) {

		/* 
		NOT USED ATM
		Simply prints the data that was input
		
		$message = "Data entered:" . "<br><br>";
		$message .= "Flight Date: " . $flightDateClean . "<br>";
		$message .= "Tail Number: " . $tailNumClean . "<br>";
		$message .= "Flight Number: " . $flightNumClean . "<br>";
		$message .= "Origin: " . $originClean . "<br>";
		$message .= "Destination: " . $destClean . "<br>";
		$message .= "Scheduled Departure: " . $schDepClean . "<br>";
		$message .= "Actual Departure: " . $actualDepClean . "<br>";
		$message .= "Scheduled Arrival: " . $schArrClean . "<br>";
		$message .= "Actual Arrival: " . $actualArrClean . "<br>";
		$message .= "Distance: " . $distanceClean . "<br>";

		*/

		// if the form is valid, then it can be submitted
		if($validForm) $submitted = true;
	}
?>

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

<h2>JetBlue Flight Browser</h2>
<p>Enter the origin and destination airport codes and see a sample of the 2016 JetBlue flights on your browser!</p>
<p><span class="error">* required field.</span></p>

<form method="post" action="">

	<p>Filter by:</p>

	<!-- Flight Date -->
	<input type="checkbox" name="filter[]" id="filter" value="Flight Date" onclick="displayCheck(this);">Flight Date
	<input type="text" id="Flight Date" name="flight-date-filter" style="display:none"><br>

	<!-- Tail Number -->
	<input type="checkbox" name="filter[]" id="filter" value="Tail Number" onclick="displayCheck(this);">Tail Number
	<input type="text" id="Tail Number" name="tail-number-filter" style="display:none">
	<br>

	<!-- Flight Number -->
	<input type="checkbox" name="filter[]" id="filter" value="Flight Number" onclick="displayCheck(this);">Flight Number
	<input type="text" id="Flight Number" name="flight-number-filter" style="display:none">
	<!-- < ?php if($flightNumSelected) echo "<span class=\"error\">" . "*" . $flightNumErr . "</span>"; ?> -->
	<br>

	<!-- Origin -->
	<input type="checkbox" name="filter[]" id="filter" value="Origin" onclick="displayCheck(this);">Origin
	<input type="text" id="Origin" name="origin-filter" style="display:none">
	<span class="error">* <?php echo $orgErr; ?></span>
	<!-- < ?php if($originSelected) echo "<span class=\"error\">" . "*" . $orgErr . "</span>"; ?> -->
	<br>

	<!-- Destination -->
	<input type="checkbox" name="filter[]" id="filter" value="Destination" onclick="displayCheck(this);">Destination
	<input type="text" id="Destination" name="destination-filter" style="display:none">
	<span class="error">* <?php echo $destErr; ?></span>
	<!-- < ?php if($destSelected) echo "<span class=\"error\">" . "*" . $destErr . "</span>"; ?> -->
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
	<!-- < ?php if($distanceSelected) echo "<span class=\"error\">" . "*" . $distanceErr . "</span>"; ?> -->
	<br>

	<br>
	<input type="submit" class="btn" name="submit" value="Submit">
	<br><br>  

	<?php 
		echo $message;

		// if form is valid and submit has been clicked, run the query
		if ($validForm && $submitted) {
			runQuery($originClean, $destClean);
		}
		$submitted = false;
	?>
</form>