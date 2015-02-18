<?php
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/include/databaseFactory.php");
	class Util{
		/**/
		public static function gotoHomePage(){
			$root = rtrim($_SERVER["DOCUMENT_ROOT"],'/');
			header("Location:".$root."/index.php");
		}
		/*session check*/
		public static function checkSession($module_code){
			$valid = false;
			$module_code = Util::getSecureString($module_code);
			if(isset($_SESSION['id_user'])){
				if(isset($_SESSION['module_code'])){
					$modules = unserialize($_SESSION['module_code']);
					if(in_array($module_code,$modules))
						$valid = true;
				}
			}
			return $valid;
		}
		/*logout*/
		public static function logout(){
			session_destroy();
			if(isset($_SESSION)){
				unset($_SESSION['id_user']);
			}
		}
		/*generate invite code*/
		public static function getInviteCode($id_invitor, $id_invitee, $id_job){
			return Util::getCiphertext('invitor'.$id_invitor.'invitee'.$id_invitee.'job'.$id_job);
		}
		/*generate sql/html/js secure string*/
		public static function getSecureString($raw){
			if(is_string($raw)){
				$db = DatabaseFactory::getInstance();
				$securestring = $db->real_escape_string($raw);
				$securestring = addcslashes($securestring, '%_');
				$securestring = str_replace("<","&lt",$raw);
				$securestring = str_replace(">","&gt",$securestring);
				return addslashes($securestring);
			}else
				return $raw;
		}
		/*translate sql secure string to raw string*/
		public static function getRawString($secure){
		/*remove trip operation*/
			//if(is_string($secure))
			//	return stripslashes($secure);
			//else	
				return $secure;
		}
		/*convert all the strings in array into sql secure ones*/
		public static function getSecureArray($rawArray){
			$secureArray = null;
			if(is_array($rawArray)){
				foreach($rawArray as $k => $v){
					if(is_string($v))
						$secureArray[$k] = Util::getSecureString($v);
					else
						$secureArray[$k] = $v;
				}
			}
			return $secureArray;
		}
		/*convert all sql secure strings in array into raw ones*/
		public static function getRawArray($secureArray){
			$rawArray = null;
			if(is_array($secureArray)){
				foreach($secureArray as $k => $v){
					if(is_string($v))
						$rawArray[$k] = Util::getRawString($v);
					else
						$rawArray[$k] = $v;
				}
			}
			return $rawArray;
		}
		/*convert raw string to ciphered one*/
		public static function getCiphertext($rawString){
			return hash("sha256",$rawString);
		}
		/*the function below is originally created by Prof. Steven*/
		public static function superExplode($str, $sep){
			$i = 0;
			$token = strtok($str, $sep);
			$arr[$i++] = $token;
			while(($token = strtok($sep))!== FALSE){
				if(strlen($token) !== 1)
					$arr[$i++] = $token;
			}
			return $arr;
		}
	}
?>