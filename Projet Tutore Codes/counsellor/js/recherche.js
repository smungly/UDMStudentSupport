function searchres(){

	re();

	var champ = document.getElementById('nom').value;

	// PHP PART : Envoie les donnes sur une page PHP.

    var donnee = "champ=" + champ ;

    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function (){
        if (xhr.readyState == 4 && xhr.status == 200){
            document.getElementById("results").innerHTML = xhr.responseText;
        }
    };
        xhr.open("POST", "recherche.php", true);

        xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");

        xhr.send(donnee);
};

function re(){
	document.getElementById("results").innerHTML = null;
}