<style>
.meter { 
	height: 7px;  /* Can be anything */
	position: relative;
	background: #555;
	-moz-border-radius: 25px;
	-webkit-border-radius: 25px;
	border-radius: 25px;
	padding: 3px;
	box-shadow: inset 0 -1px 1px rgba(255,255,255,0.3);
}
.meter > span {
  display: block;
  height: 100%;
  border-top-right-radius: 8px;
  border-bottom-right-radius: 8px;
  border-top-left-radius: 20px;
  border-bottom-left-radius: 20px;
  background-color: rgb(43,194,83);
  background-image: linear-gradient(
    center bottom,
    rgb(43,194,83) 37%,
    rgb(84,240,84) 69%
  );
  box-shadow: 
    inset 0 2px 9px  rgba(255,255,255,0.3),
    inset 0 -2px 6px rgba(0,0,0,0.4);
  position: relative;
  overflow: hidden;
}
@keyframes expandWidth {
   0% { width: 0; }
   100% { width: auto; }
}
</style>
<?php
    require_once("utilities.php");
    
    $projectId = paramInt('id');
    $orgId = paramInt('org');
    $code = paramInt('code');
    
    $stmt = prepare("SELECT ad_id, ad_message FROM ads WHERE ad_org=? ORDER BY RAND()");
    $stmt->bind_param('i', $orgId);
    $result = execute($stmt);
    if ($row = $result->fetch_assoc()) {
        $adId = $row['ad_id'];
        $adMessage = $row['ad_message'];
        
        $stmt = prepare("SELECT project_name, project_funded, project_budget, village_name, project_type, country_label FROM projects JOIN villages ON project_village_id=village_id JOIN countries ON country_id=village_country WHERE project_id=?");
        $stmt->bind_param('i', $projectId);
        $result = execute($stmt);
        $count = 0;
        if ($row = $result->fetch_assoc()) {
            $projectName = $row['project_name'];
            $projectType = $row['project_type'];
            $funded = $row['project_funded'];
            $budget = $row['project_budget'];
            $villageName = $row['village_name'];
            $countryName = $row['country_label'];
            $percent = round(100 * $funded / $budget);
            print "<TABLE cellspacing='10' style='cursor:pointer;width:500px;' onclick=\"document.getElementById('projectLink').click();\"><TR><TD>";
            print "<img src='images/type_".$projectType.".svg' /></TD><TD>";
            print "<span>$adMessage</span>";
            print "  Help <B><a id='projectLink' href='".BASE_URL."$projectId?code=$code&ad=$adId' target='_blank'>$projectName</a></B> with $villageName Village!";
            print "<div class='meter' style='margin-top:10px;'><span  style='width: $percent%'></span></div></TD></TR></TABLE>";
            
        }       
    }
?>