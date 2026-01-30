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

const colors = {"DLH": "#ffcc00ff", "JBU": "#80ff00ff", "SWA": "#ff0000ff", "ASA": "#ac1d41ff", "ATN": "#b332b3ff", "UPS": "#424cd8ff", "UAL": "#a0820cff", "SCX": "#b9ff74ff", "CSI": "#671616ff", "N": "#f0557cff", "CSB": "#1d338cff", "WJA": "#42d860ff",
                "VIR": "#987a00ff", "ACA": "#00ddffff", "CTL": "#007bffff", "DAL": "#12625cff", "AMX": "#6132b3ff", "CMP": "#181f7aff", "AEA": "#d5c379ff", "ELY": "#316001ff", "EVA": "#9e6060ff", "MAL": "#55f081ff", "TAY": "#8390c2ff", "CMP": "#d842b3ff",
                "NAK": "#ffd736ff", "MMD": "#ffdd00ff", "THY": "#00244aff", "LOT": "#25beb4ff", "WMT": "#610df2ff", "DM": "#323bb4ff", "FIN": "#1c35beff", "BTI": "#7fd12eff", "ISR": "#3e1919ff", "GAM": "#085d20ff", "RYR": "#1b2c70ff", "LOT": "#642b56ff"};
function planeColor(data) {
    let who = data[1].split(/(?=[1-9])/)[0]
    let color = colors[who] || "orange";

    /* if (data[8] != 0) {
        color = color.slice(0, -2) + "80";
    } */

    return color;
}
let lastPlane;
function loadShowData(data) {
    const div = document.getElementById("planeData"); 

    if(lastPlane == data.planeID) {
        div.classList.add("hidden");  
        lastPlane = null;
        return; 
    }
    lastPlane = data.planeID;
    div.classList.remove("hidden");   

    document.getElementById("callname").innerHTML = data.callName;
    document.getElementById("planeid").innerHTML = data.planeID;
    document.getElementById("regcountry").innerHTML = data.regCountry;
    document.getElementById("lat").innerHTML = data.lat;
    document.getElementById("lng").innerHTML = data.lng;
    document.getElementById("height").innerHTML = data.height + " km";
    document.getElementById("heading").innerHTML = data.heading + "°";
    document.getElementById("vel").innerHTML = data.vel + " km/h";
    document.getElementById("levelstatus").innerHTML = data.levelStatus;
    document.getElementById("status").innerHTML = data.status;
}
async function loadPlanes() {
    let planeList = [];
    const apiplanes = ["https://opensky-network.org/api/states/all", "data/test.json"];
    const response = await fetch(apiplanes[1]).then(p => p.json());

    const planeData = response["states"]; 

    if(planeData) {
        planeData.map(function(plane) {            
            if(plane[6] != null || plane[5] != null) {
                let onLand = plane[8] ? "on Ground" : "in Sky";
                let height = (plane[7] / 1000).toFixed(2);
                let speed = (plane[9] * 3.6).toFixed(2);
                let color = planeColor(plane);

                let status = "";
                if (plane[8] != 0) {
                    status = "-";
                } else if (plane[11] === 0) {
                    status = "on level";
                } else if(plane[11] > 0) {
                    status = "rising";
                } else {
                    status = "falling";
                }

                planeList.push({
                    lat: plane[6],
                    lng: plane[5],
                    height: height,
                    heading: plane[10],
                    color: color,

                    planeID: plane[0],
                    callName: plane[1], 
                    regCountry: plane[2],
                    lastLocTime: plane[3],
                    lastSigTime: plane[4],
                    vel: speed,
                    status: onLand,
                    levelStatus: status,
                    gps: plane[13],
                });
            }
        });

        world.htmlElementsData(planeList).htmlElement(p => {
            const plane = document.createElement("div");
            plane.innerHTML = `<svg fill="${p.color}" style="transform: rotate(${p.heading}deg);" width="14" height="14" viewBox="0 0 24 24" id="airplane-mode" data-name="Flat Color" xmlns="http://www.w3.org/2000/svg" class="icon flat-color"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path id="primary" d="M19.58,12.08,14,8.16V4a2,2,0,0,0-4,0V8.16L4.42,12.08a1,1,0,0,0-.42.81v.93a1,1,0,0,0,1.16,1L10,14v3.62l-1.71,1.7A1.05,1.05,0,0,0,8,20v1a1,1,0,0,0,1.45.89L12,20.62l2.55,1.27A1,1,0,0,0,16,21V20a1.05,1.05,0,0,0-.29-.71L14,17.62V14l4.84.81a1,1,0,0,0,1.16-1v-.93A1,1,0,0,0,19.58,12.08Z"></path></g></svg>`;
            
            plane.onclick = () => loadShowData(p);
            plane.style.pointerEvents = 'auto';
            plane.style.cursor = 'pointer';

            return plane;
        })
    }
}

loadPlanes();
setInterval(loadPlanes, 60000);