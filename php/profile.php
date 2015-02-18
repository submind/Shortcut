<?php

	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/include/includes.php");
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/php/sidebar.php");	
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/php/header.php");	

	
	if(!Util::checkSession('profile')){ //session validation  profile is in DB
		header("Location:../index.php");
		exit;
	}
	/*upload resume*/
	$upload_err = "";
	$typelist = array("application/pdf","application/msword");
	if(isset($_POST['upload']) && $_FILES['userfile']['size'] > 0)
	{

		if(in_array($_FILES['userfile']['type'],$typelist)){
			$fileName = $_FILES['userfile']['name'];
			$tmpName  = $_FILES['userfile']['tmp_name'];
			$fileSize = $_FILES['userfile']['size'];
			$fileType = $_FILES['userfile']['type'];
			if($fileSize > 15*1024*1024){
				$upload_err="The file should not larger than 15M bytes!";
			}else{
				$fp      = fopen($tmpName, 'rb');
				$content = fread($fp, filesize($tmpName));
				$resume['name'] = $fileName;
				$resume['size'] = $fileSize;
				$resume['type'] = $fileType;
				$resume['content'] = $content;
				fclose($fp);
				$user = User::getUser($_SESSION['id_user']);
				if($user['id_resume'] != 0){
					$resume['id_resume'] = $user['id_resume'];
				}
				$id_resume = Resume::save($resume);
				if($user['id_resume'] == 0){
					$user['id_resume'] = $id_resume;
					User::save($user);
				}
			}
		}else{
			$upload_err="The file can only be ".implode(",",$typelist);
		}
		
	}
	
	
	/*
	entrance:
	1.user login successfully and click his name then jump to this page;
	2.hr/admin search candidate and click look button $_POST
	3.user modify his own profile and then save
	4.hr/admin invite some user
	5.application module click detail
	*/
	$user = null;
	$from = null;
	
	if(!isset($_POST['id_user'])){/*1*/
		$user = User::getUser($_SESSION['id_user']);
		$from = "HOMEPAGE";
	}elseif($_POST['id_user'] == $_SESSION['id_user'] and isset($_POST['login_pwd'])){/*3*/
		$user['id_user'] = $_POST['id_user'];
		$user['login_name'] = $_SESSION['login_name'];
		$user['login_pwd'] = $_POST['login_pwd'];
		$user['fullname'] = $_SESSION['fullname'];
		$user['cellphone'] = $_POST['cellphone'];
		$user['email'] = $_POST['email'];
		$user['id_role'] = $_SESSION['id_role'];
		$user['resume'] = $_POST['resume'];
		$user['career'] = $_POST['career'];
		$user['location'] = $_POST['location'];
		$id = User::save($user);
		$user = User::getUser($id);
		$from = "SAVE";
	}elseif(isset($_POST['jobs'])){/*4*/
		$jobs = $_POST['jobs'];
		if(is_array($jobs)){
			foreach($jobs as $id_job){
				$invitation['id_invitor'] = $_SESSION['id_user'];
				$invitation['id_invitee'] = $_POST['id_user'];
				$invitation['id_job'] = $id_job;
				$invitation['invite_code'] = Util::getInviteCode($_SESSION['id_user'],$_POST['id_user'],$id_job);
				Invitation::save($invitation);
			}
			$user = User::getUser($_POST['id_user']);
			$from = "INVITE";
		}
	}elseif(isset($_POST['id_job'])){/*5*/
		$user = User::getUser($_POST['id_user']);
		$from = "APPLICATION";
	}else{/*2*/
		$user = User::getUser($_POST['id_user']);
		if($_POST['id_user'] == $_SESSION['id_user'])
			$from = "HOMEPAGE";
		else
			$from = "SEARCH";
	}
	/*delete all password*/
	$user['login_pwd'] = "**********";
	
	$tpl = new FastTemplate(rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/templates");
	$tpl->define(array("profile"=>"profile.tpl",
						"td"=>"td_noid.tpl",
						"tdcol"=>"td_noid_colspan.tpl",
						"tr"=>"tr.tpl",
						"input" => "input.tpl",
						"table" => "table.tpl",
						"jobmanagement"=>"jobmanagement.tpl",
						"form"=>"form.tpl",
						"divbutton"=>"div_modulebutton.tpl",
						"button"=>"button.tpl",
						"inputhidden"=>"inputhidden.tpl",
						"inputdis"=>"input_disabled.tpl",
						"inputid"=>"input_id.tpl",
						"personalpage"=>"personalpage.tpl",
						"upload"=>"upload.tpl",
						"download"=>"download.tpl")
						);
	assemblyHeader($tpl);
	assemblySideBar($tpl);
	$tpl->assign(array( 
						"TITLE" => "Deatiled Information",
						"id_user" => "id_user:", 
						"login_name" => "Login Name:",
						"login_pwd" => "*Password:",
						"fullname" => "Full Name:",
						"cellphone" => "*Phone Number:",
						"email" => "E-mail:",
						"resume" => "Resume(pdf/doc only):",
						"resume_text" => "Resume:",
						"career" => "Career objective:",
						"location" => "Location:",
						"JOBTITLE" => "Job Title",
						"JOBDESC" => "Job Desc",
						"LOCATION" => "Location",
						"LOGINNAMEALERT" => "Please type your login_name.",
						"LOGINPWDALERT" => "Password must be 5-12 digits or characters!",
						"LOGINREPWDALERT" => "Please type your same password again",
						"FULLNAMEALERT" => "Please type your fullname.",
						"PHONENUMBERALERT" => "Please type 10 numbers like: 'XXX-XXX-XXXX' or 'XXX.XXX.XXXX' or 'XXX XXX XXXX' or 'XXXXXXXXXX'.",
						"EMAILALERT" => "Not a valid e-mail address",
						"RESUMEALERT" => "Please type your resume.",
						"CAREERALERT" => "Please type your career.",
						"LOCATIONALERT" => "Please type your location."
	));

	$tpl->assign(array(
				"ID_USER"=> $user['id_user'],
				"LOGIN_NAME"=>$user['login_name'],
				"LOGIN_PWD"=>$user['login_pwd'],
				"FULLNAME"=>$user['fullname'],
				"CELLPHONE"=>$user['cellphone'],
				"EMAIL"=>$user['email'],
				"RESUME"=>$user['resume'],
				"CAREER"=>$user['career'],
				"LOCATION"=>$user['location']
		));
	/*RESUME UPLOAD & DOWNLOAD*/
	/*1,2,3,4 situation can download,
	1,3 can upload*/
	$tpl->assign("UPLOAD","");
	if($from == "HOMEPAGE" || $from == "SAVE"){
		/*show re-enter button*/
		$tpl->assign("TDCONTENT","*re-enter_login_pwd:");
		$tpl->parse("TRCONTENT","td");
		$tpl->assign(array(
			"INPUTID"=>"login_repwd",
			"INPUTTYPE"=>"password",
			"INPUTNAME"=>"login_repwd",
			"INPUTVALUE"=>$user['login_pwd'],
			"INPUTPLACEHOLDER"=>""
		));
		$tpl->parse("TDCONTENT","inputdis");
		$tpl->parse("TRCONTENT",".td");
		$tpl->parse("LOGIN_PWD_RE","tr");
		/*show modify button*/
		$tpl->assign(array(
			"ONCLICK"=>"myFunction();",
			"BUTTONID"=>"btn_save",
			"BUTTONNAME"=>"btn_save",
			"BUTTONTEXT"=>"Modify"
		));
		$tpl->parse("TDCONTENT","button");
		$tpl->assign("COLSPAN",2);
		$tpl->parse("TRCONTENT","tdcol");
		$tpl->parse("MODIFYBUTTON","tr");
		/*hide invite button*/
		$tpl->assign("INVITEBUTTON","");
		/*hide jobs table*/
		$tpl->assign("JOBSTABLECONTENT","");
		/*show upload resume button*/
		$tpl->assign("UPLOAD_ERR",$upload_err);
		$tpl->parse("UPLOAD","upload");
	}elseif($from == "SEARCH"){
		/*hidden re-enter input*/
		$tpl->assign("LOGIN_PWD_RE","");
		/*hidden modify*/
		$tpl->assign("MODIFYBUTTON","");
		/*show invite button*/
		$tpl->assign(array(
			"ONCLICK"=>"onInvite();",
			"BUTTONNAME"=>"invite",
			"BUTTONTEXT"=>"Invite",
			"BUTTONID"=>"opener"
		));
		$tpl->parse("INVITEBUTTON","button");
		/*fill jobs table*/
		$jobposts = JobPost::getPostsByPoster($_SESSION['id_user']);
		if(is_array($jobposts)){
			foreach($jobposts as $jobpost){
				$job = Job::getJob($jobpost['id_job']);
				/*<tr><th>Check</th><th>Job Title</th><th>Job Description</th><th>Location</th></tr>*/
				$tpl->assign(array(
					"INPUTTYPE"=>"checkbox",
					"INPUTNAME"=>"jobs[]",
					"INPUTVALUE"=>$jobpost['id_job'],
					"INPUTPLACEHOLDER"=>""
				));
				$tpl->parse("TDCONTENT","input");
				$tpl->parse("TRCONTENT","td");
				$tpl->assign("TDCONTENT",$job['job_title']);
				$tpl->parse("TRCONTENT",".td");
				$tpl->assign("TDCONTENT",$job['job_description']);
				$tpl->parse("TRCONTENT",".td");
				$tpl->assign("TDCONTENT",$job['job_location']);
				$tpl->parse("TRCONTENT",".td");
				$tpl->parse("JOBSTABLECONTENT",".tr");
			}
		}
	}elseif($from == "INVITE"){
		/*hidden re-enter input*/
		$tpl->assign("LOGIN_PWD_RE","");
		/*hidden modify*/
		$tpl->assign("MODIFYBUTTON","");
		/*show invited*/
		$tpl->assign("INVITEBUTTON","Invited!");
		/*hide jobs table*/
		$tpl->assign("JOBSTABLECONTENT","");
	}elseif($from == "APPLICATION"){
			/*hidden re-enter input*/
			$tpl->assign("LOGIN_PWD_RE","");
			/*hidden modify*/
			$tpl->assign("MODIFYBUTTON","");
			/*hide invitebutton*/
			$tpl->assign("INVITEBUTTON","");
			/*hide jobs table*/
			$tpl->assign("JOBSTABLECONTENT","");
	}
	/*show resume download*/
	if($user['id_resume'] != 0){
		$tpl->assign("ID_RESUME",$user['id_resume']);
		$tpl->parse("DOWNLOAD","download");
	}else{
		$tpl->assign("DOWNLOAD","No resume file uploaded.");
	}	
	
	/*FINAL*/
	$tpl->assign("FUNCTIONMODULE","Profile");/**/
	$tpl->parse("FUNCTIONPAGE","profile");
	$tpl->parse("PERSONALPAGE","personalpage");
	$tpl->FastPrint("PERSONALPAGE"); 
?>