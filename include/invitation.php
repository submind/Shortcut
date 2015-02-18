<?php
	class Invitation{
		/*update is not allowed*/
		public static function save($raw_invitation){
			$db = DatabaseFactory::getInstance();
			$invitation = Util::getSecureArray($raw_invitation);
			$sql = "insert into invitation set id_invitor=".$invitation['id_invitor'].", id_invitee=".$invitation['id_invitee'].", id_job=".$invitation['id_job'].", invite_code='".$invitation['invite_code']."'";
			$db->send_sql($sql);
			return $db->insert_id();
		}
		/*set applied status*/
		public static function setApplied($id_invitation){
			$db = DatabaseFactory::getInstance();
			$sql = "update invitation set applied=1 where id_invitation=".$id_invitation;
			$db->send_sql($sql);
		}
		/*get invitation*/
		public static function getInvitations($id_invitor = -1,$id_invitee = -1, $id_job = -1, $invite_code){
			$db = DatabaseFactory::getInstance();
			if($id_invitor != -1)
				$sql = "select * from invitation where id_invitor=".$id_invitor;
			elseif ($id_invitee != -1)
				$sql = "select * from invitation where id_invitee=".$id_invitee;
			elseif ($id_job != -1)
				$sql = "select * from invitation where id_job=".Util::getSecureString($id_job);
			else
				$sql = "select * from invitation where invite_code='".Util::getSecureString($invite_code)."'"; 
			$res = $db->send_sql($sql);
			$invitations = null;
			$invitation = null;
			if(mysqli_num_rows($res) > 0){
				while($row = $db->next_row()){
					$row = Util::getRawArray($row);
					$invitation['id_invitation'] = $row['id_invitation'];
					$invitation['id_invitor'] = $row['id_invitor'];
					$invitation['id_invitee'] = $row['id_invitee'];
					$invitation['id_job'] = $row['id_job'];
					$invitation['invite_code'] = $row['invite_code'];
					$invitation['invite_time'] = $row['invite_time'];
					$invitation['applied'] = $row['applied'];
					$invitations[] = $invitation;
				}
			}
			return $invitations;
		}
		/*check if has invited someone*/
		public static function hasInvited($id_invitor, $id_invitee, $id_job){
			$db = DatabaseFactory::getInstance();
			$sql = "select id_invitor from invitation where id_invitor=".$id_invitor." and id_invitee=".$id_invitee." and id_job=".$id_job;
			$res = $db->send_sql($sql);
			if(mysqli_num_rows($res) > 0)
				return true;
			else
				return false;
		}
		/*check if the invite code is valid*/
		public static function isValidInvitcode($id_invitee,$id_job,$raw_invitecode){
			$db = DatabaseFactory::getInstance();
			$invitecode = Util::getSecureString($raw_invitecode);
			$sql = "select id_invitor from invitation where id_invitee=".$id_invitee." and id_job=".$id_job." and invite_code='".$invitecode."'";
			$res = $db->send_sql($sql);
			if(mysqli_num_rows($res) == 0)
				return false;
			else 
				return true;
		}
		/*get invitation detail from invitee*/
		public static function getInvitationsByInvitee($id_invitee){
			$db = DatabaseFactory::getInstance();
			$sql = "select invitation.id_invitation as id_invitation,job.id_job as id_job,job.job_title as job_title,company.company_name,job.job_location as job_location,
					job.job_description as job_description,invitation.invite_time as invite_time,invitation.invite_code as invite_code,invitation.applied as applied
					from job,company,user_company,invitation,user
					where invitation.id_invitor = user.id_user
					and user.id_user = user_company.id_user
					and user_company.id_company = company.id_company
					and invitation.id_job = job.id_job
					and invitation.id_invitee =".$id_invitee;
			$res = $db->send_sql($sql);
			$invitations = null;
			if(mysqli_num_rows($res)>0){
				while($row = $db->next_row()){
					$row = Util::getRawArray($row);
					$invitation['id_invitation'] = $row['id_invitation'];
					$invitation['id_job'] = $row['id_job'];
					$invitation['job_title'] = $row['job_title'];
					$invitation['company_name'] = $row['company_name'];
					$invitation['job_location'] = $row['job_location'];
					$invitation['job_description'] = $row['job_description'];
					$invitation['invite_time'] = $row['invite_time'];
					$invitation['invite_code'] = $row['invite_code'];
					$invitation['applied'] = $row['applied'];
					$invitations[] = $invitation;
				}
			}
			return $invitations;
		}
		/*get invitation detail from inviter*/
		public static function getInvitationsByInvitor($id_invitor){
			$db = DatabaseFactory::getInstance();
			$sql = "select invitation.id_invitee as id_invitee, invitation.id_invitation as id_invitation,job.job_title as job_title, job.job_location as job_location,
					job.job_description as job_description, invitation.invite_time as invite_time, 
					invitation.invite_code as invite_code, invitation.applied as applied
					from user,job,invitation
					where invitation.id_invitor = user.id_user
					and invitation.id_job = job.id_job
					and invitation.id_invitor=".$id_invitor;
			$res = $db->send_sql($sql);
			$invitations = null;
			if(mysqli_num_rows($res)>0){
				while($row = $db->next_row()){
					$row = Util::getRawArray($row);
					$invitation['id_invitation'] = $row['id_invitation'];
					$invitation['id_invitee'] = $row['id_invitee'];
					$invitation['job_title'] = $row['job_title'];
					$invitation['job_location'] = $row['job_location'];
					$invitation['job_description'] = $row['job_description'];
					$invitation['invite_time'] = $row['invite_time'];
					$invitation['invite_code'] = $row['invite_code'];
					$invitation['applied'] = $row['applied'];
					$invitations[] = $invitation;
				}
			}
			if(is_array($invitations)){
				foreach($invitations as $k=>$invitation){
					$invitee = User::getUser($invitation['id_invitee']);
					if($invitee == null)
						$invitations[$k]['fullname'] = "";
					else
						$invitations[$k]['fullname'] = $invitee['fullname'];
				}
			}
			return $invitations;
		}
	}
?>