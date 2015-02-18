<?php
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/include/includes.php");
	if(isset($_POST['id_resume']) and $_POST['id_resume'] != null){
		$resume = Resume::getResume($_POST['id_resume']);
		if($resume != null){
			header("Content-length: ".($resume['size']));
			header("Content-type: ".$resume['type']);
			header("Content-Disposition: attachment; filename=".$resume['name']);
			$content = $resume['content'];
			//ob_clean();
			flush();
			echo $content; 
		}
		exit;
	}else{
		echo "No resume exist!";
		exit;
	}
?>