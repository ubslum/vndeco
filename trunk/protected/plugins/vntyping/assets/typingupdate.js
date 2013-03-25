// Written by zelonght @ ytst360.com & cuasotinhoc.vn, webmastervietnam.com
function typingupdate2(){
var str0 = 'ON | OFF', str1 = 'VIQR'
if(on_off==0) {str0 ='OFF',str1='NONE'}
	else {str0 ='ON'
		if(method==0) str1 ='AUTO'
			else if(method==1) str1 ='TELEX'
			else if(method==2) str1 ='VNI'
			else if(method==3) str1 ='VIQR'
			else if(method==4) str1 ='VIQR*'}
document.getElementById('vn_on_off').innerHTML = str0  
document.getElementById('vn_mode').innerHTML = str1
// set cookies
if(on_off==0) setMethod(-1)
	else setMethod(method)
}