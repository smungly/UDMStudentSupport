function retour(){
	window.location.replace("main.php");
};

function new_uname(){

	var flag = false;

	var newuname = document.getElementById('uname2').value;
	var uname = document.getElementById('uname1').value;
	var id = document.getElementById('identifiant').value;

	var regex = /[a-z A-Z0-9\\_\\"]+$/;

	re1();

	if (newuname == "" || newuname == null){
		flag = true;
		document.getElementById('uname2').focus();
		document.getElementById('uname2').style.borderColor = "#ff0000";
	}

	if (regex.test(newuname) == false){
   		 document.getElementById("erreur2").innerHTML = "*Nom utilisateur invalide";
    	 document.getElementById("uname2").style.borderColor = "#ff0000";
    	 document.getElementById("uname2").focus();
    	 flag = true;
	}

	if (uname == newuname){
   		 document.getElementById("erreur2").innerHTML = "*Le nom d'utilisateur est le même !";
    	 document.getElementById("uname2").style.borderColor = "#ff0000";
    	 document.getElementById("uname2").focus();
    	 flag = true;
	}

if (flag == false){

	var donnee = "uname=" + newuname + "&old=" + uname + "&identifiant=" + id;

    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function (){
        if (xhr.readyState == 4 && xhr.status == 200){
        	if (xhr.responseText == "Success"){
        		location.reload(); 
        	}
        	else{
        		document.getElementById("erreur2").innerHTML = xhr.responseText;
            }
        }
    };
        xhr.open("POST", "uname-change.php", true);

        xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");

        xhr.send(donnee);
}

};

function new_password(){

	// Validations nouveau password

	var errFlag = false;
	
	var id = document.getElementById('identifiant').value;
	var old_pass = document.getElementById('pswd').value;
	var mdp1 = document.getElementById('mdp1').value;
	var mdp2 = document.getElementById('mdp2').value;

	var n = mdp1.length;
	var m = mdp2.length;


	if (old_pass == "" || mdp1 == "" || mdp2 == ""){

		errFlag = true;

		if(old_pass == "" || old_pass == null){
			document.getElementById('pswd').focus();
			document.getElementById("pswd").style.borderColor = "#ff0000";
		}
		else if(mdp1 == "" || mdp1 == null){
			document.getElementById('mdp1').focus();
			document.getElementById("mdp1").style.borderColor = "#ff0000";
		}
		else if(mdp2 == "" || mdp2 == null){
			document.getElementById('mdp2').focus();
			document.getElementById("mdp2").style.borderColor = "#ff0000";
		}
	}

	else if (n < 8){
			errFlag = true;
			document.getElementById('mdp1').focus();
			document.getElementById("mdp1").style.borderColor = "#ff0000";
			document.getElementById("erreur2").innerHTML = "*Votre nouveau mot de passe doit faire au moins 8 caractères";
	}
	if (mdp2 != mdp1){
		errFlag = true;
		document.getElementById('mdp2').focus();
		document.getElementById("mdp2").style.borderColor = "#ff0000";
		document.getElementById("erreur2").innerHTML = "*Les mot de passe doivent correspondre.";
	}

if (errFlag == false){

	var donnee = "old=" + old_pass + "&mdp1=" + mdp1 + "&identifiant=" + id;

    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function (){

    if (xhr.readyState == 4 && xhr.status == 200){
        	if (xhr.responseText == "Success"){
        		document.getElementById("valid").innerHTML = "*Mot de Passe modifié";
        		location.reload(); 
        	}
        	else{
        		document.getElementById("erreur2").innerHTML = xhr.responseText;
            }
        }
    };
        xhr.open("POST", "mdp-change.php", true);

        xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");

        xhr.send(donnee);
}
};

function re1(){
	document.getElementById("erreur2").innerHTML = null;
	document.getElementById("valid2").innerHTML = null;
	document.getElementById("uname2").style.borderColor = "#D1D7DC";
};

function re2(){
	document.getElementById("erreur1").innerHTML = null;
	document.getElementById("erreur3").innerHTML = null;
	document.getElementById("pswd").style.borderColor = "#D1D7DC";
	document.getElementById("mdp1").style.borderColor = "#D1D7DC";
	document.getElementById("mdp2").style.borderColor = "#D1D7DC";
}