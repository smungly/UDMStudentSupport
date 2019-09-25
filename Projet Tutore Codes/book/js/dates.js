function dates(){

re();
var flag = false;

var date = document.getElementById('txtDate').value;
var hd = document.getElementById('hd').value;
var des = document.getElementById('desc').value;
var type = document.getElementById('type').value;
var id = document.getElementById('id').value;

var hf = '';

/*Validations*/

if (des == "" || date == ""){

	flag = true;

	if (date == "" || date == null){
		document.getElementById('txtDate').focus();
		document.getElementById('err').innerHTML = "*Veuillez choisir une date valide.";
	}

	if (des == "" || des == null ){
		document.getElementById('desc').focus();
		document.getElementById('err').innerHTML = "*Veuillez ajouter une description.";		
	}

}

if (hd == "09:00 AM"){
	var hf = "10:00 AM";
}
if (hd == "10:15 AM"){
	var hf = "11:15 AM";
}
if(hd == "01:30 PM"){
	var hf = "02:30 PM";
}
if (hd == "02:45 PM"){
	var hf = "03:45 PM";
}

if (flag == false){

	var donnee = "date=" + date + "&hd=" + hd + "&hf=" + hf+"&des=" + des + "&type=" + type + "&id=" + id;

	var xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function (){
        if (xhr.readyState == 4 && xhr.status == 200){
        	if (xhr.responseText == "Success"){
        		maFonc();
        	}
        	else{
        		document.getElementById('err').innerHTML = xhr.responseText;
        	}
        }
	};

  	xhr.open("POST", "date_dispo.php", true);

  	xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");

  	xhr.send(donnee);
}

};

function re(){
	document.getElementById('err').innerHTML = null;
};
