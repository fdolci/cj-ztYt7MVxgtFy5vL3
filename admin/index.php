<?php
	include('header.php');
	

	if (!isset($_SESSION["admin"])) {redirect("login.php"); exit();	}
	die();
?>