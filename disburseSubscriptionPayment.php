<?php
// Assume $donorId, $donationAmountDollars.
require_once("utilities.php");
$stmt = prepare("SELECT donor_first_name, donor_last_name FROM donors WHERE donor_id=?");
$stmt->bind_param('i', $donorId);
$result = execute($stmt);
if ($row = $result->fetch_assoc()) {
    $donorFirstName = $row['donor_first_name'];
    $donorLastName = $row['donor_last_name'];
}
$stmt->close();

$body = "<H3>Distribution of $donorFirstName $donorLastName's $$donationAmountDollars Subscription</H3><TABLE>";

$stmt = prepare("SELECT project_id, project_name, village_name, project_budget - project_funded AS remaining, COUNT(sd_project_id) AS disbursalCount, p1.project_type_id, IFNULL(typeCount, 0) FROM projects AS p1 LEFT JOIN (SELECT project_type_id, COUNT(project_id) AS typeCount FROM subscription_disbursals JOIN projects ON sd_project_id=project_id AND sd_donor_id=? GROUP BY project_type_id) AS types ON types.project_type_id=p1.project_type_id JOIN villages ON project_village_id=village_id LEFT JOIN subscription_disbursals ON project_id=sd_project_id AND sd_donor_id=? WHERE project_funded<project_budget GROUP BY project_id ORDER BY disbursalCount ASC, typeCount ASC, project_date_posted ASC, remaining ASC");
$stmt->bind_param('ii', $donorId, $donorId);
$result = execute($stmt);

while ($row = $result->fetch_assoc()) {
    $projectId = $row['project_id'];
    $remaining = $row['remaining'];
    $projectName = $row['project_name'];
    $villageName = $row['village_name'];
    
    $nextDonationAmount = round(min($donationAmountDollars, $remaining), 2);
    $donationAmountDollars -= $nextDonationAmount;
    doUnprotectedQuery("INSERT INTO subscription_disbursals (sd_amount, sd_project_id, sd_donor_id) VALUES ($nextDonationAmount, $projectId, $donorId)");
    recordDonation($projectId, $nextDonationAmount, $donationId);
    
    $body .= "<TR><TD><B>$$nextDonationAmount</B></TD><TD>$projectName in $villageName</TD><TR>";
    if ($donationAmountDollars < .01) {
        break;
    }
}
$stmt->close();

if ($donationAmountDollars >= .01) {
    doUnprotectedQuery("INSERT INTO subscription_disbursals (sd_amount, sd_project_id, sd_donor_id) VALUES ($donationAmountDollars, -1, $donorId)");
    $body .= "<TR><TD><B>$donationAmountDollars</B></TD><TD>Leftover for manual distribution</TD></TR>";
}
$body .= "</TABLE>";
invalidateCaches($projectId);

sendMail(getCustomerServiceEmail(), "Monthly Distribution of $donorFirstName $donorLastName's Subscription", $body, getCustomerServiceEmail());
sendMail(getAdminEmail(), "Monthly Distribution of $donorFirstName $donorLastName's Subscription", $body, getCustomerServiceEmail());