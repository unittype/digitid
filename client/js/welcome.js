let login_valid = {'email':false, 'password':false};
	let login_message = {
		'isEmailEmpty':'Email is required!', 
		'isEmailValid':'Email must be valid!',
		'isPassEmpty':'Password is required!', 
		'isPassValid':'Password string should avoid (+ = - / ? > < . , * ~ ` )'
	};
	let sign_valid = {'username':false, 'email':false, 'password_a':false, 'password_b':false, 'first_name':false, 'last_name':false, 'birthday':false, 'country':false};
	let signup_message = {
		'isUsernameEmpty' : 'Username is required!',
		'isUsernameValid' : 'Username must be valid [a-zA-Z0-9_]',
		'isEmailEmpty':'Email is required!', 
		'isEmailValid':'Email must be valid!',
		'isPassEmpty':'Password is required!', 
		'isPassValid':'Password string should avoid (+ = - / ? > < . , * ~ ` )',
		'isCPassEmpty':'Confirm password is required!', 
		'isCPassValid':'Confirm password!',
		'isFNameEmpty': 'First name required!',
		'isFNameValid': 'Only alphabet letter!',
		'isLNameEmpty': 'Last name required!',
		'isLNameValid': 'Only alphabet letter!',
		'isBdayEmpty' : 'Date of birth required!',
		'isBdayValid' : 'Date of birth invalid!',
		'isCountrySelected' : 'Select your country!'
	};
	
	function _(e) {
		return document.getElementById(e);
	}
	function $(c, n) {
		return document.getElementsByClassName(c)[n];
	}	
	function mailchar(email) {
		var filter = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
		return (filter.test(email));
	}
	function names(name) {
		var filter = /^([a-zA-Z])+$/;
		return (filter.test(name));
	}
	function dater(date) {
		var filter = /^([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))$/;
		return (filter.test(date));
	}
	function passchar(pass) {
		var filter = /^([a-zA-Z0-9_%@!?]*)+$/;
		return filter.test(pass);
	}
	function namechar(name) {
		var filter = /^([a-zA-Z0-9_ ]*)$/;
		return filter.test(name);
	}
	function disabledBTN(id, bool) {
		if(!bool){
			_(id).style.cursor = 'default';
			_(id).style.backgroundColor= '#555';
			_(id).disabled = true;			
		}else {
			_(id).style.backgroundColor= 'rgba(61, 165, 255, 1)';
			_(id).style.cursor = 'pointer';
			_(id).disabled = false;
		}
	}
	function CallBack(id) { 
		if(!(login_valid['email'] && login_valid['password'])) {
			disabledBTN(id, false);
		} else {
			disabledBTN(id, true);	
		}
	}
	function CallBackUp(id) { 
		if(sign_valid['username'] == true && sign_valid['email'] == true && sign_valid['password_a'] == true && sign_valid['password_b'] == true && sign_valid['first_name'] == true && sign_valid['last_name'] == true && sign_valid['birthday'] == true && sign_valid['country'] == true) {
			disabledBTN(id, true);	
		} else {
			disabledBTN(id, false);
		}
	}
	function toggle(a, b){
		if(_(a).style.display=='none'){
			_(a).style.display='block';
			_(b).style.display='none';		
		}else{
			_(a).style.display='none';
			_(b).style.display='block';
		}
	}
	function tab() {
		toggle('in', 'up');
	}
	function next() {
		if(_('proc_a').style.display=='none'){
			_('proc_a').style.display='block';
			_('proc_b').style.display='none';
			_('nextbtn').innerHTML = 'next';
		}else{
			_('proc_a').style.display='none';
			_('proc_b').style.display='block';
			_('nextbtn').innerHTML = 'back';
		}
	}
	window.onload = function() {
		disabledBTN('logbtn', false);	
		disabledBTN('upbtn', false);
		_('proc_b').style.display = 'none';
		_('nextbtn').style.display = 'none';
	}
	_('logbtn').addEventListener('mouseover', CallBack('logbtn'), true);
	_('upbtn').addEventListener('mouseover', CallBackUp('upbtn'), true);
	/// Login in form 
	_('lun').addEventListener('blur', 
		function (){
			if (!this.value > 0) {
				$('valid valid_1 tooltip', 0).style.color = "#ff0000";
				$('valid valid_1 tooltip', 0).innerHTML = "!<span class='tooltiptext'>"+login_message['isEmailEmpty']+"</span>";
				login_valid['email'] = false;
			}else if (!mailchar(this.value)){
				$('valid valid_1 tooltip', 0).style.color = "#ff0000";
				$('valid valid_1 tooltip', 0).innerHTML = "!<span class='tooltiptext'>"+login_message['isEmailValid']+"</span>";				
				login_valid['email'] = false;
			}else {
				$('valid valid_1 tooltip', 0).style.color = "#00ff00";
				$('valid valid_1 tooltip', 0).innerHTML = '☑';
				login_valid['email'] = true;
			}
			CallBack('logbtn');
		},  true);
	_('lpw').addEventListener('keyup', 
		function (){
			if (!this.value > 0) {
				$('valid valid_2 tooltip', 0).style.color = "#ff0000";
				$('valid valid_2 tooltip', 0).innerHTML = "!<span class='tooltiptext'>"+login_message['isPassEmpty']+"</span>";
				login_valid['password'] = false;
			}else if (!passchar(this.value)){
				$('valid valid_2 tooltip', 0).style.color = "#ff0000";
				$('valid valid_2 tooltip', 0).innerHTML = "!<span class='tooltiptext'>"+login_message['isPassValid']+"</span>";				
				login_valid['password'] = false;
			}else {
				$('valid valid_2 tooltip', 0).style.color = "#00ff00";
				$('valid valid_2 tooltip', 0).innerHTML = '☑';
				login_valid['password'] = true;
				CallBack('logbtn');
			}
		},  true);
	_('lpw').addEventListener('blur', 
		function (){
			if (!this.value > 0) {
				$('valid valid_2 tooltip', 0).style.color = "#ff0000";
				$('valid valid_2 tooltip', 0).innerHTML = "!<span class='tooltiptext'>"+login_message['isPassEmpty']+"</span>";
				login_valid['password'] = false;
			}else if (!passchar(this.value)){
				$('valid valid_2 tooltip', 0).style.color = "#ff0000";
				$('valid valid_2 tooltip', 0).innerHTML = "!<span class='tooltiptext'>"+login_message['isPassValid']+"</span>";				
				login_valid['password'] = false;
			}else {
				$('valid valid_2 tooltip', 0).style.color = "#00ff00";
				$('valid valid_2 tooltip', 0).innerHTML = '☑';
				login_valid['password'] = true;
			}
			CallBack('logbtn');
		},  true);

	/// Signuo form
	_('sun').addEventListener('blur', 
		function (){
			if (!this.value > 0) {
				$('valid valid_3 tooltip', 0).style.color = "#ff0000";
				$('valid valid_3 tooltip', 0).innerHTML = "!<span class='tooltiptext'>"+signup_message['isUsernameEmpty']+"</span>";
				sign_valid['username'] = false;
			}else if (!namechar(this.value)){
				$('valid valid_3 tooltip', 0).style.color = "#ff0000";
				$('valid valid_3 tooltip', 0).innerHTML = "!<span class='tooltiptext'>"+signup_message['isUsernameValid']+"</span>";				
				sign_valid['username'] = false;
			}else {
				$('valid valid_3 tooltip', 0).style.color = "#00ff00";
				$('valid valid_3 tooltip', 0).innerHTML = '☑';
				sign_valid['username'] = true;
			}
			CallBackUp('upbtn');
		}, true);
	_('smail').addEventListener('blur', 
		function (){
			if (!this.value > 0) {
				$('valid valid_4 tooltip', 0).style.color = "#ff0000";
				$('valid valid_4 tooltip', 0).innerHTML = "!<span class='tooltiptext'>"+signup_message['isEmailEmpty']+"</span>";
				sign_valid['email'] = false;
			}else if (!mailchar(this.value)){
				$('valid valid_4 tooltip', 0).style.color = "#ff0000";
				$('valid valid_4 tooltip', 0).innerHTML = "!<span class='tooltiptext'>"+signup_message['isEmailValid']+"</span>";				
				sign_valid['email'] = false;
			}else {
				$('valid valid_4 tooltip', 0).style.color = "#00ff00";
				$('valid valid_4 tooltip', 0).innerHTML = '☑';
				sign_valid['email'] = true;
			}
			CallBackUp('upbtn');
		},  true);
	_('spw').addEventListener('blur', 
		function (){
			if (!this.value > 0) {
				$('valid valid_5 tooltip', 0).style.color = "#ff0000";
				$('valid valid_5 tooltip', 0).innerHTML = "!<span class='tooltiptext'>"+signup_message['isPassEmpty']+"</span>";
				sign_valid['password_a'] = false;
			}else if (!passchar(this.value)){
				$('valid valid_5 tooltip', 0).style.color = "#ff0000";
				$('valid valid_5 tooltip', 0).innerHTML = "!<span class='tooltiptext'>"+signup_message['isPassValid']+"</span>";				
				sign_valid['password_a'] = false;
			}else {
				$('valid valid_5 tooltip', 0).style.color = "#00ff00";
				$('valid valid_5 tooltip', 0).innerHTML = '☑';
				sign_valid['password_a'] = true;
			}
			CallBackUp('upbtn');
		},  true);
	_('scpw').addEventListener('keyup', 
		function (){
			if (!this.value > 0) {
				$('valid valid_6 tooltip', 0).style.color = "#ff0000";
				$('valid valid_6 tooltip', 0).innerHTML = "!<span class='tooltiptext'>"+signup_message['isCPassEmpty']+"</span>";
				sign_valid['password_b'] = false;
			}else if (_('scpw').value !== _('spw').value) {
				$('valid valid_6 tooltip', 0).style.color = "#ff0000";
				$('valid valid_6 tooltip', 0).innerHTML = "!<span class='tooltiptext'>"+signup_message['isCPassValid']+"</span>";
				sign_valid['password_b'] = false;
			}else {
				sign_valid['password_b'] = true;
				$('valid valid_6 tooltip', 0).style.color = "#00ff00";
				$('valid valid_6 tooltip', 0).innerHTML = '☑';
				_('nextbtn').style.display = 'block';
			}
			CallBackUp('upbtn');
		},  true);
	_('fn').addEventListener('blur', 
		function (){
			if (!this.value > 0) {
				$('valid valid_7 tooltip', 0).style.color = "#ff0000";
				$('valid valid_7 tooltip', 0).innerHTML = "!<span class='tooltiptext'>"+signup_message['isFNameEmpty']+"</span>";
				sign_valid['first_name'] = false;
			}else if (!names(this.value)) {
				$('valid valid_7 tooltip', 0).style.color = "#ff0000";
				$('valid valid_7 tooltip', 0).innerHTML = "!<span class='tooltiptext'>"+signup_message['isFNameValid']+"</span>";
				sign_valid['first_name'] = false;
			}else {
				sign_valid['first_name'] = true;
				$('valid valid_7 tooltip', 0).style.color = "#00ff00";
				$('valid valid_7 tooltip', 0).innerHTML = '☑';
			}
			CallBackUp('upbtn');
		},  true);	
	_('ln').addEventListener('blur', 
		function (){
			if (!this.value > 0) {
				$('valid valid_8 tooltip', 0).style.color = "#ff0000";
				$('valid valid_8 tooltip', 0).innerHTML = "!<span class='tooltiptext'>"+signup_message['isLNameEmpty']+"</span>";
				sign_valid['last_name'] = false;
			}else if (!names(this.value)) {
				$('valid valid_8 tooltip', 0).style.color = "#ff0000";
				$('valid valid_8 tooltip', 0).innerHTML = "!<span class='tooltiptext'>"+signup_message['isLNameValid']+"</span>";
				sign_valid['last_name'] = false;
			}else {
				sign_valid['last_name'] = true;
				$('valid valid_8 tooltip', 0).style.color = "#00ff00";
				$('valid valid_8 tooltip', 0).innerHTML = '☑';
			}
			CallBackUp('upbtn');
		},  true);	
	_('bd').addEventListener('blur', 
		function (){
			if (!this.value > 0) {
				$('valid valid_9 tooltip', 0).style.color = "#ff0000";
				$('valid valid_9 tooltip', 0).innerHTML = "!<span class='tooltiptext'>"+signup_message['isBdayEmpty']+"</span>";
				sign_valid['birthday'] = false;
			}else if (!dater(this.value)) {
				$('valid valid_9 tooltip', 0).style.color = "#ff0000";
				$('valid valid_9 tooltip', 0).innerHTML = "!<span class='tooltiptext'>"+signup_message['isBdayValid']+"</span>";
				sign_valid['birthday'] = false;
			}else {
				sign_valid['birthday'] = true;
				$('valid valid_9 tooltip', 0).style.color = "#00ff00";
				$('valid valid_9 tooltip', 0).innerHTML = '☑';
			}
			CallBackUp('upbtn');
		},  true);	
	_('ct').addEventListener('blur', 
		function (){
			if (!this.value > 0) {
				$('valid valid_10 tooltip', 0).style.color = "#ff0000";
				$('valid valid_10 tooltip', 0).innerHTML = "!<span class='tooltiptext'>"+signup_message['isCountrySelected']+"</span>";
				sign_valid['country'] = false;
			}else if (!names(this.value)) {
				$('valid valid_10 tooltip', 0).style.color = "#ff0000";
				$('valid valid_10 tooltip', 0).innerHTML = "!<span class='tooltiptext'>"+signup_message['isCountrySelected']+"</span>";
				sign_valid['country'] = false;
			}else {
				sign_valid['country'] = true;
				$('valid valid_10 tooltip', 0).style.color = "#00ff00";
				$('valid valid_10 tooltip', 0).innerHTML = '☑';
			}
			CallBackUp('upbtn');
		},  true);
	_('ct').addEventListener('keyup', 
		function (){
			if (!this.value > 0) {
				$('valid valid_10 tooltip', 0).style.color = "#ff0000";
				$('valid valid_10 tooltip', 0).innerHTML = "!<span class='tooltiptext'>"+signup_message['isCountrySelected']+"</span>";
				sign_valid['country'] = false;
			}else if (!names(this.value)) {
				$('valid valid_10 tooltip', 0).style.color = "#ff0000";
				$('valid valid_10 tooltip', 0).innerHTML = "!<span class='tooltiptext'>"+signup_message['isCountrySelected']+"</span>";
				sign_valid['country'] = false;
			}else {
				sign_valid['country'] = true;
				$('valid valid_10 tooltip', 0).style.color = "#00ff00";
				$('valid valid_10 tooltip', 0).innerHTML = '☑';
				CallBackUp('upbtn');
			}
		},  true);
