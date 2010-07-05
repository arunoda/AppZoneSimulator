<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>AppZone.lk Simulator</title>
		<link href='assests/style.css' rel='stylesheet' />
		<link type="text/css" href="assests/redmond/jquery-ui-1.8.2.custom.css" rel="stylesheet" />	
		<script type="text/javascript" src="assests/jquery-1.4.2.min.js"></script> 
		<script type="text/javascript" src="assests/jquery-ui-1.8.2.custom.min.js"></script> 
		<script type="text/javascript" src="assests/dateFormat.js"></script> 
		<script type='text/javascript' src='assests/main.js' ></script>
	</head>
	<body>
		<div id='wrapper'>
			<div id='topBar'>
				<div id='heading'>
					<h1>AppZone.lk Simulator</h1>
					<h2>by MIT @ University of Kelaniya</h2>
				</div>
				<div id='session'>
					<button id='createBtn'>Create New Session</button>
					<button id='destroyBtn'>Destroy Session</button>
				</div>
				<div class='clear'></div>
			</div>
			<div id='contentBar'>
				<ul>
					<li><a href="#logs">View Logs</a></li>
					<li><a href="#phones">Phones</a></li>
				</ul>
				<div id="logs">
					<button id='pause'>Pause</button>
					<h2>Server Log</h2>
					<div id='serverLog'></div>
					<h2>Phone Log</h2>
					<div id='phoneLog'></div>
				</div>
				<div id="phones">
					<input type='text' id='phoneNo' size='30'/><button id='newPhone'>New Phone</button>
					<br><br>
					<div id='phoneList'>
						<ul id='phoneNames'>
							
						</ul>
						
					</div>
				</div>
			</div>
		</div>
		
		<div class='phone' id='samplePhone' style='display:none'>
			<b>Message to the Appzone</b><br>
			<textarea class='message' rows="5" cols="50"></textarea><br>
			<button class='send'>Send</button>
			<h3>Inbox</h3>
			<div class='inbox'></div>
			<h3>Return Log</h3>
			<div class='log'></div>
		</div>
		
		<div id='createSession' title="Create New Session" style='display:none'>
			AppName<br>
			<input type='text' id='appName'/><br>
			Password<br>
			<input type='text' id='password'/><br>
			reciever URL<br>
			<input type='text' id='reciever' size=60/><br><br>
			<button id='createSessionBtn'>Create</button>
		</div>
	</body>
</html>