function Valider(){

	var flag = false;
	var mdp1 = document.getElementById("pswd").value;
	var mdp2 = document.getElementById("pswd2").value;
	var mail = document.getElementById("email").value;

	var n = mdp1.length;
	
	re();

	if (mdp1 == "" || mdp2 == ""){

		flag = true;

		if (mdp1 == "" || mdp1 == null){
			document.getElementById("pswd").style.borderBottom = "1px solid #ff0000";
		}

		if (mdp2 == "" || mdp2 == null){
			document.getElementById("pswd2").style.borderBottom = "1px solid #ff0000";
		}
	}

	if (n < 8){
		document.getElementById("pswd").style.borderBottom = "1px solid #ff0000";
		document.getElementById("erreur").innerHTML = "*Votre mot de passe doit contenir plus de 8 caracteres !";
		flag = true;
	}

	else if (mdp1 != mdp2){
		document.getElementById("pswd2").style.borderBottom = "1px solid #ff0000";
		document.getElementById("erreur").innerHTML = "*Les mots de passe doivent correspondre !";
		flag = true;
	}

if (flag == false){ 

    // PHP PART : Envoie les donnes sur une page PHP.

    var donnee = "mdp=" + mdp1 + "&mail=" + mail;

    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function (){
        if (xhr.readyState == 4 && xhr.status == 200){
            if (xhr.responseText == "Success"){
                window.location.replace("../sign_in.html");
            }
            else{
                 document.getElementById("erreur").innerHTML = xhr.responseText;
            }
        }
    };
        xhr.open("POST", "../forgot-password/new.php", true);

        xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");

        xhr.send(donnee);
}

};

function re(){
	document.getElementById("pswd").style.borderBottom = "1px solid #222";
	document.getElementById("pswd2").style.borderBottom = "1px solid #222";
	document.getElementById("erreur").innerHTML = null;
};