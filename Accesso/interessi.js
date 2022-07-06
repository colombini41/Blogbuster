function gestoreArgomenti(){
/* Funzione che parte ogni volta che si clicca su uno dei cerchi Argomento. Alla pressione, controlla se quell'Argomento è già stato selezionato o meno 
e agisce di conseguenza. Se sono stati selezionati già tre Argomenti il sito ci avvisa che non possiamo sceglierne altri. */
	try{
		var idArgomento=this.id;
		contaClickArg[idArgomento]++;
			
		if (contaClickArg[idArgomento]% 2 == 0 ) {
			nodiArgomenti[idArgomento].style.border='4px solid black';
			nodiArgomenti[idArgomento].style.opacity='1';
			count--;
		} else if(contaClickArg[idArgomento]% 2 == 1  && count < 3){
			nodiArgomenti[idArgomento].style.border='4px solid red';
			nodiArgomenti[idArgomento].style.opacity='0.5';
			nodiArgomenti[idArgomento].src= 'Immagini/Argomenti/' + idArgomento + '1.jpg';
			count++;
		} else{
			alert("Hai selezionato gia' tre argomenti, deselezionane uno");
			contaClickArg[idArgomento]--;
		}
	} catch(e){
		alert('gestoreArgomenti' + e);
	}
}


function gestoreAvanti(){
/* Funzione che parte alla pressione del bottone avanti e controlla innanzitutto se sono stati scelti 3 e proprio 3 argomenti. 
A seconda di quali argomenti sono stati scelti presenta i rispettivi sottoargomenti sfruttando il controllo sulla variabile contaClickArg[Argomento]. */
	try{
  		var arg;
  		var j = 0;

		if (count == 3){
			while ( j < 3 ) {
				for (var i = 0; i < nodiArgomenti.length; i++) {
					if (nodiArgomenti[i].style.border=='4px solid red'){
						y[j]= nodiArgomenti[i].id;
						
						j++;
					}	
				}				
			}
			
			nodoAvanti.style.display='none';
			document.getElementById('second_button').style.display='block';
			for (var i = 0; i < nodiArgomenti.length; i++) {
				nodiArgomenti[i].style.display= "none";
			}
			
			if (contaClickArg['sport']% 2 == 1) {
				document.getElementById('fieldset_sport').style.display = 'block';
				document.getElementById('1').style.display= 'block';
				document.getElementById('2').style.display= 'block';
				document.getElementById('3').style.display= 'block';
			}

			if (contaClickArg['elettronica']% 2 == 1) {
				document.getElementById('fieldset_elettronica').style.display = 'block';
				document.getElementById('4').style.display= 'block';
				document.getElementById('5').style.display= 'block';
				document.getElementById('6').style.display= 'block';
			}

			if (contaClickArg['intrattenimento']% 2 == 1) {
				document.getElementById('fieldset_intrattenimento').style.display = 'block';
				document.getElementById('7').style.display= 'block';
				document.getElementById('8').style.display= 'block';
				document.getElementById('9').style.display= 'block';
			}
			if (contaClickArg['informazione']% 2 == 1) {
				document.getElementById('fieldset_informazione').style.display = 'block';
				document.getElementById('10').style.display= 'block';
				document.getElementById('11').style.display= 'block';
				document.getElementById('12').style.display= 'block';
			}

			if (contaClickArg['stile']% 2 == 1) {
				document.getElementById('fieldset_stile').style.display = 'block';
				document.getElementById('13').style.display= 'block';
				document.getElementById('14').style.display= 'block';
				document.getElementById('15').style.display= 'block';
			}

			if (contaClickArg['alimentazione']% 2 == 1) {
				document.getElementById('fieldset_alimentazione').style.display = 'block';
				document.getElementById('16').style.display= 'block';
				document.getElementById('17').style.display= 'block';
				document.getElementById('18').style.display= 'block';
			}

			if (contaClickArg['mondo']% 2 == 1) {
				document.getElementById('fieldset_mondo').style.display = 'block';
				document.getElementById('19').style.display= 'block';
				document.getElementById('20').style.display= 'block';
				document.getElementById('21').style.display= 'block';
			}

			if (contaClickArg['scrittura']% 2 == 1) {
				document.getElementById('fieldset_scrittura').style.display = 'block';
				document.getElementById('22').style.display= 'block';
				document.getElementById('23').style.display= 'block';
				document.getElementById('24').style.display= 'block';
			}

			if (contaClickArg['salute']% 2 == 1) {
				document.getElementById('fieldset_salute').style.display = 'block';
				document.getElementById('25').style.display= 'block';
				document.getElementById('26').style.display= 'block';
				document.getElementById('27').style.display= 'block';
			}
		} else {
			alert ('Hai selezionato meno di tre argomenti');
		}	
	} catch(e){
		alert('gestoreArgomenti ' + e );
	}
}


