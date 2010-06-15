<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Log Dumper</title>
<style type='text/css'>
	#serverLog{
		width:940px;
		height:300px;
		overflow : auto;
	}
</style>

<script type='text/javascript' src='jquery-1.4.2.min.js'></script>
<script type='text/javascript' src='dateFormat.js'></script>
<script type='text/javascript'>
	$(document).ready(function(){
		getServerLog();
	});

	function getServerLog(){
		$.get('service.php?service=serverLog',function(resp){
			var response=null;
			eval('response=' + resp);

			
			var html="";
			for(index in response){
				var item=response[index];
				var date=new Date();
				date.setTime(item.timestamp*1000);
				
				html+='appName:' +item.appName + ', ' + 'address:' + item.address +
					' message:' + item.message;
				html+="@" + date.format() + "<br>";
			}

			var div=$('#serverLog');
			div.html(html);
			div.attr('scrollTop',div.attr('scrollHeight'));
			
		});

		setTimeout('getServerLog();',500);
	}
</script>
</head>
<body>
<h2>Server Log</h2>
<div id='serverLog'></div>
<h2>Phone Log</h2>
<div id='phoneLog'></div>
</body>
</html>