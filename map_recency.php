<?php
require_once("utilities.php");
$rebranded = 0;
if (hasParam('branding')) {
	$rebranded = paramInt('branding');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
if ($rebranded) {
	$stmt = prepare("SELECT org_name, org_lat, org_lng, org_zoom, org_logo, org_url, org_project_prefix, org_description, org_banner FROM orgs WHERE org_id=?");
	$stmt->bind_param("i", $rebranded);
	$result = execute($stmt);
	if ($row = $result->fetch_assoc()) {
		$pageTitle = $row['org_name']." | Project Update Recency Map";
		$lat = $row['org_lat'];
		$lng = $row['org_lng'];
		$zoom = $row['org_zoom'];
		$logo = $row['org_logo'];
		$url = $row['org_url'];
		$prefix = $row['org_project_prefix'];
		$pageDescription = $row['org_description'];
		$pageImage = $row['org_banner'];
	} else {
		print "</head><body>This organization does not exist</body></html>";
		die(1);
	}
} else {
  $pageTitle = "Village X | Project Update Recency Map";
  $pageDescription = "See how recently projects have been updated, visualized on a map.";
  $lat = -15.024;
  $lng = 35;
  $zoom = 7;
}
$pageUrl = getBaseURL()."map_recency.php".($rebranded ? "?branding=$rebranded" : "");
include('header.inc');

$stmt = prepare("
	SELECT
    p.project_id,
    p.project_name,
    p.project_lat,
    p.project_lng,
    YEAR(ru.ru_date) as update_year,
    DATE_FORMAT(ru.ru_date, '%Y-%m-%d') as latest_update_date,
    ru.ru_description as latest_description,
    ru.ru_picture_ids as picture_ids
FROM projects p
LEFT JOIN raw_updates ru ON ru.ru_id = (
    SELECT r2.ru_id
    FROM raw_updates r2
    WHERE r2.ru_project_id = p.project_id
    ORDER BY r2.ru_date DESC, r2.ru_id DESC
    LIMIT 1
)
ORDER BY p.project_id
");
$result = execute($stmt);
$projectsData = array();
$years = array();
$projectsByYear = array();

while ($row = $result->fetch_assoc()) {
	$row['project_id'] = intval($row['project_id']);
	$row['project_lat'] = floatval($row['project_lat']);
	$row['project_lng'] = floatval($row['project_lng']);
	if ($row['update_year']) {
		$row['update_year'] = intval($row['update_year']);
	}
	$projectsData[] = $row;
	if ($row['update_year']) {
		$years[$row['update_year']] = true;
		if (!isset($projectsByYear[$row['update_year']])) {
			$projectsByYear[$row['update_year']] = 0;
		}
		$projectsByYear[$row['update_year']]++;
	}
}
$stmt->close();

krsort($years);
$colorMap = array();
$colors = array('#2166ac', '#4575b4', '#91bfdb', '#fee090', '#fc8d59', '#d73027', '#a50026');
$colorIndex = 0;
foreach ($years as $year => $val) {
	if ($colorIndex < count($colors)) {
		$colorMap[intval($year)] = $colors[$colorIndex];
		$colorIndex++;
	}
}

$totalProjects = count($projectsData);
$coloredProjects = array_sum($projectsByYear);
$noRecentCount = $totalProjects - $coloredProjects;
?>
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

#legend {
	position: absolute;
	bottom: 20px;
	left: 20px;
	background: white;
	padding: 15px;
	border-radius: 5px;
	box-shadow: 0 0 10px rgba(0,0,0,0.2);
	z-index: 5;
	font-family: Arial, sans-serif;
	font-size: 12px;
}

#legend h4 {
	margin: 0 0 10px 0;
	font-size: 14px;
	font-weight: bold;
}

.legend-item {
	display: flex;
	align-items: center;
	margin: 5px 0;
}

.legend-color {
	width: 20px;
	height: 20px;
	margin-right: 8px;
	border-radius: 3px;
	border: 1px solid #999;
}

@media (min-width: 720px) {
    #mapScreenDiv {
	   height: calc(100vh - 60px);
    }
}

