function Validation(){

	var mail = document.getElementById("mail").value;7
	var mailErr = false;

	re();

	if (mail == "" || mail == null){
		document.getElementById("mail").style.borderBottom = "1px solid #ff0000";
		document.getElementById("erreur").innerHTML = "* Champ vide !";
		mailErr = true;
	}

if (mailErr != true){	

    // PHP PART : Envoie les donnes sur une page PHP.

    var donnee = "mail=" + mail ;

    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function (){
        if (xhr.readyState == 4 && xhr.status == 200){
            if (xhr.responseText == "Success"){
                window.location.replace("../conf.php");
            }
            else{
            	document.getElementById("erreur").innerHTML = xhr.responseText;
            }
        }
    };
        xhr.open("POST", "mot-de-passe-oublie.php", true);

        xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");

        xhr.send(donnee);
}

};

function re(){
		document.getElementById("mail").style.borderBottom = "1px solid #222";
		document.getElementById("erreur").innerHTML = null;
}