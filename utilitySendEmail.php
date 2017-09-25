<?php
date_default_timezone_set('America/New_York');
require_once("utilities.php");

$result = doUnprotectedQuery("SELECT COUNT(mail_id) AS mailCount FROM mail WHERE mail_sent > DATE_SUB(NOW(),INTERVAL 1 HOUR)");
if ($row = $result->fetch_assoc()) {
	$count = $row['mailCount'];
}

$mailSentList = '';
$numToSend = min(MAX_MAIL_PER_HOUR - $count, MAX_MAIL_PER_REQUEST);
$sentCount = 0;
if ($numToSend > 0) {
    $result = doUnprotectedQuery("SELECT mail_id, mail_subject, mail_body, mail_from, mail_to, mail_reply FROM mail WHERE mail_sent IS NULL LIMIT $numToSend");
	while ($row = $result->fetch_assoc()) {
		$mailId = $row['mail_id'];
		$subject = $row['mail_subject'];
		$body = $row['mail_body'];
		$from = $row['mail_from'];
		$to = $row['mail_to'];
		$reply = $row['mail_reply'];
		$resultMessage = sendMailSend($to, $subject, $body, $from, $reply);
		doUnprotectedQuery("UPDATE mail SET mail_sent=NOW(), mail_result='$resultMessage' WHERE mail_id=$mailId");
		$mailSentList .= "\n$to $subject";
		$sentCount++;
	}
}

doUnprotectedQuery("DELETE FROM mail WHERE mail_sent IS NOT NULL AND mail_sent > DATE_SUB(NOW(), INTERVAL 4 WEEK) AND mail_sent < DATE_SUB( NOW( ) , INTERVAL 1 WEEK)");

print "Mail Sent: $sentCount\n\n";
print $mailSentList;
?>