function gestoreSottoArgomenti(){
/* Analogamente a "gestoreArgomenti", parte ogni volta che si clicca su uno dei cerchi Sottorgomento. Alla pressione, controlla se quel Sottoargomento 
è già stato selezionato o meno e agisce di conseguenza. Se sono stati selezionati già tre Sottoargomenti il sito ci avvisa che non possiamo sceglierne altri. */
	try{
		
		var idSottoArgomento=this.id;
		contaClickSottoArg[idSottoArgomento]++;

		if (contaClickSottoArg[idSottoArgomento]% 2 == 0 ) {
			nodiSottoArgomenti[(idSottoArgomento)-1].style.border='4px solid black';
			nodiSottoArgomenti[(idSottoArgomento)-1].style.opacity='1';
			countsott--;
	
		}
		else if(contaClickSottoArg[idSottoArgomento]% 2 == 1  && countsott < 3){

			nodiSottoArgomenti[(idSottoArgomento)-1].style.border='4px solid red';
			nodiSottoArgomenti[(idSottoArgomento)-1].style.opacity='0.5';
			nodiSottoArgomenti[(idSottoArgomento)-1].src= 'Immagini/Sottoargomenti/' + idSottoArgomento + '_1.jpg';
			countsott++;
		}
		
		else{
			alert("Hai selezionato gia' tre sottoargomenti, deselezionane uno");
			contaClickSottoArg[idSottoArgomento]--;
		}
	}	
									
	catch(e){
			alert('gestoreArgomenti' + e);
	}
}

/* Passando con il mouse sopra ai cerchi Argomento viene visualizzato il nome di quell'argomento, scambiando rapidamente l'immagine visualizzata.
Ciò avviene con le seguenti due funzioni. */

function gestoreOverArg(){
	try{
		var idArgomento=this.id;
		nodiArgomenti[idArgomento].src= 'Immagini/Argomenti/' + idArgomento + '1.jpg';
	}				
	catch(e){
			alert('gestoreOverArg' + e);
	}
}

function gestoreOutArg(){

	try{
		var idArgomento=this.id;
		if (contaClickArg[idArgomento]% 2 == 0) {
			nodiArgomenti[idArgomento].src= 'Immagini/Argomenti/' + idArgomento + '.jpg';
		}
		else {
			nodiArgomenti[idArgomento].src= 'Immagini/Argomenti/' + idArgomento + '1.jpg';
		}
	}				
	catch(e){
			alert('gestoreOutArg' + e);
	}
}

/* Analogamente a quando succede per gli Argomenti, passando con il mouse sopra ai cerchi Sottorgomento viene visualizzato il nome di quell'argomento, 
scambiando rapidamente l'immagine visualizzata. Ciò avviene con le seguenti due funzioni. */

function gestoreOverSottoArg(){

	try{
		var idSottoArgomento=this.id;
		nodiSottoArgomenti[(idSottoArgomento)-1].src= 'Immagini/Sottoargomenti/' + idSottoArgomento + '_1.jpg';
	}				
	catch(e){
			alert('gestoreOverSottoArg' + e);
	}
}

function gestoreOutSottoArg(){

	try{
		var idSottoArgomento=this.id;
		if (contaClickSottoArg[idSottoArgomento]% 2 == 0) {
			nodiSottoArgomenti[(idSottoArgomento)-1].src= 'Immagini/Sottoargomenti/' + idSottoArgomento + '.jpg';
		}
		else {
			nodiSottoArgomenti[(idSottoArgomento)-1].src= 'Immagini/Sottoargomenti/' + idSottoArgomento + '_1.jpg';
		}

	}				
	catch(e){
			alert('gestoreOutSottoArg' + e);
	}
}

