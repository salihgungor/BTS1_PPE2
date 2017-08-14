function actualisationService() {
	var service = document.getElementById("listeServices").value;
	var url = document.location.href;
	if (url.indexOf("&service=") == -1) {
		document.location += "&service=" + service
	}
	else {
		alert('test');
	}
}

function actualisationMedecin() {
	var medecin = document.getElementById("listeMedecins").value;
	document.location += "&medecin=" + medecin;
}