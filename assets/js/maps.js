"use strict";
import { EsriProvider  } from 'leaflet-geosearch';

var map;

function initmap() {
    map = L.map('map').setView([51.505, -0.09], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    map.locate({setView: true, maxZoom: 15});

    let query = window.location.search;
    let adressQuery = query.split('&')[0];
    let adress = adressQuery.split('=')[1].replace(/\+/g, ' ');
    adress = decodeURIComponent(adress);
    console.log(decodeURIComponent(adress));

    // map.setView();
    // const provider = new LocationIQProvider ({
    //     params: {
    //         key: 'e070475af59dda',
    //     },
    // });

    const provider = new EsriProvider();
    
    provider
        .search({ query: adress })
        .then(findMeals);
}

function findMeals(result) {
    var latlng = [result[0].y, result[0].x];
    map.setView(latlng);

    var circle = L.circle(latlng, {
        color: '#96D5F0',
        fillColor: '#96D5F0',
        fillOpacity: 0.3,
        radius: 1500
    }).addTo(map);
}

initmap();
