#!/usr/local/bin/php

<!DOCTYPE HTML>
<html lang="en">

<?php include("includes/header.php"); ?>
<?php include("includes/navbar.html"); ?>

<head>
	<title>JetBlue Delay Predictor</title>
	<!-- Color Chrome Nav Bar -->
	<meta name="theme-color" content="#3B4163"/>
</head>
<body>
	<header>
		<h1 id="header-title">JetBlue Delay Predictor</h1>
		<h2 id="header-subtitle">Never be late to your next destination.</h2>
	</header>

	<div id="home-page-content">

		<!-- Marketing messaging -->
		<div class="container marketing">

			<!-- Three columns of text below the carousel -->
			<div class="row">
			<div class="col-lg-4">
				<img src="http://www.cise.ufl.edu/~josorio/flight/assets/stats.svg" alt="Stats image" width="140" height="140">
				<h2>Dataset</h2>
				<p>Using flight data provided by the Bureau of Transportation Statistics, our predictor can compare your next flight against previous records to give you an estimate on how likely your flight is to be delayed.</p>
			</div><!-- /.col-lg-4 -->
			<div class="col-lg-4">
				<img src="http://www.cise.ufl.edu/~josorio/flight/assets/database.svg" alt="Database image" width="140" height="140">
				<h2>Database</h2>
				<p>Through the Oracle Database, our predictor can quickly lookup and retrieve the information requested, letting you not only save time on your next flight, but also while you're here.</p>
			</div><!-- /.col-lg-4 -->
			<div class="col-lg-4">
				<img src="http://www.cise.ufl.edu/~josorio/flight/assets/programmer.svg" alt="Programming" width="140" height="140">
				<h2>Programming</h2>
				<p>Built with the best web programming tools available, including PHP, HTML5, CSS3, Bootstrap, and jQuery.</p>
			</div><!-- /.col-lg-4 -->
			</div><!-- /.row -->

		  <!-- START THE FEATURETTES -->
		  <hr class="featurette-divider">

			<div class="row featurette">
			<div class="col-md-7">
				<h2 class="featurette-heading">Flight Delay Predictor.<span class="text-muted"> It'll blow your mind.</span></h2>
				<p class="lead">Simply input some details about your next flight with JetBlue and get an instant delay prediction.</p>
			</div>
			<div class="col-md-5">
				<!-- <img class="featurette-image img-responsive center-block" src="http://www.cise.ufl.edu/~josorio/flight/assets/travel.svg" alt="Travel image"> -->
				<img class="featurette-image img-responsive center-block" src="http://www.cise.ufl.edu/~josorio/flight/assets/travel.svg" alt="Travel image" width="250" height="250">
			</div>
			</div>

			<hr class="featurette-divider">

			<div class="row featurette">
			<div class="col-md-7 col-md-push-5">
				<h2 class="featurette-heading">Calendar of Delays.<span class="text-muted"> Skip that delay!.</span></h2>
				<p class="lead">See all the possible delays of the month with this tool. It's that easy.</p>
			</div>
			<div class="col-md-5 col-md-pull-7">
				<img class="featurette-image img-responsive center-block" src="http://www.cise.ufl.edu/~josorio/flight/assets/weekly-calendar.svg" alt="Weekly calendar image" width="250" height="250">
			</div>
			</div>

		  <hr class="featurette-divider">

			<div class="row featurette">
			<div class="col-md-7">
				<h2 class="featurette-heading">See the stats for yourself.<span class="text-muted"> For those that like data.</span></h2>
				<p class="lead">With our data browser, see the data we're using yourself on your browser!</p>
			</div>
			<div class="col-md-5">
				<img class="featurette-image img-responsive center-block" src="http://www.cise.ufl.edu/~josorio/flight/assets/browser.svg" alt="Browser image" width="250" height="250">
			</div>
			</div>

		  <hr class="featurette-divider">

		  <!-- /END THE FEATURETTES -->

		<div class="p-container">
			<?php include("includes/footer.html"); ?>
		</div>
	</div>
</body>
</html>