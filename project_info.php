	<?php if (strlen($summary) > 2) { ?>
	<!--  <div class="section" style="text-align:center">
		<h5 class="donor-text text-lighten-2" style="padding:2% 0% 0% 0%;">Project Info</h5>
	</div> -->
	
	<div class="section">	
		<div class="row">
				<div class="col s12 <?php print ($hasEvents ? "m9 l9" : "m12 l12"); ?>">
				<div class="card grey lighten-5 z-depth-1">
					<div class="card-content brown-text text-lighten-2">

							<p class="flow-text"><?php print editable("projects","$projectId","project_summary", "project_id", $summary); ?>
							</p>

							<?php if (strlen($problem) > 1) { ?> <br>
							<p>
								<b>Community Problem:</b> <?php print editable("projects","$projectId","project_community_problem", "project_id", $problem); ?>
							</p> 
							<?php } ?>
							
							<?php if (strlen($solution) > 1) { ?> <br>
						
							<p>
								<b>Community Solution:</b> <?php print editable("projects","$projectId","project_community_solution", "project_id", $solution); ?>
							</p>
							<?php } ?>
							
							<?php if (strlen($communityPartners) > 1) { ?> <br>
					
							<p>
								<b>Partners:</b> <?php print editable("projects","$projectId","project_community_partners", "project_id", $communityPartners); ?>
							</p>
							<?php } ?>
							
							<?php if (strlen($impact) > 1) { ?> <br>
					
							<p>
								<b>Outcome:</b> <?php print editable("projects","$projectId","project_impact", "project_id", $impact); ?>
							</p>
							<?php } ?>
						
					</div>
				</div>

			</div>
			<?php 
		
			$stmt = prepare("SELECT pe_date, pet_label FROM project_events JOIN project_event_types ON pe_type=pet_id WHERE pe_project_id=? ORDER BY pe_date");
			$stmt->bind_param('i', $projectId);
        		$result = execute($stmt);
        	    $count = 0;
        	    while ($row = $result->fetch_assoc()) {
        	        if ($count == 0) {
        	            ?>
        	            <div class="col s12 m3 l3">
		
					<div class="timeline-container" style="textalign:center">
					<?php
        	        } 
			     ?>
    	        			<div class="timeline-block timeline-block-right">
						<div class="marker donor-background"></div>
						<div class="timeline-content">
							<h6><?php print date("M Y", strtotime($row['pe_date'])); ?></h6>
							<span><?php print $row['pet_label']; ?></span>
						</div>
					</div>
		  <?php $count++; 
        	  }
        	  $stmt->close();
		  if ($count > 0) { 
		  		if ($count == 2 && $session_is_admin) { ?>
		  			<div class="timeline-block timeline-block-right">
						<div class="marker donor-background"></div>
						<div class="timeline-content">
							<span><a href='admin_fullyFundedTest.php?id=<?php print $projectId; ?>'>Test Fully Funded Email</a></span>
						</div>
					</div>
		  		<?php
	  			} elseif ($count == 3 && $session_is_admin) { ?>
					<div class="timeline-block timeline-block-right">
						<div class="marker donor-background"></div>
						<div class="timeline-content">
							<span><a href="" onclick="if (confirm('Are you sure you want to complete this project? Emails will be sent to donors and this page will be updated')) { document.location = 'admin_completeProject.php?id=<?php print $projectId; ?>'; } return false;">Complete Project (admin)</a> <a href='admin_completeProjectTest.php?id=<?php print $projectId; ?>'>(test)</a></span>
						</div>
					</div>
		  		<?php
		  		}

		  	?>
				</div>
			</div>
		  <?php } ?>
		</div>
		
			<?php } ?>
			<?php 
			
			$result = doUnprotectedQuery("SELECT fo_first_name, fo_last_name, picture_filename, fo_email, fo_phone FROM field_officers JOIN pictures ON picture_id=fo_picture_id WHERE fo_id=$staffId");
			if ($row = $result->fetch_assoc()) {        
			?>
    			<div class="row">
    				<div class="col s12 m9 l9">
    					<div class="grey lighten-5 z-depth-1">
    						<div class="row valign-wrapper" style="padding: 2% 2% 2% 2%">
    							<div class="col s12 m4 l4 center-align">
    							<img id='officerImage' src="<?php print PICTURES_DIR.$row['picture_filename']; ?>"
    								alt="" class="responsive-img circle"
    								style='width: 100px; height: 100px;<?php 
    							if ($session_is_admin) {
          							print "border:3px solid orange;' onclick=\"$.get('admin_edit_increment_officer.php?id=$projectId', function(data) { data = JSON.parse(data); $('#officerImage').attr('src',data.picture); $('#officerName').text(data.name); $('#officerEmail').text(data.email);$('#officerPhone').text(data.phone); });\"";
						        } else { print "'"; }
						        ?> />
    							<!-- notice the "circle" class -->
    							</div>
    							<div class="col s12 m8 l8 black-text">
    								<b>Field Officer <span id='officerName'><?php print "{$row['fo_first_name']} {$row['fo_last_name']}"; ?></span></b>
    								<p/>
    								<b>Email:</b> <span id='officerEmail'><?php print $row['fo_email']; ?></span><b><br>Phone Number:</b>
    									<span id='officerPhone'><?php print $row['fo_phone']; ?></span>
    							</div>
    						</div>
    					</div>
    				</div>
            <?php } ?>
     			
				<div class="col s12 m3 l3 center-align">
					<h6 class="brown-text">
						<b>Share <?php print $villageName; ?>'s Story</b>
					</h6>
					<br>
					<?php printShareButtons($projectShortcut, $projectName, $projectName, 60); ?>
				</div>
			</div>

		<?php 
		$stmt = prepare("SELECT pc_id, pc_label, pc_amount, ct_icon FROM project_costs JOIN cost_types ON pc_type=ct_id WHERE pc_project_id=?");
		$stmt->bind_param('i', $projectId);
		$result = execute($stmt);
	    $count = 0;
	    while ($row = $result->fetch_assoc()) {
	    		if ($count == 0) { ?>
			<div id="costbreakdown" class="section scrollspy">
				<h5 class="donor-text text-lighten-2" style="text-align: center">Cost Breakdown</h5>
			<br>
			<div class="row">
			<?php } 
			$pcId = $row['pc_id'];
			$icon = $row['ct_icon'];
			$label = $row['pc_label'];
			$amount = $row['pc_amount']; 
			?>
				<div class="col s12 m2 l2">
					<div class="icon-block center brown-text">
						<i class="material-icons" style="font-size: 30px"><?php print $icon; ?></i>
						<h5><?php print $label; ?></h5>
						<h5 class="light center">
							$<?php print editable("project_costs","$pcId","pc_amount", "pc_id", $amount); ?>
						</h5>
							<br>
					</div>
				</div>
		<?php $count++; 
	    }
	    $stmt->close();
		if ($count > 0) { ?>
		
			<br>
			</div>	
			</div>
		<?php } ?>
</div>