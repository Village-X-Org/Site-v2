<?php
require_once("utilities.php");

// Run this automatically once a day (or more).

$result = doQuery("SELECT subscription_user_id, (SELECT stripe_amount - stripe_used FROM stripe_donations WHERE stripe_token=subscription_token) AS availableAmount FROM subscriptions WHERE subscription_is_active=1 AND subscription_user_id NOT IN (SELECT donation_user_id FROM donations WHERE donation_date > DATE_SUB(curdate(), INTERVAL 1 MONTH) AND donation_is_subscription = true AND availableAmount > 0");
while ($row = $result->fetch_assoc()) {
    $userId = $row['subscription_user_id'];
    $amount = $row['subscription_amount'];
    
    $result2 = doQuery("SELECT project_id, project_budget - project_funded AS remaining FROM projects WHERE project_funded < project_budget AND project_status='funding' ORDER BY $userId IN (SELECT donation_id FROM donations WHERE donation_project_id=project_id), project_budget - project_funded");
    while ($row2 = $result2->fetch_assoc() && $amount > 0) {
        $projectId = $row2['project_id'];
        $remaining = $row2['remaining'];
        $donationAmount = min($amount, $remaining);
        $amount -=  $donationAmount;
        doQuery("INSERT INTO donations (donation_user_id, donation_project_id, donation_is_subscription, donation_amount) VALUES ($userId, $projectId, 1, $donationAmount)");
        doQuery("UPDATE projects SET project_funded=project_funded + $donationAmount WHERE project_id=$projectId");
        doQuery("UPDATE stripe_donations SET stripe_used=stripe_used + $donationAmount WHERE stripe_token=$subscriptionToken AND availableAmount > $donationAmount");
    }
}

?>