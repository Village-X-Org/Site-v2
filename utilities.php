<?php 

require_once('config.php');

session_start();
$link = 0;

define('MAX_MAIL_PER_REQUEST', 10);
define('MAX_MAIL_PER_HOUR', 600);

define("CACHED_HIGHLIGHTED_FILENAME", "cached/project_highlighted");
define("CACHED_CHARTS_FILENAME", "cached/project_charts");
define("CACHED_LISTING_FILENAME", "cached/project_listing");
define("CACHED_PROJECT_PREFIX", "cached/project_");
define("EMAIL_TYPE_PROJECT_FULLY_FUNDED", 0);
define("EMAIL_TYPE_SUBSCRIPTION_CANCELLATION", 1);
define("EMAIL_TYPE_THANKS_FOR_DONATING", 2);
define("EMAIL_TYPE_PROJECT_COMPLETED", 3);
define("EMAIL_TYPE_PROJECT_UPDATE", 4);

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
	$reqVar = $_POST;
} else {
	$reqVar = $_GET;
}

function emailErrorHandler ($errno, $errstr, $errfile, $errline, $errcontext) {
	$context = print_r($errcontext, true);
	$trace = print_r(debug_backtrace(), true);
	//doTODOQuery("INSERT INTO error_log (error_message, error_file, error_lineno, error_name) VALUES ('$errstr', '$errfile', '$errline', '$name')");
	$serverInfo = (isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : '').' '.(isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '').' '.(isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : '').' '.(isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '').' '.(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '').' '.(isset($_SERVER['USER_AGENT']) ? $_SERVER['USER_AGENT'] : '').' '.(isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : ''); 
	sendMailSend(getAdminEmail(), "VillageX Diagnostic Error: $errstr", "$serverInfo\n\n$errno - $errstr \n\n$errfile - $errline\n\n$context\n\n$trace", getAdminEmail(), "");
	print "<P><font color='red'>The system has suffered a terrible error.  Try reloading the page - that will probably fix it, and if you have a moment, please email the admin and let him know the circumstances that brought this on.</font><BR>$errstr</P>";
    exit();
}
set_error_handler("emailErrorHandler");

function getCustomerServiceEmail() {
    return "Michael Buckler at Village X <mike@villagex.org>";
}

function getAdminEmail() {
    return "Jeff DePree <jeff@villagex.org>";
}

function getBaseURL() {
	return BASE_URL;
}

function emailAdmin($subject, $str) {
	//print "$subject<BR>$str";
	sendMailSend("jdepree@gmail.com", "VillageX Diagnostic $subject", $str, getAdminEmail(), getAdminEmail());
}

function sendMail($receiver, $subject, $body, $from) {
    global $link;
    
	$body = str_replace("\\r\\n", "\n", $body);
	$body = str_replace("\\n", "\n", $body);

	$subject = stripslashes($subject);
	$body = stripslashes($body);
	$caret = strpos($from, '<');
	$fromName = 0;
	$fromEmail = 0;
	if ($caret > 0) {
	    $fromName = trim(substr($from, 0, $caret - 1));
	    $fromEmail = substr($from, $caret + 1, strlen($from) - $caret - 2);
	} else {
	    $fromEmail = $fromName = $from;
	}
	if (1) {
	    $from =  "From: $fromName <".getAdminEmail().">\r\nReply-To: ".($fromEmail ? $fromEmail : $from);
	} else {
	    $from = "From: $from";
	}
	$to = $receiver;
	
	if (strlen($to) < 2) {
	    return 0;
	}
	
	if (!$link) {
	   $link = getDBConn();
	}
	$stmt = prepare("INSERT INTO mail (mail_subject, mail_body, mail_from, mail_to, mail_reply) VALUES (?, ?, ?, ?, ?)");
	$stmt->bind_param("sssss", $subject, $body, $fromName, $to, $fromEmail);
	execute($stmt);
	$stmt->close();
	
	return 1;
}

function getDBConn() {
	$db_link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE );
	
	if (!$db_link) {
		emailAdmin("Could not connect", "Could not connect to database (utilities.getDBConn):".mysqli_error($db_link));
		die('Could not connect: ' . mysqli_error($db_link));
	}
	
	$now = new DateTime();
	$mins = $now->getOffset() / 60;
	$sgn = ($mins < 0 ? -1 : 1);
	$mins = abs($mins);
	$hrs = floor($mins / 60);
	$mins -= $hrs * 60;
	$offset = sprintf('%+d:%02d', $hrs*$sgn, $mins);
	$db_link->query("SET time_zone='$offset';");
	
	return $db_link;
}

