<?php
	class Job{
		/*the format of expire_date should be '2014-06-20'*/
		public static function save($raw_job){
			$db = DatabaseFactory::getInstance();
			$job = Util::getSecureArray($raw_job);
			$style=null;
			if(strstr($job['expire_date'],"-") != false){//2012-01-01
				$style = '%Y-%m-%d';
			}else{
				$style = '%m/%d/%Y';
			}
			if(isset($job["id_job"])){/*update*/
				$sql = "update job set job_title='".$job['job_title']."',job_description='".$job['job_description']."',job_location='"
						.$job['job_location']."', expire_date=STR_TO_DATE('".$job['expire_date']."','".$style."')"." where id_job=".$job['id_job'];
				$db->send_sql($sql);
				return $job['id_job'];
			}else{/*new*/
				$sql = "insert into job set job_title='".$job['job_title']."',job_description='".$job['job_description']."',job_location='"
						.$job['job_location']."', expire_date=STR_TO_DATE('".$job['expire_date']."','".$style."')";
				$db->send_sql($sql);
				return $db->insert_id();
			}
		}
		public static function getJob($id_job){
			$db = DatabaseFactory::getInstance();
			$sql = "select * from job where id_job=".$id_job;
			$res = $db->send_sql($sql);
			$job = null;
			if(mysqli_num_rows($res) > 0){
				if($row = $db->next_row()){
					$row = Util::getRawArray($row);
					$job['id_job'] = $row['id_job'];
					$job['job_title'] = $row['job_title'];
					$job['job_description'] = $row['job_description'];
					$job['job_location'] = $row['job_location'];
					$job['expire_date'] = $row['expire_date'];
				}
			}
			return $job;
		}
		
		public static function getJobs($index_s, $count){
			$db = DatabaseFactory::getInstance();
			$sql = "select * from job limit ".$index_s.",".$count;
			$res = $db->send_sql($sql);
			$jobs = null;
			if(mysqli_num_rows($res) > 0){
				while($row = $db->next_row()){
					$row = Util::getRawArray($row);
					$job['id_job'] = $row['id_job'];
					$job['job_title'] = $row['job_title'];
					$job['job_description'] = $row['job_description'];
					$job['job_location'] = $row['job_location'];
					$job['expire_date'] = $row['expire_date'];
					$jobs[] = $job;
				}
			}
			return $jobs;
		}
		public static function getLocations(){
			$db = DatabaseFactory::getInstance();
			$sql = "select distinct job_location from job";
			$res = $db->send_sql($sql);
			$locations = null;
			if(mysqli_num_rows($res) > 0){
				while($row = $db->next_row()){
					$row = Util::getRawString($row);
					$locations[] = $row;
				}
			}
			return $locations;
		}
		public static function deleteJob($id_job){
			$db = DatabaseFactory::getInstance();
			$sql = "delete from job where id_job=".$id_job;
			$db->send_sql($sql);
		}
		/*home page jobs data*/
		public static function getHomepageJobs($index_s, $count){
			$db = DatabaseFactory::getInstance();
			$sql = "select job.id_job as id_job, job.job_title as job_title, company.company_name as company_name, job.job_location as job_location, job.expire_date as expire_date from job,job_post,
					user_company,company where job.id_job = job_post.id_job 
					and job_post.id_poster = user_company.id_user and user_company.id_company = company.id_company ";
			if($count != -1)
				$sql = $sql."limit ".$index_s.",".$count;
			$jobs = null;
			$res = $db->send_sql($sql);
			if(mysqli_num_rows($res) > 0){
				while($row = $db->next_row()){
					$row = Util::getRawArray($row);
					$job['id_job'] = $row['id_job'];
					$job['job_title'] = $row['job_title'];
					$job['company_name'] = $row['company_name'];
					$job['job_location'] = $row['job_location'];
					$job['expire_date'] = $row['expire_date'];
					$jobs[] = $job;
				}
			}
			return $jobs;
		}
		public static function getHomepageJobsByKeywords($job_title,$job_location,$company_name,$job_description){
			$db = DatabaseFactory::getInstance();		
			$sql = "select job.id_job as id_job, job.job_title as job_title, company.company_name as company_name, job.job_location as job_location, job.expire_date as expire_date from job,job_post,
					user_company,company where job.id_job = job_post.id_job 
					and job_post.id_poster = user_company.id_user and user_company.id_company = company.id_company ";
			if($job_title != null){
				$sql = $sql."and LOWER(job.job_title) like '%".$job_title."%' ";
			}
			if($job_location != null){
				$sql = $sql."and LOWER(job.job_location) like '%".$job_location."%' ";
			}
			if($company_name != null){
				$sql = $sql."and LOWER(company.company_name) like '%".$company_name."%' ";
			}
			if($job_description != null){
				$sql = $sql."and LOWER(job.job_description) like '%".$job_description."%' ";
			}
			$jobs = null;
			$res = $db->send_sql($sql);
			if(mysqli_num_rows($res) > 0){
				while($row = $db->next_row()){
					$row = Util::getRawArray($row);
					$job['id_job'] = $row['id_job'];
					$job['job_title'] = $row['job_title'];
					$job['company_name'] = $row['company_name'];
					$job['job_location'] = $row['job_location'];
					$job['expire_date'] = $row['expire_date'];
					$jobs[] = $job;
				}
			}
			
			return $jobs;
		}
	}

?>