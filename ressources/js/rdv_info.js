function date(){
	var date = new Date();
	var jour = date.getDate();
	var mois = date.getMonth()+1;
	if(mois < 10){mois = '0'+mois;}
	var annee = date.getFullYear();
	var pdatejour = jour+'/'+mois+'/'+annee;
	return pdatejour;
}


function donnees() {
	var nom = document.getElementById("nom").value;
	var prenom = document.getElementById("prenom").value;
	var mail = document.getElementById("mail").value;
	var tel = document.getElementById("tel").value;
	var datenaiss = document.getElementById("dateN").value;
	var adresse = document.getElementById("adresse").value;
	var codepostal = document.getElementById("codepostal").value;
	var ville = document.getElementById("ville").value;
	var docteur = document.getElementById("docteur").value;
	var service = document.getElementById("service").value;
	var daterdv = document.getElementById("daterdv").value;
	var heurerdv = document.getElementById("heurerdv").value;
	var dateAct = date();
	if(verif(nom,prenom,adresse,codepostal,ville,docteur,service,daterdv,dateAct,heurerdv,mail,tel,datenaiss))
	{ 
		pdfCreation(nom,prenom,adresse,codepostal,ville,docteur,service,daterdv,dateAct,heurerdv);
		document.getElementById("validInfo").submit();
	}
}

function verif(nom,prenom,adresse,codepostal,ville,docteur,service,daterdv,dateAct,heurerdv,mail,tel,datenaiss){
	var verifdate = /^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/;
	var verifcp = new RegExp("^[0-9]+$","g");
	if(nom == '' || prenom == '' || mail == '' || tel == '' || datenaiss == '' || adresse == '' || codepostal == '' || ville == '' || daterdv == '' || docteur == "selectionner" || service == "selectionner" || heurerdv == "selectionner")
	{
		alert("Vous avez oublié de replir un ou plusieurs champs")
		return false;
	}
	else if(tel.length != 10 || tel.substring(0,2) != "06")
	{
		alert("Veuillez entrer un numéro de téléphone valide.");
		return false;
	}
	else if(verifdate.test(datenaiss) == false)
	{
		alert("Veuillez entrer une date de naissance valide.");
		return false;
	}
	else if(codepostal.length != 5 || isNaN(codepostal) == true)
	{
		alert("Veuillez entrer un code postal valide.");
		return false;
	}
	else if(verifdate.test(daterdv) == false)
	{
		alert("Veuillez entrer une date de rendez-vous valide");
		return false;
	}
	else
	{
		return true;
	}
;}

function pdfCreation(nom,prenom,adresse,codepostal,ville,docteur,service,daterdv,dateAct,heurerdv){
	var pdf = {
		content: [
			{ text: 'Hopital du Bien Être', style: 'header' },
			{ text: 'Demande de Rendez-vous :', style: 'header' },
			'\n\ndemande effectuée le : ' + dateAct, { text: 'pour un rendez-vous en date de : ' + daterdv, style: 'aligndroit', margin: [0,-15,0,15] },
			{text: 'pour : ' + heurerdv, style : 'aligndroit'},
			{text: 'par : ' + nom + ' ' + prenom, style: 'souligne'},
			{text: adresse, style : 'souligne', margin : [25, 0, 0, 0]},
			{text: codepostal + ' ' + ville, style : 'souligne', margin: [25, 0, 0, 0]},
			{text: '\nAvec le docteur ' + docteur},
			{text: 'Service ' + service}
		],
		styles: {
			header: {
				fontSize: 20,	
				bold: true,
				alignment: 'center',
				decoration : 'underline'
			},
			aligndroit: {
				alignment: 'right'
			},
			souligne: {
				decoration: 'underline'
			}
		}
	}
	pdfMake.createPdf(pdf).open();
}