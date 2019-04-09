<div class="section">
<?php
$years = array();
$values = array();
$result = doStatQuery($villageId, "Comp Score");
while ($row = $result->fetch_assoc()) {
  $years[] = $row['stat_year'];
  $values[] = $row['stat_value'];
}
if (count($years) > 1) { ?>
	<div id="databreakdown" class="section scrollspy">
		<h5 class="donor-text text-lighten-2" style="text-align: center">
			Data Trends in <?php print $villageName; ?> Village
		</h5>
				
	<div class="row">
			
		<div class="col s12 m6 l6 center-align" style="padding: 20px 30px 20px 30px">

			<h6 style="text-align: center">
				<b>Development Scores: <span class="donor-text"><?php print $villageName; ?> Village</span> v. 
					<span style="color:rgba(220,220,220,1)">Control Villages</span>
				</b>
			</h6>
			
			<div>
				<canvas id="chart2" width="250" height="250"></canvas>
			</div>

			<script>
				var ctx = document.getElementById("chart2").getContext('2d');

				var chart2 = new Chart(ctx, {
					type : 'line',
					data : {
						labels : [ <?php print join(',', $years); ?> ],
						datasets : [ {
							label: "<?php print $villageName; ?>",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "#6495ED",
                             pointBackgroundColor: "#6495ED",
                             pointRadius: 10,
							data : [ <?php print join(',', $values); ?> ],
							cubicInterpolationMode: 'monotone',
						}, 

						{
							label: "Control Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "rgba(220,220,220,1)",
                             pointBackgroundColor: "rgba(220,220,220,1)",
                             pointRadius: 10,
                             data : [ 26, 28, 27, 26, 31 ],
							cubicInterpolationMode: 'monotone',
						}]
						}, 
					options : {
						responsive : true,
						maintainAspectRatio : false,
						legend : {
							display : false,
						},
					scales : {
						yAxes : [ {
							ticks : {
								beginAtZero : true
							}
						} ]
					},
					}

				});
			</script>
		</div>
			
		<?php 
			$stmt = prepare("SELECT project_id, project_name, project_budget, YEAR(pe_date) AS yearPosted FROM projects JOIN project_events ON project_village_id=? AND pe_project_id=project_id AND pe_type=4 ORDER BY yearPosted ASC");
			$stmt->bind_param('i', $villageId);
			$result = execute($stmt);
			$count = 0;
			$labels = '';
			$amounts = '';
			$ids = '';
			$accum = 0;
			$currentYear = 2014;
			while ($row = $result->fetch_assoc()) {
			    if ($count > 0) {
		        	$labels .= ", ";
			        $amounts .= ", ";
			        $ids .= ", ";
		     	}
	           	$nextYear = $row['yearPosted'];
	           	while ($currentYear < $nextYear) {
	              	$ids .= "0, ";
	              	$amounts .= "$accum, ";
	              	$labels .= "$currentYear, ";
	              	$currentYear++;
	              	$count++;
	           	}
		     	$ids .= $row['project_id'];
			    $labels .= $row['yearPosted'];
			    $accum += $row['project_budget'];
			    $amounts .= $accum;
			    $count++;
           		$currentYear++;
			}
			$stmt->close();

	      	while ($currentYear <= 2017) {
		        if ($count > 0) {
		          $labels .= ", ";
		          $amounts .= ", ";
		          $ids .= ", ";
		        }
		        $ids .= '0';
		        $amounts .= "$accum";
		        $labels .= "$currentYear";

		        $currentYear++;
		        $count++;
	      	}

			if ($accum > 0) { ?>
			
				<div class="col s12 m6 l6 center-align" style="padding: 20px 30px 20px 30px">
					<h6 style="text-align: center"><b>Dollars Invested (cumulative)</b></h6>
					<canvas id="chart1" width="250" height="250"></canvas>
				</div>
					
				<script>
					var ctx = document.getElementById("chart1").getContext('2d');

					var chart1 = new Chart(ctx, {
						type : 'line',
						data : {
							ids: [<?php print $ids; ?>],
							labels : [ <?php print $labels; ?> ],
							datasets : [ {
								fill : false,
								backgroundColor : "#ffce56",
								pointBackgroundColor: "#6495ED",
	                            	pointRadius: 10,
	                            	borderColor: "#6495ED",
								data : [ <?php print $amounts; ?> ],
								cubicInterpolationMode: 'monotone',
								
							} ]
						},
						options : {
							responsive : true,
							maintainAspectRatio : false,
							legend : {
								display : false,
							},
							scales : {
								yAxes : [ {
									ticks : {
										beginAtZero : true,
										stacked:true,
	                  					max: <?php print (round($accum, -3) + 1000); ?>
									}
								} ]
							},
							onClick: function(event, active) {
								if (active && active.length > 0) {
									id = active[0]._chart.data.ids[active[0]._index];
									if (id != <?php print $projectId; ?> && id > 0) {
										window.location.href = "project.php?id=" + id;
									}
								}
							}
						}
					});
				</script>	
					
				<br>
			<?php } ?>
	
	</div>

	<div class="row">
		<div class="col s12 m6 l6 center-align" style="padding: 20px 30px 20px 30px">	
			<h6 style="text-align: center"><b>Cases of Waterborne Illness</b></h6>
			<div>
				<canvas id="chart3" width="250" height="250"></canvas>
			</div>

			<?php
				$years = array();
				$values = array();
				$result = doStatQuery($villageId, "Waterborne Illness");
				while ($row = $result->fetch_assoc()) {
				    $years[] = $row['stat_year'];
				    $values[] = $row['stat_value'];
				}
			?>
			<script>
				var ctx = document.getElementById("chart3").getContext('2d');

				var chart3 = new Chart(ctx, {
					type : 'line',
					data : {
						labels : [ <?php print join(',', $years); ?> ],
						datasets : [ {
							fill : false,
							backgroundColor : "#6495ED",
							pointBackgroundColor: "#6495ED",
                        		pointRadius: 10,
                        		borderColor: "#6495ED",
							data : [ <?php print join(',', $values); ?> ],
						} ]
					},
					options : {
						responsive : true,
						maintainAspectRatio : false,
						legend : {
							display : false,
						},
						scales : {
							yAxes : [ {
								ticks : {
									beginAtZero : true,
								}
							} ]
						},
					}
				});
			</script>
		</div>
	
		<div class="col s12 m6 l6" style="padding: 20px 30px 20px 30px">
			<h6 style="text-align: center"><b>Remaining Dimensions</b></h6>
			<div>
				<canvas id="chart4" width="250" height="250"></canvas>
			</div>

			<?php
			  $business = getStatYearAssociative($villageId, "Biz Score");
			  $lifestyle = getStatYearAssociative($villageId, "Lifestyle Score");
			  $education = getStatYearAssociative($villageId, "Edu Score");
			  $agriculture = getStatYearAssociative($villageId, "Ag Score");
			  $livestock = getStatYearAssociative($villageId, "Livestock Score");
			?>

			<script>
				var ctx = document.getElementById("chart4").getContext(
						'2d');
				var chart4 = new Chart(ctx,
						{
							type : 'radar',
							data : {
								labels : [ 'Business', 'Lifestyle',
										'Education', 'Agriculture',
										'Livestock'],
								datasets : [<?php 
								  $count = 0;
								  $keys = array_keys($business);
								  $colors = array('rgba(255,99,132,0.6)', 'rgba(54,162,235,0.6)', 'rgba(255,206,86,0.6)', 'rgba(187,174,204,0.6)', 'rgba(221,119,51,0.6)');
								  foreach ($keys as $year) {
								      if ($count > 0) {
								          print ", \n";
								      }
								      print "{
											fill : true,
											backgroundColor : '{$colors[$count]}',
                                         pointRadius: 2,
											label : '$year',
											data : [ ".round($business[$year]).", ".round($lifestyle[$year]).", ".round($education[$year] * .2).", ".round($agriculture[$year] * .05).", ".round($livestock[$year])."],
								      }";
								      $count++;
								  }
								?>],
							},
							options : {
								responsive : true,
								maintainAspectRatio : false,
							}
						});
			</script>
		</div> 
<?php } ?>
</div>