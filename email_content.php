<?php require_once("utilities.php"); ?>
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
    case EMAIL_TYPE_PROJECT_UPDATE:
        //$result = doQuery("");
    case EMAIL_TYPE_SUBSCRIPTION_CANCELLATION:
    case EMAIL_TYPE_THANKS_FOR_DONATING:
        $result = doQuery("SELECT donor_id, donor_first_name, donor_email, donation_amount, project_id, project_name, village_name, country_label, picture_filename FROM donations
                    JOIN donors ON donation_donor_id=donor_id
                    JOIN projects ON donation_project_id=project_id
                    JOIN villages ON project_village_id=village_id
                    JOIN countries ON village_country=country_id
                    JOIN pictures ON project_similar_image_id=picture_id
                    WHERE donation_id=$donationId");
        if ($row = $result->fetch_assoc()) {
            $donorId = $row['donor_id'];
            $firstName = $row['donor_first_name'];
            $email = $row['donor_email'];
            $donationAmount = $row['donation_amount'];
            $projectId = $row['project_id'];
            $projectName = $row['project_name'];
            $villageName = $row['village_name'];
            $countryName = $row['country_label'];
            $projectExampleImage = $row['picture_filename'];
        }
        break;
    default:
        break;
}

$hasActiveSubscriptions = false;
if ($type == EMAIL_TYPE_THANKS_FOR_DONATING) {
    $result = doQuery("SELECT donation_id FROM donations WHERE donation_donor_id=$donorId AND donation_id<>$donationId AND donation_subscription_id IS NOT NULL");
    if ($row = $result->fetch_assoc()) {
        $hasActiveSubscriptions = true;
    }
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
								<table class="spacer"
									style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; padding: 0;">
									<tbody>
										<tr style="vertical-align: top; text-align: left; padding: 0;"
											align="left">
											<td height="16px"
												style="font-size: 16px; line-height: 16px; word-wrap: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; mso-line-height-rule: exactly; color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; margin: 0; padding: 0;"
												align="left" valign="top"> </td>
										</tr>
									</tbody>
								</table>
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
																style="color: inherit; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-wrap: normal; font-size: 28px; margin: 0 0 10px; padding: 0;"
																align="left"><b>
																<?php switch ($type) {
																    case EMAIL_TYPE_PROJECT_UPDATE:
																    case EMAIL_TYPE_THANKS_FOR_DONATING:
																        print "Hi, $firstName!";
																        break;
																    case EMAIL_TYPE_SUBSCRIPTION_CANCELLATION:
																        print "$firstName,";
																        break;
																    default:
																        break;
																}?>
																</b>
															</h3> <br />

															<p class="lead"
																style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.6; font-size: 20px; margin: 0 0 10px; padding: 0;"
																align="left">
																<?php switch ($type) {
																    case EMAIL_TYPE_PROJECT_UPDATE:
																        $result = doQuery("SELECT pu_description, picture_filename FROM project_updates JOIN pictures ON pu_image_id=picture_id WHERE pu_id=$updateId");
																        if ($row = $result->fetch_assoc()) {
																            $updateDescription = $row['pu_description'];
																            $updatePicture = $row['picture_filename'];
																        }
																        ?>
																        A project you supported posted an update. <b><?php print $updateDescription; ?></b> It will get underway immediately.
            																(Click the link below to view photos of your impact.)
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
																    case EMAIL_TYPE_THANKS_FOR_DONATING:
																        ?>We deeply appreciate your 100% tax
            																deductible donation (monthly donation). You have
            																disrupted extreme poverty in rural Africa!
																		<?php 
																		break;
                                                                     default:
                                                                        break;
																}?>
															</p>
															<h2 style="color: inherit; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-wrap: normal; font-size: 30px; margin: 0 0 10px; padding: 0;"
																align="left">
															<?php switch ($type) {
																    case EMAIL_TYPE_PROJECT_UPDATE:
																    case EMAIL_TYPE_THANKS_FOR_DONATING:
																        print "Donation details";
																        break;
																    case EMAIL_TYPE_SUBSCRIPTION_CANCELLATION:
																        print "Cancellation details";
																        break;
																    default:
																        break;
																}?>
															</h2>
															<table class="spacer"
																style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; padding: 0;">
																<tbody>
																	<tr
																		style="vertical-align: top; text-align: left; padding: 0;"
																		align="left">
																		<td height="16px"
																			style="font-size: 16px; line-height: 16px; word-wrap: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; mso-line-height-rule: exactly; color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; margin: 0; padding: 0;"
																			align="left" valign="top"> </td>
																	</tr>
																</tbody>
															</table>
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
																										<?php print $email; ?>
																									</p>
																									
																									<?php switch ($type) {
                                        																    case EMAIL_TYPE_PROJECT_UPDATE:
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
                                        																    case EMAIL_TYPE_PROJECT_UPDATE:
                                        																    case EMAIL_TYPE_THANKS_FOR_DONATING: 
                                        																        ?>
                                        																        <p
            																										style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0 0 10px; padding: 0;"
            																										align="left">
            																										<strong>Donation Amount</strong><br /> $<?php print money_format('%n', $donationAmount); ?>
            																									</p>
            																									<p
            																										style="color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0 0 10px; padding: 0;"
            																										align="left">
            																										<strong>Project</strong><br /> <a href="<?php print BASE_URL."/$projectId"; ?>"
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
                                                                                                            default:
                                                                                                                break;
                                        																}?>
																									
																								</th>
																							</tr>
																						</table></th>
																				</tr>
																			</tbody>
																		</table></th>
																</tr>
															</table>
															<?php switch ($type) {
                    											        case EMAIL_TYPE_PROJECT_UPDATE:
                    												        ?>
                    												        <img src="<?php print PICTURES_DIR."/".$updatePicture; ?>" alt=""
                    															style="outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; width: 100%; clear: both; display: block;" />
                    														
                    															<?php
                    												        break;
                    												    case EMAIL_TYPE_SUBSCRIPTION_CANCELLATION:
                    												        break;
                    												    case EMAIL_TYPE_THANKS_FOR_DONATING: 
                    												        ?>
                    												        <img src="<?php print PICTURES_DIR."/".$projectExampleImage; ?>" alt=""
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
                    																			style="width: 100%; min-width: 532px;">Here's a photo
                    																		of a similar project.</center>
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
                                                                    default:
                                                                        break;
                    												}?>
															  <br />
															<h3
																style="color: inherit; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-wrap: normal; font-size: 28px; margin: 0 0 10px; padding: 0;"
																align="left">
																<?php switch ($type) {
                    											        case EMAIL_TYPE_PROJECT_UPDATE:
                    											        case EMAIL_TYPE_THANKS_FOR_DONATING:
                    												        print "With profound gratitude,";
                    												        break;
                    											        case EMAIL_TYPE_SUBSCRIPTION_CANCELLATION:
                    											            print "Best wishes,";
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
											<table class="spacer"
												style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; padding: 0;">
												<tbody>
													<tr
														style="vertical-align: top; text-align: left; padding: 0;"
														align="left">
														<td height="16px"
															style="font-size: 16px; line-height: 16px; word-wrap: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; mso-line-height-rule: exactly; color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; margin: 0; padding: 0;"
															align="left" valign="top"> </td>
													</tr>
												</tbody>
											</table>
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
																			style="color: inherit; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-wrap: normal; font-size: 20px; margin: 0 0 10px; padding: 0;"
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
															style="width: 274px; color: #0a0a0a; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; font-size: 16px; margin: 0 auto; padding: 0 16px 16px 8px;"
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
														align="center"><a href="<?php print BASE_URL; ?>"
														target="_blank"
														style="color: #2199e8; font-family: Helvetica, Arial, sans-serif; font-weight: normal; text-align: left; line-height: 1.3; text-decoration: none; margin: 0; padding: 0;"><center
																style="width: 100%; min-width: 580px;">Village X Org</center></a></th>


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
