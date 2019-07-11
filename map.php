<?php
require_once("utilities.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php 
  $pageTitle = "Village X | Project Locations";
  $pageDescription = "Zoom in from a bird's-eye view to visit partner villages and their development projects.";
  $pageUrl = getBaseURL()."map.php";
include('header.inc'); ?>
<style>
.mapboxgl-ctrl-geocoder {
	font: 15px/20px 'Helvetica Neue', Arial, Helvetica, sans-serif;
	position: relative;
	background-color: white;
	width: 400px;
	z-index: 1;
	border-radius: 3px;
}

.mapboxgl-ctrl-geocoder input[type='text'] {
	font-size: 12px;
	width: 100%;
	border: 0;
	background-color: transparent;
	height: 20px;
	margin: 0;
	color: rgba(0, 0, 0, .5);
	padding: 10px 10px 10px 40px;
	text-overflow: ellipsis;
	white-space: nowrap;
	overflow: hidden;
}

#map {
	position: absolute;
	top: 0;
	bottom: 0;
	width: 100%;
	z-index: 0;
}

#mapScreenDiv {
	position: relative;
	height: calc(100vh - 110px);
}

#mapContainer {
	position: relative;
	padding: 0px;
	width: 100%;
	height: 100%;
}

#projectScroller {
	position: absolute;
	bottom: 0px;
	width: 100%;
	overflow-x: scroll;
	white-space: nowrap;
	z-index: 6;
}

.hide-scrollbar ::-webkit-scrollbar-thumb {
	visibility: hidden;
}

div.projectCell {
	background: white;
	background-repeat: no-repeat;
	background-size: 30vmin;
	display: inline-block;
	width: 30vmin;
	margin-right: 2px;
	text-align: center;
	cursor: pointer;
	height: 30vmin;
	-webkit-filter: contrast(1);
	filter: contrast(1);
	border: 2px solid black;
	border-radius: 15px;
	-moz-border-radius: 15px;
	overflow: hidden;
}

@media (min-width: 720px) {
    #mapScreenDiv {
	   height: calc(100vh - 60px);
    }
}

div.progressBar {
	position: relative;
	background-color: #CCCCCC;
	height: 18px;
	border: 2px;
	margin-left: 0px;
	margin-right: 0px;
}

div.progressBar-label {
	position: absolute;
	font-size: 12px;
	text-align: center;
	width: 100%;
	top: -1px;
	font-weight: bold;
}

div.progressBar .ui-progressbar-value {
	background-color: #8ABC5C;
	padding: 0px;
	margin: 0px;
}
</style>

<div id='mapScreenDiv'>
	<div id='mapContainer'>

		<!-- Buttons on map (world and add project) -->
		<div class="fixed-action-btn" id='buttonHolder'
			style='position: absolute; display:none;top: 0px; right: 5px; z-index: 3;'>

			<button class="btn-floating btn-large blue" id='zoomOutButton'
				onclick="zoomToCountry(selectedCountry);"
				style='margin-left:10px;'> <i class="large material-icons"
				id='zoomOutButtonText'>zoom_out</i>
			</button>
		</div>
 	    
		<!-- Project/village tiles at bottom of map -->
		<div id="projectScroller" class='hide-scrollbar'></div>
	</div>

</div>

<div id='proposedModal' class='modal'>
	<center><h5 id='proposedName'></h5></center>
	<p style='margin-left:20px;'><b>Most Urgent Development Problem:</b> <span id='dev_problem'></span><br/>
		<b>Village Population: </b><span id='population'></span><br/>
		<b>Date Posted: </b><span id='date_added'></span><br/>
	<div id='proposedPictures' style='margin:20px;width:100%;height:250px;overflow-x:scroll;overflow-y:hidden;'></div>
</div>

