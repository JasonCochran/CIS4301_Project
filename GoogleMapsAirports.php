#!/usr/local/bin/php

<?php
// Google maps element that plots all the markers specified in markers.xml
?>

<html lang="en">
<head>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<title>US Airports</title>
	<style>
		/* Always set the map height explicitly to define the size of the div
		* element that contains the map. */
		#map {
			height: 100%;
		}
		/* Optional: Makes the sample page fill the window. */
		html, body {
			height: 100%;
			margin: 0;
			padding: 0;
		}
	</style>
</head>

<body>
	<div id="map"></div>
	<script>
		// initializes the map
		function initMap() {
			var map = new google.maps.Map(document.getElementById('map'), {
				center: new google.maps.LatLng(29.648149, -82.344163),
				zoom: 8
			});

			var infoWindow = new google.maps.InfoWindow;

			// Assigns the information on the XML file to the respective Google Maps variables
			downloadUrl('http://www.cise.ufl.edu/~josorio/flight/markers.xml', function(data) {
				var xml = data.responseXML;
				var markers = xml.documentElement.getElementsByTagName('marker');

				// loop that iterates through all the markers and the XML file
				Array.prototype.forEach.call(markers, function(markerElem) {
					var name = markerElem.getAttribute('name');
					var address = markerElem.getAttribute('iata');
					var point = new google.maps.LatLng(
						parseFloat(markerElem.getAttribute('lat')),
						parseFloat(markerElem.getAttribute('lng'))
					);
					var city = markerElem.getAttribute('city');
					var state = markerElem.getAttribute('state');

					var infowincontent = document.createElement('div');
					var strong = document.createElement('strong');
					strong.textContent = name
					infowincontent.appendChild(strong);
					infowincontent.appendChild(document.createElement('br'));

					var text = document.createElement('text');
					text.textContent = address
					infowincontent.appendChild(text);
					infowincontent.appendChild(document.createElement('br'));

					var textCity = document.createElement('text');
					textCity.textContent = city
					infowincontent.appendChild(textCity);
					infowincontent.appendChild(document.createElement('br'));

					var textState = document.createElement('text');
					textState.textContent = state
					infowincontent.appendChild(textState);

					// Google maps marker declaration
					var marker = new google.maps.Marker({
						map: map,
						position: point,
					});

					// Google maps marker on click action
					marker.addListener('click', function() {
						infoWindow.setContent(infowincontent);
						infoWindow.open(map, marker);
					});
				});
				// end of array.prototype
			});
			// end of downloadUrl
		}
		// end of initmap

		// downloadUrl declaration. Used to access the XML file specified by the URL
		function downloadUrl(url, callback) {
			var request = window.ActiveXObject ?
			new ActiveXObject('Microsoft.XMLHTTP') :
			new XMLHttpRequest;

			request.onreadystatechange = function() {
				if (request.readyState == 4) {
					request.onreadystatechange = doNothing;
					callback(request, request.status);
				}
			};

			request.open('GET', url, true);
			request.send(null);
		}

		function doNothing() {}
	</script>

	<!-- Google Maps API Key -->
	<script async defer
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyANfbe_D_1Fh2xmkCVrnMGfcZRNj21IaY0&callback=initMap">
	</script>
</body>
</html>
