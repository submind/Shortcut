<?php
	class Role{
		public static function save($raw_role){
			$db = DatabaseFactory::getInstance();
			$role = Util::getSecureArray($raw_role);
			if(isset($role["id_role"])){/*update*/
				$sql = "update role set role_code='".$role['role_code']."', role_description='".$role['role_description']."' where id_role=".$role['id_role'];
				$db->send_sql($sql);
				return $role["id_role"];
			}else{/*new one*/
				$sql = "insert into role set role_code='".$role['role_code']."', role_description='".$role['role_description']."'";
				$db->send_sql($sql);
				return $db->insert_id();
			}
		}
		public static function getRole($id_role){
			$db = DatabaseFactory::getInstance();
			$sql = "select id_role,role_code,role_description from role where id_role=".$id_role;
			$res = $db->send_sql($sql);
			$arr_role = null;
			if(mysqli_num_rows($res) > 0){
				if($row = $db->next_row()){
					$row = Util::getRawArray($row);
					$arr_role['id_role'] = $row['id_role'];
					$arr_role['role_code'] = $row['role_code'];
					$arr_role['role_description'] = $row['role_description'];
				}
			}
			return $arr_role;
		}
		public static function getRoleByCode($role_code){
			$db = DatabaseFactory::getInstance();
			$sql = "select id_role,role_code,role_description from role where role_code='".$role_code."'";
			$res = $db->send_sql($sql);
			$role = null;
			if(mysqli_num_rows($res) > 0){
				if($row = $db->next_row()){
					$row = Util::getRawArray($row);
					$role['id_role'] = $row['id_role'];
					$role['role_code'] = $row['role_code'];
					$role['role_description'] = $row['role_description'];
				}
			}
			return $role;
		}
		public static function deleteRole($id_role){
			$db = DatabaseFactory::getInstance();
			$sql = "delete from role where id_role=".$id_role;
			$db->send_sql($sql);
		}
		public static function getRoles($index_start, $count){
			$db = DatabaseFactory::getInstance();
			$limit = null;
			if($count != -1)
				$limit = " limit ".$index_start.",".$count;
			$sql = "select * from role ".$limit;
			$res = $db->send_sql($sql);
			$arr_roles = null;
			$arr_role = null;
			if(mysqli_num_rows($res) > 0){
				while($row = $db->next_row()){
					$row = Util::getRawArray($row);
					$arr_role['id_role'] = $row['id_role'];
					$arr_role['role_code'] = $row['role_code'];
					$arr_role['role_description'] = $row['role_description'];
					$arr_roles[] = $arr_role;
				}
			}
			return $arr_roles;
		}
	}
?>