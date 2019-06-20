<?php
	require_once("utilities.php");

	$statusFilter = param('statusFilter');
	$typeFilter = param('typeFilter');
	$partnerFilter = param('partnerFilter');

	setcookie("statusFilter", "$statusFilter", time() + (60 * 60));
	setcookie("typeFilter", "$typeFilter", time() + (60 * 60));
	setcookie("partnerFilter", "$partnerFilter", time() + (60 * 60));

?>