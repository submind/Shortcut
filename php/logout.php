<?php
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/include/includes.php");
	Util::logout();
	header("location:../index.php");
	exit();
?>