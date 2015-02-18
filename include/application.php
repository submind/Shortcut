<?php
	class Application{
		public static function save($raw_application){
			$db = DatabaseFactory::getInstance();
			$application = Util::getSecureArray($raw_application);
			if(isset($application['id_application'])){/*update*/
				/*check if the invite_code is valid*/
				if(!Inivitation::isValidInvitcode($application['id_applicant'],$application['id_job'],$application['invite_code'])){
					$application['invite_code'] = null;
				}
				$sql = "update application set id_application=".$application['id_application']
							.", id_applicant=".$application['id_applicant'].", id_job=".$application['id_job']
							.", invite_code='".$application['invite_code']."'";
				$db->send_sql($sql);
				return $application['id_application'];
			}else{/*new*/
				/*if the invite_code is valid, then change the invitation's status*/
				$ex = null;
				if(isset($application['invite_code']) and $application['invite_code'] != null){
					$invitations = Invitation::getInvitations(-1,-1,-1,$application['invite_code']);
					if($invitations != null){/*valid invite_code*/
						$invitation = $invitations[0];
						Invitation::setApplied($invitation['id_invitation']);
						$ex = ", invite_code='".$application['invite_code']."'";
					}
				}
				$sql = "insert into application set id_applicant=".$application['id_applicant'].", id_job=".$application['id_job'].$ex;
				$db->send_sql($sql);
				return $db->insert_id();
			}
		}
		public static function delete($id_application){
			$db = DatabaseFactory::getInstance();
			$sql = "delete from application where id_application=".$id_application;
			$db->send_sql($sql);
		}
		public static function getApplications($id_applicant=-1,$id_job){
			$db = DatabaseFactory::getInstance();
			$sql = "select job_post.id_poster as id_poster,application.id_applicant as id_applicant,user.fullname as fullname,job.id_job as id_job,job.job_title as job_title,company.company_name as company_name,
					job.job_location as job_location,job.job_description as job_description,
					application.id_application as id_application,application.apply_time as apply_time, application.invite_code as invite_code
					from user,application,job,job_post,user_company,company
					where user.id_user = application.id_applicant
					and application.id_job = job.id_job
					and job.id_job = job_post.id_job
					and job_post.id_poster = user_company.id_user
					and user_company.id_company = company.id_company and ";
			$order = null;
			if ($id_applicant != -1)
				$sql = $sql."application.id_applicant =".$id_applicant;
			else
				$sql = $sql."job.id_job=".$id_job." order by application.invite_code";
			$res = $db->send_sql($sql);
			$applications = null;
			if(mysqli_num_rows($res) > 0){
				while($row = $db->next_row()){
					$row = Util::getRawArray($row);
					$application['id_poster'] = $row['id_poster'];
					$application['id_applicant'] = $row['id_applicant'];
					$application['fullname'] = $row['fullname'];
					$application['id_job'] = $row['id_job'];
					$application['job_title'] = $row['job_title'];
					$application['company_name'] = $row['company_name'];
					$application['job_location'] = $row['job_location'];
					$application['job_description'] = $row['job_description'];
					$application['id_application'] = $row['id_application'];
					$application['apply_time'] = $row['apply_time'];
					$application['invite_code'] = $row['invite_code'];
					$applications[] = $application;
				}
			}
			return $applications;
		}
	}
?>