#updateModal {
	position: fixed;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
	width: 90%;
	max-width: 600px;
	max-height: 80vh;
	overflow-y: auto;
	background: white;
	border-radius: 8px;
	box-shadow: 0 5px 40px rgba(0,0,0,0.3);
	z-index: 1000;
	padding: 0;
	margin: 0;
	display: none;
}

#updateModal h4 {
	margin: 0 0 15px 0;
	color: #333;
	font-size: 20px;
	font-weight: 500;
}

#updateModal p {
	margin: 10px 0;
	color: #666;
}

#updateModal span {
	color: #333;
}

#modalOverlay {
	display: none;
}
</style>

<div id='mapScreenDiv'>
	<div id='mapContainer'>
		<div id="legend">
			<h4>Latest Update Year</h4>
			<?php
			foreach ($colorMap as $year => $color) {
				echo "<div class='legend-item'>";
				echo "<div class='legend-color' style='background-color: $color;'></div>";
				$count = $projectsByYear[$year] ?? 0;
				echo "<span>$year ($count)</span>";
				echo "</div>";
			}
			if ($noRecentCount > 0) {
				echo "<div class='legend-item'>";
				echo "<div class='legend-color' style='background-color: #cccccc;'></div>";
				echo "<span>Older ($noRecentCount)</span>";
				echo "</div>";
			}
			?>
		</div>
	</div>
</div>

<div id='updateModal'>
	<div style='padding: 25px; position: relative;'>
		<button style='position: absolute; top: 10px; right: 10px; background: none; border: none; font-size: 28px; cursor: pointer; color: #999;' onclick="closeUpdateModal();">&times;</button>
		<h4 id='projectTitle' style='margin-top: 0;'></h4>
		<p><b>Latest Update: </b><span id='updateDate'></span></p>
		<div id='updateDescription' style='margin: 15px 0; line-height: 1.6;'></div>
		<div id='updatePicture' style='margin: 15px 0; text-align: center;'></div>
		<button onclick="window.open('project.php?id=' + currentProjectId, '_blank');" style='margin-top: 10px; padding: 10px 20px; background-color: #1976d2; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;'>View Full Project</button>
	</div>
</div>
<div id='modalOverlay' style='position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 998; display: none;' onclick="closeUpdateModal();"></div>

