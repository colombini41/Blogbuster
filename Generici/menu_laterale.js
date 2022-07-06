function gestoreOverIcona(){

	try{
		var idImmagine=this.id;
		nodiImmagini[idImmagine].src= '../Generici/Immagini/' + idImmagine + '_o.png';
	}				
	catch(e){
			alert('gestoreOverIcona' + e);
	}
}

function gestoreOutIcona(){

	try{
		var idImmagine=this.id;
			nodiImmagini[idImmagine].src= '../Generici/Immagini/' + idImmagine + '.png';
	}				
	catch(e){
			alert('gestoreOutIcona' + e);
	}
}



var nodiImmagini;

function gestoreLoad(){

	try{
		nodiImmagini = document.getElementsByClassName('icone_menu');

		for (var i = 0; i < nodiImmagini.length; i++) {
			nodiImmagini[i].onmouseover = gestoreOverIcona;
			nodiImmagini[i].onmouseout = gestoreOutIcona;
		}
	}		
	catch(e){
		alert('gestoreLoad' + e);
	}
	
}

window.onload= gestoreLoad;