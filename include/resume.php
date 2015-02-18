<?php
	class Resume{
		public static function save($raw_resume){
			$db = DatabaseFactory::getInstance();
			//$resume = Util::getSecureArray($raw_resume);
			$resume = $raw_resume;
			$resume['content'] = addslashes($resume['content']);
			if(isset($resume['id_resume'])){/*update*/
				$sql = "update resume set name='".$resume['name']."', size=".$resume['size'].", type='".$resume['type']."', content='".$resume['content']."' where id_resume=".$resume['id_resume'];
			}else{
				$sql = "insert into resume set name='".$resume['name']."', size=".$resume['size'].", type='".$resume['type']."', content='".$resume['content']."'";
			}
			$db->send_sql($sql);
			if(isset($resume['id_resume'])){
				return $resume['id_resume'];
			}else{
				return $db->insert_id();
			}
		}
		
		public static function getResume($id_resume){
			$db = DatabaseFactory::getInstance();
			$id_resume = Util::getSecureString($id_resume);
			$sql = "select * from resume where id_resume=".$id_resume;
			$res = $db->send_sql($sql);
			$resume = null;
			if(mysqli_num_rows($res) > 0){
				$row = $db->next_row();
				if($row != null){
					$resume['id_resume'] = $row['id_resume'];
					$resume['name'] = $row['name'];
					$resume['size'] = $row['size'];
					$resume['type'] = $row['type'];
					$resume['content'] = $row['content'];
				}
			}
			return $resume;
		}
	}
?>