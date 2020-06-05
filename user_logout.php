<?php
	require_once("utilities.php");
	setcookie ( "username", "", time () - 3600 );
	setcookie ( "password", "", time () - 3600 );
	session_destroy();
	include('refresh.php');
?>