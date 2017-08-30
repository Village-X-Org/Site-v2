<?php
require_once("utilities.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include('header.inc');
include('lightbox.inc'); ?>
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
	height: calc(100vh - 60px);
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

    #pictureCaption {
      background: #FFFFFF;
      box-shadow: 0 0 15px 10px #FFFFFF;
    }

.hide-scrollbar ::-webkit-scrollbar-thumb {
	visibility: hidden;
}

div.projectCell {
	background: white;
	background-repeat: no-repeat;
	background-size: 30vh;
	display: inline-block;
	width: 30vh;
	margin-right: 2px;
	text-align: center;
	cursor: pointer;
	height: 30vh;
	-webkit-filter: contrast(1);
	filter: contrast(1);
	border: 2px solid black;
	border-radius: 15px;
	-moz-border-radius: 15px;
	overflow: hidden;
}

div.expandoCell {
    width:calc(99vw - 30vh);
    margin-left:calc(30vh + 5px);
   	height:calc(30vh - 10px);
   	padding-left: 5px;
   	padding-right: 5px;
   	padding-top: 5px;
   	padding-bottom: 5px;
   	overflow-y:scroll;
   	white-space:normal;
   	vertical-align:top;
    background-color:white;
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

			<a class="btn-floating btn-large blue" id='zoomOutButton'
				onclick="hideCell(); zoomToCountryBounds(selectedCountry);"
				style='margin-left:10px;'> <i class="large material-icons"
				id='zoomOutButtonText'>zoom_out</i>
			</a>
		</div>

 	    <!-- Pop-up picture lightbox -->
 	    <div id='pictureDiv' style='z-index:5;position:absolute;top:50px;left:0px;right:0px;display:none;'>
 	    </div>
 	    
		<!-- Project/village tiles at bottom of map -->
		<div id="projectScroller" class='hide-scrollbar'></div>
	</div>

</div>

<script>
	// Global variables.
	var selectedCell, selectedElem, selectedVillage, selectedCountry, retryCount = 1, expandoCell, timer;

	mapboxgl.accessToken = 'pk.eyJ1IjoiamRlcHJlZSIsImEiOiJNWVlaSFBBIn0.IxSUmobvVT64zDgEY9GllQ';

	var map = new mapboxgl.Map({
		container : 'mapContainer',
		style : 'mapbox://styles/jdepree/cj37ll51d00032smurmbauiq4',
		center : [20.5, 2.5],
		zoom : 4
	});

	map.addControl(new mapboxgl.NavigationControl(), 'top-left');
	map.scrollZoom.disable();

	map.on('load', function() {
		map.on('click', 'villages', function(e) {
			selectVillage(e.features[0]);
		});

	    map.on('click', 'projects', function (e) {
    		if (selectedElem == e.features[0]) {
		        return;
	        }
		  	if (selectedCell) {
				hideCell(function() { expandCell(e.features[0]); });
		  	} else {
			  	expandCell(e.features[0]);
		  	}
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

		// Bounding box for Malawi.
		selectedCountry = [ [ 35.14799880981445, -15.829999923706055 ],
				[ 35.52799987792969, -15.473999977111816 ] ];
		zoomToCountryBounds(selectedCountry);
	});

	function zoomToCountryBounds(bounds) {
		selectedCountry = bounds;

		map.fitBounds(bounds, {padding: {top: 20, bottom:150, left: 20, right: 20}});
	}
	
	function getTilesForBounds() {
		zoom = map.getZoom();
		$("#projectScroller").empty();
		if (zoom >= 14) {
			count = 0;
			lastElem = 0;

			$("#buttonHolder").show();

			projects = map.queryRenderedFeatures({
				layers : [ 'projects' ]
			});

			/*if (projects.length == 0) {
				if (retryCount > 0) {
					map.once('moveend', getTilesForBounds);
					retryCount--;
				}
				return;
			}*/

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
						$("#projectScroller")
								.append(
										"<div id='projectDiv"
												+ elem.properties.id
												+ "' class='projectCell' style=\"position:relative;background-image:url('https://4and.me/uploads/"
												+ elem.properties.picture_filename
												+ "');\">"
												+ "<div id='progressbar"
												+ elem.properties.id
												+ "' class='progressBar' style='position:absolute;bottom:25px;left:0px;width:100%;'>"
												+ "<div class='progressBar-label'>"
												+ Math
														.floor(100
																* elem.properties.project_funded
																/ elem.properties.project_budget)
												+ "% of $"
												+ elem.properties.project_budget
												+ "</div></div>"
												+ "<button id='donateButton"
												+ elem.properties.id
												+ "' class='waves-effect waves-light' style='position:absolute;bottom:0px;left:0px;height:25px;width:100%;text-align:center;font-size:14px;color:black;font-weight:bold;'>"
												+ elem.properties.name
												+ "</button>"
												+ "<button id='viewDetailsButton" + elem.properties.id + "' class='waves-effect waves-light' style='position:absolute;bottom:0px;right:0px;height:25px;display:none;text-align:center;font-size:14px;color:black;font-weight:bold;border-left: solid 1px;background-color:#59ACA1'>View Project Details</button>"
												+ "</div>");
						getProgressBar(elem.properties.id,
								elem.properties.project_funded,
								elem.properties.project_budget);

						$("#projectDiv" + elem.properties.id).on(
								"click", function(e) {
									if (selectedElem == elem) {
										return;
									}

									e.preventDefault();

									if (selectedCell) {
										hideCell(function() {
											expandCell(elem);
										});
									} else {
										expandCell(elem);
									}
								});
						lastElem = elem;
						count++;
					}
				});
			if (count == 1) {
				expandCell(lastElem);
			} else if (count == 0 && selectedVillage) {
				drawVillage(selectedVillage, false);
			}
		} else if (zoom >= 5) {
			$("#buttonHolder").hide();
			villages = map.queryRenderedFeatures({
				layers : [ 'villages' ]
			});
			/*if (villages.length == 0) {
				if (retryCount > 0) {
					map.once('moveend', getTilesForBounds);
					retryCount--;
				}
				return;
			}*/
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
	
	function expandCell(elem) {
		selectedElem = elem;

	    $('#modalBlock').show();
		selectedCell = $("#projectDiv" + elem.properties.id);
		selectedCell.css("left", "0px");
		selectedCell.css("cursor", "default");

		selectedCell.animate({ width: '100%'}, 500);
		$("#projectScroller").animate({ scrollLeft: document.getElementById("projectDiv" + elem.properties.id).offsetLeft });
		
		expandoCell = $("<div>", {"class": "expandoCell"});
		
		var updatePictures = 0;

	  	if (elem.properties.updatePictures) {
		  	updatePictures = elem.properties.updatePictures.split("~");
		  	for (i = 0; i < updatePictures.length; i++) {
			  	if (i == 0) {
					$("#pictureDiv").append("<div class='carousel' id='pictureCarousel'></div>"
			       			+ "<h6 style='text-align: center; margin-left:12%;margin-right:12%;' id='pictureCaption'>(swipe to view on mobile)</h6>");
			  		
			  		$("#pictureDiv").show();
			  	    $(document).ready(function(){
			  	      $('.carousel').carousel();
			  	    });
			  	}
			  	breakPoint = updatePictures[i].indexOf(':');
			  	imageId = updatePictures[i].substring(0, breakPoint);
			  	description = updatePictures[i].substring(breakPoint + 1);

                $("#pictureCarousel").append("<a class='carousel-item' href='' onclick=\"$('#pictureCaption').text('" + description + "'); return false;\"><img src='https://4and.me/uploads/thumb_" + imageId + "_default_see_800x600.jpeg' /></a>");
			  	
			}
			if (updatePictures.length == 0) {
		  		$("#pictureDiv").hide();
	  	  	}
	  	} else {
	  		$("#pictureDiv").hide();
	  	}
	  	
	  	expandoCell.append("<div style='margin:5px;text-align:left;font-weight:bold;font-size:22px;'>" + elem.properties.name + ' in ' + elem.properties.villageName + "</div>"
	  			+ "<P style='margin:5px;margin-top:10px;margin-bottom:50px;text-align:left;font-size:16px;'>" + elem.properties.project_summary + ""
	  			+ "<button onclick=\"document.location='project.php?id=" + elem.properties.id + "';\">View Project Details</button></P>"
	  			+ "<img style='position:absolute;top:5px;right:5px;width:24px;height:24px;cursor:pointer;' src='images/close_button.png' onclick='hideCell();window.event.stopPropagation();' />");
		
	  	selectedCell.append(expandoCell);
	}


	function hideCell(nextAction) {
		if (expandoCell) {
			expandoCell.remove();
			expandoCell = null;
		}
		if (!selectedCell) {
			return;
		}
	    
	    $('#modalBlock').hide();
		
		if (nextAction) {
			selectedCell.animate({ width: '30vh'}, 500, nextAction);
		} else {
			selectedCell.animate({ width: '30vh'}, 500);
		}

		if ($(window).width() < 720) {
			selectedCell.css('backgroundImage', "url('https://4and.me/uploads/" + selectedElem.properties.picture_filename + "')");
		}
		
		selectedCell.css("cursor", "pointer");
		selectedCell = null;
		$("#pictureDiv").empty();
		$("#pictureDiv").hide();
	    
	    newVillageDiv = $("#villageDivNew");
	    if (newVillageDiv) {
		    	newVillageDiv.off('click');
		    	$("#expandedNewVillage").off("click");
	    }
	    		
	    selectedElem = null;
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
								+ "' class='projectCell' style=\"position:relative;background-image:url('https://4and.me/uploads/"
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
		map.fitBounds([ sw, ne ], {
			padding : {
				top : 20,
				bottom : 150,
				left : 20,
				right : 20
			}
		});
		retryCount = 1;
	}
	
	function getProgressBar(id, funded, total) {
	    $( "#progressbar" + id).progressbar({
	      	value: Math.round(funded),
	      	max: Math.round(total)
	    });
	}
	
</script>
<?php include('footer.inc'); ?>