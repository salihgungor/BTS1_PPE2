var idRdv;

function date(){
	var date = new Date();
	var jour = date.getDate();
	var mois = date.getMonth()+1;
	if(mois < 10){mois = '0'+mois;}
	var annee = date.getFullYear();
	var pdatejour = jour+'/'+mois+'/'+annee;
	return pdatejour;
}

try {
	xhrMed = new XMLHttpRequest();
	xhrRDV = new XMLHttpRequest();
	xhrPriseRDV = new XMLHttpRequest();
	xhrInfo = new XMLHttpRequest();
} catch (e) {
	xhrMed = new ActiveXOblect("Microsoft.XMLHTTP");
	xhrRDV = new ActiveXOblect("Microsoft.XMLHTTP");
	xhrPriseRDV = new ActiveXOblect("Microsoft.XMLHTTP");
	xhrInfo = new ActiveXOblect("Microsoft.XMLHTTP");
}

function renseignerMedecins() {
	var service = document.getElementById("listeServices").value;
	if (service != 0) {
		$('#medecins').html('')
		$('#rendezVous').html('');
		xhrMed.open('GET', 'ressources/fonctions.php?listeMedecinsService=' + service, true);
		xhrMed.send(null);
	} else {
		$('#medecins').html('')
		$('#rendezVous').html('');
	}
}

xhrMed.onreadystatechange = function () {
	if (xhrMed.readyState === 4) {
		var medecins = xhrMed.responseText;
		if ($('#listeMedecins').length == 0) {
			$('#medecins').append('<label for="listeMedecins">Selectionnez le medecin:</label><br /><select id="listeMedecins" name="listeMedecins" onchange="renseignerRdv()"><option value="0" name="selectMed">Selectionnez un medecin</option></select>');
		} else {
			$('#medecins').html('<label for="listeMedecins">Selectionnez le medecin:</label><br /><select id="listeMedecins" name="listeMedecins" onchange="renseignerRdv()"><option value="0" name="selectMed">Selectionnez un medecin</option></select>');
			if (!$('#listeRdv').length == 0) {
				$('#rendezVous').html('');
			}
		}
		$('#listeMedecins').append(medecins);
	}
}

function renseignerRdv() {
	var medecin = document.getElementById("listeMedecins").value;
	if (medecin !== '0') {
		$('#rendezVous').html('');
		xhrRDV.open('GET', 'ressources/fonctions.php?listeRdvLibreMedecin=' + medecin, true);
		xhrRDV.send(null);
	}
	else{
		$('#rendezVous').html('');
	}
}

xhrRDV.onreadystatechange = function () {
	if (xhrRDV.readyState === 4) {
		var rdv = xhrRDV.responseText;
		if ($('listeRdv').length == 0) {
			$('#rendezVous').append('<label for="listeRdv">Selectionnez un rendez-vous:</label><br /><table id="listeRdv"><tr><th>Date</th><th>heure</th><th>action</th></tr></table>');
		} else {
			$('#rendezVous').html('<label for="listeRdv">Selectionnez un rendez-vous:</label><br /><table id="listeRdv"><tr><th>Date</th><th>heure</th><th>action</th></tr></table>');

		}
	}
	$('#listeRdv').append(rdv);
}


function RDV(num) {
	idRdv=num;
	xhrPriseRDV.open('GET', 'ressources/fonctions.php?prendreRdv=' + num, true);
	xhrPriseRDV.send(null);
}

xhrPriseRDV.onreadystatechange = function(){
	if(xhrPriseRDV.readyState === 4){
		var priseRDV = xhrPriseRDV.responseText;
		if(priseRDV == "ok"){
			if(confirm('Voulez-vous un justificatif de votre rendez-vous au format pdf ?')){
				preparationJustificatif();
				//window.location.reload();
			}else{
				window.location.reload();
			}
		}
		else{
			alert("une erreur c'est produite lors de la prise de votre rendez-vous, veuillez reessayer ulterieurement.");
			window.location.reload();
		}
	}
}

function preparationJustificatif(){
	var num = idRdv;
	xhrInfo.open('GET', 'ressources/fonctions.php?infosJustificatif=' + num, true);
	xhrInfo.send(null);
}

xhrInfo.onreadystatechange = function(){
	if(xhrInfo.readyState === 4){
		var infos=xhrInfo.responseText;
		var tabInfos = infos.split(" ");
		var nom=tabInfos[0];
		var prenom=tabInfos[1];
		var adresse=tabInfos[2];
		var codepostal=tabInfos[3];
		var ville=tabInfos[4];
		var docteur=tabInfos[5];
		var service=tabInfos[6];
		var dateRdv=tabInfos[7];
		var heureRdv=tabInfos[8];
		var dateAct=date();
		pdfCreation(nom,prenom,adresse,codepostal,ville,docteur,service,dateRdv,dateAct,heureRdv);
	}
}

function pdfCreation(nom,prenom,adresse,codepostal,ville,docteur,service,dateRdv,dateAct,heureRdv){
	var pdf = {
		content: [
			{ text: 'Hopital du Bien Être', style: 'header' },
			{ text: 'Demande de Rendez-vous :', style: 'header' },
			'\n\ndemande effectuée le : ' + dateAct, { text: 'pour un rendez-vous en date de : ' + dateRdv, style: 'aligndroit', margin: [0,-15,0,15] },
			{text: 'à : ' + heureRdv, style: 'aligndroit'},
			{text: 'par : ' + nom + ' ' + prenom, style: 'souligne'},
			{text: adresse, style: 'souligne', margin: [25, 0, 0, 0]},
			{text: codepostal + ' ' + ville, style: 'souligne', margin: [25, 0, 0, 0]},
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