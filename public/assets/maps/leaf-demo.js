// See post: http://asmaloney.com/2015/06/code/clustering-markers-on-leaflet-maps

var map = L.map( 'map', {
    center: [39.766193, 30.526714],
    minZoom: 13,
    zoom: 13
});

//http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png
L.tileLayer( 'https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    subdomains: ['a','b','c']
}).addTo( map );

var myURL = jQuery( 'script[src$="leaf-demo.js"]' ).attr( 'src' ).replace( 'leaf-demo.js', '' );

var myIcon = L.icon({
    iconUrl: myURL + 'images/pin24.png',
    iconRetinaUrl: myURL + 'images/pin48.png',
    iconSize: [29, 24],
    iconAnchor: [9, 21],
    popupAnchor: [0, -14]
});
var centIcon = L.icon({
    iconUrl: myURL + 'images/placeholder.png',
    iconRetinaUrl: myURL + 'images/m1.png',
    iconSize: [32, 32],
    iconAnchor: [9, 21],
    popupAnchor: [0, -14]
});

var markerClusters = L.markerClusterGroup();

var lat,lng,fm,str,mah;
var tKaza =0,tIntihar=0,tYara=0,tYas=0;
var oKaza =0,oIntihar=0,oYara=0,oYas=0;
var ctepe=0,codun=0;
$.ajax({
    url: '/sheet/jsonparse',
    type: 'Get',
    dataType: "JSON",
    processData: false,
    contentType: false,
    success: function (data, status) {
        for(let i = 0; i<data.length ; i++){
            if(data[i]['ilce'] == 'tepebasi'){
                ctepe++;
                //tYas = tYas + parseInt(data[i]['yas']);
                if (data[i]['cagrinedeni'] == '4') tKaza++;
                if (data[i]['cagrinedeni'] == '6') tYara++;
                if (data[i]['cagrinedeni'] == '2') tIntihar++;
                //if (data[i]['cagrinedeni'] == '4')
            }
            else{
                codun++;
                //oYas= oYas + parseInt(data[i]['yas']);
                if (data[i]['cagrinedeni'] == '4') oKaza++;
                if (data[i]['cagrinedeni'] == '6') oYara++;
                if (data[i]['cagrinedeni'] == '2') oIntihar++;
            }
        }

        var markerTep = L.marker([39.7840 , 30.5012],{icon:centIcon}).addTo(map).bindPopup(
            '<center><img src="http://www.hentiesbaytourism.com/wp-content/uploads/2014/02/Map-Marker-Flag-3-Right-Azure-icon.png"></center>'+
            '<h3><center>Tepebaşı</center></h3>'+
            '<br/><b>Toplam Vaka : </b>' +  ctepe +
            '<br/><b>Vaka Yüzdesi : </b>' + Math.round( (ctepe / data.length) * 100 )+'%'+
            '<br/><b>İntihar Vakası Oranı :</b>' + Math.round((tIntihar/ctepe)* 100 )+'%'+
            '<br/><b>Trafik Kazası Oranı : </b>' + Math.round((tKaza/ctepe)* 100 ) +'%'+
            '<br/><b>Yaralama Olayları Oranı : </b>' + Math.round((tYara/ctepe)* 100 ) +'%'
            //'<br/><b>Yaş Ortalaması : </b>' + tYas
        );

        var markerOd = L.marker([39.7668 , 30.5410],{icon:centIcon}).addTo(map).bindPopup(
            '<center><img src="http://www.hentiesbaytourism.com/wp-content/uploads/2014/02/Map-Marker-Flag-3-Right-Azure-icon.png"></center>'+
            '<h3><center>Odunpazarı</center></h3>'+
            '<br/><b>Toplam Vaka : </b> ' +  codun +
            '<br/><b>Vaka Yüzdesi :</b> ' + Math.round( (codun / data.length) * 100 )+'%'+
            '<br/><b>İntihar Vakası Oranı :</b>' + Math.round((oIntihar/ctepe)* 100 )+'%'+
            '<br/><b>Trafik Kazası Oranı : </b>' + Math.round((oKaza/ctepe)* 100 ) +'%'+
            '<br/><b>Yaralama Olayları Oranı : </b>' + Math.round((oYara/ctepe)* 100 ) +'%'
            //'<br/><b>Yaş Ortalaması : </b>' + oYas
        );

        console.time('Yavaslik Testi');
        for (let i = 0; i < data.length; i++) {

            //console.log("", data[i]['sokak']);- ----->AIzaSyB50EJOKvTwdo3cn4Mp4VnHXJyIBUdISTo
            axios.get('https://maps.googleapis.com/maps/api/geocode/json', {
                params: {
                    address: data[i]['sokak'] + 'Sokak Eskişehir',
                    key: ''
                }
            })
                .then(function (response) {
                    // Formatted Address
                    fm = response.data.results[0].formatted_address;
                    lat = response.data.results[0].geometry.location.lat;
                    lng = response.data.results[0].geometry.location.lng;
                    str = response.data.results[0].address_components[0].long_name;
                    mah = response.data.results[0].address_components[1].long_name;
                    var popup = fm+
                        '<br/>' + str +
                        '<br/><b>Tanı :</b> ' +  data[i]['tani'] +
                        '<br/><b>Mudahale :</b> ' + data[i]['mudahale'] +
                        '<br/><b>Ekip No :</b> ' + data[i]['ekipno'] +
                        '<br/><b style="color: green">Sonuc : </b> ' +  data[i]['Sonuc'];

                    var m = L.marker( [lat,lng], {icon: myIcon} )
                        .bindPopup( popup );

                    markerClusters.addLayer( m );
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


map.addLayer( markerClusters );
