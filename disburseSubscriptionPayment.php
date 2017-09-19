<?php
// Assume $donorId, $amount.
$amount /= 100;

$result = doQuery("SELECT donor_first_name, donor_last_name FROM donors WHERE donor_id=$donorId");
if ($row = $result->fetch_assoc()) {
    $donorFirstName = $row['donor_first_name'];
    $donorLastName = $row['donor_last_name'];
}

$body = "<H3>Distribution of $donorFirstName $donorLastName's $$amount Subscription</H3><TABLE>";

$result = doQuery("SELECT project_id, project_name, village_name, project_budget - project_funded AS remaining FROM projects 
        JOIN villages ON project_village_id=village_id WHERE project_funded<project_budget 
        ORDER BY EXISTS (SELECT sd_project_id FROM subscription_disbursals WHERE sd_donor_id=$donorId) ASC, 
            project_budget - project_funded ASC");

while ($row = $result->fetch_assoc()) {
    $projectId = $row['project_id'];
    $remaining = $row['remaining'];
    $projectName = $row['project_name'];
    $villageName = $row['village_name'];
 
    $donationAmount = round(min($amount, $remaining), 2);
    $amount -= $donationAmount;
    doQuery("INSERT INTO subscription_disbursals (sd_amount, sd_project_id, sd_donor_id) VALUES ($donationAmount, $projectId, $donorId)");
    doQuery("UPDATE projects SET project_funded=project_funded + $donationAmount WHERE project_id=$projectId"); 
    invalidateCaches($projectId);
    
    $body .= "<TR><TD><B>$$donationAmount</B></TD><TD>$projectName in $villageName</TD><TR>";
    if ($amount < .01) {
        break;
    }
}
if ($amount >= .01) {
    doQuery("INSERT INTO subscription_disbursals (sd_amount, sd_project_id, sd_donor_id) VALUES ($amount, -1, $donorId)");
    $body .= "<TR><TD><B>$amount</B></TD><TD>Leftover for manual distribution</TD></TR>";
}
$body .= "</TABLE>";

sendMail(getAdminEmail(), "Monthly Distribution of $donorFirstName $donorLastName's Subscription", $body, getAdminEmail());