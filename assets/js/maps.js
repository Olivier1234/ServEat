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
    console.log(query.split('token')[1].split('=')[1]);
    let token = query.split('token')[1].split('=')[1];
    let adressQuery = query.split('&')[0];
    let adress = adressQuery.split('=')[1].replace(/\+/g, ' ');
    adress = decodeURIComponent(adress);

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
    var posX = result[0].x;
    var posY = result[0].y;
    var latlng = [posY, posX];

    map.setView(latlng);

    var circle = L.circle(latlng, {
        color: '#96D5F0',
        fillColor: '#96D5F0',
        fillOpacity: 0.3,
        radius: 1500
    }).addTo(map);

    let query = window.location.search;
    console.log(query.split('token')[1].split('=')[1]);
    let token = query.split('token')[1].split('=')[1];
    $.ajax({
        url: "/search/ajax_search",
        type: "GET",
        dataType: "json",
        data: {
            "posX": posX,
            "posY" : posY
        },
        success: function (data)
        {
            console.log(data);
        }
    });
}

initmap();
