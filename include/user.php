<?php
	class User{
		public static function save($raw_user, $isCiphertext=false){
			$db = DatabaseFactory::getInstance();
			$user = Util::getSecureArray($raw_user);
			$sql_resume = null;
			if(isset($user['id_resume']))
				$sql_resume = ", id_resume=".$user['id_resume'];
			$login_pwd = $user['login_pwd'];
			if(!$isCiphertext){
				$login_pwd = Util::getCiphertext($user['login_pwd']);
			}
			if(isset($user["id_user"])){/*update*/
				
				$sql = "update user set login_name='".$user['login_name']."',login_pwd='".$login_pwd."',fullname='"
					.$user['fullname']."',cellphone='".$user['cellphone']."',email='".$user['email']."',id_role='".$user['id_role']."',resume='"
					.$user['resume']."',career='".$user['career']."',location='".$user['location']."'".$sql_resume." where id_user=".$user['id_user'];
				$db->send_sql($sql);
				return $user['id_user'];
			}else{/*new*/
				$sql = "insert into user set login_name='".$user['login_name']."',login_pwd='".$login_pwd."',fullname='"
					.$user['fullname']."',cellphone='".$user['cellphone']."',email='".$user['email']."',id_role='".$user['id_role']."',resume='"
					.$user['resume']."',career='".$user['career']."',location='".$user['location']."'".$sql_resume;
				$db->send_sql($sql);
				return $db->insert_id();
			}
		}
		public static function getUserByName($login_name,$login_pwd){
			$db = DatabaseFactory::getInstance();
			$login_name = Util::getSecureString($login_name);
			$login_pwd = Util::getSecureString($login_pwd);
			$sql = "select * from user where login_name='".$login_name."' and login_pwd='".$login_pwd."'";
			$arr_user = null;
			$res = $db->send_sql($sql);
			if(mysqli_num_rows($res) > 0){
				if($row = $db->next_row()){
					$row = Util::getRawArray($row);
					$arr_user['id_user'] = $row['id_user'];
					$arr_user['login_name'] = $row['login_name'];
					$arr_user['login_pwd'] = $row['login_pwd'];
					$arr_user['fullname'] = $row['fullname'];
					$arr_user['cellphone'] = $row['cellphone'];
					$arr_user['email'] = $row['email'];
					$arr_user['id_role'] = $row['id_role'];
					$arr_user['resume'] = $row['resume'];
					$arr_user['career'] = $row['career'];
					$arr_user['location'] = $row['location'];
					$arr_user['id_resume'] = $row['id_resume'];
				}
			}
			return $arr_user;
		}
		public static function getUser($id_user=-1,$login_name=-1){
			$db = DatabaseFactory::getInstance();
			if($id_user!=-1)
				$sql = "select id_user,login_name,login_pwd,fullname,cellphone,email,id_role,resume,career,location,id_resume from user where id_user=".$id_user;
			elseif($login_name != -1)
				$sql = "select id_user,login_name,login_pwd,fullname,cellphone,email,id_role,resume,career,location,id_resume from user where login_name='".$login_name."'";
			$res = $db->send_sql($sql);
			$arr_user = null;
			if(mysqli_num_rows($res) > 0){
				if($row = $db->next_row()){
					$row = Util::getRawArray($row);
					$arr_user['id_user'] = $row['id_user'];
					$arr_user['login_name'] = $row['login_name'];
					$arr_user['login_pwd'] = $row['login_pwd'];
					$arr_user['fullname'] = $row['fullname'];
					$arr_user['cellphone'] = $row['cellphone'];
					$arr_user['email'] = $row['email'];
					$arr_user['id_role'] = $row['id_role'];
					$arr_user['resume'] = $row['resume'];
					$arr_user['career'] = $row['career'];
					$arr_user['location'] = $row['location'];
					$arr_user['id_resume'] = $row['id_resume'];
				}
			}
			return $arr_user;
		}
		
		public static function deleteUser($id_user){
			$db = DatabaseFactory::getInstance();
			$sql = "delete from user where id_user=".$id_user;
			$db->send_sql($sql);
		}
		
		public static function getUsers($index_start, $count){
			$db = DatabaseFactory::getInstance();
			$limit = null;
			if($count != -1)
				$limit = " limit ".$index_start.",".$count;
			$sql = "select * from user".$limit; 
			$res = $db->send_sql($sql);
			$arr_users = null;
			$arr_user = null;
			if(mysqli_num_rows($res) > 0){
				while($row = $db->next_row()){
					$row = Util::getRawArray($row);
					$arr_user['id_user'] = $row['id_user'];
					$arr_user['login_name'] = $row['login_name'];
					$arr_user['login_pwd'] = $row['login_pwd'];
					$arr_user['fullname'] = $row['fullname'];
					$arr_user['cellphone'] = $row['cellphone'];
					$arr_user['email'] = $row['email'];
					$arr_user['id_role'] = $row['id_role'];
					$arr_user['resume'] = $row['resume'];
					$arr_user['career'] = $row['career'];
					$arr_user['location'] = $row['location'];
					$arr_user['id_resume'] = $row['id_resume'];
					$arr_users[] = $arr_user;
				}
			}
			return $arr_users;
		}
		/*words in pattern should be separated by ',',
		location, career, resume*/
		public static function searchUsers($keywords,$role_code='standard'){
			$arr_keyword = Util::superExplode($keywords,',');
			$arr_keyword = Util::getSecureArray($arr_keyword);
			$arr_users = null;
			$db = DatabaseFactory::getInstance();
			foreach($arr_keyword as $keyword){
				if($keyword == "")
					continue;
				if($role_code == 'all')
					$sql = "select * from user where LOWER(location) like '%".$keyword."%' or LOWER(career) like '%".$keyword."%' or LOWER(resume) like '%".$keyword."%'";
				else
					$sql = "select user.* from user,role where user.id_role=role.id_role and role.role_code='".$role_code."' and (LOWER(location) like '%".$keyword."%' or LOWER(career) like '%".$keyword."%' or LOWER(resume) like '%".$keyword."%')";
				$res = $db->send_sql($sql);
				$arr_user = null;
				if(mysqli_num_rows($res) > 0){
					while($row = $db->next_row()){
						$row = Util::getRawArray($row);
						$arr_user['id_user'] = $row['id_user'];
						$arr_user['login_name'] = $row['login_name'];
						$arr_user['login_pwd'] = $row['login_pwd'];
						$arr_user['fullname'] = $row['fullname'];
						$arr_user['cellphone'] = $row['cellphone'];
						$arr_user['email'] = $row['email'];
						$arr_user['id_role'] = $row['id_role'];
						$arr_user['resume'] = $row['resume'];
						$arr_user['career'] = $row['career'];
						$arr_user['location'] = $row['location'];
						$arr_user['id_resume'] = $row['id_resume'];
						$arr_users[] = $arr_user;
					}
				}
			}
			if($arr_users != null)
				/*delete users with same id*/
				$arr_users = array_intersect_key( $arr_users , array_unique( array_map('serialize' , $arr_users ) ) ); 
			return $arr_users;
		}
		public static function getUserManagementInfos(){
			$db = DatabaseFactory::getInstance();
			/*id_user,login_name, fullname, id_company, company_name, id_role, role_code*/
			$sql = "select distinct user.id_user as id_user,user.login_name as login_name, user.fullname as fullname, company.id_company as id_company, company.company_name as company_name, role.id_role as id_role, role.role_code as role_code from user,user_company,company,role where user.id_user = user_company.id_user and user.id_role = role.id_role and user_company.id_company = company.id_company order by company.id_company ";
			$res = $db->send_sql($sql);
			$users = null;
			if(mysqli_num_rows($res) > 0){
				while($row = $db->next_row()){
					$row = Util::getRawArray($row);
					$user['id_user'] = $row['id_user'];
					$user['login_name'] = $row['login_name'];
					$user['fullname'] = $row['fullname'];
					$user['id_company'] = $row['id_company'];
					$user['company_name'] = $row['company_name'];
					$user['id_role'] = $row['id_role'];
					$user['role_code'] = $row['role_code'];
					$users[] = $user;
				}
			}
			$sql = "select distinct user.id_user as id_user,user.login_name as login_name, user.fullname as fullname, role.id_role as id_role, 
					role.role_code as role_code from user,role where user.id_role = role.id_role and user.id_user not in 
					(select distinct user.id_user as id_user from user,user_company,company,role 
					where user.id_user = user_company.id_user and user.id_role = role.id_role)";
			$res = $db->send_sql($sql);
			if(mysqli_num_rows($res) > 0){
				while($row = $db->next_row()){
					$row = Util::getRawArray($row);
					$user['id_user'] = $row['id_user'];
					$user['login_name'] = $row['login_name'];
					$user['fullname'] = $row['fullname'];
					$user['id_company'] = null;
					$user['company_name'] = null;
					$user['id_role'] = $row['id_role'];
					$user['role_code'] = $row['role_code'];
					$users[] = $user;
				}
			}
			return $users;
		}
		public static function setUserCompanyRole($id_user, $id_company, $id_role){
			$db = DatabaseFactory::getInstance();
			$usercompany = UserCompany::getCompanyByUser($id_user);
			if($usercompany == null){/*new*/
				$user_company['id_user'] = $id_user;
				$user_company['id_company'] = $id_company;
				UserCompany::save($user_company);
			}else{
				$usercompany['id_company'] = $id_company;
				UserCompany::save($usercompany);
			}
			$user = User::getUser($id_user);
			if($user != null){
				$user['id_role'] = $id_role;
				User::save($user,true);
			}
		}

	}
?>