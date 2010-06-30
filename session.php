<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Log Dumper</title>
<style type='text/css'>
	body,div,span,a,p,button{
		font-family: 'lucida grande', tahoma, verdana, arial, sans-serif;
		color:rgb(50,50,50);
	}
	
	#destroy,#create{
		display:none;
	}
</style>

<script type='text/javascript' src='jquery-1.4.2.min.js'></script>
<script type='text/javascript' src='dateFormat.js'></script>
<script type='text/javascript'>
	$(document).ready(function(){
		existsCheck();

		$('#destroyBtn').click(function(){
			$.get('service.php?service=session&action=destroy',function(){
				existsCheck();
			});
		});

		$('#createBtn').click(function(){
			$appName=$('#appName').attr('value');
			$password=$('#password').attr('value');
			$reciever=$('#reciever').attr('value');

			$.get('service.php?service=session&action=create&appName='+ $appName+
			'&password='+$password+'&reciever=' + $reciever,function($rest){
				existsCheck();
			});
		});
	});

	function existsCheck(){
		$('#destroy,#create').hide();
		$.get('service.php?service=session&action=isExists',function(resp){
			if(resp=='true'){
				$('#destroy').show();
			}
			else{
				$('#create').show();
			}
		});
	}

</script>
</head>
<body>
<h2>Session Manager</h2>
<div id='destroy'>
	<button id='destroyBtn'>Destroy</button>
</div>
<div id='create'>
	AppName<br>
	<input type='text' id='appName'/><br>
	Password<br>
	<input type='text' id='password'/><br>
	reciever URL<br>
	<input type='text' id='reciever' size=60/><br><br>
	<button id='createBtn'>Create</button>
</div>
</body>
</html>