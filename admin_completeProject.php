<?php
require_once("utilities.php");
$projectId = param('id');

if ($session_is_admin) {
    $stmt = prepare("SELECT project_id, project_funded, project_budget, picture_filename FROM projects JOIN raw_updates ON project_id=? AND project_id=ru_project_id JOIN pictures ON ru_picture_ids LIKE CONCAT('%,', picture_id, ',%') ORDER BY picture_id DESC LIMIT 1");
    $stmt->bind_param("i", $projectId);
    $result = execute($stmt);
    if ($row = $result->fetch_assoc()) {
        $projectId = $row['project_id'];
        $funded = $row['project_funded'];
        $budget = $row['project_budget'];
        $projectExampleImage = $row['picture_filename'];
        
        if ($funded < $budget - 1) {
            print "This project is not fully funded.  Please insure that it is funded before attempting to mark it completed.";
            die();
        }
        
        $result = doUnprotectedQuery("SELECT pe_id FROM project_events WHERE pe_project_id=$projectId AND pe_type=4");
        if ($row = $result->fetch_assoc()) {
            print "This project has already been marked as complete.  No further action is possible.";
            die();
        }
    } else { 
        print "No picture update is available for this project.  Please upload one before attempting to mark it completed.";
        die();
    }
    
    $stmt = prepare("INSERT INTO project_events (pe_type, pe_project_id) VALUES (4, ?)"); // 4=Project Completed in project_event_types
    $stmt->bind_param("i", $projectId);
    execute($stmt);
    $donorStmt = prepare("SELECT donor_id, donor_email, donation_id, donor_first_name, donor_last_name, isSubscription FROM donors JOIN ((SELECT sd_id as donation_id, sd_donor_id AS donation_donor_id, 1 as isSubscription FROM subscription_disbursals WHERE sd_project_id=?) UNION (SELECT donation_id, donation_donor_id, 0 as isSubscription FROM donations WHERE donation_project_id=? AND donation_is_test=0)) AS derived ON donation_donor_id=donor_id GROUP BY donor_id");
    $donorStmt->bind_param("ii", $projectId, $projectId);
    $donorResult = execute($donorStmt);
    
    while ($donorRow = $donorResult->fetch_assoc()) {
        $donationId = $donorRow['donation_id'];
        $donorEmail = $donorRow['donor_email'];
        $donorFirstName = $donorRow['donor_first_name'];
        $donorLastName = $donorRow['donor_last_name'];
        
        $type = EMAIL_TYPE_PROJECT_COMPLETED;
        ob_start();
        $isSubscription = $donorRow['isSubscription'];
        include("email_content.php");
        $output = ob_get_clean();
        sendMail($donorEmail, "Project Complete!", $output, getCustomerServiceEmail());
        recordProjectEmailDate($projectId);
    }
    print $output;
    $stmt = prepare("UPDATE projects SET project_status='completed' WHERE project_id=?");
    $stmt->bind_param("i", $projectId);
    execute($stmt);

    include('rc.php');
}