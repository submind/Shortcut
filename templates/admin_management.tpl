<!doctype html>
<html lang="en_us">
	<head>
	</head>
<body>
<script language="JavaScript">
	function validation_new_company(){
		var obj_company_name = document.getElementById("new_company_name"); 
		var company_name=obj_company_name.value;
		if(company_name==null || company_name=="")
		{
			alert("company name error");
			obj_company_name.focus();
			return false;
		}
		return true;
	}
	
	function validation_modify_company(company_id){
		var obj_company_name = document.getElementById("CN_INPUT"+company_id);
			//alert("CN"+company_id);
		//alert(obj_company_name.value);
		var company_name=obj_company_name.value;
		if(company_name==null || company_name=="")
		{
			alert("company name error");
			obj_company_name.focus();
			return false;
		}
		//alert("obj_company_name");
		return true;
	}
	

	
	
</script>
		<table border="1" id="user_table">
			<input type="hidden" id="id_job" name="id_job" value="-1" />
			<tr><th>Login Name</th><th>Full Name</th><th>Company</th><th>Role</th><th>Apply</th><th>Delete</th></tr>
			{USER_TABLE_CONTENT}
		</table>
	
	
		<table border="1" id="company_table">
			<tr><th>Company Name</th><th>Address</th><th>Descreption</th><th>Phone Number</th><th>Apply</th></tr>
			{COMPANY_TABLE_CONTENT}
			<form method="POST" onsubmit="return validation_new_company()">
			<tr>
			<td><input type="text" name = "company_name" id="new_company_name" placeholder="company name"/></td>
			<td><input type="text" name = "company_address" id="new_company_address" placeholder="company address"/></td>
			<td><input type="text" name = "company_description" id="new_company_descreption" placeholder="descreption"/></td>
			<td><input type="text" name = "cellphone" id="new_company_phone" placeholder="phone"/></td>
			<td><input type="submit" id="submit_button" value="add" name="add_company"/></td>    
			</tr>
			</form>
		</table>
	
</body>
</html>