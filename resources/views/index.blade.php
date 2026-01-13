<head>
  <style> body { margin: 0; } </style>

  <script src="//cdn.jsdelivr.net/npm/globe.gl"></script>
</head>

<body>
  <div id="globeViz"></div>

  <script type="module">
    import { MeshLambertMaterial, DoubleSide } from 'https://esm.sh/three';
    import * as THREE from 'https://esm.sh/three';
    import * as topojson from 'https://esm.sh/topojson-client';
    
    const world = new Globe(document.getElementById('globeViz'))
      .backgroundColor('rgba(0, 0, 0, 1)')
      .showGlobe(true)
      .showAtmosphere(true)
      .atmosphereColor('rgba(49, 144, 204, 1)')
      .globeMaterial(new THREE.MeshPhongMaterial({color: "rgba(2, 0, 33, 1)"}));

    fetch('//cdn.jsdelivr.net/npm/world-atlas/countries-110m.json').then(res => res.json()).then(topo => {
        world
          .polygonsData(topojson.feature(topo, topo.objects.countries).features)
          .polygonCapMaterial(new MeshLambertMaterial({ color: 'rgba(48, 81, 81, 1)', side: DoubleSide }))
          .polygonSideColor(() => 'rgba(0, 0, 0, 1)')
          .polygonStrokeColor(() => 'rgba(17, 30, 30, 1)')
      });

      let plane_test = [{
        lat: 40,
        lng: -74,
        heading:-45,
        color: 'orange'
      }];

      world
        .htmlElementsData(plane_test)
        .htmlElement(data => {
          let plane = document.createElement("div");
          
          plane.innerHTML=`<svg fill="${data.color}" style="transform: rotate(${data.heading - 90}deg);" width="34" height="34" viewBox="0 0 24 24" id="airplane-mode" data-name="Flat Color" xmlns="http://www.w3.org/2000/svg" class="icon flat-color"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path id="primary" d="M19.58,12.08,14,8.16V4a2,2,0,0,0-4,0V8.16L4.42,12.08a1,1,0,0,0-.42.81v.93a1,1,0,0,0,1.16,1L10,14v3.62l-1.71,1.7A1.05,1.05,0,0,0,8,20v1a1,1,0,0,0,1.45.89L12,20.62l2.55,1.27A1,1,0,0,0,16,21V20a1.05,1.05,0,0,0-.29-.71L14,17.62V14l4.84.81a1,1,0,0,0,1.16-1v-.93A1,1,0,0,0,19.58,12.08Z"></path></g></svg>`;
          return plane;
        });
  </script>
</body>
