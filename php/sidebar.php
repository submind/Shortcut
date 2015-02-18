<?php
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/include/includes.php");
	function assemblySideBar(&$tpl){
		/*this part will be replace*/
		if(!isset($_SESSION['id_user'])){
			header("Location:../index.php");
			exit;
		}
		/*display modules*/
		if(isset($_SESSION['module_code']) && isset($_SESSION['module_text'])){
			$modulecodes = unserialize($_SESSION['module_code']);
			$moduletexts = unserialize($_SESSION['module_text']);
			/*display*/
			$tpl->assign(array("SIDEBARFULLNAME"=>$_SESSION['fullname'],
								"SIDEBARROLECODE"=>$_SESSION['role_code']));
			/*LOGOUT*/
			$tpl->assign(array("ONCLICK"=>"location.href='http://".$_SERVER['HTTP_HOST']."/php/logout.php';",
									"BUTTONID"=>"logout",
									"BUTTONNAME"=>"logout",
									"BUTTONTEXT"=>"Log out"));
			$tpl->parse("MODULECODE","button");
			$tpl->parse("SIDEBARMODULES","divbutton");
			$count = count($modulecodes);
			for($i=0;$i<$count;$i++){
				$tpl->assign(array("ONCLICK"=>"location.href='http://".$_SERVER['HTTP_HOST']."/php/".$modulecodes[$i].".php';",
									"BUTTONID"=>$modulecodes[$i],
									"BUTTONNAME"=>$modulecodes[$i],
									"BUTTONTEXT"=>$moduletexts[$i]));
				$tpl->parse("MODULECODE","button");
				$tpl->parse("SIDEBARMODULES",".divbutton");			
			}
		}else{
			/*display*/
			$tpl->assign(array("FULLNAME"=>$_SESSION['fullname'],
								"ROLECODE"=>$_SESSION['role_code']));
			/*LOGOUT*/
			$tpl->assign(array("ONCLICK"=>"location.href='http://".$_SERVER['HTTP_HOST']."/php/logout.php';",
									"BUTTONID"=>"logout",
									"BUTTONNAME"=>"logout",
									"BUTTONTEXT"=>"Log out"));
			$tpl->parse("MODULECODE","button");
			$tpl->parse("SIDEBARMODULES","divbutton");
		}
	}
?>