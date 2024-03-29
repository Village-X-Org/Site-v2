<?php require_once("utilities.php");
?>
<!-- Inliner Build Version 4380b7741bb759d6cb997545f3add21ad48f010b -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
	xmlns="http://www.w3.org/1999/xhtml"
	style="min-height: 100%; background: #f3f3f3;">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width" />
<style type="text/css">
<?php include ('email_styles.inc');
switch ($type) {
    case EMAIL_TYPE_PROJECT_COMPLETED:
    case EMAIL_TYPE_PROJECT_FULLY_FUNDED:
    case EMAIL_TYPE_SUBSCRIPTION_CANCELLATION:
    case EMAIL_TYPE_THANKS_FOR_PURCHASE:
    case EMAIL_TYPE_THANKS_FOR_DONATING:
    	if ($isSubscription) {
    		$stmt = prepare("SELECT thisDonor.donor_id AS donorId, thisDonor.donor_first_name AS donorFirstName, thisDonor.donor_email AS donorEmail, sd_amount as donation_amount, project_id, project_name, village_name, country_label, similarPictures.picture_filename AS similarPicture, exemplaryPictures.picture_filename as exemplaryPicture,
                        CONCAT(matchingDonors.donor_first_name, ' ', matchingDonors.donor_last_name) AS matchingDonor, 0 as donation_matched_to, 0 as fundraiser_id, '' as fundraiser_title FROM subscription_disbursals
                    JOIN donors AS thisDonor ON sd_donor_id=thisDonor.donor_id
                    JOIN projects ON sd_project_id=project_id
                    LEFT JOIN donors AS matchingDonors ON matchingDonors.donor_id=project_matching_donor
                    JOIN villages ON project_village_id=village_id
                    JOIN countries ON village_country=country_id
                    JOIN pictures AS similarPictures ON project_similar_image_id=picture_id
                    LEFT JOIN pictures AS exemplaryPictures ON project_exemplary_image_id=exemplaryPictures.picture_id 
                    WHERE sd_id=?");
    	} else {
        	$stmt = prepare("SELECT thisDonor.donor_id AS donorId, thisDonor.donor_first_name AS donorFirstName, thisDonor.donor_email AS donorEmail, donation_amount, project_id, project_name, village_name, country_label, similarPictures.picture_filename AS similarPicture, exemplaryPictures.picture_filename as exemplaryPicture, fundraiser_id, fundraiser_title,
                        CONCAT(matchingDonors.donor_first_name, ' ', matchingDonors.donor_last_name) AS matchingDonor, donation_matched_to FROM donations
                    JOIN donors AS thisDonor ON donation_donor_id=thisDonor.donor_id
                    JOIN projects ON donation_project_id=project_id
                    LEFT JOIN donors AS matchingDonors ON matchingDonors.donor_id=project_matching_donor
                    LEFT JOIN fundraisers ON donation_fundraiser_id=fundraiser_id
                    JOIN villages ON project_village_id=village_id
                    JOIN countries ON village_country=country_id
                    JOIN pictures AS similarPictures ON project_similar_image_id=picture_id
                    LEFT JOIN pictures AS exemplaryPictures ON project_exemplary_image_id=exemplaryPictures.picture_id 
                    WHERE donation_id=?");
    		
    	}
        $stmt->bind_param("i", $donationId);
        $result = execute($stmt);
        if ($row = $result->fetch_assoc()) {
            $donorId = $row['donorId'];
            $donorFirstName = $row['donorFirstName'];
            $donorEmail = $row['donorEmail'];
            $donationAmountDollars = $row['donation_amount'];
            $donationMatchedTo = $row['donation_matched_to'];
            if ($donationMatchedTo) {
            	$donationMatchedTo = $donationAmountDollars * 2;
            }
            $matchingDonor = $row['matchingDonor'];
            $projectId = $row['project_id'];
            $projectName = $row['project_name'];
            $villageName = $row['village_name'];
            $countryName = $row['country_label'];
            $exemplaryPicture = $row['exemplaryPicture'];
            if (!isset($projectExampleImage)) {
           		$projectExampleImage = $row['similarPicture'];
           	}
            if ($exemplaryPicture) {
            	$projectExampleImage = $exemplaryPicture;
            }
            $fundraiserId = $row['fundraiser_id'];
            $fundraiserTitle = $row['fundraiser_title'];
        }
        $stmt->close();
        break;
    case EMAIL_TYPE_FUNDRAISER:
       	$stmt = prepare("SELECT donor_id AS donorId, donor_first_name AS donorFirstName, donor_email AS donorEmail, 
       				project_id, project_name, village_name, country_label, picture_filename
                    FROM donors JOIN projects ON project_id=?
                    JOIN villages ON project_village_id=village_id
                    JOIN countries ON village_country=country_id
                    JOIN pictures ON project_similar_image_id=picture_id
                    WHERE donor_id=?");
        $stmt->bind_param("ii", $projectId, $donorId);
        $result = execute($stmt);
        if ($row = $result->fetch_assoc()) {
            $donorId = $row['donorId'];
            $donorFirstName = $row['donorFirstName'];
            $donorEmail = $row['donorEmail'];
            $projectId = $row['project_id'];
            $projectName = $row['project_name'];
            $villageName = $row['village_name'];
            $countryName = $row['country_label'];
            $projectExampleImage = $row['picture_filename'];
        }
        $stmt->close();
        break;
    case EMAIL_TYPE_PROFILE_ACTIVATION:
		$donorFirstName = $donorLastName = "Anonymous";
    	$stmt = prepare("SELECT donor_id, donor_email, donor_password FROM donors WHERE donor_id=?");
		$stmt->bind_param('i', $donorId);
		$result = execute($stmt);
		if ($row = $result->fetch_assoc()) {
			$donorId = $row['donor_id'];
			$donorEmail = $row['donor_email'];
			$code = substr(md5($donorEmail.$row['donor_password']), 0, 8);
			$profileActivationLink = "https://villagex.org/reset/$donorId/$code";
		}
		$stmt->close();
    	break;
    case EMAIL_TYPE_UPDATE:
    	$stmt = prepare("SELECT project_id, project_name, ru_title, ru_description, ru_picture_ids, ru_video_id, ru_date, village_name, country_label FROM raw_updates 
    		JOIN projects ON project_id=ru_project_id JOIN villages ON project_village_id=village_id JOIN countries ON village_country=country_id WHERE ru_id=?");
    	$stmt->bind_param('i', $updateId);
    	$result = execute($stmt);
    	if ($row = $result->fetch_assoc()) {
    		$projectId = $row['project_id'];
    		$projectName = $row['project_name'];
    		$countryName = $row['country_label'];
    		$villageName = $row['village_name'];
    		$updateTitle = $row['ru_title'];
    		$updateDescription = $row['ru_description'];
    		$updatePictures = explode(',', $row['ru_picture_ids']);
    		$videoId = $row['ru_video_id'];
    		$updateDate = $row['ru_date'];
    	}
    	$donorFirstName = "n/a";
    	$stmt->close();
    	break;
    default:
        break;
}

$hasActiveSubscriptions = false;
if ($type == EMAIL_TYPE_THANKS_FOR_DONATING) {
    $stmt = prepare("SELECT donation_id FROM donations WHERE donation_donor_id=? AND donation_id<>? AND donation_subscription_id IS NOT NULL");
    $stmt->bind_param("ii", $donorId, $donationId);
    $result = execute($stmt);
    if ($row = $result->fetch_assoc()) {
        $hasActiveSubscriptions = true;
    }
    $stmt->close();
}


?>
</style>
</head>
<body style="width: 100% !important; min-width: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0; padding: 0;">
	<p
		style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0 0 10px; padding: 0;"
		align="left"></p>
	<!-- <style> -->
	<table class="body" data-made-with-foundation=""
		style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; height: 100%; width: 100%; color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; line-height: 1.3; font-size: 16px; background: #f3f3f3; margin: 0; padding: 0;"
		bgcolor="#f3f3f3">
		<tr style="vertical-align: top; text-align: left; padding: 0;"
			align="left">
			<td class="float-center" align="center" valign="top"
				style="word-wrap: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: center; float: none; color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; line-height: 1.3; font-size: 16px; margin: 0 auto; padding: 0;">
				<center data-parsed="" style="width: 100%; min-width: 580px;">
				<table align="center" class="wrapper header float-center"
					style="width: 100%; border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: center; float: none; background: #8a8a8a; margin: 0 auto; padding: 0;"
					bgcolor="#8a8a8a">
					<tr style="vertical-align: top; text-align: left; padding: 0;"
						align="left">
						<td class="wrapper-inner"
							style="word-wrap: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; line-height: 1.3; font-size: 16px; margin: 0; padding: 20px;"
							align="left" valign="top">
							<table align="center" class="container"
								style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: inherit; width: 580px; background: #8a8a8a; margin: 0 auto; padding: 0;"
								bgcolor="#8a8a8a">
								<tbody>
									<tr style="vertical-align: top; text-align: left; padding: 0;"
										align="left">
										<td
											style="word-wrap: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; line-height: 1.3; font-size: 16px; margin: 0; padding: 0;"
											align="left" valign="top">
											<table class="row collapse"
												style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; display: table; padding: 0;">
												<tbody>
													<tr
														style="vertical-align: top; text-align: left; padding: 0;"
														align="left">
														<th class="small-6 large-6 columns first"
															style="width: 298px; color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0 auto; padding: 0;"
															align="left">
															<table
																style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; padding: 0;">
																<tr
																	style="vertical-align: top; text-align: left; padding: 0;"
																	align="left">
																	<th
																		style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0; padding: 0;"
																		align="left"><img src="<?php print BASE_URL; ?>/images/logo.png"
																		style="outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; width: auto; max-width: 100%; clear: both; display: block;" /></th>
																</tr>
															</table>
														</th>
														<th class="small-6 large-6 columns last"
															style="width: 298px; color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0 auto; padding: 0;"
															align="left">
															<table
																style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; padding: 0;">
																<tr
																	style="vertical-align: top; text-align: left; padding: 0;"
																	align="left">

																</tr>
															</table>
														</th>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</table>
				<table align="center" class="container float-center"
					style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: center; width: 580px; float: none; background: #fefefe; margin: 0 auto; padding: 0;"
					bgcolor="#fefefe">
					<tbody>
						<tr style="vertical-align: top; text-align: left; padding: 0;"
							align="left">
							<td
								style="word-wrap: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; line-height: 1.3; font-size: 16px; margin: 0; padding: 0;"
								align="left" valign="top">

								<table class="row"
									style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; display: table; padding: 0;">
									<tbody>
										<tr style="vertical-align: top; text-align: left; padding: 0;"
											align="left">
											<th class="small-12 large-12 columns first last"
												style="width: 564px; color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0 auto; padding: 0 16px 16px;"
												align="left">
												<table
													style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; padding: 0;">
													<tr
														style="vertical-align: top; text-align: left; padding: 0;"
														align="left">
														<th
															style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0; padding: 0;"
															align="left">
															<h3
																style="color: inherit; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-wrap: normal; font-size: 28px; margin: 10px 0 10px; padding: 0;" align="left"><b>
																<?php 
																if ($donorFirstName) { 
        																switch ($type) {
        																    case EMAIL_TYPE_PROJECT_COMPLETED:
        																    case EMAIL_TYPE_PROJECT_FULLY_FUNDED:
    																		case EMAIL_TYPE_THANKS_FOR_PURCHASE:
        																    case EMAIL_TYPE_THANKS_FOR_DONATING:
    																        case EMAIL_TYPE_FUNDRAISER:
        																        if (isset($useHonoree)) {
        																            print "Hi, $honoreeFirstName!";
        																        } else {
        																            print "Hi, $donorFirstName!";
        																        }
        																        break;
        																    case EMAIL_TYPE_PROFILE_ACTIVATION:
        																    	print "Thank you for donating to Village X!";
    																			break;
        																    case EMAIL_TYPE_SUBSCRIPTION_CANCELLATION:
        																        print "$donorFirstName,";
        																        break;
																		    case EMAIL_TYPE_UPDATE:
																		    	print "<div style='position:absolute;left:10px;top:10px;font-size:14px;'><a href='".BASE_URL."$projectId' target='_blank' style='color:#014421;text-decoration:none;'>$projectName</a></div>";
																		    	print "<div style='position:absolute;right:10px;top:10px;font-size:14px;'><a href='".BASE_URL."user_profile.php?id=$donorId' target='_blank' style='color:#014421;text-decoration:none;'>My Donations</a></div>";
																		    	print "<br/><center style='font-size:20px;'>UPDATE: $projectName in $villageName Village, $countryName<br/><span style='font-size:18px;font-weight:normal;'>(you donated to this project -- thank you!)</span></center>";
        																    default:
        																        break;
        																}
                                                                    }   ?>
                                                                    </b></h3>
																<br />

															<p class="lead"
																style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.6; font-size: 20px; margin: 0 0 10px; padding: 0;"
																align="left">
																<?php switch ($type) {
																    case EMAIL_TYPE_PROJECT_COMPLETED:
																        ?>
																       	We are happy to announce that a project you helped fund has recently been completed!
																       	<b>For pictures, and a post-project report, click on the link below.</b>
																		<?php 
																        break;
																    case EMAIL_TYPE_PROJECT_FULLY_FUNDED:
																        ?>
																       	<b>The project is fully funded!  It will get underway immediately.</b>
																		<?php 
																        break;
																    case EMAIL_TYPE_SUBSCRIPTION_CANCELLATION:
																        ?>
																        This email confirms your cancellation of monthly giving.
            																We are sorry to see you go, but you can re-join the
            																Village Fund at any time by clicking the <a
            																	href="<?php print BASE_URL; ?>/village_fund_payment_view.php"
            																	target="_blank"
            																	style="color: #2199e8; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; text-decoration: none; margin: 0; padding: 0;">Give
            																	Monthly</a> button on our website.
																		<?php 
																        break;
    																case EMAIL_TYPE_THANKS_FOR_PURCHASE:
    																	?>We deeply appreciate your purchase, of which $<?php print $donationAmountDollars; ?> is a 100% tax-deductible donation. You have disrupted extreme poverty in rural Africa.

    																	<h2 style="color: inherit; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-wrap: normal; font-size: 30px; margin: 0 0 10px; padding: 0;" align="left">Purchase Summary</h2>
    																		<TABLE style='width:100%;'>
    																	<?php

    																	foreach ($products as $product) {
    																		print "<TR><TD><b>".$product[1]."</b><br/>Quantity: ".$product[4]."<br/>Price for each: $".($product[2] / 100)."</TD><TD style='align:right;'><div style=\"width:150px;height:150px;background-position:center; background-color:black;background-repeat:no-repeat; background-size:150px; border:1px solid;background-image:url('".ABS_PICTURES_DIR.$product[3]."');\"></div></TD></TR>";
    																	}
    																	?></TABLE>
    																	<p/><b>Shipping Address</b>
    																	<p/><?php print nl2br($address);
    																	break; 
																    case EMAIL_TYPE_THANKS_FOR_DONATING:
																        if (isset($useHonoree)) {
																            print (strlen($donorFirstName) > 0 ? "$donorFirstName $donorLastName" : "Someone")." made a donation in your honor.";
																            if (strlen($honoreeMessage) > 1) {
																                print "  They included this message: <blockquote>&quot;$honoreeMessage&quot;</blockquote>";
																            }
																        } else {
    																            ?>We deeply appreciate your 100% tax
                																deductible <?php print ($isSubscription ? "monthly " : ""); ?>donation<?php print (isset($honoreeFirstName) ? " in honor of $honoreeFirstName" : ""); ?><?php print ($fundraiserId && $fundraiserTitle ? " to <a href='".getBaseURL()."fundraiser/$fundraiserId' target='_blank'
        																											style='color: #2199e8; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; text-decoration: none; margin: 0; padding: 0;'>$fundraiserTitle</a>" : ""); ?>. You have
                																disrupted extreme poverty in rural Africa!
    																			<?php 
																        }
																		break;
																	case EMAIL_TYPE_FUNDRAISER:
																		print "We deeply appreciate you launching a fundraiser to help an extreme poverty village in rural Africa.";
																		break;
																	case EMAIL_TYPE_PROFILE_ACTIVATION:
																		print "Click on this link to activate your impact profile:<br/><a href='$profileActivationLink'>$profileActivationLink</a></p>
																		<p>We created Village X to take direct giving to a whole new level.  We deploy your donations straight to problems on the ground.  We then send you data, pics, and videos providing a vivid accounting of exactly how your money improves development outcomes for rural Africans fighting extreme poverty.</p><p>Today we are happy to announce the next step in our efforts to put you on the front lines:  impact profiles.  Click on the link above to activate your profile.  Each profile includes the status of the last project you helped and a listing of your donations.  Your profile also features the number of people you have directly helped and a carousel of pictures from your projects.</p><p>Thanks again for your support.  To provide feedback or just connect, shoot us an email at chat@villagex.org.  We're here to help.</p>";
    																	break;
																    case EMAIL_TYPE_UPDATE:
																    	print "<div style='margin-top:-10px;'>$updateDescription</div>";
																    	if ($videoId) {
																    		?><center><a href='https://youtu.be/<?php print $videoId; ?>' target='_blank' style='text-decoration:none;color:#014421;font-weight:bold;'><div style="position:relative;background-position:center;background-size:cover;background-image:url('https://img.youtube.com/vi/<?php print $videoId; ?>/hqdefault.jpg');width:98%;height:350px;"></div>Click to watch the above video</a></center>
																    		<?php
																    	}
																    	foreach ($updatePictures as $pictureId) {
																    		if ($pictureId) {
																    		?>
																    		<br/><img src="<?php print ABS_PICTURES_DIR.$pictureId.'.jpg'; ?>" alt=""
                    															style="outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; width: 100%; clear: both; display: block;" />
                    														<?php
                    														}
																    	}
																		print "<br/><center><span style='font-size:20px'>Click <a href='".BASE_URL.$projectId."' target='_blank' style='text-decoration:none;color:#014421;font-weight:bold;'>here</a> to get more project details.</span></center>";
																    	break;
                                                                    default:
                                                                        break;
																}?>
															</p>
															<h2 style="color: inherit; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-wrap: normal; font-size: 30px; margin: 0 0 10px; padding: 0;"
																align="left">
															<?php switch ($type) {
															        case EMAIL_TYPE_PROJECT_COMPLETED:
															            break;
															        case EMAIL_TYPE_PROJECT_FULLY_FUNDED:
															        case EMAIL_TYPE_THANKS_FOR_PURCHASE:
																    case EMAIL_TYPE_THANKS_FOR_DONATING:
																        print "Donation details";
																        break;
																    case EMAIL_TYPE_SUBSCRIPTION_CANCELLATION:
																        print "Cancellation details";
																        break;
															        case EMAIL_TYPE_FUNDRAISER:
															        	print "Fundraiser details";
    																	break;
    																case EMAIL_TYPE_PROFILE_ACTIVATION:
    																	break;
																	case EMAIL_TYPE_UPDATE:
																		break;
																    default:
																        break;
																}?>
															</h2>
															<?php if ($type != EMAIL_TYPE_PROFILE_ACTIVATION && $type != EMAIL_TYPE_UPDATE) { ?>
															<table class="callout"
																style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; margin-bottom: 16px; padding: 0;">
																<tr
																	style="vertical-align: top; text-align: left; padding: 0;"
																	align="left">
																	<th class="callout-inner secondary"
																		style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; width: 100%; background: #ebebeb; margin: 0; padding: 10px; border: 1px solid #444444;"
																		align="left" bgcolor="#ebebeb"><br />
																		<table class="row"
																			style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; display: table; padding: 0;">
																			<tbody>
																				<tr
																					style="vertical-align: top; text-align: left; padding: 0;"
																					align="left">
																					<th class="small-12 large-6 columns first"
																						style="width: 50%; color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0 auto; padding: 0 0 16px;"
																						align="left"><table
																							style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; padding: 0;">
																							<tr
																								style="vertical-align: top; text-align: left; padding: 0;"
																								align="left">
																								<th
																									style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0; padding: 0;"
																									align="left">
																									<p
																										style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0 0 10px; padding: 0;"
																										align="left">
																										<strong>Date</strong><br /> <?php print date("F j, Y"); ?><br />
																									</p>

																									<p
																										style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0 0 10px; padding: 0;"
																										align="left">
																										<strong>Email Address</strong><br />
																										<?php print $donorEmail; ?>
																									</p>
																									
																									<?php switch ($type) {
    																										case EMAIL_TYPE_THANKS_FOR_PURCHASE:
?>
                                        																        <p
            																										style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0 0 10px; padding: 0;"
            																										align="left">
            																										<strong>Purchase ID</strong><br />
            																										<?php print $purchaseId; ?>
            																									</p><?php
    																											break;
    																											case EMAIL_TYPE_PROJECT_COMPLETED:
																									    case EMAIL_TYPE_PROJECT_FULLY_FUNDED:
                                        																    case EMAIL_TYPE_THANKS_FOR_DONATING: 
                                        																        ?>
                                        																        <p
            																										style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0 0 10px; padding: 0;"
            																										align="left">
            																										<strong>Donation ID</strong><br />
            																										<?php print $donationId; ?>
            																									</p><?php
                                        																        break;
                                        																    case EMAIL_TYPE_SUBSCRIPTION_CANCELLATION:
                                        																        break;
                                    																        case EMAIL_TYPE_FUNDRAISER:
        																										break;
        																									case EMAIL_TYPE_UPDATE:
        																										break;
                                        																    default:
                                        																        break;
                                        																}?>
																									
																								</th>
																							</tr>
																						</table></th>
																					<th class="small-12 large-6 columns last"
																						style="width: 50%; color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0 auto; padding: 0 0 16px;"
																						align="left"><table
																							style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; padding: 0;">
																							<tr
																								style="vertical-align: top; text-align: left; padding: 0;"
																								align="left">
																								<th
																									style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0; padding: 0;"
																									align="left">
																									
																									<?php switch ($type) {
																									    case EMAIL_TYPE_PROJECT_COMPLETED:
																									    case EMAIL_TYPE_PROJECT_FULLY_FUNDED:
    																									case EMAIL_TYPE_THANKS_FOR_PURCHASE:
                                        																case EMAIL_TYPE_THANKS_FOR_DONATING: 
        																								case EMAIL_TYPE_FUNDRAISER:
                                    																        ?>
                                    																        <p
        																										style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0 0 10px; padding: 0;"
        																										align="left">
        																										<?php if (isset($donationAmountDollars) && $donationAmountDollars > 0) { ?>
        																											<strong>Donation Amount</strong><br /> $<?php print numfmt_create('en_US', NumberFormatter::DECIMAL)->formatCurrency($donationAmountDollars, 'USD'); ?>
        																										<?php } ?>
        																										<?php print (isset($donationMatchedTo) && $donationMatchedTo ? " (matched to $".numfmt_create('en_US', NumberFormatter::DECIMAL)->formatCurrency($donationMatchedTo, 'USD').")" : ""); ?>
        																									</p>
        																									<?php if (isset($projectName)) { ?>
        																									<p
        																										style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0 0 10px; padding: 0;"
        																										align="left">
        																										<strong>Project</strong><br /> <a href="<?php print BASE_URL.'project.php?'.($type == EMAIL_TYPE_PROJECT_COMPLETED ? 't=1&' : '')."id=$projectId"; ?>"
        																											target="_blank"
        																											style="color: #2199e8; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; text-decoration: none; margin: 0; padding: 0;">
        																											<?php print $projectName; ?></a>
        																									</p>
        																									<?php } ?>
        																									<p
        																										style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0 0 10px; padding: 0;"
        																										align="left">
        																										<strong>Location</strong><br /> <?php print $villageName; ?>
        																										Village, <?php print $countryName; ?>
        																									</p><?php
                                    																        break;
                                    																    case EMAIL_TYPE_SUBSCRIPTION_CANCELLATION:
                                    																        ?>
                                    																        <p
        																										style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0 0 10px; padding: 0;"
        																										align="left">
        																										<strong>Action</strong><br /> cancellation of
        																										monthly giving
        																									</p>
        
        																									<?php
        																									break;
        																								case EMAIL_TYPE_FUNDRAISER:
        																								?>
        																									<p
        																										style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0 0 10px; padding: 0;"
        																										align="left">
        																										<strong>Project</strong><br /> <a href="<?php print BASE_URL.$projectId; ?>"
        																											target="_blank"
        																											style="color: #2199e8; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; text-decoration: none; margin: 0; padding: 0;">
        																											<?php print $projectName; ?></a>
        																									</p>
        																									<p
        																										style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0 0 10px; padding: 0;"
        																										align="left">
        																										<strong>Location</strong><br /> <?php print $villageName; ?>
        																										Village, <?php print $countryName; ?>
        																									</p><?php
        																									break;
        																								case EMAIL_TYPE_UPDATE:
        																									break;
                                                                                                        default:
                                                                                                            break;
                                        																}?>
																									
																								</th>
																							</tr>
																						</table></th>
																				</tr>
																<tr style='padding:0px;margin:0px;'><td colspan="2" style='margin:0;padding:0:;font-size:12px;'>No goods or services were provided in exchange for the donation.</td></tr>
																			</tbody>
																		</table></th>
																</tr>
															</table>
														<?php } ?>
															<?php switch ($type) {
    															    case EMAIL_TYPE_PROJECT_COMPLETED:
    															        ?>
                    												        <img src="<?php print ABS_PICTURES_DIR.$projectExampleImage; ?>" alt="" style="outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; width: 100%; clear: both; display: block;" />
                    														<table class="callout"
                    																style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; margin-bottom: 16px; padding: 0;">
                																<tr
                																	style="vertical-align: top; text-align: left; padding: 0;"
                																	align="left">
                																	<th class="callout-inner primary"
                																		style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; width: 100%; background: #def0fc; margin: 0; padding: 10px; border: 1px solid #444444;"
                																		align="left" bgcolor="#def0fc">
                																		<p
                																			style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0 0 10px; padding: 0;"
                																			align="left"></p> <center
                																			style="width: 100%; min-width: 532px;">Here's the project you supported.</center>
                																	</th>
                																	<th class="expander"
                																		style="visibility: hidden; width: 0; color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0; padding: 0;"
                																		align="left"></th>
                																</tr>
                															</table>
                    															<?php
                    													break;
    															    case EMAIL_TYPE_PROJECT_FULLY_FUNDED:
                    												        ?>
                    												        <img src="<?php print ABS_PICTURES_DIR.$projectExampleImage; ?>" alt=""
                    															style="outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; width: 100%; clear: both; display: block;" />
                    														<table class="callout"
                    																style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; margin-bottom: 16px; padding: 0;">
                																<tr
                																	style="vertical-align: top; text-align: left; padding: 0;"
                																	align="left">
                																	<th class="callout-inner primary"
                																		style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; width: 100%; background: #def0fc; margin: 0; padding: 10px; border: 1px solid #444444;"
                																		align="left" bgcolor="#def0fc">
                																		<p
                																			style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0 0 10px; padding: 0;"
                																			align="left"></p> <center
                																			style="width: 100%; min-width: 532px;">Here's a similar project.</center>
                																	</th>
                																	<th class="expander"
                																		style="visibility: hidden; width: 0; color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0; padding: 0;"
                																		align="left"></th>
                																</tr>
                															</table>
                    															<?php
                    												        break;
                    												    case EMAIL_TYPE_SUBSCRIPTION_CANCELLATION:
                    												        break;
                    												    case EMAIL_TYPE_THANKS_FOR_PURCHASE:
                    												    case EMAIL_TYPE_THANKS_FOR_DONATING: 
                    												        ?>
                    												        <img src="<?php print ABS_PICTURES_DIR.$projectExampleImage; ?>" alt=""
                    															style="outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; width: 100%; clear: both; display: block;" />
                    															<table class="callout"
                    																style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; margin-bottom: 16px; padding: 0;">
                    																<tr
                    																	style="vertical-align: top; text-align: left; padding: 0;"
                    																	align="left">
                    																	<th class="callout-inner primary"
                    																		style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; width: 100%; background: #def0fc; margin: 0; padding: 10px; border: 1px solid #444444;"
                    																		align="left" bgcolor="#def0fc">
                    																		<p
                    																			style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0 0 10px; padding: 0;"
                    																			align="left"></p> <center
                    																			style="width: 100%; min-width: 532px;">Here's a similar project.</center>
                    																	</th>
                    																	<th class="expander"
                    																		style="visibility: hidden; width: 0; color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0; padding: 0;"
                    																		align="left"></th>
                    																</tr>
                    															</table><h2
                    																style="color: inherit; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-wrap: normal; font-size: 30px; margin: 0 0 10px; padding: 0;"
                    																align="left">What's coming</h2>
                    															<p class="lead"
                    																style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.6; font-size: 20px; margin: 0 0 10px; padding: 0;"
                    																align="left">You'll receive two more emails from us --
                    																one when the project is fully funded and another when
                    																it's complete. We'll post updates to the corresponding
                    																project page (linked above), including key timeline
                    																dates, pictures, and data outcomes.</p> <br />
                    															<?php if (!$hasActiveSubscriptions) { ?>
                    															<h2
                    																style="color: inherit; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-wrap: normal; font-size: 30px; margin: 0 0 10px; padding: 0;"
                    																align="left">Our challenge for you</h2>
                    
                    															<p class="lead"
                    																style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.6; font-size: 20px; margin: 0 0 10px; padding: 0;"
                    																align="left">
                    																We share your passion to defeat extreme poverty in
                    																Africa. It's a worthy fight that rages 24 hours a day, 7
                    																days a week. To maximize your impact, please consider
                    																making automatic monthly donations (as little as $5 per
                    																month) to our <a
                    																	href="<?php print BASE_URL; ?>/village_fund_payment_view.php"
                    																	target="_blank"
                    																	style="color: #2199e8; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; text-decoration: none; margin: 0; padding: 0;">Village
                    																	Fund</a>. Sit back, relax, and receive impact updates
                    																all year long.
                    															</p><?php
                    												            }
                    															break;
	        															case EMAIL_TYPE_FUNDRAISER:
	        															?><img src="<?php print ABS_PICTURES_DIR.$projectExampleImage; ?>" alt=""
                    															style="outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; width: 100%; clear: both; display: block;" />
                    															<table class="callout"
                    																style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; margin-bottom: 16px; padding: 0;">
                    																<tr
                    																	style="vertical-align: top; text-align: left; padding: 0;"
                    																	align="left">
                    																	<th class="callout-inner primary"
                    																		style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; width: 100%; background: #def0fc; margin: 0; padding: 10px; border: 1px solid #444444;"
                    																		align="left" bgcolor="#def0fc">
                    																		<p
                    																			style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0 0 10px; padding: 0;"
                    																			align="left"></p> <center
                    																			style="width: 100%; min-width: 532px;">Here's a similar project.</center>
                    																	</th>
                    																	<th class="expander"
                    																		style="visibility: hidden; width: 0; color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0; padding: 0;"
                    																		align="left"></th>
                    																</tr>
                    															</table>
                    															<h2 style="color: inherit; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; 
	        																line-height: 1.3; word-wrap: normal; font-size: 30px; margin: 0 0 10px; padding: 0;" align="left">What's coming</h2>
	        															  Fundraising is easy with email and social media.  Share your fundraiser with friends and family and tell them why 
	        															  you're so passionate about ending extreme poverty in rural Africa.  Encourage more donations by thanking donors 
	        															  publicly on social media.  Build urgency by organizing your fundraiser around a particular date or event in your 
	        															  life (e.g., a birthday).  Need more advice?  Shoot us an email at chat@villagex.org.  We're here to help.
	        															  <P><a href='https://villagex.org/fundraiser/<?php print $id; ?>'>https://villagex.org/fundraiser/<?php print $id; ?></a>
																		<?php
																			break;
																		case EMAIL_TYPE_PROFILE_ACTIVATION:
																			print "<img src='https://villagex.org/images/woman_with_goat_small.jpg' />";
																			print "<br/>Thank you from Chikumbu Village, Malawi!<p/>";
																		case EMAIL_TYPE_UPDATE:
																			break;
	                                                                    default:
	                                                                        break;
                    												}?>
															  <br />
															<h3
																style="color: inherit; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-wrap: normal; font-size: 28px; margin: 0 0 10px; padding: 0;"
																align="left">
																<?php switch ($type) {
																    case EMAIL_TYPE_PROJECT_COMPLETED:
																    case EMAIL_TYPE_PROJECT_FULLY_FUNDED:
																    case EMAIL_TYPE_THANKS_FOR_PURCHASE:
                											        case EMAIL_TYPE_THANKS_FOR_DONATING:
            											            case EMAIL_TYPE_FUNDRAISER:
            											            case EMAIL_TYPE_UPDATE:
            											            case EMAIL_TYPE_PROFILE_ACTIVATION:
                												        print "With profound gratitude,";
                												        break;
                											        case EMAIL_TYPE_SUBSCRIPTION_CANCELLATION:
                											            print "Best wishes,";
																		break;
                											        default:
                											            break;
                                                                } ?>
																</h3>
															<h3
																style="color: inherit; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-wrap: normal; font-size: 28px; margin: 0 0 10px; padding: 0;"
																align="left">
																<b>The Village X Team</b>
															</h3> <br />
														</th>
														<th class="expander"
															style="visibility: hidden; width: 0; color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0; padding: 0;"
															align="left"></th>
													</tr>
												</table>
											</th>
										</tr>
									</tbody>
								</table>
								<table class="wrapper secondary" align="center"
									style="width: 100%; border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; background: #f3f3f3; padding: 0;"
									bgcolor="#f3f3f3">
									<tr style="vertical-align: top; text-align: left; padding: 0;"
										align="left">
										<td class="wrapper-inner"
											style="word-wrap: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; line-height: 1.3; font-size: 16px; margin: 0; padding: 0;"
											align="left" valign="top">
										
											<table class="row"
												style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; display: table; padding: 0;">
												<tbody>
													<tr
														style="vertical-align: top; text-align: left; padding: 0;"
														align="left">
														<th class="small-12 large-6 columns first"
															style="width: 274px; color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0 auto; padding: 0 8px 16px 16px;"
															align="left">
															<table
																style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; padding: 0;">
																<tr
																	style="vertical-align: top; text-align: left; padding: 0;"
																	align="left">
																	<th
																		style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0; padding: 0;"
																		align="left">
																		<h5
																			style="color: inherit; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-wrap: normal; font-size: 20px; margin: 10px 0 10px; padding: 0;"
																			align="left">Connect With Us:</h5>
																		<table align="left" class="menu vertical"
																			style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; padding: 0;">
																			<tr
																				style="vertical-align: top; text-align: left; padding: 0;"
																				align="left">
																				<td
																					style="word-wrap: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; line-height: 1.3; font-size: 16px; margin: 0; padding: 0;"
																					align="left" valign="top">
																					<table
																						style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; padding: 0;">
																						<tr
																							style="vertical-align: top; text-align: left; padding: 0;"
																							align="left">
																							<th
																								style="text-align: left; float: none; color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; line-height: 1.3; font-size: 16px; display: block; margin: 0 auto; padding: 10px 0 10px 10px;"
																								class="menu-item float-center" align="left"><a
																								href="https://www.instagram.com/villagexorg/"
																								target="_blank"
																								style="color: #2199e8; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; text-decoration: none; width: 100%; margin: 0; padding: 0;">Instagram</a></th>
																							<th
																								style="text-align: left; float: none; color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; line-height: 1.3; font-size: 16px; display: block; margin: 0 auto; padding: 10px 0 10px 10px;"
																								class="menu-item float-center" align="left"><a
																								href="https://www.facebook.com/villagexorg/"
																								target="_blank"
																								style="color: #2199e8; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; text-decoration: none; width: 100%; margin: 0; padding: 0;">Facebook</a></th>
																							<th
																								style="text-align: left; float: none; color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; line-height: 1.3; font-size: 16px; display: block; margin: 0 auto; padding: 10px 0 10px 10px;"
																								class="menu-item float-center" align="left"><a
																								href="https://twitter.com/villagexorg"
																								target="_blank"
																								style="color: #2199e8; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; text-decoration: none; width: 100%; margin: 0; padding: 0;">Twitter</a></th>
																						</tr>
																					</table>
																				</td>
																			</tr>
																		</table>
																	</th>
																</tr>
															</table>
														</th>
														<th class="small-12 large-6 columns last"
															style="width: 274px; color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0 auto; padding: 10px 16px 16px 8px;"
															align="left">
															<table
																style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; padding: 0;">
																<tr
																	style="vertical-align: top; text-align: left; padding: 0;"
																	align="left">
																	<th
																		style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0; padding: 0;"
																		align="left">
																		<h5
																			style="color: inherit; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-wrap: normal; font-size: 20px; margin: 0 0 10px; padding: 0;"
																			align="left">Contact Info:</h5>
																		<p
																			style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0 0 10px; padding: 0;"
																			align="left">3717 W Street NW</p>
																		<p
																			style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0 0 10px; padding: 0;"
																			align="left">Washington, DC 20007</p>
																		<p
																			style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0 0 10px; padding: 0;"
																			align="left">Phone: 202-360-9931</p>
																		<p
																			style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0 0 10px; padding: 0;"
																			align="left">
																			Email: <a href="mailto:;chat@villagex.org"
																				style="color: #2199e8; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; text-decoration: none; margin: 0; padding: 0;">chat@villagex.org</a>
																		</p>
																	</th>
																</tr>
															</table>
														</th>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
								</table> <center data-parsed=""
									style="width: 100%; min-width: 580px;">
								<table align="center" class="menu float-center"
									style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: center; float: none; width: auto !important; margin: 0 auto; padding: 0;">
									<tr style="vertical-align: top; text-align: left; padding: 0;"
										align="left">
										<td
											style="word-wrap: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; line-height: 1.3; font-size: 16px; margin: 0; padding: 0;"
											align="left" valign="top">
											<table
												style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; padding: 0;">
												<tr
													style="vertical-align: top; text-align: left; padding: 0;"
													align="left">
													<br />
													<th class="menu-item float-center"
														style="float: none; text-align: center; color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; line-height: 1.3; font-size: 16px; margin: 0 auto; padding: 10px;"
														align="center"><center
																style="width: 100%; min-width: 580px;"><a href="<?php print BASE_URL; ?>"
														target="_blank"
														style="color: #2199e8; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; text-decoration: none; margin: 0; padding: 0;">Village X Org</a>
																<br><span style='font-size: 12px;'>501(c)(3) exempt organization</span><br/>
																	<span style='font-size: 12px;'>EIN: 47-1845825</span></center></th>


												</tr>
											</table>
										</td>
									</tr>
								</table>
								</center>
							</td>
						</tr>
					</tbody>
				</table>
				</center>
			</td>
		</tr>
	</table>


</body>
</html>
