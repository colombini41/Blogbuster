$(function() {
    $("form[name='modifica_account']").validate({  
        rules: {
            vecchia: {
                minlength:6,
                maxlength: 30
            },
            nuova: {  
                minlength: 6, 
                maxlength: 30
            }, 
            conferma_nuova: {
                equalTo: "#nuova"
            },
            nuova_email: {
                email: true,
                maxlength: 50
            },  
            nuovo_telefono: {  
                digits: true,
                minlength: 10,
                maxlength: 10 
                },       
        }, 
              
        messages: {  
            vecchia: {
                minlength: "La tua vecchia password ha almeno 6 caratteri",
                maxlength: "La tua vecchia password ha al massimo 30 caratteri"
                },
            nuova: {
                minlength: "La tua nuova password deve avere almeno 6 caratteri",
                maxlength: "La tua nuova password deve avere al massimo 30 caratteri"
                },
            conferma_nuova: {  
                equalTo: "Le due password non coincidono"
                }, 
            nuova_email: {  
                email: "La tua nuova email non è valida",
                maxlength: "La tua nuova email è troppo lunga"
                },
            nuovo_telefono:{  
                digits: "Il numero di telefono non è valido, potresti aver inserito il prefisso",
                minlength: "Il numero è troppo corto",
                maxlength: "Il numero è troppo lungo" 
                },  
            },
            submitHandler: function(form) {
            HTMLFormElement.prototype.submit.call(form);
            }  
    }); 

});