<script>
	// Global variables.
	var selectedCell, selectedElem, selectedVillage, selectedCountry, retryCount = 1, timer;

	mapboxgl.accessToken = '<?php print MAPBOX_API_KEY; ?>';

	var map = new mapboxgl.Map({
		container : 'mapContainer',
		style : 'mapbox://styles/jdepree/cj37ll51d00032smurmbauiq4',
		center : [20.5, 2.5],
		zoom : 4
	});

	map.addControl(new mapboxgl.NavigationControl(), 'top-left');
	map.scrollZoom.disable();

	map.on('load', function() {
		window.scrollTo(0,1);
		map.on('click', 'villages', function(e) {
			selectVillage(e.features[0]);
		});

	    map.on('click', 'projects', function (e) {
    			if (selectedElem == e.features[0]) {
		        return;
	        }
    			window.open("project.php?id=" + e.features[0].properties.id, '_blank');
	    });

		map.on("data", function(data) {
			if (timer) {
				clearInterval(timer);
				timer = 0;
			}
			timer = setTimeout(function() {
				getTilesForBounds();
			}, 1000);
		});
	    
		map.on("mousemove", "villages", function(e) {
			map.getCanvas().style.cursor = 'pointer';
		});
		map.on("mousemove", "projects", function(e) {
			map.getCanvas().style.cursor = 'pointer';
		});
		map.on("mouseleave", "villages", function() {
			map.getCanvas().style.cursor = 'default';
		});
		map.on("mouseleave", "projects", function() {
			map.getCanvas().style.cursor = 'default';
		});

		map.loadImage('images/icon_village.png', function(error, image) {
			if (error) throw error;
			map.addImage('proposed', image);
			map.addLayer({
				"id": "proposed",
				"type": "symbol",
				"source": {
					"type": "geojson",
					'data': 'cached/proposed.json'
				},
				"layout": {
					"icon-image": "proposed"
				},
      			"minzoom": 5
			});
			$('#proposedModal').modal();

			map.on("mousemove", "proposed", function(e) {
				map.getCanvas().style.cursor = 'pointer';
			});
			map.on("mouseleave", "proposed", function() {
				map.getCanvas().style.cursor = 'default';
			});
			map.on("click", "proposed", function(e) {
				$('#proposedName').text(e.features[0].properties.name);
				$('#dev_problem').text(e.features[0].properties.dev_problem);
				$('#population').text(e.features[0].properties.population);
				$('#date_added').text(e.features[0].properties.date_added);
				$.each(e.features[0].properties.pictures.split(','), function(i, next) {
					if (next.length > 0) {
						img = document.createElement("img");
						img.style.height = '250px';
						img.src = '<?php print ABS_PICTURES_DIR; ?>' + next + '.jpg';
						$('#proposedPictures').append(img);
					}
				});

				$('#proposedModal').modal('open');
			});
		});

		zoomToCountry([35,-15.024]);
	});

	function zoomToCountry(coords) {
		selectedCountry = coords;
		$("#buttonHolder").hide();

		map.flyTo({center: coords, zoom: 7, padding: {top: 20, bottom:150, left: 20, right: 20}, pitch: 60}); 
		//map.fitBounds(bounds, {padding: {top: 20, bottom:150, left: 20, right: 20}, pitch: 60});
	}
	
	function getTilesForBounds() {
		zoom = map.getZoom();
		$("#projectScroller").empty();
		if (zoom >= 14) {
			count = 0;
			lastElem = 0;

			projects = map.queryRenderedFeatures({
				layers : [ 'projects' ]
			});

			projects.sort(function(a, b) {
				diffA = a.properties.project_funded
						- a.properties.project_budget;
				diffB = b.properties.project_funded
						- b.properties.project_budget;
				return diffA >= diffB ? (diffA == diffB ? 0 : 1) : -1;
			});

			$.each(
				projects,
				function(i, elem) {
					if ($("#projectDiv" + elem.properties.id).length == 0) {
						filled = Math.max(5, Math.floor(100 * elem.properties.project_funded / elem.properties.project_budget));
						unfilled = 100 - filled;
						$("#projectScroller")
								.append(
										"<div id='projectDiv"
												+ elem.properties.id
												+ "' class='projectCell' style=\"position:relative;background-image:url('<?php print ABS_PICTURES_DIR; ?>"
												+ elem.properties.picture_filename
												+ "');\">"
        											+ "<span style='position:absolute;bottom:25px;height:25px;left:0px;width:100%;background:linear-gradient(90deg, #8ABC5C "
												+ filled
												+ "%, #CCCCCC "
												+ unfilled
												+ "%);border: solid 1px white;font-size:12px;font-weight:bold;'>"
												+ filled + "% of $" + elem.properties.project_budget
												+ "</span>"
												+ "<button id='donateButton"
												+ elem.properties.id
												+ "' class='waves-effect waves-light' style='position:absolute;bottom:0px;left:0px;height:25px;width:100%;text-align:center;font-size:14px;color:black;font-weight:bold;'>"
												+ elem.properties.name
												+ "</button>"
												+ "<button id='viewDetailsButton" + elem.properties.id + "' class='waves-effect waves-light' style='position:absolute;bottom:0px;right:0px;height:25px;display:none;text-align:center;font-size:14px;color:black;font-weight:bold;border-left: solid 1px;background-color:#59ACA1'>View Project Details</button>"
												+ "</div>");
						$("#projectDiv" + elem.properties.id).on(
								"click", function(e) {
					    				window.open("project.php?id=" + elem.properties.id, '_blank');
								});
						lastElem = elem;
						count++;
					}
				});
			if (count == 0 && selectedVillage) {
				drawVillage(selectedVillage, false);
			}
		} else if (zoom >= 5) {
			villages = map.queryRenderedFeatures({
				layers : [ 'villages' ]
			});
			villages.sort(function(a, b) {
				return b.properties.fundingCount - a.properties.fundingCount;
			});
			$.each(villages, function(i, elem) {
				if ($("#villageDiv" + elem.properties.id).length == 0) {
					drawVillage(elem, true);
				}
			});
		}
	}
	
	function drawVillage(elem, hasListener) {
		completed = parseInt(elem.properties.completedCount);
		funding = parseInt(elem.properties.fundingCount);
		construction = parseInt(elem.properties.constructionCount);
		total = completed + funding + construction;
		if (total == 0) {
			filled = 0;
		} else {
			filled = Math.floor((total - funding) * 100 / total);
		}
		unfilled = 100 - filled;
		$("#projectScroller")
				.append(
						"<div id='villageDiv"
								+ elem.properties.id
								+ "' class='projectCell' style=\"position:relative;background-image:url('<?php print ABS_PICTURES_DIR; ?>"
								+ elem.properties.picture_filename
								+ "');"
								+ (total == 0 ? "background-size:calc(30vh + 30px);"
										: "")
								+ "\">"
								+ (total > 0 ? "<span style='position:absolute;bottom:25px;height:25px;left:0px;width:100%;background:linear-gradient(90deg, #8ABC5C "
										+ filled
										+ "%, #CCCCCC "
										+ unfilled
										+ "%);border: solid 1px white;font-size:12px;font-weight:bold;'>"
										+ elem.properties.projectCount
										+ "</span>"
										: "")
								+ "<button style='position:absolute;bottom:0px;left:0px;right:0px;height:25px;width:100%;text-align:center;font-size:14px;color:black;font-weight:bold;'>"
								+ elem.properties.name + "</button>" + "</div>");
		if (hasListener) {
			$("#villageDiv" + elem.properties.id).on("click", function(e) {
				selectVillage(elem);
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
		map.flyTo({ center: village.geometry.coordinates, zoom: 18,
			padding : {
				top : 20,
				bottom : 150,
				left : 20,
				right : 20
			}
		});

		$("#buttonHolder").show();
		retryCount = 1;
	}

</script>
<?php include('footer.inc'); ?>