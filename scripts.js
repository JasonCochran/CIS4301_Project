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

$(".dropdown-menu li a").click(function(){
  $(this).parents(".dropdown").find('.btn').html($(this).text() + ' <span class="caret"></span>');
  $(this).parents(".dropdown").find('.btn').val($(this).data('value'));
});