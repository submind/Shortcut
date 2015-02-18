<style>
.err{
	color:red;
	margin-top: -10%;
}
.inputlogin{width:70%;}
.labellogin{
	font-weight:500;
}
#signlogin{margin-top:1%}

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

	<div id="loginblock">
		<h2>{LOGIN}</h2>
		
		<form class="loginclass" name="loginForm" action="" method="post" onsubmit="return validation()">
			<span class="labellogin">{USERNAME}</span><br/>
			<div><input id="login_name" name="login_name" class="inputlogin" type="text"></input></div><br/>
			<span class="labellogin">{PASSWORD}</span><br/>
			<div><input id="login_pwd" name="login_pwd" class="inputlogin" type="password"></input></div><br/>

			<input id="signlogin" type="submit" value="Login" name="signsubmit"></input>
			<a href="/php/signup.php">{NEWUSER}</a>
		</form>
		
		<div class="err">{ERRMSG}</div>
	</div>
