<?php
require_once("utilities.php");
include("header.inc");
$stmt = prepare("SELECT project_completion, GROUP_CONCAT(picture_filename) as pictures, GROUP_CONCAT(pu_description SEPARATOR '~') AS descriptions, project_name, village_name,  MAX(pu_timestamp) AS maxTime FROM projects JOIN villages ON project_completion IS NOT NULL AND project_village_id=village_id JOIN project_updates ON pu_project_id=project_id JOIN pictures ON pu_image_id=picture_id GROUP BY project_id ORDER BY maxTime DESC");
$result = execute($stmt);
$count = 0;
$firstDate = '';
print "<script>var index = 0, titles = new Array(), dates = new Array(), completions = new Array(), pictureStrs = new Array(), descriptionStrs = new Array();</script>";
while ($row = $result->fetch_assoc()) {
    $projectName = $row['project_name'];
    $villageName = $row['village_name'];
    $date = (new DateTime($row['maxTime']))->format("F j, Y");
    $completion = $row['project_completion'];
    $pictureStr = $row['pictures'];
    $descriptionStr = $row['descriptions'];
    
    if ($count == 0) {
        $pictures = explode(',', $pictureStr);
        $descriptions = explode('~', $descriptionStr);
        print "<div id='newsPics' class='section scrollspy' style='margin:20px;'>
    			           <h5 style='text-align: center; color:#4FC3F7; font-weight:300;' id='newsTitleSpan'>News from the Villages</h5>
                    <TABLE style='width:100%;'><TR><TD style='width:50%;position:relative;vertical-align:top;'><BR><span style='color:black;font-weight:bold;'>$projectName in $villageName - $date</span>
                            <p/><span class='flow-text align-center' style='font-size:16px;' id='newsCompletionSpan'>$completion</span>
                    <TABLE style='padding:20px;'><TR><TD>
                    <a href='' onclick='jumpToProject(--index); return false;' style='display:none;font-weight:bold;color:#4FC3F7; id='newsPreviousProjectLink'>&lt;&lt;</a>
                    </TD><TD style='text-align:right;'>
                    <a href='' onclick='jumpToProject(++index); return false;' style='font-weight:bold;color:#4FC3F7;' id='newsNextProjectLink'>October 15th, 2017 &gt;&gt;</a>
                    </TD></TR></TABLE>    
                    </TD><TD style='width:50%;'>
                         <div class='carousel' id='newsCarouselDiv'>"; 
                               
                   
                               
        $index = 0;
        foreach ($pictures AS $picture) {
            print "<a class='carousel-item' href='' onclick=\"$('#newsPictureCaptionId').text('".addslashes($descriptions[$index])."'); return false;\"><img src='".PICTURES_DIR."{$picture}' /></a>";
            $index++;
        }
        print "</div>
        </TD></TR>
        </TABLE>";
    } 
    print "<script>pictureStrs.push(\"$pictureStr\"); descriptionStrs.push(\"".addslashes($descriptionStr)."\"); completions.push(\"".addslashes($completion)."\");
            titles.push(\"$projectName in $villageName\"); dates.push(\"$date\");</script>"; 
    $count++;
}
$stmt->close();
    ?>
<h6 style="text-align: center" id='newsPictureCaptionId'>(swipe to view on mobile)</h6>
<script>
  	$(document).ready(function(){
      	$('.carousel').carousel();
  	});

  	if (dates.length > 1) {
		$('#newsNextProjectLink').text(dates[1] + " >>");
		$('#newsNextProjectLink').show();
  	}
	
	function jumpToProject(index) {
		if (index == 0) { 
			$('#newsPreviousProjectLink').hide();
		} else {
			$('#newsPreviousProjectLink').show();
			$('#newsPreviousProjectLink').text("<< " + dates[index - 1]);
		}
		if (index == <?php print ($count - 1); ?>) {
			$('#newsNextProjectLink').hide();
		} else {
			$('#newsNextProjectLink').show();
			$('#newsPreviousProjectLink').text(dates[index + 1] + " >>");
		}
		carouselDiv = $('#newsCarouselDiv');

		newCarouselDiv = $("<div>", {"id": "newsCarouselDiv", "class": "carousel"});
		pictures = pictureStrs[index].split(",");
		descriptions = descriptionStrs[index].split("~");
		for (i = 0; i < pictures.length; i++) {
			a = $("<a>", {"href": "", "class": "carousel-item"});
			img = $("<img>", {"src": "<?php print PICTURES_DIR; ?>" + pictures[i]});
			a.append(img);
			a.click(function() {
				$('#newsPictureCaptionId').text(eval(descriptions[i])); 
				return false;
			});
			newCarouselDiv.append(a);
		}
		carouselDiv.replaceWith(newCarouselDiv);
      	$('.carousel').carousel();
		
		$('#newsTitleSpan').text(titles[index] + " - " + dates[index]);
		$('#newsCompletionSpan').text(completions[index]);
	}
</script>
</div>
  