<!doctype html>
<html lang="en_us">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Job Management</title>
		<style>
			#table2{
				width: 80%;
			}
			.joblabel{
				width: 56%;
				height: 22px;
			}
			#job_description{
				width: 56%;
				height:80px;
			}
			.applybutton{
				text-align:center;
			}
			.errMessage{
				color:#f00;
			}
		</style>
		
	</head>
	<body>
		<form action="" method="POST">
			<input type="hidden" id="id_job" name="id_job" value="{IDJOB}" />
			<table border='1' id="table2">
				<tr><td colspan=2>Job Detail</td></tr>
				<tr><td>Title</td><td class="joblabel">{JOBTITLE}</td></tr>
				<tr><td>Location</td><td class="joblabel">{JOBLOCATION}</td></tr>
				<tr><td>Description</td><td id="job_description">{JOBDESCRIPTION}</td></tr>
				<tr><td>Expire Date</td><td class="joblabel">{JOBEXPIREDATE}</td></tr>
				<tr><td>Invite Code(optional)</td><td>{INVITECODE}<div class="errMessage">{INVITECODEERR}</div></td></tr>
				<tr><td colspan=2 class="applybutton">{APPLYBUTTON}</td></tr>
			</table>
		</form>
	</body>
</html>