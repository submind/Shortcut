<style>
</style>

<script>

function switchToMode(mode){
	var su_app_table = document.getElementById("standard-app-table");
	var su_invitaton = document.getElementById("standard-invitation-table");
	var hr_app_table = document.getElementById("hr-app-table");
	var hr_invitaton = document.getElementById("hr-invitation-table");
	if(mode == "standard"){
		su_app_table.style.display = "block";
		su_invitaton.style.display = "block";
		hr_app_table.style.display = "none";
		hr_invitaton.style.display = "none";
	}else if(mode == "hr"){
		su_app_table.style.display = "none";
		su_invitaton.style.display = "none";
		hr_app_table.style.display = "block";
		hr_invitaton.style.display = "block";
	}else{
		su_app_table.style.display = "none";
		su_invitaton.style.display = "none";
		hr_app_table.style.display = "none";
		hr_invitaton.style.display = "none";
	}
}
</script>
<body onload="switchToMode({MODE});">
<div id="applications">
	<div id="app-label">
	Applications
	</div>
	<div id="standard-app-table">
		<table border=1>
			<tr><th>Job Title</th><th>Company</th><th>Location</th><th>Description</th><th>Apply Date</th><th>Invite Code</th></tr>
			{SUAPPLICATIONS}
		</table>
	</div>
	<div id="hr-app-table">
		<table border=1>
			<tr><th>Applicant Name</th><th>Job Title</th><th>Job Location</th><th>Job Description</th><th>Apply Date</th><th>Invite Code</th><th>Detail</th></tr>
			{HRAPPLICATIONS}
		</table>
	</div>
	<div id="invitation-label">
	Invitations
	</div>
	<div id="standard-invitation-table">
		<table border=1>
			<tr><th>Job Title</th><th>Company</th><th>Location</th><th>Description</th><th>Invite Date</th><th>Invite Code</th><th>Apply</th></tr>
			{SUINVITATIONS}
		</table>
	</div>
	<div id="hr-invitation-table">
		<table border=1>
			<tr><th>Applicant Name</th><th>Job Title</th><th>Job Location</th><th>Job Description</th><th>Invite Date</th><th>Invite Code</th><th>Applied</th><th>Detail</th></tr>
			{HRINVITATIONS}
		</table>
	</div>
</div>
</body>