	<script>
		function myFunction()
		{
			var element = document.getElementById("btn_save");
			if(element != null){
				if(element.value == "Modify"){
					element.value = "Save";
					element = document.getElementById("login_pwd");
					element.disabled="";
					element.value="";
					element = document.getElementById("login_repwd");
					element.disabled="";
					element.value="";
					element = document.getElementById("cellphone");
					element.disabled="";
					element = document.getElementById("email");
					element.disabled="";
					element = document.getElementById("resume");
					element.disabled="";
					element = document.getElementById("career");
					element.disabled="";
					element = document.getElementById("location");
					element.disabled="";
					element = document.getElementById("userfile");
					element.disabled="";	
					element = document.getElementById("upload");
					element.disabled="";					
					return false;
				}else{
					var obj_login_pwd = document.getElementById("login_pwd");  //login_pwd validation
					var login_pwd=obj_login_pwd.value;
					var obj_login_repwd = document.getElementById("login_repwd");  //login_pwd validation
					var login_repwd=obj_login_repwd.value;
					
					var re =  /^\w{5,12}$/;
					 if (re.test(login_pwd)==false)
					 {
						alert("{LOGINPWDALERT}");
						obj_login_pwd.focus();
						return false;
					 }else if(login_pwd!=login_repwd ){	//if user input different password in the re-input
						alert("{LOGINREPWDALERT}");
						obj_login_repwd.focus();
						return false;
					}
					var obj_phoneNum = document.getElementById("cellphone");	  //cellphonevalidation
					var phoneNum=obj_phoneNum.value;
					var re = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
					  if (re.test(phoneNum)==false)
					 {
						alert("{PHONENUMBERALERT}");
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
					 var obj_resume = document.getElementById("resume");    //resume
					 var resume=obj_resume.value;
					 if(resume==null || resume=="")
					 {
						alert("{RESUMEALERT}");
						obj_resume.focus();
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
					document.userform.submit();
					return true;
				}
			}else{
				return false;
			}
		}
		function onInvite(){
			var e = document.getElementById("jobsshow");
			if(e.style.display != "block")
				e.style.display = "block";
		}
	   $(function() {
			$( "#resume_dialog" ).dialog({
			autoOpen: false,
			 height: 250,
			width: 500,
			show: {
			
			duration: 1000
			},
			hide: {
			
			duration: 1000
			}
		});
		$( "#resume_up_down" ).click(function() {
			$( "#resume_dialog" ).dialog( "open" );
			});
		});
	</script>
	<style>
		table{
			margin:0 auto;
		}
		.content{
			margin:0 auto;
		}
		
		.tag1{
			margin-top:20px;
		}
		.input_tag{
		
			height:25px;
			width:200px;
		}
		.user_infor_form{
			margin:0 auto;
		}
		input{
			font-weight:500;
		}
		#opener{
			text-align:center;
			height: 37px;
		}
		#btnarea{
			text-align:center;
		}
		#error{
			color: #f00;
		}
		.user_info_form input, .user_info_form textarea {
			width:100%;
			
		}
		.user_info_form input[type="button"] {
			width:30%;
			text-align:center;
		}
		#btn_save{
			position: relative;
			left: 35%;
		}
		#jobsshow{
			width:80%;
			text-align:center;
			margin-left:10%;
		}
		#btn1{
			width:60%;
			margin-left:42%;
			margin-bottom:2%;
		}
		#profilesubmit{
			width: 23%;
			margin-left: 3.5%;
			height: 36px;
		}
	</style>

		<div class="content">
			<div class="user_info_form">
				<form enctype="multipart/form-data" method="post" name="userform" id="userform"" onsubmit="return myFunction();">
					<table border=1>
						<input type="hidden" name="id_user" value="{ID_USER}" />
						<tr><td>{login_name}</td><td>{LOGIN_NAME}</td></tr>
						<tr><td>{login_pwd}</td><td> 
						<input type="password"  name="login_pwd" id="login_pwd" value="{LOGIN_PWD}" disabled="disabled"/></td></tr>
						{LOGIN_PWD_RE}
						<tr><td>{fullname}</td><td>{FULLNAME}</td></tr>
						<tr><td>{cellphone}</td><td>
						<input type="text"  name="cellphone" id="cellphone" value="{CELLPHONE}" disabled="disabled"/></td></tr>
						<tr><td>{email}</td><td>
						<input type="text"  name="email" id="email" value="{EMAIL}" disabled="disabled"/></td></tr>
						<tr><td>{resume_text}</td><td>
						<textarea cols="32" rows="6" name="resume" id="resume" disabled="disabled">{RESUME}</textarea></td></tr>
						<tr><td>{career}</td><td>
						<input type="text"   name="career" id="career" value="{CAREER}" disabled="disabled"/></td></tr>
						<tr><td>{location}</td><td>
						<input type="text"  name="location" id="location" value="{LOCATION}" disabled="disabled"/></td></tr>
						<tr><td>{resume}</td><td>
						
						<input type= "button" id="resume_up_down" value="RESUME"/>
					</td></tr>
						<div  class="btnarea">
							{MODIFYBUTTON}
						</div>
					</table>
				</form>
				<div id="btn1">
					{INVITEBUTTON}
				</div>
			</div>
			<div id="resume_dialog" title="RESUME">
				{UPLOAD}
				{DOWNLOAD}
			</div>
			<div id="jobsshow" title="Choose Jobs to invite" style="display:none;">
				<table border=1 >
					<form method="post" id="jobsform" name="jobsform">
						<input type="hidden" name="id_user" value="{ID_USER}" />
						<tr><th>Check</th><th>Job Title</th><th>Job Description</th><th>Location</th></tr>
						{JOBSTABLECONTENT}
						<tr>
							<td colspan=4><input type="submit"  id="profilesubmit" name="submit" value="Confirm"/></td>
						</tr>
					  </form>
					 
				</table>
			</div>			
		</div>
