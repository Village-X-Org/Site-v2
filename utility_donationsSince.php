<?php
require_once("utilities.php");
$since = paramInt('since');

$stmt = prepare("SELECT donation_id, donor_email, donor_first_name, donor_last_name, 
        donation_amount, donation_date, donation_project_id, donation_subscription_id FROM donations 
        JOIN donors ON donation_donor_id=donor_id WHERE donation_id>? ORDER BY donation_date DESC");
$stmt->bind_param('i', $since);
$result = execute($stmt);
print "<pre>";
while ($row = $result->fetch_assoc()) {
    //print $row['donation_id'].",".$row['donor_email'].",".$row['donor_first_name'].",".$row['donor_last_name'].",".$row['donation_amount']
    //        .",".$row['donation_date'].",".$row['donation_project_id'].",".$row['donation_subscription_id']."\n";
}
print "</pre>";
$stmt->close();

?>