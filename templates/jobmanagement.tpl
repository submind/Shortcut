<!doctype html>
<html lang="en_us">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Job Management</title>
		<style>
			#table1 input{
				width: 100%;
				height: 100%;
			}
				
			#div1{
				margin-left:6%;
			}
			#div2{
				margin-left:6%;
			}
			#table1{
				width: 93%;
			}
			#table2{
				width: 93%;
			}
			.input{
				width: 56%;
				height: 22px;
			}
			#job_description{
				width: 56%;
				height:80px;
			}
		</style>
		<link rel="stylesheet" type="text/css" href="css/mystyle.css">
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
		<link rel="stylesheet" href="/resources/demos/style.css" />
	</head>
	<body>
		<script language="JavaScript">
			function onModify(id_job){
				document.getElementById("id_job").value=id_job;
				document.getElementById("job_title").value=document.getElementById("JT"+id_job).innerHTML;
				document.getElementById("job_location").value=document.getElementById("JL"+id_job).innerHTML;
				document.getElementById("job_description").value=document.getElementById("JD"+id_job).innerHTML;
				document.getElementById("expire_date").value=document.getElementById("ET"+id_job).innerHTML;
			}
			 $(function() {
				$( "#expire_date" ).datepicker();
				});
			function clearID(){
				document.getElementById("id_job").value = -1;
				return true;
			}

		</script>
		<div id="div1">
			<table border='1' id="table1">
				<tr><th>Seq</th><th>Title</th><th>Location</th><th>Description</th><th>Expire Date</th><th colspan=2>Operation</th></tr>
					{JM_TABLE_CONTENT}
			</table>
		</div>
		<hr/>
		<div id="div2">
			<form method="POST" id="job_detail_form" onreset="clearID();">
				<input type="hidden" id="id_job" name="id_job" value="-1" />
				<table border='1' id="table2">
					<tr><td colspan=2>Job Detail</td></tr>
					<tr><td>Title</td><td><input class="input" id="job_title" type="text" name="job_title" placeholder="Job Title" value="{JOBTITLE}"/></td></tr>
					<tr><td>Location</td><td><input class="input" id="job_location" type="text" name="job_location" placeholder="Job Location" value="{JOBLOCATION}"/></td></tr>
					<tr><td>Description</td><td><textarea id="job_description"  name="job_description" placeholder="Job Description">{JOBDESCRIPTION}</textarea></td></tr>
					<tr><td>Expire Date</td><td><input class="input" id="expire_date"  name="expire_date" placeholder="ExpireDate" readonly>{JOBEXPIREDATE}</input></td></tr>
					<tr><td><input name="save" type="submit" value="Save" /></td><td><input type="reset" value="Reset" /></td></tr>
				</table>
			</form>
		</div>
	</body>
</html>