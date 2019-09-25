function Att(){
	document.getElementById('container').innerHTML = null;

	var xhr = new XMLHttpRequest();	

	xhr.onreadystatechange = function()
	{
		if (xhr.readyState == 4 && xhr.status == 200)
		{
			document.getElementById('container').innerHTML= xhr.responseText;		
		}
	};
		
	/*Ouvrir la connexion*/
	xhr.open("GET", "en_attente.php", true);

	/*Envoyer*/
	xhr.send();
};

function Conf(){
	document.getElementById('container').innerHTML = null;

	var xhr = new XMLHttpRequest();	

	xhr.onreadystatechange = function()
	{
		if (xhr.readyState == 4 && xhr.status == 200)
		{
			document.getElementById('container').innerHTML= xhr.responseText;		
		}
	};
		
	/*Ouvrir la connexion*/
	xhr.open("GET", "confirme.php", true);

	/*Envoyer*/
	xhr.send();
};

function Annules(){
	document.getElementById('container').innerHTML = null;

	var xhr = new XMLHttpRequest();	

	xhr.onreadystatechange = function()
	{
		if (xhr.readyState == 4 && xhr.status == 200)
		{
			document.getElementById('container').innerHTML= xhr.responseText;		
		}
	};
		
	/*Ouvrir la connexion*/
	xhr.open("GET", "annules.php", true);

	/*Envoyer*/
	xhr.send();
};

function Term(){
	document.getElementById('container').innerHTML = null;

	var xhr = new XMLHttpRequest();	

	xhr.onreadystatechange = function()
	{
		if (xhr.readyState == 4 && xhr.status == 200)
		{
			document.getElementById('container').innerHTML= xhr.responseText;		
		}
	};
		
	/*Ouvrir la connexion*/
	xhr.open("GET", "terminees.php", true);

	/*Envoyer*/
	xhr.send();
};

function Ajd(){
	document.getElementById('container').innerHTML = null;

	var xhr = new XMLHttpRequest();	

	xhr.onreadystatechange = function()
	{
		if (xhr.readyState == 4 && xhr.status == 200)
		{
			document.getElementById('container').innerHTML= xhr.responseText;		
		}
	};
		
	/*Ouvrir la connexion*/
	xhr.open("GET", "ajd.php", true);

	/*Envoyer*/
	xhr.send();
};

function save(){

	var des = document.getElementById('story').value;
	var id = document.getElementById('id').value;

	var flag = false;

	if (des == "" || des == null){

		flag = true;

		document.getElementById('story').focus();
		document.getElementById('erreur').innerHTML = "Champ vide !";
	}

if (flag == false){
   // PHP PART : Envoie les donnes sur une page PHP.

    var donnee = "des=" + des + "&id=" + id;

    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function (){
        if (xhr.readyState == 4 && xhr.status == 200){
          if (xhr.responseText == "Success"){
          		Fonc();
          }
          else{
         	  document.getElementById('erreur').innerHTML = xhr.responseText;
      	  }
        }
    };
        xhr.open("POST", "savegarder_update.php", true);

        xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");

        xhr.send(donnee);
	}

};
