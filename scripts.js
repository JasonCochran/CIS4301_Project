function initMap() {
  var uluru = {lat: -25.363, lng: 131.044};
  var gville = {lat: 29.648, lng: -82.344};

  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 6,
    center: gville
  });

  var marker = new google.maps.Marker({
    position: uluru,
    map: map
  });

  var marker2 = new google.maps.Marker({
    position: gville,
    map: map
  });
}