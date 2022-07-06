function gestoreDescrizione(){
	try{
		var idBlog = this.id;
		var descrizione = document.getElementsByClassName("idBlog");
		descrizione.style.display="block";
	}
	catch(e){
		alert('gestoreDescrizione' + e);
	}
}


var nodiBlog;

function gestoreLoad(){

	try{
		nodiBlog=document.getElementsByClassName("img_dinamiche");
		for (var i = 0; i < nodiBlog.length; i++) {
			nodiBlog[i].onmouseover = gestoreDescrizione();
		}
	}
	catch(e){
		alert('gestoreLoad' + e);
	}
}

window.onload = gestoreLoad;