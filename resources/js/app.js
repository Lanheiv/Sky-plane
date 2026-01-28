import * as THREE from 'three';
import { MeshLambertMaterial, DoubleSide } from 'three';
import * as topojson from 'topojson';

const world = new Globe(document.getElementById('globeViz'))
    .backgroundColor('rgba(2, 2, 12, 1)')
    .showGlobe(true)
    .showAtmosphere(true)
    .atmosphereColor('rgba(49, 144, 204, 1)')
    .globeMaterial(new THREE.MeshPhongMaterial({color: "rgba(2, 0, 33, 1)"}));

fetch("data/countries-110m.json").then(res => res.json()).then(topo => {
    world
    .polygonsData(topojson.feature(topo, topo.objects.countries).features)
    .polygonCapMaterial(new MeshLambertMaterial({ color: 'rgba(48, 81, 81, 1)', side: DoubleSide }))
    .polygonSideColor(() => 'rgba(0, 0, 0, 1)')
    .polygonStrokeColor(() => 'rgba(17, 30, 30, 1)');
});

async function loadPlanes() {
    let planeList = [];
    const apiplanes = ["https://opensky-network.org/api/states/all", "data/test.json"];
    const response = await fetch(apiplanes[1]).then(p => p.json()); // apiplanes[1] ir priekš testēšanas ja oficiālais APi nestrādā 

    const planeData = response["states"]; 

    if(planeData) {
        planeData.map(function(plane) {
            
            if(plane[6] != null || plane[5] != null) {
            planeList.push({
                lat: plane[6],
                lng: plane[5],
                height: plane[7],
                heading: plane[10],
                color: "orange",

                planeID: plane[0],
                callName: plane[1], 
                regCountry: plane[2],
                lastLocTime: plane[3],
                lastSigTime: plane[4],
                vel: plane[9],
                verRate: plane[11],
                gps: plane[13],
            });
            }
        });

        world.htmlElementsData(planeList).htmlElement(p => {
            const plane = document.createElement("div");
            plane.innerHTML = `<svg fill="${p.color}" style="transform: rotate(${p.heading}deg);" width="24" height="24" viewBox="0 0 24 24" id="airplane-mode" data-name="Flat Color" xmlns="http://www.w3.org/2000/svg" class="icon flat-color"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path id="primary" d="M19.58,12.08,14,8.16V4a2,2,0,0,0-4,0V8.16L4.42,12.08a1,1,0,0,0-.42.81v.93a1,1,0,0,0,1.16,1L10,14v3.62l-1.71,1.7A1.05,1.05,0,0,0,8,20v1a1,1,0,0,0,1.45.89L12,20.62l2.55,1.27A1,1,0,0,0,16,21V20a1.05,1.05,0,0,0-.29-.71L14,17.62V14l4.84.81a1,1,0,0,0,1.16-1v-.93A1,1,0,0,0,19.58,12.08Z"></path></g></svg>`;
            
            plane.onclick = () => console.info(p);
            plane.style.pointerEvents = 'auto';
            plane.style.cursor = 'pointer';

            return plane;
        })
    }
}

loadPlanes();
setInterval(loadPlanes, 60000);