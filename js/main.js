function showResult(str) {

  if (str.length==0) { 
    document.getElementById("searchFieldHeader").style.width=96+"px";
	
    return;
  }else{
	document.getElementById("searchFieldHeader").style.width=99+"px";
  }

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();

  } else {  
  	// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }

  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		// Do something with it
    }
  }

  xmlhttp.open("POST","/wordpress/wp-admin/admin-ajax.php?action=search&q="+str,true); //Gets wp-admins ajax
  xmlhttp.send();
}

// Defines the width depending on the string length of search entry
window.onload = function() {
	var sfh = document.getElementById('searchFieldHeader');
	var mq480 = window.matchMedia( "(max-width: 480px)" );
	if (sfh){
		sfh.addEventListener("keyup", function(){
			if (sfh.length==0) { 
			    sfh.style.width = 90+"px";
			}else{
				if (sfh.value.length>5&&sfh.value.length<20){
					sfh.style.width = (10*sfh.value.length)+40+"px";
					if (mq480.matches){
						sfh.parentNode.style.width = (10*sfh.value.length)+120+"px";
					}
				}else if (sfh.value.length>=20){
					sfh.style.width = 240+"px"; // (10*20)+40 = 240
					if (mq480.matches){
						sfh.parentNode.style.width = 310+"px";
					}
				}else {
					sfh.style.width = 90+"px";
				}
			}
		});
	}
};
