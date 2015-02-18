<?php
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/include/includes.php");
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/php/sidebar.php");	
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/php/header.php");	
	
	if(!Util::checkSession('applicationmanagement')){
		header("Location:../index.php");
		exit;
	}
	/*apply operation*/
	if(isset($_POST['id_job']) and isset($_POST['invite_code']) and isset($_POST['id_invitation'])){
		$application['id_applicant'] = $_SESSION['id_user'];
		$application['id_job'] = $_POST['id_job'];
		$application['invite_code'] = $_POST['invite_code'];
		Application::save($application);
		Invitation::setApplied($_POST['id_invitation']);
	}

	$tpl = new FastTemplate(rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/templates");
	$tpl->define(array("application_management"=>"applicationmanagement.tpl",
						"form"=>"form.tpl",
						"formaction"=>"form_action.tpl",
						"tr"=>"tr.tpl",
						"td"=>"td_noid.tpl",
						"divbutton"=>"div_modulebutton.tpl",
						"button"=>"button.tpl",
						"inputhidden"=>"inputhidden.tpl",
						"input"=>"input.tpl",
						"personalpage"=>"personalpage.tpl"
						));
	
	assemblyHeader($tpl);
	assemblySideBar($tpl);
	/*different roles show different views*/
	$role_code = $_SESSION['role_code'];
	$applications = null;
	$invitations = null;
	/*initialize*/
	$tpl->assign("SUAPPLICATIONS","");
	$tpl->assign("HRAPPLICATIONS","");
	$tpl->assign("SUINVITATIONS","");
	$tpl->assign("HRINVITATIONS","");
	if($role_code == "standard"){
		/*hide hr views*/
		$tpl->assign("MODE","'standard'");
		/*applications*/
		/*<tr><th>Job Title</th><th>Company</th><th>Location</th><th>Description</th><th>Apply Date</th><th>Invite Code</th></tr>*/
		$applications = Application::getApplications($_SESSION['id_user'],-1);
		$invite_code = null;
		if(is_array($applications)){
			foreach($applications as $application){
				$tpl->assign("TDCONTENT",$application['job_title']);
				$tpl->parse("TRCONTENT","td");
				$tpl->assign("TDCONTENT",$application['company_name']);
				$tpl->parse("TRCONTENT",".td");
				$tpl->assign("TDCONTENT",$application['job_location']);
				$tpl->parse("TRCONTENT",".td");
				$tpl->assign("TDCONTENT",$application['job_description']);
				$tpl->parse("TRCONTENT",".td");
				$tpl->assign("TDCONTENT",$application['apply_time']);
				$tpl->parse("TRCONTENT",".td");	
				$invite_code = $application['invite_code'];
				if($invite_code != null){
					$invite_code = substr($invite_code,0,10);
					$invite_code = $invite_code."...";
				}
				$tpl->assign("TDCONTENT",$invite_code);
				$tpl->parse("TRCONTENT",".td");
				$tpl->parse("SUAPPLICATIONS",".tr");
			}
		}
		/*invitations*/
		/*<tr><th>Job Title</th><th>Company</th><th>Location</th><th>Description</th><th>Invite Date</th><th>Invite Code</th><th>Apply</th></tr>*/
		$invitations = Invitation::getInvitationsByInvitee($_SESSION['id_user']);
		if(is_array($invitations)){
			foreach($invitations as $invitation){
				$tpl->assign("TDCONTENT",$invitation['job_title']);
				$tpl->parse("TRCONTENT","td");
				$tpl->assign("TDCONTENT",$invitation['company_name']);
				$tpl->parse("TRCONTENT",".td");
				$tpl->assign("TDCONTENT",$invitation['job_location']);
				$tpl->parse("TRCONTENT",".td");
				$tpl->assign("TDCONTENT",$invitation['job_description']);
				$tpl->parse("TRCONTENT",".td");
				$tpl->assign("TDCONTENT",$invitation['invite_time']);
				$tpl->parse("TRCONTENT",".td");
				$invite_code = $invitation['invite_code'];
				if($invite_code != null){
					$invite_code = substr($invite_code,0,10);
					$invite_code = $invite_code."...";
				}
				$tpl->assign("TDCONTENT",$invite_code);
				$tpl->parse("TRCONTENT",".td");
				if($invitation['applied'] == 0){/*not apply*/
					$tpl->assign(array(
						"INPUTTYPE"=>"submit",
						"INPUTNAME"=>"apply",
						"INPUTVALUE"=>"Apply",
						"INPUTPLACEHOLDER"=>""
					));
					$tpl->parse("TDCONTENT","input");
				}else{
					$tpl->assign("TDCONTENT","Applied");
				}
				$tpl->parse("TRCONTENT",".td");
				$tpl->parse("FORMCONTENT","tr");
				$tpl->assign(array(
					"HIDDENNAME"=>"id_job",
					"HIDDENVALUE"=>$invitation['id_job']
				));
				$tpl->parse("FORMCONTENT",".inputhidden");
				$tpl->assign(array(
					"HIDDENNAME"=>"invite_code",
					"HIDDENVALUE"=>$invitation['invite_code']
				));
				$tpl->parse("FORMCONTENT",".inputhidden");
				$tpl->assign(array(
					"HIDDENNAME"=>"id_invitation",
					"HIDDENVALUE"=>$invitation['id_invitation']
				));
				$tpl->parse("FORMCONTENT",".inputhidden");
				$tpl->parse("SUINVITATIONS",".form");
			}
		}
	}else{
		$tpl->assign("MODE","'hr'");
		/*applications*/
/*<tr><th>Applicant Name</th><th>Job Title</th><th>Job Location</th><th>Job Description</th><th>Apply Date</th><th>Invite Code</th><th>Detail</th></tr>*/
		/*all posted jobs*/
		$jobs = JobPost::getPostsByPoster($_SESSION['id_user']);
		if(is_array($jobs)){
			foreach($jobs as $job){
				$applications = Application::getApplications(-1,$job['id_job']);
				if(is_array($applications)){
					foreach($applications as $application){
						$tpl->assign("TDCONTENT",$application['fullname']);
						$tpl->parse("TRCONTENT","td");
						$tpl->assign("TDCONTENT",$application['job_title']);
						$tpl->parse("TRCONTENT",".td");
						$tpl->assign("TDCONTENT",$application['job_location']);
						$tpl->parse("TRCONTENT",".td");
						$tpl->assign("TDCONTENT",$application['job_description']);
						$tpl->parse("TRCONTENT",".td");
						$tpl->assign("TDCONTENT",$application['apply_time']);
						$tpl->parse("TRCONTENT",".td");
						$invite_code = $application['invite_code'];
						if($invite_code != null){
							$invite_code = substr($invite_code,0,10);
							$invite_code = $invite_code."...";
						}
						$tpl->assign("TDCONTENT",$invite_code);
						$tpl->parse("TRCONTENT",".td");
						$tpl->assign(array(
							"INPUTTYPE"=>"submit",
							"INPUTNAME"=>"detail",
							"INPUTVALUE"=>"Detail",
							"INPUTPLACEHOLDER"=>""
						));
						$tpl->parse("TDCONTENT","input");
						$tpl->parse("TRCONTENT",".td");
						$tpl->parse("FORMCONTENT","tr");
						/*id_user*/
						$tpl->assign(array(
							"HIDDENNAME"=>"id_user",
							"HIDDENVALUE"=>$application['id_applicant'],
						));
						$tpl->parse("FORMCONTENT",".inputhidden");
						/*id_job*/
						$tpl->assign(array(
							"HIDDENNAME"=>"id_job",
							"HIDDENVALUE"=>$job['id_job'],
						));
						$tpl->parse("FORMCONTENT",".inputhidden");
						$tpl->assign("ACTIONPAGE","profile.php");
						$tpl->parse("HRAPPLICATIONS",".formaction");
					}
				}
			}
		}
		/*invitations*/
/*<tr><th>Applicant Name</th><th>Job Title</th><th>Job Location</th><th>Job Description</th><th>Invite Date</th><th>Invite Code</th><th>Applied</th><th>Detail</th></tr>*/
		$invitations = Invitation::getInvitationsByInvitor($_SESSION['id_user']);
		if(is_array($invitations)){		
			foreach($invitations as $invitation){
				$tpl->assign("TDCONTENT",$invitation['fullname']);
				$tpl->parse("TRCONTENT","td");
				$tpl->assign("TDCONTENT",$invitation['job_title']);
				$tpl->parse("TRCONTENT",".td");
				$tpl->assign("TDCONTENT",$invitation['job_location']);
				$tpl->parse("TRCONTENT",".td");
				$tpl->assign("TDCONTENT",$invitation['job_description']);
				$tpl->parse("TRCONTENT",".td");
				$tpl->assign("TDCONTENT",$invitation['invite_time']);
				$tpl->parse("TRCONTENT",".td");
				$invite_code = $invitation['invite_code'];
				if($invite_code != null){
					$invite_code = substr($invite_code,0,10);
					$invite_code = $invite_code."...";
				}
				$tpl->assign("TDCONTENT",$invite_code);
				$tpl->parse("TRCONTENT",".td");
				if($invitation['applied'] == 0){/*not apply*/
					$tpl->assign("TDCONTENT","Not yet");
				}else{
					$tpl->assign("TDCONTENT","Applied");
				}
				$tpl->parse("TRCONTENT",".td");
				$tpl->assign(array(
							"INPUTTYPE"=>"submit",
							"INPUTNAME"=>"detail",
							"INPUTVALUE"=>"Detail",
							"INPUTPLACEHOLDER"=>""
						));
				$tpl->parse("TDCONTENT","input");
				$tpl->parse("TRCONTENT",".td");
				$tpl->parse("FORMCONTENT","tr");
				$tpl->assign(array(
					"HIDDENNAME"=>"id_user",
					"HIDDENVALUE"=>$invitation['id_invitee'],
				));
				$tpl->parse("FORMCONTENT",".inputhidden");
				$tpl->assign("ACTIONPAGE","profile.php");
				$tpl->parse("HRINVITATIONS",".formaction");
			}
		}else{
			$tpl->assign("HRINVITATIONS","");
		}
	}
	$tpl->assign("FUNCTIONMODULE","Application Management");
	$tpl->parse("FUNCTIONPAGE","application_management");
	$tpl->parse("PERSONALPAGE","personalpage");
	$tpl->FastPrint("PERSONALPAGE");
?>
