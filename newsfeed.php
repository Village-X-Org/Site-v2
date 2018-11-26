<?php 
    require_once("utilities.php");
	$month = param('month');

	$dateStr = date('Y-m-d', strtotime($month));

	$edit = isset($session_is_admin) && $session_is_admin && hasParam('edit');

    $result = doUnprotectedQuery("SELECT ru_id, project_id, project_name, village_name, ru_description, ru_date, ru_picture_ids FROM raw_updates JOIN projects ON project_id=ru_project_id 
        JOIN villages ON project_village_id=village_id WHERE MONTH(ru_date)=MONTH('$dateStr') AND YEAR(ru_date)=YEAR('$dateStr') ORDER BY ru_date DESC");

	$count = $lastDate = $previousDate = 0;
	while ($row = $result->fetch_assoc()) {
	    $date = (new DateTime($row['ru_date']))->format("F jS, Y");
	   	$ruId = $row['ru_id'];
	    $projectId = $row['project_id'];
	  	$projectName = $row['project_name'];
	  	$villageName = $row['village_name'];
	  	$updateDescription = $row['ru_description'];
	  	$pictureIds = explode(",", $row['ru_picture_ids']);
	    $primaryPictureFilename = PICTURES_DIR . $pictureIds[1].".jpg";
	    $primarySmallFilename = PICTURES_DIR . "s".$pictureIds[1].".jpg";
	    $pictureBuffer = '';
	    for ($i = 2; $i < count($pictureIds) - 1; $i++) {
	    	$pictureFilename = PICTURES_DIR . $pictureIds[$i].".jpg";
	    	$smallFilename = PICTURES_DIR . "s".$pictureIds[$i].".jpg";
			$pictureBuffer .= "<a href='$pictureFilename'  data-imagelightbox='update$ruId'><img src='$smallFilename' style='display:none;' /></a>";
		}
		$additionalPictureCount = count($pictureIds) - 3;
	  	
	  	$indexOfPeriod = strpos($updateDescription, '.');
	  	$firstSentence = substr($updateDescription, 0, $indexOfPeriod);
	  	
	  	if ($lastDate) {
	  	    $previousDate = $lastDate;
	  	}
	  	$lastDate = $date;
	        ?>
	        <div class="card horizontal <?php print ($count % 2 == 1 ? "right" : ""); ?>" 
	        	style="<?php print ($count % 2 == 0 ? "border-top-left-radius:15px;border-bottom-left-radius:15px;" 
	        	: "border-top-right-radius:15px;border-bottom-right-radius:15px;"); ?>margin:20px;width:95%;height:200px;text-align:left;">
	        	<?php if ($count % 2 == 0) { ?>
	        		<div class="card-image" style='position:relative;'>
		        		<a href='<?php print $primaryPictureFilename; ?>' data-imagelightbox='update<?php print $ruId; ?>'><img src="<?php print "$primarySmallFilename"; ?>" style="object-fit:cover;width:200px;height:200px;border-top-left-radius:15px;border-bottom-left-radius:15px;" /></a>
		        		<?php if ($additionalPictureCount > 0) { ?>
		        		<div style='position:absolute;bottom:0px;right:5px;font-size:36px;font-weight:bold;opacity:.8;color:#DDDDDD;'>+<?php print $additionalPictureCount; ?></div>
		      			<?php print $pictureBuffer; 
		      			}?>
		      		</div>
	        	<?php } ?>
		      <div class="card-stacked">
		        <div class="card-action" style='margin-left:20px;padding-left:0px;border-top:0px;border-bottom:1px solid rgba(160,160,160,0.2);'>
		          <a style='color:black;font-weight:bold;text-transform:none;' href="project.php?id=<?php print $projectId; ?>"><?php print "$date $projectName in $villageName"; ?></a>
		        </div>
		        <div class="card-content" style='overflow:hidden;padding-top:10px;'>
		          <?php print ($edit ? "<TEXTAREA id='newDescription$ruId'>" : "").$updateDescription.($edit ? "</TEXTAREA><br/><input type='button' value='update description' onclick=\"updateDescription($ruId, $('#newDescription$ruId').val());\" />" : ""); ?>
		        </div>
		      </div>
		      <?php if ($count % 2 == 1) { ?>
	        		<div class="card-image" style='position:relative;'>
		        		<a href='<?php print $primaryPictureFilename; ?>' data-imagelightbox='update<?php print $ruId; ?>'><img src="<?php print "$primarySmallFilename"; ?>" style="object-fit:cover;width:200px;height:200px;border-top-right-radius:15px;border-bottom-right-radius:15px;" /></a>
		        		<?php if ($additionalPictureCount > 0) { ?>
		        		<div style='position:absolute;bottom:0px;right:5px;font-size:36px;font-weight:bold;opacity:.8;color:#DDDDDD'>+<?php print $additionalPictureCount; ?></div>
		        		<?php print $pictureBuffer; 
		        		} ?>
		      		</div>
	        	<?php } ?>
			</div>
	   	<?php
	  	$count++;
    } ?>
    <script>
	    var attrs = {};
	    var classes = $("a[data-imagelightbox]").map(function(index, element) {
	      var key = $(element).attr("data-imagelightbox");
	      attrs[key] = true;
	      return attrs;
	    });
	    var attrsName = Object.keys(attrs);

	    attrsName.forEach(function(entry) {
	        $( "[data-imagelightbox='" + entry + "']" ).imageLightbox({
	            overlay: true,
	            navigation:true
	        });
	    });
	</script>