function prepare($queryStr) {
    global $link;
    if (!$link) {
        $link = getDBConn();
    }
    
    print mysqli_error($link);
    return $link->prepare($queryStr);
}


function execute($stmt) {
    if (!$stmt->execute()) {
        $trace = print_r(debug_backtrace(), true);
        emailAdmin("Exception", "Exception in Village X\n\n".$stmt->error."\n\n".$trace);
        print "<FONT color='red'>Something has gone terribly wrong.  The administrator has been notified.  Please do not panic - you will be emailed as soon as the issue is resolved. ";
        //if (isset($_SESSION['session_admin'])) {
        print "<P>details: ".mysqli_error($link)." <BR>QUERY: ".$stmt->error."</FONT><P>$trace</P>";
        //}
        die();
    }
    
    return $stmt->get_result();
}

function doUnprotectedQuery($queryToBeExecuted) {
	global $_SESSION;
	global $link;
	
	if (!$link) {
	    $link = getDBConn();
	}
	print mysqli_error($link);
	if (!($result = $link->query($queryToBeExecuted))) {
		$email = '';
		$trace = print_r(debug_backtrace(), true);
		$name = 'Unlogged User';
		if (isset($_SESSION['session_first_name'])) {
			$name = $_SESSION['session_first_name'].' '.$_SESSION['session_last_name'];
		}
		
		emailAdmin("Exception", "Exception caused by: $name\n\n".mysqli_error($link)."\n\n".$queryToBeExecuted."\n\n".$trace);
		print "<FONT color='red'>Something has gone terribly wrong.  The administrator has been notified.  Please do not panic - you will be emailed as soon as the issue is resolved. ";
		//if (isset($_SESSION['session_admin'])) {
			print "<P>details: ".mysqli_error($link)." <BR>QUERY: $queryToBeExecuted</FONT><P>$trace</P>";
		//}
		die();
	}
	
	return $result;
}

function closeDBConn() {
	global $link;
	mysqli_close($link);
}
// End DB functions

function doStatQuery($villageId, $statName) {
    $stmt = prepare("SELECT stat_value, stat_year FROM village_stats WHERE stat_village_id=? AND stat_type_id=(SELECT st_id FROM stat_types WHERE st_label=?)");
    $stmt->bind_param("is", $villageId, $statName);
    return execute($stmt);
}

function getStatYearAssociative($villageId, $statName) {
    $arr = array();
    $stmt = prepare("SELECT stat_value, stat_year FROM village_stats WHERE stat_village_id=? AND stat_type_id=(SELECT st_id FROM stat_types WHERE st_label=?)");
    $stmt->bind_param("is", $villageId, $statName);
    $result = execute($stmt);
    while ($row = $result->fetch_assoc()) {
        $arr[$row['stat_year']] = $row['stat_value'];
    }
    $stmt->close();
    return $arr;
}

function getLatestValueForStat($villageId, $statName) {
    $stmt = prepare("SELECT stat_value FROM village_stats WHERE stat_village_id=? AND stat_type_id=(SELECT st_id FROM stat_types WHERE st_label=?) ORDER BY stat_year DESC LIMIT 1");
    $stmt->bind_param("is", $villageId, $statName);
    $result = execute($stmt);
    $value = -1;
    if ($row = $result->fetch_assoc()) {
        $value = $row['stat_value'];
    }
    $stmt->close();
    return $value;
}

// Request processing
function getGet($key) {
	return getFromReq($key, $_GET);
}

function getPost($key) {
	return getFromReq($key, $_POST);
}

function getFromReq($key, $req) {
	return stripslashes($req[$key]);
}

function escStr($str) {
    global $link;
    if (!$link) {
        $link = getDBConn();
    }
    return mysqli_real_escape_string($link, $str); 
}

function param($key) {
	global $reqVar;
	return getFromReq($key, $reqVar);
}

