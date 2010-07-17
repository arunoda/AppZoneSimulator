/*********************************
 * @author Arunoda Susiripala
 * @copyright Arunoda Susiripala
 * @licence http://www.gnu.org/licenses/gpl-3.0.txt
 */

$(document).ready(function(){
	$('#contentBar').tabs();
	$('button').button();
	$('#phoneList').tabs();
});

/***************************************
 * LOG VIEW
 **************************************/
var pause=false;
$(document).ready(function(){
	getServerLog();
	getPhoneLog();

	$('#logs #pause').click(function(){
		var buttonName="Play";
		if(pause){
			pause=false;
			buttonName='Pause';
		}
		else{
			pause=true;
		}

		$('#logs #pause').text(buttonName);
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

		var div=$('#logs #serverLog');
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

		var div=$('#logs #phoneLog');
		div.html(html);
		div.attr('scrollTop',div.attr('scrollHeight'));
		
	});

	setTimeout('getPhoneLog();',500);
}

/***************************************************
* Phones
***************************************************/
var totalPhones=0;

$(document).ready(function(){
	$('#phones #newPhone').click(function(){
		var phoneNo=$('#phones #phoneNo').attr('value');
		new Phone(phoneNo);
		$('#phones #phoneNo').attr('value','');
		totalPhones++;
	});
	
});

function Phone(phoneNo){
	
	//Phone UI Creation
	$phoneDiv=
		'<div id="'+phoneNo+'" class="phone">' + 
		$('#samplePhone').html() +
		'</div>';
	$('#phoneList').append($phoneDiv);
	var index=$('#phoneList').tabs('add',"#"+phoneNo,phoneNo);
	$('#phoneList').tabs('select',totalPhones);
	$('#'+phoneNo+' .message').focus();
	
	//SMS inbox setup
	getSMSLog(phoneNo);
	
	//SMS Functionality
	$('#'+phoneNo+' .send').click(function(){
		var message=$('#'+phoneNo+' .message').attr('value');
		
		var script='alert("Message sent!");'+
		"$('#"+phoneNo+" .message').attr('value',\"\");"+
		"$('#"+phoneNo+" .message').focus();"+
		"handleLog('#"+phoneNo+"',response)";
		
		var callback=createDynamicFunction(script);

		$.get('service.php?service=sendSMS&phone=' + phoneNo + '&message=' + message,callback);
	});

}

function handleLog(id,log){
	var date=new Date();
	var html='@ ' + date.format() + '<br>' + log + '<hr/>';
	var div=$(id+' .log');
	div.append(html);
	div.attr('scrollTop',div.attr('scrollHeight'));
}

function getSMSLog(phoneNo){
	var script="eval('response=' + response);"+
		'var html="";'+
		'for(index in response){'+
			'var item=response[index];'+
			'var date=new Date();'+
			'date.setTime(item.timestamp*1000);'+
			
			"html+='from:' +item.appName + ', ' + 'message:' + item.message;"+
			'html+=" @" + date.format() + "<hr/>";'+
		'}'+
	
		"var div=$('#"+phoneNo+" .inbox');"+
		'div.html(html);'+
		"div.attr('scrollTop',div.attr('scrollHeight'));"+
	
		'setTimeout(\'getSMSLog("'+phoneNo+'");\',500);';
	
	var callback=createDynamicFunction(script);
	
	$.get('service.php?service=smsLog&phone='+phoneNo,callback);
}

function createDynamicFunction(script){
	//make callback Global
	var callbackName="callback_" + Math.floor(Math.random()*10000);
	var func="function "+ callbackName +"(response){"+script+"} ";
	jQuery.globalEval(func);
	var func;
	eval('func='+callbackName);
	return func;
};

/****************************************************************
 *  SESSION 
 * *************************************************************/

$(document).ready(function(){
	existsCheck();

	$('#destroyBtn').click(function(){
		$.get('service.php?service=session&action=destroy',function(){
			existsCheck();
			$('#serverLog,#phoneLog').html("");
			$('#phoneList div').detach();
			$('#phoneList ul li').detach();
		});
	});
	
	$('#createBtn').click(function(){
		$("#createSession").dialog({
			width:450,
			height:200,
			modal: true
		});
		$('#createSession #appName').focus();
	});

	$('#createSessionBtn').click(function(){
		$appName=$('#createSession #appName').attr('value');
		$password=$('#createSession #password').attr('value');
		$reciever=$('#createSession #reciever').attr('value');

		$.get('service.php?service=session&action=create&appName='+ $appName+
		'&password='+$password+'&reciever=' + $reciever,function($rest){
			existsCheck();
		});
		
		$("#createSession").dialog('close');
	});
});

function existsCheck(){
	$('#destroyBtn,#createBtn').hide();
	$.get('service.php?service=session&action=isExists',function(resp){
		if(resp=='true'){
			$('#destroyBtn').show();
		}
		else{
			$('#createBtn').show();
		}
	});
}
