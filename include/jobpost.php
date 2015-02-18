<?php
	class JobPost{
		public static function post($id_poster, $job){
			$db = DatabaseFactory::getInstance();
			$id_job = Job::save($job);
			$sql = "insert into job_post set id_poster=".$id_poster.", id_job=".$id_job;
			$db->send_sql($sql);
		}
		public static function getPostsByPoster($id_poster){
			$db = DatabaseFactory::getInstance();
			$sql = "select * from job_post where id_poster=".$id_poster;
			$res = $db->send_sql($sql);
			$jobposts = null;
			if(mysqli_num_rows($res) > 0){
				while($row = $db->next_row()){
					$jobpost['id_job_post'] = $row['id_job_post'];
					$jobpost['id_poster'] = $row['id_poster'];
					$jobpost['id_job'] = $row['id_job'];
					$jobpost['post_time'] = $row['post_time'];
					$jobposts[] = $jobpost;
				}
			}
			return $jobposts;
		}
	}
?>