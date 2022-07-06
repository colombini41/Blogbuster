function gestoreDescrizione(){
	try{
		this.firstElementChild.style.display="block";
	}
	catch(e){
		alert('gestoreDescrizione' + e);
	}
}


var nodiBlog;

function gestoreLoad(){

	try{
		nodiBlog=document.getElementsByClassName("contenitore_blog");
		for (var i = 0; i < nodiBlog.length; i++) {
			nodiBlog[i].onmouseover = gestoreDescrizione();
		}
	}
	catch(e){
		alert('gestoreLoad' + e);
	}
}

window.onload = gestoreLoad;