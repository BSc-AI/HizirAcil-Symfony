jQuery(document).ready(function ($) {
    function initialize() {

        var lat,lng,fm,str,mah;

        var markers = [];
        $.ajax({
            url: '/sheet/jsonparse',
            type: 'Get',
            dataType: "JSON",
            processData: false,
            contentType: false,
            success: function (data, status) {

                console.time('Yavaslik Testi');
                for (let i = 0; i < data.length; i++) {

                    //console.log("", data[i]['sokak']);
                    axios.get('https://maps.googleapis.com/maps/api/geocode/json', {
                        params: {
                            address: data[i]['sokak'] + 'Sokak Eskişehir',
                            key: 'AIzaSyDu3XI2eEIWtcB5NYjIw0L0aTZ8VhRRObc'
                        }
                    })
                        .then(function (response) {
                            // Formatted Address
                            fm = response.data.results[0].formatted_address;
                            lat = response.data.results[0].geometry.location.lat;
                            lng = response.data.results[0].geometry.location.lng;
                            str = response.data.results[0].address_components[0].long_name;
                            mah = response.data.results[0].address_components[1].long_name;

                            console.table([[lat,lng], [fm], [str],[mah]]);

                        })
                        .catch(function (error) {
                            console.log(error);
                        });

                }
                console.timeEnd('Yavaslik Testi'); // burada bitirdik

            },
            error: function (xhr, desc, err) {
                console.log("Hata liste cekilemedi");

            }
        });

    }
    google.maps.event.addDomListener(window, 'load', initialize);

});

