<?php
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/include/dbUtil.php");
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/include/user.php");
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/include/util.php");
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/include/role.php");
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/include/usercompany.php");
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/include/invitation.php");
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/include/job.php");
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/include/jobpost.php");
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/include/application.php");
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/include/company.php");
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/include/class.FastTemplate.php");
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/include/resume.php");
	
	if(!isset($_SESSION))
		session_start();

?>