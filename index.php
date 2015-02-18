<?php 
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/include/includes.php");
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/php/header.php");
	/*SEARCH*/
	/*job_title,company_name,job_description,job_location*/
	if(isset($_POST['searchsubmit'])){
	/*getHomepageJobsByKeywords($job_title,$job_location,$company_name,$job_description)*/
		if($_POST['keyworditem'] == 'job_title'){
			$job_title = strtolower($_POST['keyword']);
			$job_description = null;
			$company_name = null;
		}elseif($_POST['keyworditem'] == 'job_description'){
			$job_title = null;
			$job_description = strtolower($_POST['keyword']);
			$company_name = null;
		}elseif($_POST['keyworditem'] == 'company_name'){
			$job_title =null;
			$job_description = null;
			$company_name = strtolower($_POST['keyword']);
		}
		$jobs = Job::getHomepageJobsByKeywords($job_title,$_POST['job_location'],$company_name,$job_description); 
		
	}else{
		$jobs = Job::getHomepageJobs(0,-1);//all jobs
	}
	$errmsg = null;
	/*LOGIN*/
	if(isset($_POST['signsubmit'])){
		$user = User::getUserByName($_POST['login_name'], Util::getCiphertext($_POST['login_pwd']));
		if($user == null)
			$errmsg = 'Username or password is wrong!';
		else{/*save to session*/
			$user_info = DbUtil::getSessionInfor($user['id_user']);
			$_SESSION['id_user'] = $user_info['id_user'];
			$_SESSION['fullname'] = $user_info['fullname'];
			$_SESSION['login_name'] = $user_info['login_name'];
			$_SESSION['id_role'] = $user_info['id_role'];
			$_SESSION['role_code'] = $user_info['role_code'];
			$_SESSION['role_description'] = $user_info['role_description'];
			$_SESSION['module_code'] = $user_info['module_code'];
			$_SESSION['module_text'] = $user_info['module_text'];
		}
	}
	$tpl = new FastTemplate(rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/templates");
	$tpl->define(array("homepage"=>"homepage.tpl",
						"login"=>"login_homepage.tpl",
						"table"=>"table.tpl",
						"options"=>"options.tpl",
						"th"=>"th.tpl",
						"td"=>"td.tpl",
						"td_no"=>"td_noid.tpl",
						"tr"=>"tr.tpl",
						"link"=>"link.tpl",
						"link_blank"=>"link_target.tpl",
						"loginsuccess"=>"homepage_logined_page.tpl",
						"search"=>"searchJobs.tpl",
						"ads"=>"ads.tpl",
						"img"=>"img.tpl"));
	/*header*/
	assemblyHeader($tpl);
	/*JOBS SEARCH*/
	$tpl->assign("OPTIONVALUE","job_title");
	$tpl->assign("OPTIONCONTENT","Job Title");
	$tpl->assign("OPTIONSELECTED","selected");
	$tpl->parse("KEYWORDOPTIONS","options");
	$tpl->assign("OPTIONVALUE","company_name");
	$tpl->assign("OPTIONCONTENT","Company");
	$tpl->assign("OPTIONSELECTED","");
	$tpl->parse("KEYWORDOPTIONS",".options");
	$tpl->assign("OPTIONVALUE","job_description");
	$tpl->assign("OPTIONCONTENT","Description");
	$tpl->assign("OPTIONSELECTED","");
	$tpl->parse("KEYWORDOPTIONS",".options");
	$joblocations = Job::getLocations();
	/*all*/
	$tpl->assign("OPTIONVALUE","");
	$tpl->assign("OPTIONCONTENT","All");
	$tpl->assign("OPTIONSELECTED","selected");
	$tpl->parse("LOCATIONOPTIONS",".options");
	if(is_array($joblocations)){
		foreach($joblocations as $locations){
			foreach($locations as $location){
				$tpl->assign("OPTIONVALUE",$location);
				$tpl->assign("OPTIONCONTENT",ucwords($location));
				$tpl->assign("OPTIONSELECTED","");
				$tpl->parse("LOCATIONOPTIONS",".options");
			}
		}
	}
	$tpl->parse("SEARCHJOBSAREA","search");
	/*JOBS TABLE*/
	/*table header*/
	$tpl->assign("THCONTENT","Job Title");
	$tpl->parse("TRCONTENT",".th");
	$tpl->assign("THCONTENT","Company Name");
	$tpl->parse("TRCONTENT",".th");
	$tpl->assign("THCONTENT","Job Location");
	$tpl->parse("TRCONTENT",".th");
	$tpl->assign("THCONTENT","Expire Date");
	$tpl->parse("TRCONTENT",".th");
	$tpl->parse("TABLECONTENT",".tr");
	$num = count($jobs); 
	for($i=0;$i<$num;$i++){
		$job = $jobs[$i];
		$tpl->assign("LINKVALUE",$job['job_title']);
		$tpl->assign("LINK",'http://'.$_SERVER['HTTP_HOST'].'/php/jobdetail.php?id_job='.$job['id_job']);
		$tpl->parse("TDCONTENT","link_blank"); 
		$tpl->parse("TRCONTENT","td");
		$tpl->assign("TDCONTENT",$job['company_name']);
		$tpl->parse("TRCONTENT",".td");
		$tpl->assign("TDCONTENT",$job['job_location']);
		$tpl->parse("TRCONTENT",".td");
		$tpl->assign("TDCONTENT",$job['expire_date']);
		$tpl->parse("TRCONTENT",".td");
		$tpl->parse("TABLECONTENT",".tr");
	}
	$tpl->parse("CONTENTAREA","table");
	/*LOGIN PAGE*/
	if(isset($_SESSION['id_user'])){
		$tpl->assign("LINKVALUE",$_SESSION['fullname']);
		$tpl->assign("LINK",'http://'.$_SERVER['HTTP_HOST'].'/php/profile.php');
		$tpl->parse("USERFULLNAMELINK","link");
		$tpl->assign("LINKVALUE","Log out");
		$tpl->assign("LINK",'http://'.$_SERVER['HTTP_HOST'].'/php/logout.php');
		$tpl->parse("LOGOUT","link");
		$tpl->parse("LOGINAREA","loginsuccess");
	}else{
		
		$tpl->assign(array( 
		"HOMEPAGE" => "HomePage",
		"USERNAME" => "Username", 
		"PASSWORD" => "Password",
		"NEWUSER" => "New User",
		"ERRMSG" => $errmsg,
		"LOGIN" => "Log In",
		"LOGINNAMEALERT" => "Invalid username!",
		"LOGINPWDALERT" => "Password must be 5-12 digits or characters!"
		));
		$tpl->parse("LOGINAREA", "login"); 
	}
	/*ads*/
	$imgs = rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/imgs/ads/";
	$tpl->assign("ADVERTISEMENT","");
	if(file_exists($imgs) and is_dir($imgs)){
		chdir($imgs);
		$h_dir = opendir($imgs);
		while(($file=readdir($h_dir))!==false){
			if($file == '.' or $file == '..')
				continue;
			if(is_file($file)){
				$files[] = $file;
			}
		}
		closedir($h_dir);
	}
	foreach($files as $file){
		$tpl->assign("SOURCE","/imgs/ads/".$file);
		$tpl->assign("ALT","");
		$tpl->parse("TDCONTENT","img");
		$tpl->parse("ADVERTISEMENT",".td_no");
	}
	$tpl->parse("ADVERTISEMENTAREA","ads");
	$tpl->parse("HOMEPAGE", "homepage"); 
	$tpl->FastPrint("HOMEPAGE");

?>

