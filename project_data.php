<div class="section">
<?php
$years = array();
$values = array();
$result = doStatQuery($villageId, "Comp Score");
while ($row = $result->fetch_assoc()) {
  $years[] = $row['stat_year'];
  $values[] = $row['stat_value'];
}

function convertToPercentages($inputArray) {
	$base = max(1, $inputArray[0]);
	for ($i = 1; $i < count($inputArray); $i++) {
		$inputArray[$i] = ($inputArray[$i] - $base) / $base * 100;
	}
	$inputArray[0] = 0;

	return $inputArray;
}

if (count($years) > 1) { ?>
	<div id="databreakdown" class="section scrollspy">
				
	<div class="row">
			
		<div class="col s12 m6 l6 center-align" style="padding: 20px 30px 20px 30px">

			<h5 style="text-align: center">
				<b>Change in Development Score:<br/><span class="blue-text"><?php print $villageName; ?> Village</span> v. 
					<span style="color:rgba(192,192,192,1)">Control Villages</span>
				</b>
			</h5>
			
			<div>
			<canvas id="chart1" width="250" height="250"></canvas>
			</div>

			<script>
				var ctx = document.getElementById("chart1").getContext('2d');

				var chart1 = new Chart(ctx, {
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
							data : [ <?php print join(',', convertToPercentages($values)); ?> ],
							cubicInterpolationMode: 'monotone',
						}, 

						{
							label: "Control Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "rgba(220,220,220,1)",
                             pointBackgroundColor: "rgba(220,220,220,1)",
                             pointRadius: 10,
                             data : [ <?php print join(',', array(0, 8, 4, 1, 19)); ?> ],
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
								beginAtZero : false,
								stacked:true,
								callback: function(value, index, values) {
									return value + '%';
                    			}
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
					<h5 style="text-align: center"><b>Dollars Invested in Projects in <br/><span class="blue-text"><?php print $villageName; ?> Village</span> (cumulative)</b></h5>
				<div><canvas id="chart2" width="250" height="250"></canvas></div>
					
				<script>
					var ctx = document.getElementById("chart2").getContext('2d');

					var chart2 = new Chart(ctx, {
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
										beginAtZero : false,
										stacked:true,
	                  					max: <?php print (round($accum, -3) + 1000); ?>,
										callback: function(value, index, values) {
											return '$' + value;
		                    			}
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
			<h5 style="text-align: center"><b>Change in Health Burden:<br/><span class="blue-text"><?php print $villageName; ?> Village</span> v. 
					<span style="color:rgba(192,192,192,1)">Control Villages</span></b></h5>
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
							data : [ <?php print join(',', convertToPercentages($values)); ?> ],
						},
						{
							label: "Control Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "rgba(220,220,220,1)",
                             pointBackgroundColor: "rgba(220,220,220,1)",
                             pointRadius: 10,
                             data : [ <?php print join(',', convertToPercentages(array(38, 39, 38, 44, 41))); ?> ],
							cubicInterpolationMode: 'monotone',
						}
						 ]
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
									beginAtZero : false,
									callback: function(value, index, values) {
										return value + '%';
	                    			}
								}
							} ]
						},
					}
				});
			</script>
			<h6 style="padding:0 3% 0 3%">*Scores based on # of waterborne illnesses, malaria cases, maternal deaths, and infant deaths per capita.</h6>
		</div>
		<div class="col s12 m6 l6 center-align" style="padding: 20px 30px 20px 30px">	
			<h5 style="text-align: center"><b>Change in Local Education:<br/><span class="blue-text"><?php print $villageName; ?> Village</span> v. 
					<span style="color:rgba(192,192,192,1)">Control Villages</span></b></h5>
			<div>
				<canvas id="chart4" width="250" height="250"></canvas>
			</div>

			<?php
				$years = array();
				$values = array();
				$result = doStatQuery($villageId, "Edu Score");
				while ($row = $result->fetch_assoc()) {
				    $years[] = $row['stat_year'];
				    $values[] = $row['stat_value'];
				}
			?>
			<script>
				var ctx = document.getElementById("chart4").getContext('2d');

				var chart4 = new Chart(ctx, {
					type : 'line',
					data : {
						labels : [ <?php print join(',', $years); ?> ],
						datasets : [ {
							fill : false,
							backgroundColor : "#6495ED",
							pointBackgroundColor: "#6495ED",
                        		pointRadius: 10,
                        		borderColor: "#6495ED",
							data : [ <?php print join(',', convertToPercentages($values)); ?> ],
						},
						{
							label: "Control Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "rgba(220,220,220,1)",
                             pointBackgroundColor: "rgba(220,220,220,1)",
                             pointRadius: 10,
                             data : [ <?php print join(',', convertToPercentages(array(93, 100, 100, 103, 104))); ?> ],
							cubicInterpolationMode: 'monotone',
						}
						 ]
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
									beginAtZero : false,
									callback: function(value, index, values) {
										return value + '%';
	                    			}
								}
							} ]
						},
					}
				});
			</script>
			<h6 style="padding:0 3% 0 3%">*Scores based on school enrollment and national exam passage rates per capita.</h6>
		</div> 
		</div>

		<div class="row">
		<div class="col s12 m6 l6 center-align" style="padding: 20px 30px 20px 30px">	
			<h5 style="text-align: center"><b>Change in Business Activity:<br/><span class="blue-text"><?php print $villageName; ?> Village</span> v. 
					<span style="color:rgba(192,192,192,1)">Control Villages</span></b></h5>
			<div>
				<canvas id="chart5" width="250" height="250"></canvas>
			</div>

			<?php
				$years = array();
				$values = array();
				$result = doStatQuery($villageId, "Biz Score");
				while ($row = $result->fetch_assoc()) {
				    $years[] = $row['stat_year'];
				    $values[] = $row['stat_value'];
				}
			?>
			<script>
				var ctx = document.getElementById("chart5").getContext('2d');

				var chart5 = new Chart(ctx, {
					type : 'line',
					data : {
						labels : [ <?php print join(',', $years); ?> ],
						datasets : [ {
							fill : false,
							backgroundColor : "#6495ED",
							pointBackgroundColor: "#6495ED",
                        		pointRadius: 10,
                        		borderColor: "#6495ED",
							data : [ <?php print join(',', convertToPercentages($values)); ?> ],
						},
						{
							label: "Control Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "rgba(220,220,220,1)",
                             pointBackgroundColor: "rgba(220,220,220,1)",
                             pointRadius: 10,
                             data : [ <?php print join(',', convertToPercentages(array(16, 19, 18, 19, 20))); ?> ],
							cubicInterpolationMode: 'monotone',
						}
						 ]
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
									beginAtZero : false,
									callback: function(value, index, values) {
										return value + '%';
	                    			}
								}
							} ]
						},
					}
				});
			</script>
			<h6 style="padding:0 3% 0 3%">*Scores based on # of agriculural and non-agricultural village businesses per capita.</h6>
		</div>
	
		<div class="col s12 m6 l6 center-align" style="padding: 20px 30px 20px 30px">	
			<h5 style="text-align: center"><b>Change in Lifestyle Upgrades:<br/><span class="blue-text"><?php print $villageName; ?> Village</span> v. 
					<span style="color:rgba(192,192,192,1)">Control Villages</span></b></h5>
			<div>
				<canvas id="chart6" width="250" height="250"></canvas>
			</div>

			<?php
				$years = array();
				$values = array();
				$result = doStatQuery($villageId, "Lifestyle Score");
				while ($row = $result->fetch_assoc()) {
				    $years[] = $row['stat_year'];
				    $values[] = $row['stat_value'];
				}
			?>
			<script>
				var ctx = document.getElementById("chart6").getContext('2d');

				var chart6 = new Chart(ctx, {
					type : 'line',
					data : {
						labels : [ <?php print join(',', $years); ?> ],
						datasets : [ {
							fill : false,
							backgroundColor : "#6495ED",
							pointBackgroundColor: "#6495ED",
                        		pointRadius: 10,
                        		borderColor: "#6495ED",
							data : [ <?php print join(',', convertToPercentages($values)); ?> ],
						},
						{
							label: "Control Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "rgba(220,220,220,1)",
                             pointBackgroundColor: "rgba(220,220,220,1)",
                             pointRadius: 10,
                             data : [ <?php print join(',', convertToPercentages(array(24, 28, 31, 34, 44))); ?> ],
							cubicInterpolationMode: 'monotone',
						}
						 ]
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
									beginAtZero : false,
									callback: function(value, index, values) {
										return value + '%';
	                    			}
								}
							} ]
						},
					}
				});
			</script>
			<h6 style="padding:0 3% 0 3%">*Scores based on # of roofs with iron sheets, TVs, motorcycles, and smartphones per capita.</h6>
		</div> 
		</div>

		<div class="row">
		<div class="col s12 m6 l6 center-align" style="padding: 20px 30px 20px 30px">	
			<h5 style="text-align: center"><b>Change in Agricultural Production:<br/><span class="blue-text"><?php print $villageName; ?> Village</span> v. 
					<span style="color:rgba(192,192,192,1)">Control Villages</span></b></h5>
			<div>
				<canvas id="chart7" width="250" height="250"></canvas>
			</div>

			<?php
				$years = array();
				$values = array();
				$result = doStatQuery($villageId, "Ag Score");
				while ($row = $result->fetch_assoc()) {
				    $years[] = $row['stat_year'];
				    $values[] = $row['stat_value'];
				}
			?>
			<script>
				var ctx = document.getElementById("chart7").getContext('2d');

				var chart7 = new Chart(ctx, {
					type : 'line',
					data : {
						labels : [ <?php print join(',', $years); ?> ],
						datasets : [ {
							fill : false,
							backgroundColor : "#6495ED",
							pointBackgroundColor: "#6495ED",
                        		pointRadius: 10,
                        		borderColor: "#6495ED",
							data : [ <?php print join(',', convertToPercentages($values)); ?> ],
						},
						{
							label: "Control Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "rgba(220,220,220,1)",
                             pointBackgroundColor: "rgba(220,220,220,1)",
                             pointRadius: 10,
                             data : [ <?php print join(',', convertToPercentages(array(431, 349, 274, 227, 282))); ?> ],
							cubicInterpolationMode: 'monotone',
						}
						 ]
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
									beginAtZero : false,
									callback: function(value, index, values) {
										return value + '%';
	                    			}
								}
							} ]
						},
					}
				});
			</script>
			<h6 style="padding:0 3% 0 3%">*Scores based on # of 60 kg bags of maize produced per capita.</h6>
		</div>
	
		<div class="col s12 m6 l6 center-align" style="padding: 20px 30px 20px 30px">	
			<h5 style="text-align: center"><b>Change in Livestock Holdings:<br/><span class="blue-text"><?php print $villageName; ?> Village</span> v. 
					<span style="color:rgba(192,192,192,1)">Control Villages</span></b></h5>
			<div>
				<canvas id="chart8" width="250" height="250"></canvas>
			</div>

			<?php
				$years = array();
				$values = array();
				$result = doStatQuery($villageId, "Livestock Score");
				while ($row = $result->fetch_assoc()) {
				    $years[] = $row['stat_year'];
				    $values[] = $row['stat_value'];
				}
			?>
			<script>
				var ctx = document.getElementById("chart8").getContext('2d');

				var chart8 = new Chart(ctx, {
					type : 'line',
					data : {
						labels : [ <?php print join(',', $years); ?> ],
						datasets : [ {
							fill : false,
							backgroundColor : "#6495ED",
							pointBackgroundColor: "#6495ED",
                        		pointRadius: 10,
                        		borderColor: "#6495ED",
							data : [ <?php print join(',', convertToPercentages($values)); ?> ],
						},
						{
							label: "Control Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "rgba(220,220,220,1)",
                             pointBackgroundColor: "rgba(220,220,220,1)",
                             pointRadius: 10,
                             data : [ <?php print join(',', convertToPercentages(array(78, 88, 81, 73, 87))); ?> ],
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
									beginAtZero : false,
									callback: function(value, index, values) {
										return value + '%';
	                    			}
								}
							} ]
						},
					}
				});
			</script>
							<h6 style="padding:0 3% 0 3%">*Scores based on # of goats and cows per capita.</h6>
		</div> 
		</div>
	
<?php } ?>
</div>