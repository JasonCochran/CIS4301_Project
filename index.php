#!/usr/local/bin/php

<!DOCTYPE HTML>
<html lang="en">

<?php include("includes/header.php"); ?>
<?php include("includes/navbar.html"); ?>

<head>
	<title>JetBlue Delay Predictor</title>
	<meta name="theme-color" content="#3B4163"/>
</head>
<body>
	<header>
		<h1 id="header-title">JetBlue Delay Predictor</h1>
		<h2 id="header-subtitle">Never be late to your next destination</h2>
	</header>

	<div id="home-page-content">

		<div class="container marketing">

			<div class="row">
			<div class="col-lg-4">
				<img src="http://www.cise.ufl.edu/~josorio/flight/assets/stats.svg" alt="Stats image" width="140" height="140">
				<h2>Data</h2>
				<p>Using historical flight data provided by the Bureau of Transportation Statistics, our predictor can determine how likely it is that your next JetBlue flight will be delayed.</p>
			</div>
			<div class="col-lg-4">
				<img src="http://www.cise.ufl.edu/~josorio/flight/assets/database.svg" alt="Database image" width="140" height="140">
				<h2>Database</h2>
				<p>With the Oracle Database, our predictor can quickly lookup and retrieve the information requested, saving you valuable research and travel time.</p>
			</div>
			<div class="col-lg-4">
				<img src="http://www.cise.ufl.edu/~josorio/flight/assets/programmer.svg" alt="Programming" width="140" height="140">
				<h2>Programming</h2>
				<p>Built with the best web programming and markup tools available, including PHP, HTML5, CSS3, Bootstrap, and jQuery.</p>
			</div>
			</div>

		  <hr class="featurette-divider">

			<div class="row featurette">
			<div class="col-md-7">
				<h2 class="featurette-heading">Predict the future.<span class="text-muted"> Skip the wait.</span></h2>
				<p class="lead">Simply input some details about your next flight with JetBlue and get an instant delay prediction.</p>
			</div>
			<div class="col-md-5">
				<img class="featurette-image img-responsive center-block" src="http://www.cise.ufl.edu/~josorio/flight/assets/travel.svg" alt="Travel image" width="250" height="250">
			</div>
			</div>

			<hr class="featurette-divider">

			<div class="row featurette">
			<div class="col-md-7 col-md-push-5">
				<h2 class="featurette-heading">Delay Calendar.<span class="text-muted"> Not anymore!</span></h2>
				<p class="lead">See how the delays change over a month. Now you know what days are bad for travel.</p>
			</div>
			<div class="col-md-5 col-md-pull-7">
				<img class="featurette-image img-responsive center-block" src="http://www.cise.ufl.edu/~josorio/flight/assets/weekly-calendar.svg" alt="Weekly calendar image" width="250" height="250">
			</div>
			</div>

		  <hr class="featurette-divider">

			<div class="row featurette">
			<div class="col-md-7">
				<h2 class="featurette-heading">Stats.<span class="text-muted"> For those that like data.</span></h2>
				<p class="lead">With our custom search tool, you can check out the data we're using on your own browser.</p>
			</div>
			<div class="col-md-5">
				<img class="featurette-image img-responsive center-block" src="http://www.cise.ufl.edu/~josorio/flight/assets/browser.svg" alt="Browser image" width="250" height="250">
			</div>
			</div>

		  <hr class="featurette-divider">

		<div class="p-container">
			<?php include("includes/footer.html"); ?>
		</div>
	</div>
</body>
</html>