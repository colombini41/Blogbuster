
function gestorecommenti(){
    var commento=this;
    alert("ciaoooo");
    commento.style.margin='20%';
}


var commento = new Array();


function gestore(){
    commento=document.getElementByClass('-1');
    for (var i = 0; i < commento.length; i++) {
       commento[i].onclick = gestorecommenti;
    }
}

window.onload= gestore;

