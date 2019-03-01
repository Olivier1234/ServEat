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

    $.ajax({
        url: "/search/ajax_search",
        type: "GET",
        dataType: "text",
        contentType  : "text/html; charset=ISO-8859-1",
        data: {
            "posX": posX,
            "posY" : posY
        },
        success: function (data)
        {
            console.log(JSON.parse(data));
            setMealsMarker(JSON.parse(data));
        }
    });
}

function setMealsMarker(meals) {
    for (var meal of meals) {

        var lat = parseFloat(meal.posY);
        var long = parseFloat(meal.posX);


        console.log(meal);
        var marker = L.marker([lat, long]).addTo(map);
        marker.bindPopup(`<div>` + meal.title + `</div>` +
           `<div>` + meal.description + '</div>' +
            '<div>' +  meal.price + '€</div>' +
            ' <a href=\"/booking\"><button class="btn btn-primary">Book</button> </a> ')
    }
}

initmap();
