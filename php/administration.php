<?php
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/include/includes.php");
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/php/sidebar.php");	
	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/php/header.php");	
	if(!Util::checkSession('administration')){
		header("Location:../index.php");
		exit;
	}
	
	/*user modify, delete*/
if(isset($_POST['id_user'])){
		/*modify*/
		if(isset($_POST['modify-user'])){
			User::setUserCompanyRole($_POST['id_user'],$_POST['company_select'],$_POST['role_select']);
			
			
			
		}elseif(isset($_POST['delete-user'])){
			User::deleteUser($_POST['id_user']);
		}
	}

/*add new company*/
if(isset($_POST['add_company'])){

	$new_company['company_name']= $_POST['company_name'];
	$new_company['company_address']= $_POST['company_address'];
	$new_company['company_description']= $_POST['company_description'];
	$new_company['cellphone']= $_POST['cellphone'];
	Company::save($new_company);
	
}
/*modify company*/
if(isset($_POST['id_company'])){
	$new_company['id_company'] =$_POST['id_company'];
	$new_company['company_name']= $_POST['company_name'];
	$new_company['company_address']= $_POST['company_address'];
	$new_company['company_description']= $_POST['company_description'];
	$new_company['cellphone']= $_POST['cellphone'];
	Company::save($new_company);
	
}
/*
if(isset($_POST['modify_company'])){
	$new_company['company_name']= $_POST['company_name'];
	$new_company['company_address']= $_POST['company_address'];
	$new_company['company_description']= $_POST['company_description'];
	$new_company['cellphone']= $_POST['cellphone'];
}
	*/
	$tpl = new FastTemplate(rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/templates");
	$tpl ->define(array("Administratiion" => "admin_management.tpl",
						"tr"=>"tr.tpl",
						"td"=>"td.tpl",
						"link"=>"link.tpl",
						"divbutton"=>"div_modulebutton.tpl",
						"button"=>"button.tpl",
						"select"=>"select_name.tpl",
						"input"=>"input_id.tpl",
						"form"=>"form_onsubmit.tpl",
						"inputhidden"=>"inputhidden.tpl",
						"option"=>"options.tpl",
						"personalpage"=>"personalpage.tpl"));
						
	assemblyHeader($tpl);
	assemblySideBar($tpl);
	
	
	//all users
	$users = User::getUserManagementInfos();	
	//all companies
	$companies = Company::getCompanies();
	//all roles
	$roles = Role::getRoles(0,-1);
	/*user list*/
	if (is_array($users)){
		foreach($users as $user){
			$tpl->assign("TDID","LN".$user['id_user']);
			$tpl->assign("TDCONTENT",$user['login_name']);
			$tpl->parse("TRCONTENT","td");
			$tpl->assign("TDID","FN".$user['id_user']);
			$tpl->assign("TDCONTENT",$user['fullname']);
			$tpl->parse("TRCONTENT",".td");
			//company
			$tpl->assign("TDID","CM".$user['id_user']);
			//clear
			$tpl->clear("SELECTCONTENT");
			if(is_array($companies)){
				foreach($companies as $company){
					$tpl->assign("OPTIONVALUE",$company['id_company']);
					$tpl->assign("OPTIONCONTENT",$company['company_name']);
					if($user['company_name'] == $company['company_name']){
						//pre select
						$tpl->assign("OPTIONSELECTED","selected");
						$tpl->parse("SELECTCONTENT",".option");
					}
					else{
						$tpl->assign("OPTIONSELECTED","");
						$tpl->parse("SELECTCONTENT",".option");
					}
				}
			}
			$tpl->assign("SELECTNAME","company_select");
			$tpl->parse("TDCONTENT","select");
			$tpl->parse("TRCONTENT",".td");
			//roles
			$tpl->assign("TDID","Role".$user['id_user']);
			//clear
			$tpl->clear("SELECTCONTENT");
			foreach($roles as $role){
				$tpl->assign("OPTIONVALUE",$role['id_role']);
				$tpl->assign("OPTIONCONTENT",$role['role_code']);
				if($user['role_code'] == $role['role_code']){
				//pre select
					$tpl->assign("OPTIONSELECTED","selected");
					$tpl->parse("SELECTCONTENT",".option");
				}
				else{
					$tpl->assign("OPTIONSELECTED","");
					$tpl->parse("SELECTCONTENT",".option");
				}
			}
			$tpl->assign("SELECTNAME","role_select");
			$tpl->parse("TDCONTENT","select");
			$tpl->parse("TRCONTENT",".td");
			
			//button-modify
			/*
			$tpl->assign("BUTTONNAME","BTM".$user['id_user']);
			$tpl->assign("BUTTONTEXT","Modify");
			$tpl->assign("BUTTONID","");
			$tpl->assign("ONCLICK","onModify(".$user['id_user'].")");
			$tpl->parse("TDCONTENT","button");
			$tpl->parse("TRCONTENT",".td");
			*/
			$tpl->assign(array("INPUTTYPE"=>"submit",
								"INPUTNAME"=>"modify-user",
								"INPUTPLACEHOLDER"=>"",
								"INPUTVALUE"=>"modify"));
			$tpl->parse("TDCONTENT","input");
			$tpl->parse("TRCONTENT",".td");
			//button-delete
			/*
			$tpl->assign("BUTTONNAME","BTD".$user['id_user']);
			$tpl->assign("BUTTONTEXT","Delete");
			$tpl->assign("BUTTONID","");
			$tpl->assign("ONCLICK","onDelet(".$user['id_user'].")");
			$tpl->parse("TDCONTENT","button");
			$tpl->parse("TRCONTENT",".td");
			*/
			/*delete*/
			$tpl->assign(array("INPUTTYPE"=>"submit",
								"INPUTNAME"=>"delete-user",
								"INPUTPLACEHOLDER"=>"",
								"INPUTVALUE"=>"delete"));
			$tpl->parse("TDCONTENT","input");
			$tpl->parse("TRCONTENT",".td");
			/*hidden input*/
			$tpl->assign(array("HIDDENNAME"=>"id_user",
								"HIDDENVALUE"=>$user['id_user']));
			$tpl->assign("ONSUBMITFUNCTION","");
			$tpl->parse("FORMCONTENT","inputhidden");
			$tpl->parse("FORMCONTENT",".tr");
			$tpl->parse("USER_TABLE_CONTENT",".form");
		}
		//clear
		$tpl->clear("TRCONTENT");
		//company table
	if(is_array($companies)){
		foreach($companies as $company){
			$tpl->assign("INPUTTYPE","text");
			$tpl->assign("INPUTNAME","company_name");
			$tpl->assign("INPUTPLACEHOLDER","");
			$tpl->assign("INPUTID","CN_INPUT".$company['id_company']);
			$tpl->assign("INPUTVALUE",$company['company_name']);
			$tpl->assign("TDID","CN".$company['id_company']);
			$tpl->parse("TDCONTENT","input");
			$tpl->parse("TRCONTENT","td");
			
			$tpl->assign("INPUTTYPE","text");
			$tpl->assign("INPUTNAME","company_address");
			$tpl->assign("INPUTPLACEHOLDER","");
			$tpl->assign("INPUTID","CA_INPUT".$company['id_company']);
			$tpl->assign("INPUTVALUE",$company['company_address']);
			$tpl->assign("TDID","CA".$company['id_company']);
			$tpl->parse("TDCONTENT","input");
			$tpl->parse("TRCONTENT",".td");
			
			$tpl->assign("INPUTTYPE","text");
			$tpl->assign("INPUTNAME","company_description");
			$tpl->assign("INPUTPLACEHOLDER","");
			$tpl->assign("INPUTID","CD_INPUT".$company['id_company']);
			$tpl->assign("INPUTVALUE",$company['company_description']);
			$tpl->assign("TDID","CD".$company['id_company']);
			$tpl->parse("TDCONTENT","input");
			$tpl->parse("TRCONTENT",".td");
			
			$tpl->assign("INPUTTYPE","text");
			$tpl->assign("INPUTNAME","cellphone");
			$tpl->assign("INPUTPLACEHOLDER","");
			$tpl->assign("INPUTID","CP_INPUT".$company['id_company']);
			$tpl->assign("INPUTVALUE",$company['cellphone']);			
			$tpl->assign("TDID","CP".$company['id_company']);
			$tpl->parse("TDCONTENT","input");
			$tpl->parse("TRCONTENT",".td");
			
			//button-modify
			/*
			$tpl->assign("BUTTONNAME","BTC".$company['id_company']);
			$tpl->assign("BUTTONTEXT","Modify");
			$tpl->assign("BUTTONID","");
			$tpl->assign("ONCLICK","onModify_company(".$company['id_company'].")");
			$tpl->parse("TDCONTENT","button");
			$tpl->parse("TRCONTENT",".td");
			*/
			$tpl->assign(array("INPUTTYPE"=>"submit",
								"INPUTNAME"=>"modify_company",
								"INPUTPLACEHOLDER"=>"",
								"INPUTID"=>"",
								"INPUTVALUE"=>"Modify"));
			$tpl->parse("TDCONTENT","input");
			$tpl->parse("TRCONTENT",".td");
			/*hidden input*/
			//$tpl->clear("SELECTCONTENT");
			$tpl->assign(array("HIDDENNAME"=>"id_company",
								"HIDDENVALUE"=>$company['id_company']));
			$tpl->parse("FORMCONTENT","inputhidden");
			$tpl->assign("ONSUBMITFUNCTION","return validation_modify_company(".$company['id_company'].")");
			$tpl->parse("FORMCONTENT",".tr");
			$tpl->parse("COMPANY_TABLE_CONTENT",".form");
			
		}
	}
	else{
		$tpl->assign("COMPANY_TABLE_CONTENT","");
	}
	$tpl->parse("FUNCTIONPAGE","Administratiion");
	$tpl->assign("FUNCTIONMODULE","Admin Management");
	$tpl->parse("PERSONALPAGE","personalpage");
	$tpl->FastPrint("PERSONALPAGE"); 
	//$tpl->FastPrint("ADMINMANAGEMENT"); 
	}

?>