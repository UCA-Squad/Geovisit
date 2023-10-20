/* 
 * 
 * Observatoire de Physique du Globe de Clermont-Ferrand
 * Campus Universitaire des Cezeaux
 * 4 Avenue Blaise Pascal
 * TSA 60026 - CS 60026
 * 63178 AUBIERE CEDEX FRANCE
 * 
 * Author: Yannick Guehenneux
 *         y.guehenneux [at] opgc.fr
 * 
 */

function checkPoint(lat, lng) {
    if (isNaN(lat) || isNaN(lng)) {
        return false;
    }
    if (lat < -90.0 || lat > 90.0 || lng < -180.0 || lng > 180.0) {
        return false;
    }
    return true;
}

function drawMap() {
    $('#site-popup-map').html("<div id='map' style='width: 100%; height: 100%; z-index: 100%'></div>");

    var latmin = parseFloat($('#site-map-latmin').val());
    var latmax = parseFloat($('#site-map-latmax').val());
    var lonmin = parseFloat($('#site-map-lonmin').val());
    var lonmax = parseFloat($('#site-map-lonmax').val());

    var map = new L.map('map', {zoomControl: false}).setView([0.0, 0.0], 2);
    map.addControl(L.control.zoom({position: 'topright'}));

    new L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
    }).addTo(map);

    new L.tileLayer('https://server.arcgisonline.com/arcgis/rest/services/Reference/World_Boundaries_and_Places/MapServer/tile/{z}/{y}/{x}', {
        bounds: [[-90, -180], [90, 180]]
    }).addTo(map);

    var editableLayers = new L.featureGroup();
    map.addLayer(editableLayers);

    if (checkCoordinates(latmin, latmax, lonmin, lonmax)) {
        editableLayers.addLayer(L.rectangle([[latmin, lonmin], [latmax, lonmax]], {color: '#f96332'}));
    }

    var drawPluginOptions = {
        position: 'topright',
        draw: {
            polygon: false,
            polyline: false,
            circle: false,
            rectangle: {
                shapeOptions: {
                    color: '#f96332'
                }
            },
            marker: false
        }
    };

    var drawControl = new L.Control.Draw(drawPluginOptions);
    map.addControl(drawControl);

    map.on('draw:created', function (e) {
        editableLayers.clearLayers();
        var type = e.layerType,
                layer = e.layer;

        if (type === 'rectangle') {
            getCoordinatesFromMap(layer.getLatLngs()[0]);
        }

        editableLayers.addLayer(layer);
    });

}

function drawMapAtelier() {
    if (parseInt($('#sig_map').val()) === 1) {
        var geovisitIcon = L.icon({
            iconUrl: host + '/img/point.png',
            shadowUrl: null,
            iconSize: [26, 26],
            iconAnchor: [13, 13]
        });

        var latmin = parseFloat($('#map_latmin').val());
        var latmax = parseFloat($('#map_latmax').val());
        var lonmin = parseFloat($('#map_lonmin').val());
        var lonmax = parseFloat($('#map_lonmax').val());
        var lat = parseFloat($('#x_carte').val());
        var lng = parseFloat($('#y_carte').val());

        var sw = L.latLng(latmin, lonmin);
        var ne = L.latLng(latmax, lonmax);
        var bounds = L.latLngBounds(sw, ne);

        var map = new L.map('map-atelier', {
            maxBounds: bounds,
            center: [latmin + ((latmax - latmin) / 2), lonmin + ((lonmax - lonmin) / 2)],
            zoomSnap: 0.1
        });

        map.setMinZoom(map.getBoundsZoom(bounds));
        map.fitBounds(bounds);


        new L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            bounds: [[latmin, lonmin], [latmax, lonmax]],
            attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
        }).addTo(map);

        new L.tileLayer('https://server.arcgisonline.com/arcgis/rest/services/Reference/World_Boundaries_and_Places/MapServer/tile/{z}/{y}/{x}', {
            bounds: [[latmin, lonmin], [latmax, lonmax]]
        }).addTo(map);

        var editableLayers = new L.featureGroup();
        map.addLayer(editableLayers);

        var drawPluginOptions = {
            position: 'topright',
            draw: {
                polygon: false,
                polyline: false,
                circle: false,
                rectangle: false,
                marker: {
                    icon: geovisitIcon,
                    draggable: true
                }
            }
        };

        var drawControl = new L.Control.Draw(drawPluginOptions);
        map.addControl(drawControl);

        if (checkPoint(lat, lng)) {
            editableLayers.addLayer(L.marker([lat, lng], {icon: geovisitIcon}));
        }

        map.on('draw:created', function (e) {
            editableLayers.clearLayers();
            var type = e.layerType,
                    layer = e.layer;

            if (type === 'marker') {
                getAtelierCoordinatesFromMap(layer.getLatLng());
            }

            editableLayers.addLayer(layer);
        });
    }
}

function drawMapTp(points, selected = null) {
    var geovisitIcon = L.icon({
        iconUrl: host + '/img/point.png',
        shadowUrl: null,
        iconSize: [26, 26],
        iconAnchor: [13, 13]
    });
    
    var geovisitIconSelected = L.icon({
        iconUrl: host + '/img/point-selected.png',
        shadowUrl: null,
        iconSize: [26, 26],
        iconAnchor: [13, 13]
    });

    var latmin = parseFloat($('#map-latmin').val());
    var latmax = parseFloat($('#map-latmax').val());
    var lonmin = parseFloat($('#map-lonmin').val());
    var lonmax = parseFloat($('#map-lonmax').val());

    var sw = L.latLng(latmin, lonmin);
    var ne = L.latLng(latmax, lonmax);
    var bounds = L.latLngBounds(sw, ne);

    var map = new L.map('map-tp', {
        maxBounds: bounds,
        center: [latmin + ((latmax - latmin) / 2), lonmin + ((lonmax - lonmin) / 2)],
        zoomSnap: 0.1
    });

    map.setMinZoom(map.getBoundsZoom(bounds));
    map.fitBounds(bounds);

    new L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        bounds: [[latmin, lonmin], [latmax, lonmax]],
        attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
    }).addTo(map);

    new L.tileLayer('https://server.arcgisonline.com/arcgis/rest/services/Reference/World_Boundaries_and_Places/MapServer/tile/{z}/{y}/{x}', {
        bounds: [[latmin, lonmin], [latmax, lonmax]]
    }).addTo(map);
    
    var editableLayers = new L.featureGroup();
    map.addLayer(editableLayers);
    
    if (selected === null) {
        points.forEach(function(point) {
            if (checkPoint(point.lat, point.lon)) {
                editableLayers.addLayer(L.marker([point.lat, point.lon], {icon: geovisitIcon}));
            }
        });
    } else {
        for (i = 0; i < points.length; i++) {
            if (i === selected) {
                editableLayers.addLayer(L.marker([points[i].lat, points[i].lon], {icon: geovisitIconSelected}));
            } else {
                editableLayers.addLayer(L.marker([points[i].lat, points[i].lon], {icon: geovisitIcon}));
            }
        }
    }
}