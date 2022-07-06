function gestoreAvanti() {
    try {
    	nodoCampiSx2.style.display = "block";
   		nodoCampiDx2.style.display = "block";
   		nodotestocolore.style.display="block";
    	nodoCampiSx1.style.display = "none";
    	nodoCampiDx1.style.display = "none";
   		nodoBottoniAvanti.style.display = "none";
    	nodoBottoniInvio.style.display = "block";
    	nodoAll1.style.display="block";
    	nodoTextarea.style.display="block";
    }
    catch (e){
    	alert('gestoreAvanti' + e);
    }
}

function gestoreIndietro() {
	 try {
	 	nodoCampiSx2.style.display = "none";
	    nodoCampiDx2.style.display = "none";
	    nodotestocolore.style.display="none";
	    nodoCampiSx1.style.display = "block";
	    nodoCampiDx1.style.display = "block";
	    nodoBottoniAvanti.style.display = "block";
	    nodoBottoniInvio.style.display = "none";
	    nodoAll1.style.display="none";
	    nodoTextarea.style.display="none";
	}
	catch (e) {
		alert('gestoreIndietro' + e);
	}
}

var nodoCampiSx1;
var nodoCampiSx2;
var nodoCampiDx1;
var nodoCampiDx2;
var nodoAvanti;
var nodoIndietro; 
var nodoCrea;
var nodoBottoniAvanti;
var nodoBottoniInvio;
var nodoForm;
var nodoAll1;
var nodoTextarea;
var nodotestocolore;

function gestoreLoad() {

	try {
		nodoAvanti = document.getElementById("avanti");
		nodoAvanti.onclick = gestoreAvanti;
		nodoIndietro= document.getElementById("indietro");
		nodoIndietro.onclick= gestoreIndietro;
		nodoCrea = document.getElementById("crea");
		nodoCampiSx1 = document.getElementById("campi_sx1");
		nodoCampiSx2 = document.getElementById("campi_sx2");
		nodoCampiDx1 = document.getElementById("campi_dx1");
		nodoCampiDx2 = document.getElementById("campi_dx2");
		nodotestocolore =document.getElementById("p_fs");
		nodoBottoniAvanti = document.getElementById("bottoni_avanti");
		nodoBottoniInvio = document.getElementById("bottoni_invio");
		nodoForm = document.getElementById("crea_blog");
		nodoAll1 = document.getElementById("all");
		nodoTextarea = document.getElementById("changeMe");
	}	
	catch(e) {
		alert('gestoreLoad' + e);
	}
	
}

window.onload= gestoreLoad;