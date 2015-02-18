<?php
	class UserCompany{
		public static function save($usercompany){
			$db = DatabaseFactory::getInstance();
			$usercompany = Util::getSecureArray($usercompany);
			if(isset($usercompany["id_user_company"])){/*update*/
				$sql = "update user_company set id_user=".$usercompany['id_user'].", id_company=".$usercompany['id_company']." where id_user_company=".$usercompany['id_user_company'];
				$db->send_sql($sql);
				return $usercompany["id_user_company"];
			}else{/*new one*/
				$sql = "insert into user_company set id_user=".$usercompany['id_user'].", id_company=".$usercompany['id_company'];
				$db->send_sql($sql);
				return $db->insert_id();
			}
		}
		public static function getUserCompany($id_user_company){
			$db = DatabaseFactory::getInstance();
			$sql = "select * from user_company where id_user_company=".$id_user_company;
			$res = $db->send_sql($sql);
			$usercompany = null;
			if(mysqli_num_rows($res) > 0){
				if($row = $db->next_row()){
					$usercompany['id_user_company'] = $row['id_user_company'];
					$usercompany['id_user'] = $row['id_user'];
					$usercompany['id_company'] = $row['id_company'];
				}
			}
			return $usercompany;
		}
		public static function getCompanyByUser($id_user){
			$db = DatabaseFactory::getInstance();
			$sql = "select * from user_company where id_user=".$id_user;
			$res = $db->send_sql($sql);
			$usercompany = null;
			if(mysqli_num_rows($res) > 0){
				if($row = $db->next_row()){
					$usercompany['id_user_company'] = $row['id_user_company'];
					$usercompany['id_user'] = $row['id_user'];
					$usercompany['id_company'] = $row['id_company'];
				}
			}
			return $usercompany;
		}
		public static function deleteUserCompany($id_user_company){
			$db = DatabaseFactory::getInstance();
			$sql = "delete from user_company where id_user_company=".$id_user_company;
			$db->send_sql($sql);
		}
		
		public static function getUserCompanys($index_start, $index_end){
			$db = DatabaseFactory::getInstance();
			$sql = "select * from user_company limit ".$index_start.",".$index_end;
			$res = $db->send_sql($sql);
			$usercompanys = null;
			$usercompany = null;
			if(mysqli_num_rows($res) > 0){
				while($row = $db->next_row()){
					$usercompany['id_user_company'] = $row['id_user_company'];
					$usercompany['id_user'] = $row['id_user'];
					$usercompany['id_company'] = $row['id_company'];
					$usercompanys[] = $usercompany;
				}
			}
			return $usercompanys;
		}
	}
?>