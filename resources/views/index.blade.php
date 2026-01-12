<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fixed Google Map</title>
    <style>#map { height: 400px; }</style>
</head>
<body>
    <div id="map"></div>

    <script>
    function initMap() {
        const myLatLng = { lat: 22.2734719, lng: 70.7512559 };
        
        google.maps.importLibrary("maps").then(() => {
            google.maps.importLibrary("marker").then(({ AdvancedMarkerElement }) => {
                const map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 5,
                    center: myLatLng,
                    mapId: '119df797593452476b474eed'
                });
                new AdvancedMarkerElement({
                    map: map,
                    position: myLatLng,
                    title: "Hello Rajkot!"
                });
            });
        });
    }
    </script>
    
    <script async src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap&libraries=marker&loading=async"></script>
</body>
</html>
