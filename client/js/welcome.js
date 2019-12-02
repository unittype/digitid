function _(e) {
	return document.getElementById(e);
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