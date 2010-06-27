<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Phone - Simulator</title>
<style type='text/css'>
	body,div,span,a,p,button{
		font-family: 'lucida grande', tahoma, verdana, arial, sans-serif;
		color:rgb(50,50,50);
		font-size:12px;
	}
	
	#inbox{
		width:700px;
		height:125px;
		overflow : auto;
		border:1px solid rgb(150,150,150);
		padding:10px;
	}
	
	#log{
		width:700px;
		height:100px;
		overflow : auto;
		border:1px solid rgb(150,150,150);
		padding:10px;
	}
	
</style>
<script type='text/javascript' src='jquery-1.4.2.min.js'></script>
<script type='text/javascript' src='dateFormat.js'></script>
<script type='text/javascript'>
		var phoneNo=null;
		$(document).ready(function(){
			getSMSLog();
			$('#send').click(function(){
				if(!phoneNo) $('#setPhoneNo').click();
				var message=$('#message').attr('value');

				$.get('service.php?service=sendSMS&phone=' + phoneNo + '&message=' + message,function(resp){
					alert("Message sent!");
					$('#message').attr('value',"");
					$('#message').focus();
					handleLog(resp);
				});
			});

			$('#setPhoneNo').click(function(){
				phoneNo=$('#phoneNo').attr('value');
				$('#phoneNo').attr('disabled','disabled');
				
			});
		});

		function handleLog(log){
			var date=new Date();
			var html='@ ' + date.format() + '<br>' + log + '<hr/>';
			var div=$('#log');
			div.append(html);
			div.attr('scrollTop',div.attr('scrollHeight'));
		}

		function getSMSLog(){
			if(!phoneNo){
				//when user has not entered the phone no
				setTimeout('getSMSLog();',500);
				return;
			}
			$.get('service.php?service=smsLog&phone='+phoneNo,function(resp){
				var response=null;
				eval('response=' + resp);
				
				var html="";
				for(index in response){
					var item=response[index];
					var date=new Date();
					date.setTime(item.timestamp*1000);
					
					html+='from:' +item.appName + ', ' + 'message:' + item.message;
					html+=" @" + date.format() + "<hr/>";
				}

				var div=$('#inbox');
				div.html(html);
				div.attr('scrollTop',div.attr('scrollHeight'));

				setTimeout('getSMSLog();',500);
			});
		}
</script>

</head>
<body>
<h2>Phone Simulator</h2>
<b>My Phone No</b><br>
<input type='text' id='phoneNo' /> 
<button id='setPhoneNo'>Set Phone No</button><br><br>
<b>Message to the Appzone</b><br>
<textarea id='message' rows="5" cols="50"></textarea><br>
<button id='send'>Send</button>
<h3>Inbox</h3>
<div id='inbox'></div>
<h3>Return Log</h3>
<div id='log'></div>
</body>
</html>