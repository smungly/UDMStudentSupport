function Validation(){

err = false;

var uname = document.forms["login-form"]["u_name"].value;
var pswd = document.forms["login-form"]["pswd"].value;

var n = pswd.length; 

reinit();

if (uname == "" || pswd == ""){

  err = true;

  if (uname == "" || uname == null){
    document.getElementById("u_name").style.borderBottom = "1px solid #ff0000";
    document.getElementById("u_name").focus(); 
  }

  else if(pswd == "" || pswd == null){
     document.getElementById("pswd").style.borderBottom = "1px solid #ff0000";
     document.getElementById("pswd").focus(); 
  }
}
else if(n < 8){
	 document.getElementById("pswd").style.borderBottom = "1px solid #ff0000";
	 document.getElementById("pswd").focus(); 
	 err = true; 
}

if (err == false){
	var donnee = "uname=" + uname + "&pswd=" + pswd;

	var xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function(){
		if(xhr.readyState == 4 && xhr.status == 200){
			if (xhr.responseText == "Super User"){
				document.body.style.cursor = 'wait';
				window.location.replace("counsellor/mes-rdv.php");
			}
			else if(xhr.responseText == "Success"){
				document.body.style.cursor = 'wait';
				window.location.replace("main.php");
			}
			else{
				document.getElementById("erreur").innerHTML = xhr.responseText;
			}
		}
	};

	xhr.open("POST", "login.php", true);

 	xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");

    xhr.send(donnee);
}

};

function reinit(){
  document.getElementById("u_name").blur();
  document.getElementById("pswd").blur(); 
  document.getElementById("u_name").style.borderBottom = "1px solid #222";  
  document.getElementById("pswd").style.borderBottom = "1px solid #222";
  document.getElementById("erreur").innerHTML = null;
};