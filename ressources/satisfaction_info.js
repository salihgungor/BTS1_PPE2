function date() {
	var date = new Date();
	var jour = date.getDate();
	var mois = date.getMonth() + 1;
	if (mois < 10) {
		mois = '0' + mois;
	}
	var annee = date.getFullYear();
	var pdatejour = jour + '/' + mois + '/' + annee;
	return pdatejour;
}


function donnees() {
	var createPDF = true;
	var service = document.getElementById('service').value;
	if (service == 'selectionner') {
		createPDF = false;
		alert('Selectionnez un service.');
	} else {
		var servadmin = document.querySelector('input[name="servadmin"]:checked').value;
		var unitsoin = document.querySelector('input[name="unitsoin"]:checked').value;
		var douleur = document.querySelector('input[name="douleur"]:checked').value;
		var soins = document.querySelector('input[name="soins"]:checked').value;
		var ecoute = document.querySelector('input[name="ecoute"]:checked').value;
		var soulagement = document.querySelector('input[name="soulagement"]:checked').value;
		var datact = date();
		if (createPDF == true) {
			pdfCreation(service, servadmin, unitsoin, douleur, soins, ecoute, soulagement, datact);
		}
	}
}


function pdfCreation(service, servadmin, unitsoin, douleur, soins, ecoute, soulagement, datact) {
	var pdf = {
		content: [
			{text: [
					{text: 'Hopital de Bien être\n\n', style: 'header', margin: [15, 15, 15, 15]},
					{text: 'Questionnaire de satisfaction\n\n', style: 'soustitre', margin: [15, 15, 15, 15]},
					{text: 'Voici vos reponse pour le service  :', style: 'autreStyle'}, {text: ' ' + service + "\n\n"},
					{text: 'Accueil du service administratif  :', style: 'soulignement'}, {text: ' ' + servadmin + "\n\n"},
					{text: 'Accueil dans l\'unite de soin  :', style: 'soulignement'}, {text: "  " + unitsoin + "\n\n"},
					{text: 'Prise en charge de la douleur  :', style: 'soulignement'}, {text: "  " + douleur + "\n\n"},
					{text: 'Soins(infirmiers-aides soignantes  :', style: 'soulignement'}, {text: "  " + soins + "\n\n"},
					{text: 'A-t-on été a votre écoute ?', style: 'soulignement'}, {text: ecoute + "\n\n"},
					{text: 'Le soulagement de la douleur a été ?', style: 'soulignement'}, {text: "  " + soulagement + "\n\n"},
					{text: datact, style: 'footer', margin: [40, 40, 40, 10]}

				]}
		],

		styles: {
			header: {
				fontSize: 20,
				bold: true,
				alignment: 'center',
				decoration: 'underline',

			},
			soustitre: {
				alignment: 'left',
				fontSize: 15,
				bol: true


			},
			soulignement: {
				decoration: 'underline'
			},
			autreStyle: {
				alignment: 'left',
				bold: true
			},
			footer: {
				bold: true,
				alignment: 'right'

			}
		}

	}
	pdfMake.createPdf(pdf).open();
}