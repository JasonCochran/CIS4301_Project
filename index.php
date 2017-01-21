<!DOCTYPE html>
<html lang="en">
<head>

  <title>Flight Thingy</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="index.css">
  <script src="scripts.js"></script>
  <!-- script element below must be in this html file -->
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAWuqrQ1kLDEAgyNHpAmcqxFVZtwHg7_28&callback=initMap">
  </script>

</head>
<body>
    <!-- Navbar --> 
    <div class="row">
        <div class="col-md-2">
            <img src="/assets/logo.jpeg" width="100%">
        </div>
        <div class="col-md-1">
            <h1>Flight Thingy</h1>
        </div>
    </div>
    
    <!-- Main content -->

    <div class="row">
        <div class="col-md-4">
            <!-- Search side bar -->
            <h3>Search Settings</h3>
                <form>
                     <div class="form-group">
                        <label for="carrierInput">Carrier:</label>
                        <select class="form-control" id="carrierInput">
                            <option>JetBlue</option>
                        </select>
                        
                        <div class="btn-group" role="group" aria-label="...">
                            <select class="form-control" id="monthInput">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                                <option>7</option>
                                <option>8</option>
                                <option>9</option>
                                <option>10</option>
                                <option>11</option>
                                <option>12</option>
                            </select>
                        </div>

                    </div>
                </form>
        </div>
        <div class="col-md-8">
            <!-- Map -->
            <div id="map"></div>
        </div>
    </div>

</body>
<footer>
    <div class="container">
        <div class="col-md-2">
            <h4> Flight Thingy </h4>
            <h6>2016 University of Florida</h6>
        </div>
        <div class="col-md-4 push-4">
            <h4>

            </h4>    
        </div>
    </div>
</footer>
</html>