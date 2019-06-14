jQuery(document).ready(function ($) {


    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 12,
        center: new google.maps.LatLng(39.766193, 30.526714),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    var infowindow = new google.maps.InfoWindow();
    var marker, i;

    var locations = [];
    var adress = [];
    var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    function geocode(street) {

        axios.get('https://maps.googleapis.com/maps/api/geocode/json', {
            params: {
                address: street+' eskişehir',
                key: 'AIzaSyDu3XI2eEIWtcB5NYjIw0L0aTZ8VhRRObc'
            }
        })
            .then(function (response) {
                // Formatted Address
                var formattedAddress = response.data.results[0].formatted_address;
                var lat = response.data.results[0].geometry.location.lat;
                var lng = response.data.results[0].geometry.location.lng;
                console.log("latlong",formattedAddress,lat,lng);
                marker = new google.maps.Marker({

                    position: new google.maps.LatLng(lat,lng),
                    label: labels[i % labels.length],
                    map: map
                });
                var markers = locations.map(function(latitude,longtitude, i) {
                    return new google.maps.Marker({
                        position: location,
                        label: labels[i % labels.length]
                    });
                });
                google.maps.event.addListener(marker, 'click', (function (marker) {
                    return function () {
                        infowindow.setContent(formattedAddress);
                        infowindow.open(map, marker);
                    }
                })(marker, i));

            })
            .catch(function (error) {
                console.log(error);
            });

    }

    //Street İnfo
    var streetArr = [];
    var oReq = new XMLHttpRequest(); //New request object
    oReq.onload = function () {
        //This is where you handle what to do with the response.
        //The actual data is found on this.responseText
        var json = JSON.parse(this.responseText);
        //console.log("deneme", json, json.length);
        streetInfo(json, json.length);
    };
    console.log('LOC ve ADRESS ', locations,adress);

    oReq.open("get", "/sheet/jsonparse", true);
    oReq.send();

    function streetInfo(item, length) {
        console.log("testStreet", item, length);
        for (let i = 0; i < length; i++) {
            streetArr.push(item[i]['sokak'])
            geocode(item[i]['sokak']);
        }
    }


});
