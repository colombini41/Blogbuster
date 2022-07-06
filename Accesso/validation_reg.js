//CONTROLLO NUMERO DOCUMENTO CON REGEX
$(function()  { 
    $.validator.addMethod('documento_regex',
        function(value, element) {
           return this.optional(element) || /^([a-zA-Z]{2})([0-9]{5})([a-zA-Z]{2})$/.test(value); 
       }, 'Il numero di documento non è valido - deve essere 2 lettere, 5 cifre e poi ancora 2 lettere');
//CONTROLLO CHE IL NOME UTENTE SIA DISPONIBILE
$("#nome_utente").keyup(function(){
    var nome_utente = $(this).val().trim();

    if(nome_utente != ''){

        $.ajax({
            url: 'checkuniq.php?stop=1',
            type: 'post',
            data: {
                nome_utente: nome_utente,

             },
            success: function(response){
                $('#uname_response').html(response);
                if ($(".span_controllo").get(0).id == "1") {
                    $('#submit').attr("disabled", true);
                } else {
                     $('#submit').attr("disabled",false);
                }
            }
    }); 
       
 } else {
         $("#uname_response").html("<span id= '2' class = 'span_controllo'>Il nome utente non sarà più modificabile</span>");
      }

    });

//VALIDAZIONE FORM CON PLUGIN JQUERY VALIDATE
    $("form[name='frm']").validate({  
        rules: {  
            nome: "required",  
            cognome: "required",
            documento: "required",
            numero_documento: {  
                required:true,
                minlength: 9,
                maxlength: 9,
                documento_regex: true
                }, 
            email: {  
                required:true,
                email: true
            },
            data_nascita: "required",  
            telefono: {  
                required:true,
                digits: true,
                minlength: 10,
                maxlength: 10  
                },  
            nome_utente: {
                required: true
            },
            password: {  
                required:true,
                minlength: 6  
                }, 
            repassword: {  
                equalTo: "#password"
                }      
        }, 
              
        messages: {  
            nome: "Il campo nome è vuoto",  
            cognome: "Il campo cognome è vuoto",
            documento: "Il campo documento è vuoto",
            numero_documento: {  
                required: "Il campo numero documento è vuoto",
                minlength: "Il numero di documento deve avere 9 caratteri",
                maxlength: "Il numero di documento deve avere 9 caratteri"
                }, 
            email: {  
                required: "Il campo email è vuoto",
                email: "L'email non è valida"
                },
            data_nascita: "Il campo data di nascita è vuoto",  
            telefono:{  
                required: "Il campo numero di telefono è vuoto",
                digits: "Il numero di telefono non è valido",
                minlength: "Il numero è troppo corto",
                maxlength: "Il numero è troppo lungo" 
                },  
            nome_utente: {
                required: "Il campo nome utente è vuoto", 
                remote: " è un nome utente già in uso" 
                },
            password:{  
                required: "Il campo password è vuoto",
                minlength: "La password deve avere almeno 6 caratteri"  
                }, 
            repassword:{  
                equalTo: "Le due password non coincidono"
                },
            },
            submitHandler: function(form) {
            HTMLFormElement.prototype.submit.call(form);
            }  

    }); 

});