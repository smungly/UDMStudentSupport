function Validation(){

var err = false;
var mailErr = false;
var match = false;
var unametest = false;
var checktest = false;

var nom = document.getElementById("nom").value;
var prenom = document.getElementById("prenom").value;
var mail = document.getElementById("email").value;
var mdp = document.getElementById("mdp").value;
var remdp = document.getElementById("re_mdp").value;
var dept = document.getElementById("dept").value;
var bday = document.getElementById("bday").value;
var sexe = document.getElementById("sexe").value;
var nat = document.getElementById("nation").value;
var add = document.getElementById("adresse").value;
var uname = document.getElementById("uname").value;
var check = document.getElementById("agree-term");

// Pour calculer l'age
var anneeCourante = new Date().getFullYear();
var anneeDeNaissance = new Date(bday).getFullYear();

var age = anneeCourante - anneeDeNaissance;

var n = mdp.length;

var regex = /[a-z A-Z0-9\\_\\"]+$/;

reinit();

/* Validations : textbox vides, 
                 mot de passe moins 8 caracteres et 
                 mot de passes non correspondantes. */

if (nom == "" || prenom == "" || mail == "" || mdp == "" || remdp == "" || uname == "" || bday == "" || add == ""){

    err = true;

    if (nom == "" || nom == null){
        document.getElementById("nom").style.borderBottom = "1px solid #ff0000";      
    }

    if (prenom == "" || prenom == null){
        document.getElementById("prenom").style.borderBottom = "1px solid #ff0000";   
    }

    if (mail == "" || mail == null){
        document.getElementById("email").style.borderBottom = "1px solid #ff0000";     
    }

    if (mdp == "" || mdp == null ){
        document.getElementById("mdp").style.borderBottom = "1px solid #ff0000";    
    }

    if (remdp == "" || remdp == null){
        document.getElementById("re_mdp").style.borderBottom = "1px solid #ff0000";     
    }

    if (uname == "" || uname == null){
        document.getElementById("uname").style.borderBottom = "1px solid #ff0000";     
    }

    if (bday == "" || bday == null){
        document.getElementById("bday").style.borderBottom = "1px solid #ff0000";     
    }

    if (add == "" || add == null){
        document.getElementById("adresse").style.borderBottom = "1px solid #ff0000";     
    }
}

if (regex.test(uname) == false){
    document.getElementById("errUname").innerHTML = "*Nom utilisateur invalide";
    document.getElementById("uname").style.borderBottom = "1px solid #ff0000";
    document.getElementById("uname").focus();
    unametest = true;
}

if (n < 8){
    document.getElementById("errPswd").innerHTML = "*Il faut au moins 8 caractères";
    document.getElementById("mdp").style.borderBottom = "1px solid #ff0000";
    document.getElementById("mdp").focus();
    match = true;
}

if (age < 17){
    document.getElementById("errDate").innerHTML = "*Date de naissance invalide";
    document.getElementById("bday").style.borderBottom = "1px solid #ff0000";
    document.getElementById("bday").focus();
    match = true;
}

if (remdp != mdp){
    document.getElementById("errMatch").innerHTML = "*Les mots de passe doivent correspondre !";
    document.getElementById("re_mdp").style.borderBottom = "1px solid #ff0000";
    document.getElementById("re_mdp").focus(); 
    match = true;
}

if(!check.checked){
    document.getElementById("errCheck").innerHTML = "*Veuillez lire et accepter les conditions d'utilisation.";
    checktest = true;
}

if (err == false && mailErr == false && unametest == false && match == false &&  checktest == false){ 

    // PHP PART : Envoie les donnes sur une page PHP.

    var donnee = "nom=" + nom + "&prenom=" + prenom + "&mail=" + mail + 
    "&mdp=" + mdp + "&re_mdp=" + remdp + "&uname=" + uname + 
    "&dept=" + dept + "&sexe=" + sexe + "&bday=" + 
    bday + "&nat=" + nat + "&add=" + add;

    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function (){
        if (xhr.readyState == 4 && xhr.status == 200){
            if (xhr.responseText == "001"){
                // Erreur de nom
                document.getElementById("nom").focus();
                document.getElementById("errNom").innerHTML = "*Nom Invalide";
                document.getElementById("nom").style.borderBottom = "1px solid #ff0000";  
            }
            else if(xhr.responseText == "002"){
                // Erreur de prenom
                document.getElementById("prenom").focus();
                document.getElementById("errPre").innerHTML = "*Prénom Invalide";
                document.getElementById("prenom").style.borderBottom = "1px solid #ff0000";  
            }
            else if (xhr.responseText == "003"){
                // Erreur d'adresse
                document.getElementById("adresse").focus();
                document.getElementById("errAdd").innerHTML = "*Adresse Invalide";
                document.getElementById("adresse").style.borderBottom = "1px solid #ff0000";
            }
            else if (xhr.responseText == "004"){
                // Erreur de mail (Mail invalide)
                document.getElementById("email").focus();
                document.getElementById("errMail").innerHTML = "*Email Invalide";
                document.getElementById("email").style.borderBottom = "1px solid #ff0000";  
            }
            else if (xhr.responseText == "007"){
                 // Erreur de Uname (Uname invalide)
                 document.getElementById("uname").focus();
                 document.getElementById("errUname").innerHTML = "*Ce nom d'utilisateur n'est pas disponible";
                 document.getElementById("uname").style.borderBottom = "1px solid #ff0000";
            }
            else if (xhr.responseText == "008"){
                 // MDP 
                document.getElementById("mdp").focus();
                document.getElementById("errPswd").innerHTML = "*Votre mot de passe doit inclure au moins un chiffre, une lettre et ne doit pas commencer et terminer par un espace";
                document.getElementById("mdp").style.borderBottom = "1px solid #ff0000";
            }
            else if (xhr.responseText == "010"){
                 // Erreur de mail (Mail deja inscrit)
                 document.getElementById("email").focus();
                 document.getElementById("errMail").innerHTML = "*Cette adresse mail est déja dans notre base de donnees. Veuillez vous connecter ou ré-initialiser votre mot de passe";
                 document.getElementById("email").style.borderBottom = "1px solid #ff0000";
            }
            else if (xhr.responseText == "Success"){
                document.body.style.cursor = 'wait';
                window.location.replace("success.php");
            }
            else{
                document.getElementById("errMatch").innerHTML = xhr.responseText;
            }
        }
    };
        xhr.open("POST", "inscription.php", true);

        xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");

        xhr.send(donnee);
}

};

function reinit(){
    document.getElementById("nom").style.borderBottom = "1px solid #222";  
    document.getElementById("prenom").style.borderBottom = "1px solid #222";
    document.getElementById("email").style.borderBottom = "1px solid #222"; 
    document.getElementById("mdp").style.borderBottom = "1px solid #222";
    document.getElementById("re_mdp").style.borderBottom = "1px solid #222";
    document.getElementById("uname").style.borderBottom = "1px solid #222";
    document.getElementById("bday").style.borderBottom = "1px solid #222"; 
    document.getElementById("errCheck").innerHTML = null;
    document.getElementById("errPswd").innerHTML = null;
    document.getElementById("errMatch").innerHTML = null;
    document.getElementById("errUname").innerHTML = null;
    document.getElementById("errDate").innerHTML = null;
    document.getElementById("errAdd").innerHTML = null;
    document.getElementById("errNom").innerHTML = null;
    document.getElementById("errPre").innerHTML = null;
    document.getElementById("errMail").innerHTML = null;
};

