<?php
	class Company{
		public static function save($raw_company){
			$db = DatabaseFactory::getInstance();
			$company = Util::getSecureArray($raw_company);
			if(isset($company["id_company"])){/*update*/
				$sql = "update company set company_name='".$company['company_name']."', company_address='".$company['company_address']."', company_description='".
				$company['company_description']."', cellphone = '".$company['cellphone']."' where id_company=".$company['id_company'];
				$db->send_sql($sql);
				return $company["id_company"];
			}else{/*new one*/
				$sql = "insert into company set company_name='".$company['company_name']."', company_address='".$company['company_address']."', company_description='".
				$company['company_description']."', cellphone = '".$company['cellphone']."'";			
				$db->send_sql($sql);
				return $db->insert_id();
			}
		}
		public static function delete($id_company){
			$db = DatabaseFactory::getInstance();
			$sql = "delete from company where id_company=".$id_company;
			$db->send_sql($sql);
		}
		public static function getCompanies(){
			$db = DatabaseFactory::getInstance();
			$sql = "select * from company";
			$res = $db->send_sql($sql);
			$companies = null;
			if(mysqli_num_rows($res) > 0){
				while($row = $db->next_row()){
					$row = Util::getRawArray($row);
					$company['id_company'] = $row['id_company'];
					$company['company_name'] = $row['company_name'];
					$company['company_address'] = $row['company_address'];
					$company['company_description'] = $row['company_description'];
					$company['cellphone'] = $row['cellphone'];
					$companies[] = $company;
				}
			}
			return $companies;
		}
	}
?>