function paramInt($key) {
    global $reqVar;
    $value = getFromReq($key, $reqVar);
    $matches = array();
    preg_match('/([\d]+)/', $value, $matches);
    if (count($matches) > 0) {
        return $matches[0];
    } else {
        return 0;
    }
}

function hasParam($key) {
	global $reqVar;
	return isset($reqVar[$key]);
}

function checked($key) {
	global $reqVar;
	return (isset($reqVar[$key]) ? 1 : 0);
}
// End request processing

function recordDonation($projectId, $donationAmountDollars, $donationId) {
    $stmt = prepare("SELECT project_name, project_funded, project_budget, project_matching_donor FROM projects WHERE project_id=?");
    $stmt->bind_param("i", $projectId);
    $result = execute($stmt);
    if ($row = $result->fetch_assoc()) {
        $funded = $row['project_funded'];
        $budget = $row['project_budget'];
        $matchingDonorId = $row['project_matching_donor'];
        $stmt->close();
        
        if ($matchingDonorId) {
            $stmt = prepare("INSERT INTO donations (donation_donor_id, donation_amount, donation_project_id) VALUES (?, ?, ?)");
            $stmt->bind_param("idi", $matchingDonorId, $donationAmountDollars, $projectId);
            execute($stmt);
            $stmt->close();
        }
        
        $stmt = prepare("UPDATE projects SET project_funded=project_funded + ? WHERE project_id=?");
        $matchedDonation = $donationAmountDollars * ($matchingDonorId ? 2 : 1);
        $stmt->bind_param("di", $matchedDonation, $projectId);
        execute($stmt);
        invalidateCaches($projectId);
        $stmt->close();
        
        if ($funded >= $budget && $funded - $matchedDonation < $budget) {
            $stmt = prepare("INSERT INTO project_events (pe_type, pe_project_id) VALUES (3, ?)"); // 3=Project Funded in project_event_types
            $stmt->bind_param("i", $projectId);
            execute($stmt);
            $donorStmt = prepare("SELECT donor_email, donation_id, donor_first_name, donor_last_name FROM donors JOIN donations ON donation_donor_id=donor_id WHERE donation_project_id=? AND donation_is_test=0 GROUP BY donor_id");
            $donorStmt->bind_param("i", $projectId);
            $donorResult = execute($donorStmt);
            
            while ($donorRow = $donorResult->fetch_assoc()) {
                $donationId = $donorRow['donation_id'];
                $donorEmail = $donorRow['donor_email'];
                $donorFirstName = $donorRow['donor_first_name'];
                $donorLastName = $donorRow['donor_last_name'];
                
                $type = EMAIL_TYPE_PROJECT_FULLY_FUNDED;
                ob_start();
                $isSubscription = 1;
                include("email_content.php");
                $output = ob_get_clean();
                sendMail($donorEmail, "Project Fully Funded!", $output, getCustomerServiceEmail());
            }
            $donorStmt->close();
        }
    }   
}

function getDateRangeString($startTime, $endTime, $includeSpans=false) {
		$startMonth = date("F", $startTime);
		$shortStartMonth = date("M", $startTime);
		$startMonthNum = date("n", $startTime);
		$endMonth = date("F", $endTime);
		$shortEndMonth = date("M", $endTime);
		$endMonthNum = date("n", $endTime);
		$startDay = date("j", $startTime);
		$endDay = date("j", $endTime);
		$startYear = date("Y", $startTime);
		
		if ($includeSpans) {
			$yearStr = date("Y", $startTime);
			$endYear = date("Y", $endTime);
			
			$startMonthTime = mktime(0, 0, 0, $startMonthNum, 0, $yearStr);	
			$endMonthTime = mktime(0, 0, 0, $endMonthNum, 0, $endYear);
			$startDayTime = mktime(0, 0, 0, $startMonthNum, $startDay, $yearStr);
			$endDayTime = mktime(0, 0, 0, $endMonthNum, $endDay, $yearStr);
			$startYearTime = mktime(0, 0, 0, 0, 0, $yearStr);
			$endYearTime = mktime(0, 0, 0, 0, 0, $endYear);
			
			if ($endDay == $startDay && $startMonth == $endMonth) {
				$dateStr = "<span class='month' id='$startMonthTime'>$startMonth</span> <span class='day' id='$startTime~$endTime'>$startDay</span>, <span class='year' id='$startYearTime'>$yearStr</span>";
			} else {
				if ($startMonth == $endMonth && $yearStr == $endYear) {
					$dateStr = "<span class='month' id='$startMonthTime'>$startMonth</span> <span class='day' id='$startTime~$endTime'>$startDay - $endDay</span>, <span class='year' id='$endYearTime'>$endYear</span>";
				} else {
					$dateStr = "<span class='month' id='$startMonthTime'>$shortStartMonth</span> <span class='day' id='$startTime~$endTime'>$startDay</span> - <span class='month' id='$endMonthTime'>$shortEndMonth</span> <span class='day' id='$startTime~$endTime'>$endDay</span>, <span class='year' id='$endYearTime'>$endYear</span>";
				}
			}
		} else {
			if ($endDay == $startDay && $startMonth == $endMonth) {
				$dateStr = date("F j, Y", $startTime);
			} else {
				$endYear = date("Y", $endTime);
				if ($startMonth == $endMonth && $startYear == $endYear) {
					$dateStr = $startMonth." ".$startDay." - ".$endDay.", ".$endYear;
				} elseif ($startYear == $endYear) {
					$dateStr = $shortStartMonth." ".$startDay." - ".$shortEndMonth." ".$endDay.", ".$endYear;
				} else {
					$dateStr = $shortStartMonth." ".$startYear." - ".$shortEndMonth." ".$endYear;
				}
			}
		}
		return $dateStr;
}

