<?php

require_once('utilities.php');
if (!$session_is_admin) {
    die(0);
}

$start = 0;
if (hasParam('start')) {
    $start = paramInt('start');
}

if (hasParam('mailId')) {
    $mailId = paramInt('mailId');
    doUnprotectedQuery("UPDATE mail SET mail_sent=NULL, mail_result=NULL WHERE mail_id=$mailId");
    print "record for $mailId reset";
    die(0);
}

?>
<HTML><HEAD><TITLE>Recent Mail</TITLE></HEAD><BODY>
    <style>
        TD {
            padding:20px;
        }
    </style>
    <TABLE><TR><TH></TH><TH>To</TH><TH>From</TH><TH>Sent At</TH><TH>Subject</TH><TH>Body</TH></TR>
<?php

$result = doUnprotectedQuery("SELECT mail_id, mail_subject, mail_from, mail_to, mail_reply, mail_sent
        FROM mail ORDER BY mail_sent DESC LIMIT $start, 50");

while ($row = $result->fetch_assoc()) {
    $mailId = $row['mail_id'];
    $subject = $row['mail_subject'];
    $from = $row['mail_from'];
    $to = $row['mail_to'];
    $reply = $row['mail_reply'];
    $sent = $row['mail_sent'];
    print "<TR><TD style='padding:20px;'><b><a href='' onclick=\"resend($mailId);this.style.visibility = 'hidden';return false;\">resend</a></b></TD><TD>$to</TD><TD>$from &lt;$reply&gt;</TD><TD>$sent</TD><TD>$subject</TD></TR>";
}

?>
</TABLE>
<script>
    function resend(mailId) {
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.open( "GET", "mail.php?mailId=" + mailId, true );
        xmlHttp.send( null );
        console.log(xmlHttp.responseText);
    }
</script>
</BODY></HTML>