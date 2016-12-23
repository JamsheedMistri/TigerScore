<?php
	include "base.php";
	$_SESSION = array();
	session_destroy();

	header("Location: .");
?>
