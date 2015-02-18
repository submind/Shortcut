<!doctype html>
<html lang="en_us">
<head>
 <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{FUNCTIONMODULE}</title>
<style>
	.personpageheader{
		height:100px;
		margin-left:5%;
		margin-right:5%;
	}
	.personpagefunctionpage{
		background-color:#F0F8FF;
		height:700px;
		width:69.6%;
		margin-left:5%;
		margin-right:5%;
		margin-top:0.5%;
	}
	.psersonpagesidebar{
		background-color:#70B8FF;
		margin-left:75%;
		margin-right:5%;
		margin-top: -700px;
        height: 700px;
        min-width:180px;
        position: relative;
	}
	.personpagename{
		font-size:180%;
		text-align:center;
		color:#FFFF00;
		font-weight:bold;
	}
	.psersonpagerole{
		font-size:100%;
		margin-top:5%;
		text-align:center;
	}
	.personpagemodules{
		text-align:center;	
		font-size:150%;
		margin-top:5%;
	}
    input[type=button]{
        width: 75%;
		height:40px;
		margin-top:5%;
    }
</style>
</head>
<body>
	<div class="personpageheader">
		{HEADER}
	</div>
	<div class="personpagefunctionpage">
		{FUNCTIONPAGE}
	</div>
	<div class="psersonpagesidebar">
		<div class="personpagename">
			{SIDEBARFULLNAME}
		</div>
		<div class="psersonpagerole">
			{SIDEBARROLECODE}
		</div>
		<div class="personpagemodules">
		{SIDEBARMODULES}
		</div>
	</div>
</body>
</html>