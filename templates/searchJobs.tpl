<!doctype html>
<html lang="en_us">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Search Candidate</title>
		<style>
			#div1{
				text-align: center;
				margin-top: 0.5%;
				border: 1px solid #000;
				padding-top: 2%;
				padding-bottom: 2%;
				padding-right: 2%;
			}
			#searchJobsKW{
				font-size:20px;
			}
			#searchJobsinput{
				width: 32%;
				height:25px;
				font-size:18px;
				margin-left:1%;
			}
			.searchJobsselect{
				width: 15%;
				margin-left: 3%;
				height:30px;
				font-size:18px;
			}
			#searchJobssubmit{
				width: 10%;
				margin-left: 4%;
				height:30px;
				font-size:18px;
			}
		</style>
		<script language="JavaScript">
			
		</script>
	</head>
	<body>
		<div id="div1">
			<form method="POST">
					<label id="searchJobsKW">Keyword</label><input id="searchJobsinput" name="keyword" type="text" />
					<select class="searchJobsselect" name="keyworditem">
						{KEYWORDOPTIONS}
					</select>
					<select class="searchJobsselect" name="job_location">
						{LOCATIONOPTIONS}
					</select>
					<input id="searchJobssubmit" name="searchsubmit" type="submit" value="SEARCH" />
			</form>
		</div>
	</body>
</html>