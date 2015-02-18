<?php

	include_once (rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/include/includes.php");
	$usernameerror="";
	$login_name="";
	$fullname="";
	$cellphone="";
	$email="";
	$resume="";
	$career="";
	$location="";
	if(isset($_POST['submit']))
	{
		if(User::getUser(-1,strtolower($_POST['login_name'])) == null)
		{
			$user['login_name'] = strtolower($_POST['login_name']);
			$user['login_pwd'] = $_POST['login_pwd'];
			$user['fullname'] = $_POST['fullname'];
			$user['cellphone'] = $_POST['cellphone'];
			$user['email'] = $_POST['email'];
			$user['resume'] = $_POST['resume'];
			$user['career'] = $_POST['career'];
			$user['location'] = $_POST['location'];
			/*id_role*/
			$role = Role::getRoleByCode("standard");
			$user['id_role'] = $role['id_role'];
			User::save($user);
			header('location:../index.php');
		}else{
			$usernameerror = "This name has been used!";
			$login_name=$_POST['login_name'];
			$fullname=$_POST['fullname'];
			$cellphone=$_POST['cellphone'];
			$email=$_POST['email'];
			$resume=$_POST['resume'];
			$career=$_POST['career'];
			$location=$_POST['location'];
		}
	}
	$tpl = new FastTemplate(rtrim($_SERVER["DOCUMENT_ROOT"],'/')."/templates");
	$tpl->define(array("signup"=>"signup.tpl"));
	$tpl->assign(array( 
	"SIGNUP" => "SIGN UP", 
	"LOGINNAMEALERT" => "Please type your login_name.",
	"LOGINNAMESAMEALERT" => "The login_name has already exists!",
	"LOGINPWDALERT" => "Password must be 5-12 digits or characters!",
	"RELOGINPWDALERT" => "Password is not the same!",
	"FULLNAMEALERT" => "Please type your fullname.",
	"CELLPHONEALERT" => "Please type 10 numbers like: 'XXX-XXX-XXXX' or 'XXX.XXX.XXXX' or 'XXX XXX XXXX' or 'XXXXXXXXXX'.",
	"EMAILALERT" => "Not a valid e-mail address",
	"RESUMEALERT" => "Please type your resume.",
	"CAREERALERT" => "Please type your career.",
	"LOCATIONALERT" => "Please type your location.",
	"ADDNEWUSER" => "Add New User",
	"USERNAMEERROR"=>$usernameerror,
	"LOGINNAME"=>$login_name,
	"FULLNAME"=>$fullname,
	"CELLPHONE"=>$cellphone,
	"EMAIL"=>$email,
	"RESUME"=>$resume,
	"CAREER"=>$career,
	"LOCATION"=>$location
	));
	$tpl->parse("ptl_signup", "signup"); 
	// print contents of handler "result" 
	$tpl->FastPrint("ptl_signup"); 
?>