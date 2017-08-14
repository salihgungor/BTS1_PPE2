

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
	var datenaiss = document.getElementById("dateN").value;
	var adresse = document.getElementById("adresse").value;
	var codepostal = document.getElementById("codepostal").value;
	var ville = document.getElementById("ville").value;
	var docteur = document.getElementById("docteur").value;
	var service = document.getElementById("service").value;
	var daterdv = document.getElementById("daterdv").value;
	var dateAct = date();
	if(verif(nom,prenom,mail,datenaiss,adresse,codepostal,ville,docteur,service,daterdv) == false)
	{
		alert("Vous avez oublié de remplr un ou plusieurs champ.");
	}
	else
	{ 
		pdfCreation(nom,prenom,mail,datenaiss,adresse,codepostal,ville,docteur,service,daterdv,dateAct);
	}
}

function verif(nom,prenom,mail,datenaiss,adresse,codepostal,ville,docteur,service,daterdv){
	//verif non vide
	if(nom == '' || prenom == '' || mail == '' || datenaiss == '' || adresse == '' || codepostal == '' || ville == '' || daterdv == '' || docteur == "selectionner" || service == "selectionner")
	{
		return false;
	}
	else
	{
		return true;
	}

	//a faire verif entrée valide
;}

function pdfCreation(nom,prenom,mail,datenaiss,adresse,codepostal,ville,docteur,service,daterdv,dateAct){
	var pdf = {
		content: [
			{ text: 'Hopital du Bien Être', style: 'header' },
			{ text: 'Demande de Rendez-vous :', style: 'header' },
			'\n\ndemande effectuée le : ' + dateAct, { text: 'pour un rendez-vous en date de : ' + daterdv, style: 'aligndroit', margin: [0,-15,0,15] },
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