function gestoreIndietro(){
/* Cliccando sul bottone Indietro torno alla visualizzazione degli Argomenti, qualora volessimo cambiare idea su uno o più degli Argomenti scelti.
Contestualmente, azzero tutti i contaClickSottoArg dei vari Sottoargomenti, in modo da rendere nulla qualsiasi scelta del Sottoargomento fatta fino a quel 
punto, ma mantengo la precedente scelta degli Argomenti. */
	try{
		nodoAvanti.style.display='inline-block';
		for (var i = 0; i < nodiArgomenti.length; i++) {
			document.getElementsByTagName("fieldset")[i].style.display='none';
		}
		
		document.getElementById('second_button').style.display='none';
		for (var i = 0; i < nodiArgomenti.length; i++) {
			nodiArgomenti[i].style.display='inline-block';
		}
		for (var i = 1; i < nodiSottoArgomenti.length; i++) {
			nodiSottoArgomenti[i-1].style.display='none';
			contaClickSottoArg[i-1]=0;
			nodiSottoArgomenti[i-1].style.border='4px solid black';
			nodiSottoArgomenti[i-1].style.opacity='1';
			nodiSottoArgomenti[i-1].src= 'Immagini/Sottoargomenti/' + i + '.jpg';
			countsott=0;
		}
	}
	catch(e){
			alert('gestoreIndietro' + e);
	}
}

function gestoreConferma(){
/* Cliccando sul bottone Conferma, invio gli Argomenti e i Sottoargomenti scelti a interessi.php, che li salverà nel nostro Database (nel caso dell'utente 
registrato) o li salverà in Sessione (nel caso della visita come Ospite). Inoltre viene creato un Popup che reindirizza all'homepage. */
	try{
		var j=0;
		if (countsott == 3) {
			while ( j < 3 ) {
				for (var i = 0; i < nodiSottoArgomenti.length; i++) {
					if (nodiSottoArgomenti[i].style.border=='4px solid red'){
						x[j]= nodiSottoArgomenti[i].id;
						j++;
					}	
				}			
			}
			var z = y.concat(x);
			var sendData = function() {
				$.post('interessi.php?stop=1', {
					data: z
				}, function(response) {
					console.log(response);
				});
			}
			sendData();
			document.getElementById('body_interessi').innerHTML = "<div id='popup1' class='overlay'> <div class='popup'> <h2> BENVENUTO IN BLOGBUSTER! </h2> <a class='close' href='../Homepage/homepage.php?stop=1'>&times;</a> <div class='contentP'> Verrai subito reindirizzato alla tua homepage personalizzata </div> </div> </div>";
		} else {
			alert('Hai selezionato meno di tre argomenti');
		}
	}
	catch(e){
			alert('gestoreConferma' + e);
	}
}

var nodoAvanti;
var nodoIndietro;
var nodoConferma;
var nodiSottoArgomenti;
var nodiArgomenti;
var count= 0;
var countsott= 0;
var y= new Array();
var x= new Array();
var contaClickArg={
	sport:0, 
	alimentazione: 0,
	informazione: 0,
	mondo: 0,
	elettronica: 0,
	salute: 0,
	intrattenimento: 0,
	stile: 0,
	scrittura: 0
};

var contaClickSottoArg={
	"1": 0, 
	"2": 0,
	"3": 0,

	"4": 0,
	"5": 0,
	"6": 0,

	"7": 0,
	"8": 0,
	"9": 0,

	"10": 0, 
	"11": 0,
	"12": 0,

	"13": 0,
	"14": 0,
	"15": 0,

	"16": 0,
	"17": 0,
	"18": 0,

	"19": 0,
	"20": 0,
	"21": 0,

	"22": 0, 
	"23": 0,
	"24": 0,

	"25": 0,
	"26": 0,
	"27": 0,
};


function gestoreLoad(){

	try{
		nodoAvanti = document.getElementById('avanti');
		nodoAvanti.onclick = gestoreAvanti;
		nodoIndietro= document.getElementById('indietro');
		nodoIndietro.onclick= gestoreIndietro;
		nodoConferma = document.getElementById('conferma');
		nodoConferma.onclick = gestoreConferma;
		nodiArgomenti = document.getElementsByClassName('argomento');
		nodiSottoArgomenti  = document.getElementsByClassName('sottoArgomento');
		for (var i = 0; i < nodiArgomenti.length; i++) {
		 	nodiArgomenti[i].onclick=gestoreArgomenti;
		 	nodiArgomenti[i].onmouseover= gestoreOverArg;
		 	nodiArgomenti[i].onmouseout= gestoreOutArg;
		}
	 	for (var j = 0; j < nodiSottoArgomenti.length; j++) {
	 		nodiSottoArgomenti[j].onclick=gestoreSottoArgomenti;
	 		nodiSottoArgomenti[j].onmouseover= gestoreOverSottoArg;
		 	nodiSottoArgomenti[j].onmouseout= gestoreOutSottoArg;
		} 
		
	}		
	catch(e){
		alert('gestoreLoad' + e);
	}
	
}

window.onload= gestoreLoad;