<script>
	var projectsData = <?php echo json_encode($projectsData); ?>;
	var colorMap = <?php echo json_encode($colorMap); ?>;
	var currentProjectId = 0;
	var selectedVillage = 0;

	function closeUpdateModal() {
		$('#updateModal').hide();
		$('#modalOverlay').hide();
	}

	function openUpdateModal() {
		$('#updateModal').show();
		$('#modalOverlay').show();
	}

	mapboxgl.accessToken = '<?php print MAPBOX_API_KEY; ?>';

	var map = new mapboxgl.Map({
		container : 'mapContainer',
		style : 'mapbox://styles/jdepree/cmu1eax7d00as01sk4thw8ksy',
		center : [<?php print "$lng, $lat"; ?>],
		zoom : <?php print $zoom; ?>
	});

	map.addControl(new mapboxgl.NavigationControl(), 'top-left');
	map.scrollZoom.disable();

	map.on('load', function() {
		window.scrollTo(0,1);

		// Create GeoJSON for projects with color coding
		var features = [];

		// Nudge each project randomly by up to JITTER_FEET in any direction so projects with nearly identical coordinates don't stack on top of each other
		var JITTER_FEET = 300;
		function jitterCoordinates(lng, lat) {
			var feetPerDegreeLat = 364000;
			var feetPerDegreeLng = 364000 * Math.cos(lat * Math.PI / 180);
			return [
				lng + (Math.random() * 2 - 1) * JITTER_FEET / feetPerDegreeLng,
				lat + (Math.random() * 2 - 1) * JITTER_FEET / feetPerDegreeLat
			];
		}
		console.log('colorMap:', colorMap);
		console.log('projectsData sample:', projectsData.slice(0, 3));

		projectsData.forEach(function(project) {
			var color = colorMap[project.update_year] || '#cccccc';
			if (project.update_year && !colorMap[project.update_year]) {
				console.warn('No color for year:', project.update_year, 'available colors:', Object.keys(colorMap));
			}
			features.push({
				type: 'Feature',
				geometry: {
					type: 'Point',
					coordinates: jitterCoordinates(parseFloat(project.project_lng), parseFloat(project.project_lat))
				},
				properties: {
					id: project.project_id,
					name: project.project_name,
					color: color,
					update_year: project.update_year || '',
					latest_update_date: project.latest_update_date || '',
					latest_description: project.latest_description || '',
					picture_ids: project.picture_ids || ''
				}
			});
		});
		console.log('Features created:', features.length, 'with colors');

		// Add project source
		map.addSource('projects-recency', {
			type: 'geojson',
			data: {
				type: 'FeatureCollection',
				features: features
			}
		});

		// Add circle layer for projects
		map.addLayer({
			id: 'projects-recency-circles',
			type: 'circle',
			source: 'projects-recency',
			paint: {
				'circle-radius': 8,
				'circle-color': ['get', 'color'],
				'circle-stroke-width': 2,
				'circle-stroke-color': '#fff',
				'circle-opacity': 0.8
			}
		});

		// Add label layer
		map.addLayer({
			id: 'projects-recency-labels',
			type: 'symbol',
			source: 'projects-recency',
			layout: {
				'text-field': ['get', 'name'],
				'text-font': ['Open Sans Regular', 'Arial Unicode MS Regular'],
				'text-size': 12,
				'text-anchor': 'top',
				'text-offset': [0, 1.5]
			},
			paint: {
				'text-color': '#000',
				'text-halo-color': '#fff',
				'text-halo-width': 1
			},
			minzoom: 8
		});

		// Click handler
		map.on('click', 'projects-recency-circles', function(e) {
			var project = e.features[0].properties;
			currentProjectId = project.id;
			$('#projectTitle').text(project.name);

			if (project.latest_update_date) {
				$('#updateDate').text(project.latest_update_date);
			} else {
				$('#updateDate').text('No updates');
			}

			$('#updateDescription').empty();
			if (project.latest_description && project.latest_description !== '0' && project.latest_description !== null) {
				$('#updateDescription').html('<p>' + escapeHtml(project.latest_description) + '</p>');
			} else {
				$('#updateDescription').html('<p style="color: #999; font-style: italic;">No update description available</p>');
			}

			$('#updatePicture').empty();
			if (project.picture_ids) {
				var pictureIds = project.picture_ids.split(',').filter(function(id) { return id.trim().length > 0; });
				if (pictureIds.length > 0) {
					var firstPictureId = pictureIds[0].trim();
					var img = document.createElement('img');
					img.src = '<?php print ABS_PICTURES_DIR; ?>' + firstPictureId + '.jpg';
					img.style.maxWidth = '100%';
					img.style.maxHeight = '400px';
					img.style.borderRadius = '4px';
					img.onerror = function() {
						this.style.display = 'none';
						var notFound = document.createElement('p');
						notFound.style.color = '#999';
						notFound.style.fontStyle = 'italic';
						notFound.textContent = 'Image not found';
						$('#updatePicture').append(notFound);
					};
					$('#updatePicture').append(img);
				}
			}

			openUpdateModal();
		});

		function escapeHtml(unsafe) {
			return unsafe
				.replace(/&/g, "&amp;")
				.replace(/</g, "&lt;")
				.replace(/>/g, "&gt;")
				.replace(/"/g, "&quot;")
				.replace(/'/g, "&#039;");
		}

		// Change cursor on hover
		map.on('mouseenter', 'projects-recency-circles', function() {
			map.getCanvas().style.cursor = 'pointer';
		});
		map.on('mouseleave', 'projects-recency-circles', function() {
			map.getCanvas().style.cursor = '';
		});

		// Initial zoom
		map.flyTo({center: [<?php print "$lng, $lat"; ?>], zoom: <?php print $zoom; ?>});
	});
</script>
<?php if (!$rebranded) {
	include('footer.inc');
} ?>
</html>
