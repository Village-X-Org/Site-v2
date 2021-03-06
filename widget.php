<html><body style='overflow:hidden;'>
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

a { color: #005500;
	     text-decoration: none;
	     
}
a.tag { color: #FFFFFF;
	text-decoration:none;
}
a.tag:hover {
	font-weight:bold;
}
a.tag:focus {
	font-weight:bold;
}
</style>
<?php
    require_once("utilities.php");
    
    $projectId = paramInt('id');
    $orgId = paramInt('org');
    $code = param('code');
    
    $stmt = prepare("SELECT ad_id, ad_message FROM ads WHERE ad_org=? ORDER BY RAND()");
    $stmt->bind_param('i', $orgId);
    $result = execute($stmt);
    if ($row = $result->fetch_assoc()) {
        $adId = $row['ad_id'];
        $adMessage = $row['ad_message'];
        
        $stmt = prepare("SELECT project_name, project_funded, project_budget, village_name, pt_label, country_label FROM projects JOIN villages ON project_village_id=village_id JOIN countries ON country_id=village_country JOIN project_types ON project_type_id=pt_id WHERE project_id=?");
        $stmt->bind_param('i', $projectId);
        $result = execute($stmt);
        $count = 0;
        if ($row = $result->fetch_assoc()) {
            $projectName = $row['project_name'];
            $projectType = $row['pt_label'];
            $funded = $row['project_funded'];
            $budget = $row['project_budget'];
            $villageName = $row['village_name'];
            $countryName = $row['country_label'];
            $percent = round(100 * $funded / $budget);
            print "<TABLE cellspacing='10' style='cursor:pointer;width:580px;border:1px solid;' onclick=\"document.getElementById('projectLink').click();\"><TR><TD>";
            print "<img src='images/type_".$projectType.".svg' style='height:50px;' /></TD><TD>";
            print "<span style='font-size:14px;'>$adMessage";
            print "  Help <B><a id='projectLink' href='".BASE_URL."$projectId?code=$code&ad=$adId' target='_blank'>$projectName</a></B> with $villageName Village!</span>";
            print "<div class='meter' style='margin-top:10px;'><span  style='width: $percent%'></span></div></TD></TR></TABLE>";
            
        }       
    }
?>
</body>
</html>