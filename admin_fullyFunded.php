<?php
require_once("utilities.php");
$username = param('username');
$password = md5(param('password'));
$projectId = param('id');

$stmt = prepare("SELECT user_id FROM users WHERE user_username=? AND user_password=?");
$stmt->bind_param('ss', $username, $password);
$result = execute($stmt);
if ($row = $result->fetch_assoc()) {
	$stmt = prepare("SELECT pe_project_id FROM project_events WHERE pe_type=3 AND pe_project_id=?");
    $stmt->bind_param("i", $projectId);
    $result = execute($stmt);
    if ($row = $result->fetch_assoc()) {
    } else {
        $stmt = prepare("INSERT INTO project_events (pe_type, pe_project_id) VALUES (3, ?)"); // 3=Project Funded in project_event_types
        $stmt->bind_param("i", $projectId);
        execute($stmt);
        $donorStmt = prepare("SELECT donor_email, donation_id, donation_amount, donor_first_name, donor_last_name FROM donors JOIN donations ON donation_donor_id=donor_id WHERE donation_project_id=? AND donation_is_test=0 GROUP BY donor_id");
        $donorStmt->bind_param("i", $projectId);
        $donorResult = execute($donorStmt);
        
        while ($donorRow = $donorResult->fetch_assoc()) {
            $donationId = $donorRow['donation_id'];
            $donorEmail = $donorRow['donor_email'];
            $donationAmount = $donorRow['donation_amount'];
            $donationAmountDollars = $donationAmount / 100;
            $donorFirstName = $donorRow['donor_first_name'];
            $donorLastName = $donorRow['donor_last_name'];
            
            $type = EMAIL_TYPE_PROJECT_FULLY_FUNDED;
            ob_start();
            $isSubscription = 1;
            include("email_content.php");
            $output = ob_get_clean();
            sendMail($donorEmail, "Project Fully Funded!", $output, getCustomerServiceEmail());
            recordProjectEmailDate($projectId);
        }
        $donorStmt->close();
    }
}

?>