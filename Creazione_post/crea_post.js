function gestoreAnnulla() {
	try {
		window.location.href = '../Homepage/homepage.php';
	}
	catch(e) {
		alert('gestoreAnnulla' + e);
	}
}

var nodoAnnulla;

function gestoreLoad() {

	try {
		nodoAnnulla = document.getElementById("annulla");
		nodoAnnulla.onclick = gestoreAnnulla;
	}	
	catch(e) {
		alert('gestoreLoad' + e);
	}
	
}

window.onload= gestoreLoad;