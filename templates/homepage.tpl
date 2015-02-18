<!doctype html>
<html lang="en_us">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shortcut</title>
	</style>
	<script language="JavaScript">
		function validation()
		{
			var obj_login_name = document.getElementById("login_name");  //login_name
			var login_name=obj_login_name.value;
			if(login_name==null || login_name=="")
			{
				alert("{LOGINNAMEALERT}"); //alert fasttemplate should contain ""
				obj_login_name.focus();
				return false;
			}
			var obj_login_pwd = document.getElementById("login_pwd");  //login_pwd
			var login_pwd=obj_login_pwd.value;
			if(login_pwd.search(/^\w{5,12}$/) == -1)
			{
				alert("{LOGINPWDALERT}");
				obj_login_pwd.focus();
				return false;
			}
			return true;
		}
	</script>
	<style>
	#divheadpage{
		height:90px;
		margin-bottom:1%;
        margin: 1px 5%;
	}
	#divsearch{
        margin: 1px 5%;
		background-color:#99CCFF;
		margin-bottom:0.5%;
	}
	#divcontent{
		background-color:#F0F8FF;
		height:410px;
		float:left;
        width: 65%;
        margin-left: 5%;
	}
	#loginblock{
		margin-top: 0%;
        background-color: #70B8FF;
        width: 45%;
        margin-left: 50%;
		height:255px;
		padding-top:0.5%;
	}
    #loginblock h2{
        padding-top: 1em;
        margin-top: 0;
        padding-left: 1%;
    }
        
    #loginblock form
    {
        padding-left: -15%;
        padding-bottom: 2em;
    }
	#divadvertisement{
        float: left;
        margin: 2px 0;
        width: 25%;
		height:153px;
		border: 1px solid black;
	}
	.err{color:red;}
	.input{
		width: 70%;
    }
	#welcome{
		font-size:150%;
	}
	</style>
</head>
<body>
	<div id="divheadpage">
	{HEADER}
	</div>
	<div id="divsearch">
		{SEARCHJOBSAREA}
	</div>
	<div id="divcontent">
		{CONTENTAREA}
	</div>
	<div id="loginblock">
			{LOGINAREA}
	</div>
			
	<div id="divadvertisement">
	{ADVERTISEMENTAREA}
	</div>
</body>
</html>