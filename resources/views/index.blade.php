{{-- resources/views/globe.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>3D Globe - Laravel</title>
    <style>
        body { margin: 0; overflow: hidden; background: #000; }
        #globeViz { width: 100vw; height: 100vh; }
    </style>
    <script src="//cdn.jsdelivr.net/npm/globe.gl"></script>
</head>
<body>
    <div id="globeViz"></div>

    <script>
        const pointsData = @json($points);

        const globePoints = pointsData.map(point => ({
            lat: point.lat,
            lng: point.lng,
            name: point.name,
            size: 0.3,
            color: 'red'
        }));

        new Globe(document.getElementById('globeViz'))
            .globeImageUrl('//cdn.jsdelivr.net/npm/three-globe/example/img/earth-night.jpg')
            .pointsData(globePoints)
            .pointAltitude('size')
            .pointColor('color')
            .pointLabel('name')
            .onPointClick(point => {
                alert(`${point.name}: ${point.lat.toFixed(3)}, ${point.lng.toFixed(3)}`);
            });
    </script>
</body>
</html>
