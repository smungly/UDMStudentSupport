function retour(){
	window.location.replace("main.php");
};

function valider(){

	var err = false;

	var id = document.getElementById('identifiant').value;
	var nom = document.getElementById('nom').value;
	var prenom = document.getElementById('prenom').value;
	var adresse = document.getElementById('adresse').value;
 	var email = document.getElementById('email').value;
	var tel = document.getElementById('tel').value;
	var uname = document.getElementById('uname').value;
	var sexe = document.getElementById('sexe').value;
	var ville = document.getElementById('ville').value;

	var reg = /^[0-9]*$/;

	re();

	if (nom == "" || prenom == "" || adresse == "" || email == "" || tel == ""){

		err = true;

		if (nom == "" || nom == null){
			document.getElementById('nom').focus();
			document.getElementById("nom").style.borderColor = "#ff0000";
		}

		else if (prenom == "" || prenom == null){
			document.getElementById('prenom').focus();
			document.getElementById("prenom").style.borderColor = "#ff0000";
		}

		else if (adresse == "" || adresse == null){
			document.getElementById('adresse').focus();
			document.getElementById("adresse").style.borderColor = "#ff0000";
		}

		else if (email == "" || email == null){
			document.getElementById('email').focus();
			document.getElementById("email").style.borderColor = "#ff0000";
		}

		else if (tel == "" || tel == null){
			document.getElementById('tel').focus();
			document.getElementById("tel").style.borderColor = "#ff0000";
		}
	}

if (err != true){	

    // PHP PART : Envoie les donnes sur une page PHP.

    var donnee = "id=" + id + "&nom=" + nom + "&prenom=" + prenom + "&adresse=" + adresse +"&email=" + email + "&tel=" + tel + "&sexe=" + sexe + "&ville=" + ville;

    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function (){
        if (xhr.readyState == 4 && xhr.status == 200){

        	if (xhr.responseText == "001"){
        		document.getElementById('nom').focus();
        		document.getElementById("errNom").innerHTML = "*Nom invalide";
        	}
        	else if(xhr.responseText == "002"){
        		document.getElementById('prenom').focus();
        		document.getElementById("errPre").innerHTML = "*Prenom invalide";
        	}
        	else if(xhr.responseText == "003"){
        		document.getElementById('adresse').focus();
        		document.getElementById("errAdd").innerHTML = "*Adresse invalide";
        	}
        	else if(xhr.responseText == "004"){
        		document.getElementById('email').focus();
        		document.getElementById("errMail").innerHTML = "*Email invalide";
        	}
        	else if(xhr.responseText == "005"){
        		document.getElementById('tel').focus();
        		document.getElementById("errTel").innerHTML = "*Numero de telephone invalide";
        	}
        	else{
        		$('html, body').animate({ scrollTop: 0 }, 'fast');
        		document.getElementById("valid").innerHTML = xhr.responseText;
        	}
        }
    };
        xhr.open("POST", "infos.php", true);

        xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");

        xhr.send(donnee);
}

};

function re(){
	document.getElementById("errNom").innerHTML = null;
	document.getElementById("errPre").innerHTML = null;
	document.getElementById("errTel").innerHTML = null;
	document.getElementById("errAdd").innerHTML = null;
	document.getElementById("errMail").innerHTML = null;
	document.getElementById("valid").innerHTML = null;
	document.getElementById("tel").style.borderColor = "#D1D7DC";
	document.getElementById("email").style.borderColor = "#D1D7DC";
	document.getElementById("adresse").style.borderColor = "#D1D7DC";
	document.getElementById("prenom").style.borderColor = "#D1D7DC";
	document.getElementById("nom").style.borderColor = "#D1D7DC";
};