<?php
	include_once ($_SERVER["DOCUMENT_ROOT"]."/include/databaseClassMySQLi.php");
	include_once ($_SERVER["DOCUMENT_ROOT"]."/include/dbConfig.php");
	class DatabaseFactory{
		private static $db=null;
		public static function getInstance(){
			if(DatabaseFactory::$db == null){
				global $host,$db_name,$db_pwd,$db_user;
				DatabaseFactory::$db = new database();
				DatabaseFactory::$db->setup($db_user,$db_pwd,$host,$db_name);
			}
			return DatabaseFactory::$db;
		}
	}
?>