<?php 
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/include/includes.php");
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/php/sidebar.php");	
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/php/header.php");

	if(!Util::checkSession('searchcandidate')){
		header("Location:../index.php");
		exit;
	}
	$users = null;
	if(isset($_POST['submit'])){
		if($_SESSION['role_code'] == 'admin')
			$users = User::searchUsers(strtolower($_POST['keywords']),'all');
		else
			$users = User::searchUsers(strtolower($_POST['keywords']));
	}
	
	$tpl = new FastTemplate($_SERVER["DOCUMENT_ROOT"]."templates");
	$tpl->define(array("searchcandidate"=>"searchcandidate.tpl",
						"li"=>"li.tpl",
						"th"=>"th.tpl",
						"table"=>"table.tpl",
						"td"=>"td_noid.tpl",
						"tr"=>"tr.tpl",
						"input"=>"input.tpl",
						"form_action"=>"form_action.tpl",
						"sidebar"=>"sidebar.tpl",
						"tdcol"=>"td_noid_colspan.tpl",
						"input" => "input.tpl",
						"form"=>"form.tpl",
						"divbutton"=>"div_modulebutton.tpl",
						"button"=>"button.tpl",
						"inputhidden"=>"inputhidden.tpl",
						"inputdis"=>"input_disabled.tpl",
						"inputid"=>"input_id.tpl",
						"personalpage"=>"personalpage.tpl"));
	assemblyHeader($tpl);
	assemblySideBar($tpl);
	$tpl->assign(array( 
	"SHORTCUT" => "ShortCut"
	));
	
	$tpl->assign("THCONTENT","Login Name");
	$tpl->parse("TRCONTENT",".th");
	$tpl->assign("THCONTENT","Full Name");
	$tpl->parse("TRCONTENT",".th");
	$tpl->assign("THCONTENT","Job Location");
	$tpl->parse("TRCONTENT",".th");
	$tpl->assign("THCONTENT","Job Career");
	$tpl->parse("TRCONTENT",".th");
	$tpl->assign("THCONTENT","Resume");
	$tpl->parse("TRCONTENT",".th");
	$tpl->assign("THCONTENT","Detail");
	$tpl->parse("TRCONTENT",".th");
	$tpl->parse("TABLECONTENT",".tr");
	$num = count($users);
	for($i=0;$i<$num;$i++){
		$user = $users[$i];
		$tpl->assign("TDCONTENT",$user['login_name']); //login_name is db column name
		$tpl->parse("TRCONTENT","td");
		$tpl->assign("TDCONTENT",$user['fullname']);
		$tpl->parse("TRCONTENT",".td");
		$tpl->assign("TDCONTENT",$user['location']);
		$tpl->parse("TRCONTENT",".td");
		$tpl->assign("TDCONTENT",$user['career']);
		$tpl->parse("TRCONTENT",".td");
		$tpl->assign("TDCONTENT",$user['resume']);
		$tpl->parse("TRCONTENT",".td");
		$tpl->assign(array(
			"INPUTTYPE"=>"submit",
			"INPUTNAME"=>"detail",
			"INPUTVALUE"=>"detail",
			"INPUTPLACEHOLDER"=>""
		));
		$tpl->parse("TDCONTENT","input");
		$tpl->parse("TRCONTENT",".td");
		$tpl->parse("FORMCONTENT","tr");
		$tpl->assign(array(
			"HIDDENNAME"=>"id_user",
			"HIDDENVALUE"=>$user['id_user']
		));		
		$tpl->parse("FORMCONTENT",".inputhidden");
		$tpl->assign("ACTIONPAGE","profile.php");
		$tpl->parse("TABLECONTENT",".form_action");
	}
	$tpl->parse("MAIN","table");
	/*FINAL*/
	$tpl->assign("FUNCTIONMODULE","Search Candidate");/**/
	$tpl->parse("FUNCTIONPAGE","searchcandidate");
	$tpl->parse("PERSONALPAGE","personalpage");
	$tpl->FastPrint("PERSONALPAGE"); 
?>