function getTimeRangeString($startTime, $endTime) {
	if ($startTime == $endTime) {
		return getTimeString($startTime);
	}
	$startDayTime = mktime(0, 0, 0, date("m", $startTime), date("d", $startTime), date("Y", $startTime));
	$endDayTime = mktime(0, 0, 0, date("m", $endTime), date("d", $endTime), date("Y", $endTime));
	if ($endDayTime != $startDayTime) {
		return getDateRangeString($startTime, $endTime);
	} else {
		$targetTime = mktime(0, 0, 0, date("m", $startTime), date("d", $startTime), date("Y", $startTime));
		$nowTime = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
		$tomorrow = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"));
		$nextWeek = mktime(0, 0, 0, date("m"), date("d") + 7, date("Y"));
		
		$day = '';
		if ($nowTime == $targetTime) {
			$day = "Today ";
		} elseif ($tomorrow == $targetTime) {
			$day = "Tomorrow ";
		} elseif ($targetTime < $nextWeek) {
			$day = date('D ', $startTime);
		} else {
			$day = date('M j ', $startTime);
		}
		return $day.date('g:ia', $startTime).' - '.date('g:ia', $endTime);
	}
}

function getTimeString($time) {
	$targetTime = mktime(0, 0, 0, date("m", $time), date("d", $time), date("Y", $time));
	$nowTime = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
	$tomorrow = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"));
	$nextWeek = mktime(0, 0, 0, date("m"), date("d") + 7, date("Y"));
	$lastWeek = mktime(0, 0, 0, date("m"), date("d") - 7, date("Y"));
	
	if ($nowTime == $targetTime) {
		return "Today ".date('g:ia', $time);
	} elseif ($tomorrow == $targetTime) {
		return "Tomorrow ".date('g:ia', $time);
	} elseif ($targetTime < $nextWeek && $targetTime > $lastWeek) {
		return date('D g:ia', $time);
	} else {
		return date('M j g:ia', $time);
	}
}

function ordinal($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13))
        return $number. 'th';
        else
            return $number. $ends[$number % 10];
}

function printShareButtons($projectId, $facebookMessage, $twitterMessage, $sideSize) {
    include('share_buttons.inc');   
}

function invalidateCaches($projectId) {
    if (file_exists(CACHED_PROJECT_PREFIX.$projectId)) {
        @unlink(CACHED_PROJECT_PREFIX.$projectId);
    }
    if (file_exists(CACHED_HIGHLIGHTED_FILENAME)) {
        @unlink(CACHED_HIGHLIGHTED_FILENAME);
    }
    if (file_exists(CACHED_LISTING_FILENAME)) {
        @unlink(CACHED_LISTING_FILENAME);
    }
    if (file_exists(CACHED_CHARTS_FILENAME)) {
        @unlink(CACHED_CHARTS_FILENAME);
    }
    include("getProjects.php");
    include("getVillages.php");
}

?>
