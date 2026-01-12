<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>

        .text-center { text-align: center; }

        #map { width: 100%; height: 400px; }

    </style>

</head>

<body>

<h1 class="text-center">Laravel Google Maps</h1>

               <div id="map"></div>

               <!-- Google Maps API -->

<script src="https://maps.googleapis.com/maps/api/js?              key=YOUR_API_KEY&callback=initMap" async> </script>

<script>

        let map, activeInfoWindow, markers = [];

        // Initialize Google Map

        function initMap() {

            map = new google.maps.Map(document.getElementById("map"), {

                center: { lat: 28.626137, lng: 79.821603 },

                zoom: 15

            });

            map.addListener("click", function(event) {

                console.log("Map clicked at:", event.latLng.lat(), event.latLng.lng());

            });

            initMarkers();

        }

  // Add Markers

        function initMarkers() {

            const initialMarkers = <?php echo json_encode($initialMarkers); ?>;

initialMarkers.forEach((markerData, index) => {

                const marker = new google.maps.Marker({

                    position: markerData.position,

                    label: markerData.label,

                    draggable: markerData.draggable,

                    map

                });

                markers.push(marker);

                const infowindow = new google.maps.InfoWindow({

                    content: `<b>${markerData.position.lat}, ${markerData.position.lng}</b>`,

                });

                marker.addListener("click", () => {

                    if(activeInfoWindow) activeInfoWindow.close();

                    infowindow.open({ anchor: marker, map });

                    activeInfoWindow = infowindow;

                    console.log("Marker clicked:", marker.position.toString());

                });

                marker.addListener("dragend", (event) => {

                    console.log("Marker dragged to:", event.latLng.lat(), event.latLng.lng());

                });

            });

        }

    </script>

</body>

</html>