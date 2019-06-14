jQuery(document).ready(function($) {
   var locations = [
     ['Bondi Beach', 39.766193,30.526714, 4],
     ['Coogee Beach', 39.76422,30.53234, 5],
     ['Cronulla Beach', 39.734,30.566332, 3],
     ['Manly Beach', 39.76661, 30.5532, 2],
     ['Maroubra Beach', 39.711123,30.52234, 1],
     ['Maroubra Beach', 39.7223,30.53, 0],
     ['Maroubra Beach', 39.71233,30.5323, 6],

   ];

   var map = new google.maps.Map(document.getElementById('map'), {
     zoom: 12,
     center: new google.maps.LatLng(39.766193,30.526714),
     mapTypeId: google.maps.MapTypeId.ROADMAP
   });

   var infowindow = new google.maps.InfoWindow();

   var marker, i;

   for (i = 0; i < locations.length; i++) {
     marker = new google.maps.Marker({

       position: new google.maps.LatLng(locations[i][1], locations[i][2]),
       map: map
     });

     google.maps.event.addListener(marker, 'click', (function(marker, i) {
       return function() {
         infowindow.setContent(locations[i][0]);
         infowindow.open(map, marker);
       }
     })(marker, i));
   }

   } )
