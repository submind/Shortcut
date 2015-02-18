<?php
	function assemblyHeader(&$tpl){
		$header="<a href='../index.php'><img src='/imgs/banner.jpg' alt='Logo' style='width:30%; height:100%; text-align:center; padding-left:35%; '></a>";
		$tpl->assign("HEADER",$header);
	}

?>