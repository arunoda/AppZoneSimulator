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
	
	#serverLog{
		width:940px;
		height:250px;
		overflow : auto;
		border:1px solid rgb(150,150,150);
		padding:10px;
	}
	
	#phoneLog{
		width:940px;
		height:250px;
		overflow : auto;
		border:1px solid rgb(150,150,150);
		padding:10px;
	}
	
	#pause{
		width:70px;
		height:30px;
	}
	
</style>

<script type='text/javascript' src='jquery-1.4.2.min.js'></script>
<script type='text/javascript' src='dateFormat.js'></script>
<script type='text/javascript'>
	var pause=false;
	$(document).ready(function(){
		getServerLog();
		getPhoneLog();

		$('#pause').click(function(){
			var buttonName="Play";
			if(pause){
				pause=false;
				buttonName='Pause';
			}
			else{
				pause=true;
			}

			$('#pause').text(buttonName);
		});
	});

	function getServerLog(){
		if(pause) {
			setTimeout('getServerLog();',500);
			return;
		}
		
		$.get('service.php?service=serverLog',function(resp){
			var response=null;
			eval('response=' + resp);

			
			var html="";
			for(index in response){
				var item=response[index];
				var date=new Date();
				date.setTime(item.timestamp*1000);
				
				html+='appName:' +item.appName + ', ' + 'address:' + item.address +
					' message:' + item.message + ', status:' + item.statusCode;
				html+=" @" + date.format() + "<br>";
			}

			var div=$('#serverLog');
			div.html(html);
			div.attr('scrollTop',div.attr('scrollHeight'));
			
		});

		setTimeout('getServerLog();',500);
	}

	function getPhoneLog(){
		if(pause) {
			setTimeout('getPhoneLog();',500);
			return;
		}
		$.get('service.php?service=phoneLog',function(resp){
			var response=null;
			eval('response=' + resp);

			
			var html="";
			for(index in response){
				var item=response[index];
				var date=new Date();
				date.setTime(item.timestamp*1000);
				
				html+='from:' +item.from + ', ' + 'to:' + item.to +
					' message:' + item.message ;
				html+=" @" + date.format() + "<br>";
			}

			var div=$('#phoneLog');
			div.html(html);
			div.attr('scrollTop',div.attr('scrollHeight'));
			
		});

		setTimeout('getPhoneLog();',500);
	}
</script>
</head>
<body>
<button id='pause'>Pause</button>
<h2>Server Log</h2>
<div id='serverLog'></div>
<h2>Phone Log</h2>
<div id='phoneLog'></div>
</body>
</html>