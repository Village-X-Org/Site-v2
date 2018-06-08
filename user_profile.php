<?php
require_once ("utilities.php");
if (!hasParam('id')) {
  if ($session_donor_id) {
    $userId = $session_donor_id;
  } else {
    print "No user parameter found";
    return;
  }
} else {
  $userId = param('id');
}

$livestockCount = $waterCount = $educationCount = $agCount = $bizCount = $totalDonationAmount = 0;
$donorLocation = "";
$populations = array();
$households = array();
$donationAmounts = array();
$donationDates = array();
$projectIds = array();
$projectNames = array();
$villageNames = array();
$funded = array();
$budget = array();
$statuses = array();
$stmt = prepare("SELECT donor_first_name, donor_last_name, donor_location, donation_amount, UNIX_TIMESTAMP(donation_date) AS donation_date, project_id, project_name, project_type, village_name,
              vs1.stat_value AS peopleCount, vs2.stat_value AS houseCount, project_status, project_funded, project_budget
              FROM donors 
              LEFT JOIN donations ON donation_donor_id=? AND donation_donor_id=donor_id 
              JOIN projects ON donation_project_id=project_id 
              JOIN villages ON project_village_id=village_id 
              LEFT JOIN village_stats AS vs1 ON vs1.stat_village_id=village_id AND vs1.stat_type_id=18 AND YEAR(donation_date)=vs1.stat_year
              LEFT JOIN village_stats AS vs2 ON vs2.stat_village_id=village_id AND vs2.stat_type_id=19 AND YEAR(donation_date)=vs2.stat_year
              ORDER BY donation_date DESC");
$stmt->bind_param('i', $userId);
$result = execute($stmt);
$count = 0;
while ($row = $result->fetch_assoc()) {
  if ($count == 0) {
    $userFirstName = $row['donor_first_name'];
    $userLastName = $row['donor_last_name'];
    $initials = $userFirstName[0].(strlen($userLastName) > 0 ? $userLastName[0] : "");
    $donorLocation = $row['donor_location'];
  }
  $amount = $row['donation_amount'];
  if (!$amount) {
    break;
  }
  $totalDonationAmount += $amount;
  array_push($donationAmounts, $amount);
  array_push($projectIds, $row['project_id']);
  array_push($projectNames, $row['project_name']);
  array_push($villageNames, $row['village_name']);
  array_push($donationDates, $row['donation_date']);
  array_push($populations, $row['peopleCount']);
  array_push($households, $row['houseCount']);
  array_push($budget, $row['project_budget']);
  array_push($funded, $row['project_funded']);
  array_push($statuses, $row['project_status']);

  $projectType = $row['project_type'];
  $livestockCount += ($projectType == 'livestock' ? $amount : 0);
  $waterCount += ($projectType == 'water' ? $amount : 0);
  $educationCount += ($projectType == 'school' || $projectType == 'house' || $projectType == 'nursery' ? $amount : 0);
  $agCount += ($projectType == 'farm' ? $amount : 0);
  $bizCount += ($projectType == 'business' ? $amount : 0);
  $count++;
} 
$stmt->close();

if (!isset($userFirstName)) {
  print "No user found";
  return;
}

if (count($donationDates) > 0) {
  $latestDonationDate = $donationDates[0];
  $latestBudget = $budget[0];
  $latestFunded = $funded[0];
  $latestStatus = $statuses[0];
  $latestVillage = $villageNames[0];
  $latestProject = $projectNames[0];
  $latestProjectId = $projectIds[0];
}
$totalDonationAmount = max(1, $totalDonationAmount);
  $labels = ["Livestock", "Water", "Education", "Farming", "Business"];
  $counts = [round($livestockCount * 100 / $totalDonationAmount), round($waterCount * 100 / $totalDonationAmount), 
    round($educationCount * 100 / $totalDonationAmount), round($agCount * 100 / $totalDonationAmount), 
    round($bizCount * 100 / $totalDonationAmount)];
  $colors = ["#3e95cd", "#8e5ea2","#3cba9f", "#FFD700", '#2288CC'];

  for ($i = count($labels) - 1; $i >= 0; $i--) {
    if ($counts[$i] == 0) {
      unset($counts[$i]);
      unset($labels[$i]);
      unset($colors[$i]);
    }
  }

$typeStr = join(' and ', array_filter(array_merge(array(join(', ', array_slice($labels, 0, -1))), array_slice($labels, -1)), 'strlen'));

$peopleCount = 0;
$houseCount = 0;
$uniqueVillages = array();
$uniqueProjects = array();
for ($i = 0; $i < $count; $i++) {
  if (!in_array($villageNames[$i], $uniqueVillages)) {
    $peopleCount += $populations[$i];
    $houseCount += $households[$i];
    $uniqueVillages[] = $villageNames[$i];
  }
  if (!in_array($projectIds[$i], $uniqueProjects)) {
    $uniqueProjects[] = $projectIds[$i];
  }
}
$totalProjectCount = count($uniqueProjects);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Village X Org | Fund Projects That Villages Choose</title>
<meta name="description" content="Disrupting extreme poverty in rural Africa with democracy, direct giving, and data."/>
<?php include ('header.inc'); ?>

<div id="index-banner" class="parallax-container hide-on-med-and-down" style="background-color: rgba(0, 0, 0, 0.3); height: 500px">
    
  <div class="container no-pad-bot" style="height: 100%; width: 100%; padding: 2% 0% 0% 0%">
    <div class="row">
      <div class="col s6 m6 l2 right-align" style="padding: 9% 0% 0% 3%;">
      <div style="width:175px; height:175px; border-radius:20%; border-style:solid; background-color:#008080BB;">
                <h1 class="header center-align light text-shadow: 2px 2px 7px #111111" style="padding:12% 5% 5% 5%"><b><?php print $initials[0]; ?></b></h1>
      </div>
    </div> 
  
    <div class="col s6 m6 l6 left-align" style="padding: 7% 1% 1% 2%;">
      <div style="padding: 5% 5% 5% 5%">
        <h3 class="header col s12 white-text text-lighten-2 text-shadow: 2px 2px 7px #111111"><?php print "$userFirstName $userLastName"; ?></h3>
      </div>  

      <div style="padding: 5% 5% 0% 5%;">
        <h5 class="header light" style="margin:0% 1% 0% 2%;font-size:32px;">
          <?php print ($donorLocation ? $donorLocation : ""); ?></h5>
      </div>
    </div>
      
    <div class="col l4" style="padding: 5% 3% 1% 1%;">
      <div class="card z-depth-1" style="padding: 1% 1% 1% 1%; background-color:#008080BB;">
        <div class="card-content header white-text light">
        <div><h5 class="header center-align" style="padding: 2px 2px 7px;"><?php print $userFirstName; ?>'s Stats</h5></div>
          <div style="padding: 0% 0% 0% 10%">
          <h5 class="valign-wrapper" style="padding: 3% 3% 1% 0%"><i class="material-icons small">home</i>&nbsp;&nbsp;&nbsp;<span style="font-size: smaller;">Projects: &nbsp;</span><b><?php print $totalProjectCount; ?></b></h5>
          <h5 class="valign-wrapper" style="padding: 1% 3% 1% 0%"><i class="material-icons small">person</i>&nbsp;&nbsp;&nbsp;<span style="font-size: smaller;">People Helped: &nbsp;</span><b><?php print $peopleCount; ?></b></h5>
          <h5 class="valign-wrapper" style="padding: 1% 3% 1% 0%"><i class="material-icons small">people</i>&nbsp;&nbsp;&nbsp;<span style="font-size: smaller;">Families Helped: &nbsp;</span><b><?php print $houseCount; ?></b></h5>
          <h5 class="valign-wrapper" style="padding: 1% 3% 1% 0%"><i class="material-icons small">cake</i>&nbsp;&nbsp;&nbsp;<span style="font-size: smaller;">Fundraisers Led: &nbsp;</span><b>0</b></h5>
            </div>
        </div>
      </div>
    
  </div>
  </div>
</div>
      <div class="parallax">
        <img src="images/header1.jpg">
      </div>
    
  </div>

<div id="index-banner" class="parallax-container hide-on-large-only" style="background-color: rgba(0, 0, 0, 0.3); height: 500px">
    
  <div class="section no-pad-bot valign-wrapper" style="height: 100%; width: 100%; padding: 2% 0% 0% 0%">
    <div class="row center">
      
      <div class="col s12 m12 l6 center-align" style="padding: 6% 1% 6% 1%;">
        <div style="padding: 5% 0% 5% 0%">
          <h3 class="header col s12 white-text text-lighten-2 text-shadow: 2px 2px 7px #111111"><?php print "$userFirstName $userLastName"; ?></h3>
        </div>
      </div>
  </div>
  </div>

      <div class="parallax">
        <img src="images/header1.jpg">
      </div>
    </div>

<div class="container">
    <div class="row" style="width:100%; padding: 2% 0% 2% 0%">
         
    <div class="col s12 m12 l6 left-align" style="vertical-align: middle;padding: 2% 3% 2% 2%">
    <div>     
          <h6>
            <?php if (isset($latestDonationDate)) { ?>
              <span style="font-size: x-large; font-weight: 500">Last Donation: <?php print date('M j, Y', $latestDonationDate); ?></span>
            </h6>
            <div class='progress'>
              <div class='determinate' style='width: <?php print round(100 * $latestFunded / max(1, $latestBudget)); ?>%'></div>
            </div>
            <div class="valign-wrapper"><i class="material-icons small" style="padding:0 2% 0 0%">update</i><b>Status Update:&nbsp;</b> <a href="project.php?id=<?php print $latestProjectId;?>" target='_blank'><?php print "$latestProject in $latestVillage" ?></a>&nbsp;is <b>&nbsp;<?php print $latestStatus; ?></b></div>

            <?php } ?>
<br>
          
    <div class="left-align">
        
        <a href='project_tiles.php'
        id="donate-button"
        class="waves-effect waves-light donor-background lighten-1 btn-large" style="width:100%; border-radius:10px;font-size: large">Find Projects</a>
      
    </div>    
    </div>

    <div class="flow-text" style="padding: 5% 0% 0% 0%">
    <?php print $userFirstName; ?> has supported <?php print $totalProjectCount; ?> project<?php print ($totalProjectCount != 1 ? 's' : ''); ?>
    <?php print ($peopleCount > 0 ? ", helping <?php print $peopleCount; ?> people and <?php print $houseCount; ?> households in rural Malawi" : ""); ?>.  
    <?php print ($typeStr ? "He has donated to ".strtolower($typeStr)." projects." : "");?>  <?php if (0) { print "$userFirstName has been a monthly donor since "; } ?>
          <h5 class="valign-wrapper hide-on-large-only" style="padding: 3% 0% 1% 0%"><i class="material-icons small">home</i>&nbsp;Projects Supported: &nbsp;<b><?php print $totalProjectCount; ?></b></h5>
          <h5 class="valign-wrapper hide-on-large-only" style="padding: 1% 0% 1% 0%"><i class="material-icons small">person</i>&nbsp;People Helped: &nbsp;<b>200</b></h5>
          <h5 class="valign-wrapper hide-on-large-only" style="padding: 1% 0% 1% 0%"><i class="material-icons small">people</i>&nbsp;Families Helped: &nbsp;<b>35</b></h5>
          <h5 class="valign-wrapper hide-on-large-only" style="padding: 1% 0% 1% 0%"><i class="material-icons small">cake</i>&nbsp;Fundraisers Led: &nbsp;<b>0</b></h5>
    </div>
      <div style="padding:0% 10% 0% 10%;">
      
      <div>
        <canvas id="chart2" width="250 " height="250" style="padding:5% 5% 0% 5%"></canvas>
      </div>

      <script>
        var ctx = document.getElementById("chart2").getContext('2d');

        var chart2 = new Chart(ctx, {
              type: 'doughnut',
              data: {
                labels: [<?php
                    $count = 0;
                    foreach ($labels as $label) {
                      if ($count++ > 0) {
                        print ", ";
                      }
                      print "\"$label\"";
                    }
                  ?>],
                datasets: [
                  {
                    label: "Population (millions)",
                    backgroundColor: [<?php
                    $count = 0;
                    foreach ($colors as $color) {
                      if ($count++ > 0) {
                        print ", ";
                      }
                      print "\"$color\"";
                    }
                  ?>],
                    data: [<?php
                    $count = 0;
                    foreach ($counts as $datum) {
                      if ($count++ > 0) {
                        print ", ";
                      }
                      print "$datum";
                    }
                  ?>]
                  }
                ]
              },
              
          });
      </script>
        
    </div>
    </div>
    
    <div class="col s12 m12 l6 left-align" style="vertical-align: middle;padding: 0% 2% 2% 3%">
  
            <h5 class="valign-wrapper" style="padding: 4% 0% 2% 0%"><b>Donation History</b>&nbsp;<span style="font-size: smaller; font-weight: lighter;"><?php print ($session_donor_id == $userId ? "(Total: $".money_format('%.2n', $totalDonationAmount).")" : ""); ?></span></h5>

                    <div style="overflow: scroll; height:250px;">
          <?php
          $numDonations = count($donationAmounts);
          for ($i = 0; $i < $numDonations; $i++) {
              ?>
                            <div class="row valign-wrapper">
                <div style="padding 0 0 0 0%;margin: 3% 0% 3% 3%; display:inline-block;background-color: teal;border-radius:50%; border-color:black;border-width:thin; height:80px; width:80px;">
                            <a class="tooltip" style='text-decoration:none;color:#EEEEEE;'><span style="height:80px; width:80px; padding: 0 0% 0 0%; font-size: x-large; font-color: #ffffff; 
                                        text-align: center;display: table-cell;vertical-align:middle;"><b><?php print $initials;?></b></span></a>
                        
                  </div>
                  <div style="padding:0 0 0% 5%;vertical-align:middle; display: inline-block;"><span style="font-size: 16px; font-weight: 300"><?php print ($session_donor_id == $userId ? "<b>Donated $".money_format('%.2n', $donationAmounts[$i])."</b>" : "Donated "); ?><span style="font-size: medium; font-weight: 300; text-color:#efebe9"> on <?php print date('M j, Y', $donationDates[$i]); ?> to</span>
                    <div style="font-weight: 200; font-size:16px;"><a href="project.php?id=<?php print $projectIds[$i];?>" target='_blank'><?php print $projectNames[$i]; ?></a> in <?php print $villageNames[$i]; ?> Village</div>
                  </div>
                </div>
            <?php
          }
          ?>

      </div>
            
        
          
    <div style="padding:3% 2% 0% 2%;">
 
        <h5 class="center-align"><b><span class="blue-text"><?php print $userFirstName; ?>'s Villages</span> v. <span style="color:rgba(150,75,75,.7);">Control Villages</span></b></h5>
    <div>
        <canvas id="chart3" width="250" height="250"></canvas>
      </div>

      <script>
        var ctx = document.getElementById("chart3").getContext('2d');

        var chart3 = new Chart(ctx, {
          type : 'line',
          data : {
            labels : [ 2014, 2015, 2016],
            datasets : [ {
              label: "Partner Villages Average",
              fill : false,
              backgroundColor : "#ffce56",
              borderColor: "#6495ED",
                             pointBackgroundColor: "#6495ED",
                             pointRadius: 5,
              data : [ 11.92, 12.42, 16.93 ],
              cubicInterpolationMode: 'monotone',
            }, 

            {
              label: "Control Villages Average",
              fill : false,
              backgroundColor : "#ffce56",
              borderColor: "rgba(150,75,75,.7)",
                             pointBackgroundColor: "rgba(150,75,75,.7)",
                             pointRadius: 5,
              data : [ 13.72, 12.11, 9.5 ],
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
              }
            } ]
          },
          }

        });
      </script>
        <div class="center-align" style="padding: 2% 0 0 0; font-weight:thin; font-size:medium">dev scores based on 17 indicators collected from each village for health, education, business, lifestyle, agriculture, and livestock</div>
      
    </div>
    </div>
  </div>

    <?php
        $stmt = prepare("SELECT picture_filename FROM projects JOIN donations ON donation_donor_id=? AND donation_project_id=project_id JOIN project_updates ON pu_project_id=project_id JOIN pictures ON pu_image_id=picture_id ORDER BY RAND() DESC LIMIT 20");
        $stmt->bind_param('i', $userId);
        $result = execute($stmt);
        $count = 0;
        while ($row = $result->fetch_assoc()) {
            if ($count == 0) {
                print "<div class='carousel'>";
            }
            print "<a class='carousel-item'><img src='".PICTURES_DIR."{$row['picture_filename']}' /></a>";
            $count++;
        }
        $stmt->close();
        if ($count > 0) {
            ?>
                  <script>
                  $(document).ready(function(){
                      $('.carousel').carousel();
                    });
                  </script>
                  </div>
            <?php 
        }
    ?>

</div>

</div>
</div>

<?php include ('footer.inc'); ?>
