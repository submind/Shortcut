<?php

	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/include/includes.php");
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/php/sidebar.php");	
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/php/header.php");	

	if(!Util::checkSession('jobmanagement')){
		header("Location:../index.php");
		exit;
	}

	
	/*job modify or add or delete*/
	if(isset($_POST['id_job'])){
		/*modify*/
		if(isset($_POST['save'])){
			if((int)$_POST['id_job'] != -1)
				$job['id_job'] = $_POST['id_job'];
			$job['job_title'] = $_POST['job_title'];
			$job['job_location'] = $_POST['job_location'];
			$job['job_description'] = $_POST['job_description'];
			$job['expire_date'] = $_POST['expire_date'];
			if((int)$_POST['id_job'] == -1){
				JobPost::post($_SESSION['id_user'],$job);
			}else{
				Job::save($job);
			}
		}elseif(isset($_POST['delete'])){
			Job::deleteJob($_POST['id_job']);
		}
	}

	$tpl = new FastTemplate(rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/templates");
	$tpl->define(array("jobmanagement"=>"jobmanagement.tpl",
							"form"=>"form.tpl",
							"tr"=>"tr.tpl",
							"td"=>"td.tpl",
							"td_noid"=>"td_noid.tpl",
							"divbutton"=>"div_modulebutton.tpl",
							"button"=>"button.tpl",
							"inputhidden"=>"inputhidden.tpl",
							"input"=>"input.tpl",
							"personalpage"=>"personalpage.tpl"));
	assemblyHeader($tpl);
	assemblySideBar($tpl);
	$jobposts = JobPost::getPostsByPoster($_SESSION['id_user']);
	/*jobs list*/
	if(is_array($jobposts)){
		$seq = 1;
		foreach($jobposts as $jobpost){
			$job = Job::getJob($jobpost['id_job']);
			$tpl->assign("TDCONTENT",$seq++);
			$tpl->parse("TRCONTENT","td_noid");
			$tpl->assign("TDID",'JT'.$job['id_job']);
			$tpl->assign("TDCONTENT",$job['job_title']);
			$tpl->parse("TRCONTENT",".td");
			$tpl->assign("TDID",'JL'.$job['id_job']);
			$tpl->assign("TDCONTENT",$job['job_location']);
			$tpl->parse("TRCONTENT",".td");
			$tpl->assign("TDID",'JD'.$job['id_job']);
			$tpl->assign("TDCONTENT",$job['job_description']);
			$tpl->parse("TRCONTENT",".td");
			$tpl->assign("TDID",'ET'.$job['id_job']);
			$tpl->assign("TDCONTENT",$job['expire_date']);
			$tpl->parse("TRCONTENT",".td");
			$tpl->assign("BUTTONNAME","BT".$job['id_job']);
			$tpl->assign("BUTTONTEXT","Modify");
			$tpl->assign("ONCLICK","onModify(".$job['id_job'].");");
			$tpl->parse("TDCONTENT","button");
			$tpl->parse("TRCONTENT",".td_noid");
			/*delete*/
			$tpl->assign(array("INPUTTYPE"=>"submit",
								"INPUTNAME"=>"delete",
								"INPUTPLACEHOLDER"=>"",
								"INPUTVALUE"=>"delete"));
			$tpl->parse("TDCONTENT","input");
			$tpl->parse("TRCONTENT",".td_noid");
			/*hidden input*/
			$tpl->assign(array("HIDDENNAME"=>"id_job",
								"HIDDENVALUE"=>$job['id_job']));
			$tpl->parse("FORMCONTENT","inputhidden");
			$tpl->parse("FORMCONTENT",".tr");
			$tpl->parse("JM_TABLE_CONTENT",".form");
		}
	}else{
		$tpl->assign("JM_TABLE_CONTENT","");
	}
	$tpl->assign("JOBTITLE","");
	$tpl->assign("JOBLOCATION","");
	$tpl->assign("JOBDESCRIPTION","");
	$tpl->assign("JOBEXPIREDATE","");
	$tpl->parse("FUNCTIONPAGE","jobmanagement");
	/*FINAL*/
	$tpl->assign("FUNCTIONMODULE","Job Management");
	$tpl->parse("PERSONALPAGE","personalpage");
	$tpl->FastPrint("PERSONALPAGE"); 
?>