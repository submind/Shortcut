<?php
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/include/databaseFactory.php");
	class DbUtil{
		/*get session information*/
		public static function getSessionInfor($id_user){
			$db = DatabaseFactory::getInstance();
			$sql = "select user.id_user as id_user,user.fullname as fullname,user.login_name as login_name,role.id_role as id_role,role.role_code as role_code,role.role_description as role_description
					from user,role
					where user.id_role=role.id_role
					and user.id_user=".$id_user;
			$res = $db->send_sql($sql);
			$user_info = null;
			if(mysqli_num_rows($res) > 0){
				if($row = $db->next_row()){
					$user_info['id_user'] = $row['id_user'];
					$user_info['fullname'] = $row['fullname'];
					$user_info['login_name'] = $row['login_name'];
					$user_info['id_role'] = $row['id_role'];
					$user_info['role_code'] = $row['role_code'];
					$user_info['role_description'] = $row['role_description'];
				}
			}
			if($user_info != null){
				$sql = "select module.module_code as module_code, module.module_text as module_text from role_module,module
						where role_module.id_module = module.id_module and role_module.id_role=".$user_info['id_role'];
				$res = $db->send_sql($sql);
				$arr_module_code = null;
				$arr_module_text = null;
				if(mysqli_num_rows($res) > 0){
					while($row = $db->next_row()){
						$arr_module_code[] = $row['module_code'];
						$arr_module_text[] = $row['module_text'];
					}
					if(count($arr_module_code) > 0)
						$arr_module_code = serialize($arr_module_code);
					if(count($arr_module_text) > 0)
						$arr_module_text = serialize($arr_module_text);
				}
				$user_info['module_code'] = $arr_module_code;
				$user_info['module_text'] = $arr_module_text;
			}
			return $user_info;
		}
	}
?>