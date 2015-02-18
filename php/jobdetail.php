<?php
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/include/includes.php");
	/*get id_job*/
	$job = null;
	if(isset($_GET['id_job']) and $_GET['id_job'] != ""){
		$job = Job::getJob($_GET['id_job']);
	}
	/*apply process*/
	$invite_code_error="";
	if(isset($_SESSION['id_user']) and isset($_POST['id_job']) and $_POST['id_job'] != ""){
		$application['id_applicant'] = $_SESSION['id_user'];
		$application['id_job'] = $_POST['id_job'];
		if($_POST['invite_code'] != null and $_POST['invite_code'] != ""){/*user has input some code*/
			$invitation = Invitation::getInvitations(-1,-1,-1,$_POST['invite_code']);
			if($invitation == null)
				$invite_code_error = "The invite code is invalid! You can apply directly!";
			else{
				if($invitation != null and $invitation['id_invitee'] == $_SESSION['id_user'] and $invitation['id_job']==$_POST['id_job'])
					Invitation::setApplied($invitation['id_invitation']);
				else
					$invite_code_error = "The invite code is invalid! You can apply directly!";
			}
		}else{
			$application['invite_code'] = null;
		}
		if($invite_code_error == "")
			Application::save($application);
	}
	/*generate page*/
	$tpl = new FastTemplate(rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/templates");
	$tpl->define(array("jobdetail"=>"jobdetail.tpl",
						"tr"=>"tr.tpl",
						"td"=>"td.tpl",
						"input"=>"input.tpl"));
	if($job == null){
		$tpl->assign(array(	"IDJOB"=>"",
							"JOBTITLE"=>"",
							"JOBLOCATION"=>"",
							"JOBDESCRIPTION"=>"",
							"EXPIREDATE"=>""
						));

	}else{
		$tpl->assign(array(	"IDJOB"=>$job['id_job'],
							"JOBTITLE"=>$job['job_title'],
							"JOBLOCATION"=>$job['job_location'],
							"JOBDESCRIPTION"=>$job['job_description'],
							"JOBEXPIREDATE"=>$job['expire_date'])
						);
	}
	$tpl->assign("INVITECODEERR",$invite_code_error);
	/*invite code && apply button*/
	if(isset($_SESSION['id_user']) and $_SESSION['role_code'] == 'standard'){
		/**/
		$tpl->assign(array("INPUTNAME"=>"invite_code",
							"INPUTTYPE"=>"text",
							"INPUTPLACEHOLDER"=>"Invite code from recruiter",
							"INPUTVALUE"=>""));
		$tpl->parse("INVITECODE","input");
		if(isset($_POST['id_job']) and $_POST['id_job'] != "" and $invite_code_error==""){/*has applied*/
			$tpl->assign("APPLYBUTTON","Applied");
		}else{
				$tpl->assign(array("INPUTNAME"=>"submit",
									"INPUTTYPE"=>"submit",
									"INPUTPLACEHOLDER"=>"",
									"INPUTVALUE"=>"Apply"));
				$tpl->parse("APPLYBUTTON","input");
		}
	}else{
		$tpl->assign("INVITECODE","");
		$tpl->assign("APPLYBUTTON","");
	}
	$tpl->parse("JOBDETAIL","jobdetail");
	$tpl->FastPrint("JOBDETAIL");
?>