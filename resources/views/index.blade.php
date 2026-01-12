<head>
  <style> body { margin: 0; } </style>

  <script src="//cdn.jsdelivr.net/npm/globe.gl"></script>
</head>

<body>
    <div>
        <div id="globeViz"></div>
    </div>

  <script type="module">
    import { MeshLambertMaterial, DoubleSide } from 'https://esm.sh/three';
    import * as topojson from 'https://esm.sh/topojson-client';

    const world = new Globe(document.getElementById('globeViz'))
      .backgroundColor('rgba(0, 0, 0, 1)')
      .showGlobe(true)
      .showAtmosphere(true)
      .atmosphereColor('rgba(49, 144, 204, 1)');

    fetch('//cdn.jsdelivr.net/npm/world-atlas/countries-110m.json').then(res => res.json())
.then(topo => {
        world
          .polygonsData(topojson.feature(topo, topo.objects.countries).features)
          .polygonCapMaterial(new MeshLambertMaterial({ color: 'rgba(48, 81, 81, 1)', side: DoubleSide }))
          .polygonSideColor(() => 'rgba(0, 0, 0, 1)')
          .polygonStrokeColor(() => 'rgba(36, 59, 59, 1)')
      });
  </script>
</body>