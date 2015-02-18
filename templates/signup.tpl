<!doctype html>
<html lang="en_us">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>{SIGNUP}</title>
	<style>
		#form
		{
		border:1px solid #E5E5E5;
		}
		#addnew
		{
			height:700px;
			padding-top:1%;
			width:50%;
			margin-left:25%;
			background-color:#E1E1E1;
		}
		.label{font-weight:bold;}
		#login_name{
			height:30px;
			width:35%;
			background-color:#DBEEFF;
			float:left;
			margin-left:5%;
			margin-top:3%;
		}
		#fullname{
			height:30px;
			width:35%;
			background-color:#DBEEFF;
			margin-left:15%;
		}
		#login_pwd{
			float:left;
			height:30px;
			width:35%;
			background-color:#DBEEFF;
			margin-left:5%;
			margin-top:3%;
		}
		#relogin_pwd{
			height:30px;
			width:35%;
			background-color:#DBEEFF;
			margin-left:15%;
		}
		
		#cellphone{
			float:left;
			height:30px;
			width:35%;
			background-color:#DBEEFF;
			margin-left:5%;
			margin-top:3%;
		}
		#email{
			height:30px;
			width:35%;
			background-color:#DBEEFF;
			margin-left:15%;
		}
		#career{
			float:left;
			height:30px;
			width:35%;
			background-color:#DBEEFF;
			margin-left:5%;
			margin-top:3%;
		}
		#location{
			height:30px;
			width:35%;
			background-color:#DBEEFF;
			margin-left:15%;
		}
		#resume{
			background-color:#DBEEFF;
			height:300px;
			margin-left:5%;
			width:86%;
		}
		#sign{background-color:#009900;
			color:white;
			height: 50px;
			width:27%;
			vertical-align: baseline;  
			outline: none;  
			cursor: pointer;  
			text-align: center;  
			text-decoration: none;  
			font: 20px/100% Arial, Helvetica, sans-serif; 
			text-shadow: 0 1px 1px rgba(0,0,0,.3);  
			-webkit-border-radius: .5em;   
			-moz-border-radius: .5em;  
			border-radius: .7em;  
			margin-left:15%;
		}
		#cancel{background-color:#009900;
			color:white;
			height: 50px;
			width:27%;
			vertical-align: baseline;  
			outline: none;  
			cursor: pointer;  
			text-align: center;  
			text-decoration: none;  
			font: 20px/100% Arial, Helvetica, sans-serif; 
			text-shadow: 0 1px 1px rgba(0,0,0,.3);  
			-webkit-border-radius: .5em;   
			-moz-border-radius: .5em;  
			border-radius: .7em;  
			margin-left:15%;
		}
		h1{font:italic bold 30px Georgia, serif;text-align:center;}
		#usernameErr{
			color:#f00;
			margin-left: -36%;
		}
	</style>
</head>
<body>
	<script language="JavaScript">
	function validation()
	{
		var obj_login_name = document.getElementById("login_name");  //login_name
		var login_name=obj_login_name.value;
		if(login_name==null || login_name=="")
		{
			alert("{LOGINNAMEALERT}");
			obj_login_name.focus();
			return false;
		}
		var obj_fullname = document.getElementById("fullname");  //fullname
		var fullname=obj_fullname.value;
		if(fullname==null || fullname=="")
		{
			alert("{FULLNAMEALERT}");
			obj_fullname.focus();
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
		var reobj_login_pwd = document.getElementById("relogin_pwd");  //login_pwd
		var relogin_pwd=reobj_login_pwd.value;
		if(relogin_pwd!=login_pwd)
		{
			alert("{RELOGINPWDALERT}");
			reobj_login_pwd.focus();
			return false;
		}
		
		var obj_phoneNum = document.getElementById("cellphone");	  //cellphonevalidation
		var phoneNum=obj_phoneNum.value;
		var re = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
		  if (re.test(phoneNum)==false)
		 {
			alert("{CELLPHONEALERT}");
			obj_phoneNum.focus();
			return false;
		 }
		var obj_email = document.getElementById("email");    //emailvalidation
		var email=obj_email.value;
		 var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		 if (re.test(email)==false)
		 {
			alert("{EMAILALERT}");
			obj_email.focus();
			return false;
		 }
		 var obj_career = document.getElementById("career");    //career
		 var career=obj_career.value;
		 if(career==null || career=="")
		 {
			alert("{CAREERALERT}");
			obj_career.focus();
			return false;
		 }
		 var obj_location = document.getElementById("location");    //location
		 var location=obj_location.value;
		 if(location==null || location=="")
		 {
			alert("{LOCATIONALERT}");
			obj_location.focus();
			return false;
		 }
		 var obj_resume = document.getElementById("resume");    //resume
		 var resume=obj_resume.value;
		 if(resume==null || resume=="")
		 {
			alert("{RESUMEALERT}");
			obj_resume.focus();
			return false;
		 }
		return true;
	}

	</script>
	<div id="form">
	<input type="hidden" id="inputid" name="inputname" value="1">
		<div id="addnew">
			<h1>{ADDNEWUSER}</h1>
			<form name="AddNewForm" action="" method="post" onsubmit="return validation()">
				<span id="usernameErr">{USERNAMEERROR}</span>
				<input id="login_name" name="login_name" class="input" type="text" placeholder="Login Name"  height="100px" value="{LOGINNAME}"/><br/>
				<input id="fullname" name="fullname" class="input" type="text" placeholder="Full name" value="{FULLNAME}"/><div id="fullnameErr"></div><br/>
				<input id="login_pwd" name="login_pwd" class="input" type="password" placeholder="Password"/><div id="passwdErr"></div><br/>
				<input id="relogin_pwd" name="relogin_pwd" class="input" type="password" placeholder="Re-enter password"/><div id="repasswdErr"></div><br/>
				<input id="cellphone" name="cellphone" class="input" type="text" placeholder="Cellphone" value="{CELLPHONE}"/><div id="cellphoneErr"></div><br/>
				<input id="email" name="email" class="input" type="text" placeholder="Email" value="{EMAIL}"/><div id="emailErr"></div><br>
				<input id="career" name="career" class="input" type="text" placeholder="Career objective" value="{CAREER}"/><div id="careerErr"></div><br/>
				<input id="location" name="location" class="input" type="text" placeholder="Your location" value="{LOCATION}"/><div id="locationErr"></div><br/>
				<textarea rows="2" cols="23" id="resume" name="resume" class="input" placeholder="Resume">{RESUME}</textarea><div id="resumeErr"></div><br/>
				<input id="sign" type="submit" value="SIGN UP" name="submit"/>
				<input type="button" id="cancel" onclick="window.location.href = '/index.php';" value="CANCEL"/>
			</form>
		</div>
	</div>
</body>
</html>