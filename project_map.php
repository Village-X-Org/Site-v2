

	<div class="section">
		<div class='map' id='map' style='width:100%;height:700px;'></div>
	</div>
<script>
    projectId = <?php print $projectId; ?>;
    lastScrollTop = 0;
    refreshing = 0;
    mapboxgl.accessToken = 'pk.eyJ1IjoiamRlcHJlZSIsImEiOiJjajdjMndlbG4xMDk5MndwbGZyc3I3YnN5In0.uCkT-Femn4KqxRbrlr-CIA';
    var map = new mapboxgl.Map({
        container : 'map',
        style : 'mapbox://styles/jdepree/cj37ll51d00032smurmbauiq4',
        center : [34,-13.024],
        zoom : 6, 
        padding: {top: 20, bottom:150, left: 20, right: 20}
    });
    map.scrollZoom.disable();
    map.addControl(new mapboxgl.NavigationControl(), 'top-right');

    function zoomTo(elem, lat, lng) {
        map.flyTo({center: [lng, lat], zoom: 15});
        if (elem) {
            elem.scrollIntoView({
                behavior: 'smooth'
            });
        }
    }

    function selectVillage(village) {
        selectedVillage = village;
        sw = [ parseFloat(selectedVillage.properties.boundsSwLng),
                parseFloat(selectedVillage.properties.boundsSwLat) ];
        ne = [ parseFloat(selectedVillage.properties.boundsNeLng),
                parseFloat(selectedVillage.properties.boundsNeLat) ];
        if (Math.abs(ne[0] - sw[0]) < .001) {
            ne[0] += .005;
            sw[0] -= .005;
        }
        if (Math.abs(ne[1] - sw[1]) < .001) {
            ne[1] += .005;
            sw[1] -= .005;
        }
        map.flyTo({ center: village.geometry.coordinates, zoom: 15,
            padding : {
                top : 20,
                bottom : 150,
                left : 20,
                right : 20
            }
        });
    }

    map.on('click', 'villages', function(e) {
        selectVillage(e.features[0]);
    });

    map.on('click', 'projects', function (e) {
            window.open("project.php?id=" + e.features[0].properties.id, '_blank');
    });

    <?php if ($projectId) { ?>
        map.on('load', function() {
            map.addSource("source_circle_500", {
                "type": "geojson",
                "data": {
                    "type": "FeatureCollection",
                    "features": [{
                        "type": "Feature",
                        "geometry": {
                            "type": "Point",
                            "coordinates": [<?php print "$villageLng, $villageLat"; ?>]
                        }
                    }]
                }
            });

            map.addLayer({
                "id": "circle500",
                "type": "circle",
                "source": "source_circle_500",
                "paint": {
                    "circle-radius": 20,
                    "circle-color": "#5b94c6",
                    "circle-opacity": 0.6
                }
            });
        });
    <?php } ?> 
    </script>