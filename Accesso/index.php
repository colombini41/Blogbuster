<?php
include "../Accesso/connect.php";
session_start();

?> 
<!DOCTYPE html>
<html lang="it">
    <head> 
        <meta charset= "UTF-8">
        <link rel="stylesheet" type="text/css" href="stile.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
        <script type="text/javascript" src="validation_reg.js"></script>
        <title> Blogbuster </title>
    </head>
    <body> 
        <?php 
        //Se lo user non è loggato e non è nemmeno un ospite redirect al login, altrimenti redirect alla homepage
        if ( !isset($_SESSION['user'])) {
        ?>
        <div class="container">
            <img src="Immagini/loghetto.png" id="logo" alt="logo">
            <div class="quadrato" id="quadrato">
                <div id="scelta_accesso">
                    <button class="login" id="scelta_accesso_login" > Accedi </button> <!-- modificare visibilita div accesso -->
                    <button class="login" id="scelta_accesso_registrazione"> Registrati</button> <!-- modificare visibilita div registrazione -->
                    <button class="login" id="scelta_accesso_guess" onclick="window.location.href='interessi.html'"> Entra come ospite </button>

                </div>
                
                 <!--SCELTA CON 3 BUTTON (JQUERY CSS - COMPARSA)-->
                <script> 
                    $(function(){
                        $("#scelta_accesso_login").click(function(){
                            $("#scelta_accesso").hide();
                            $("#accesso").show();
                            $("#quadrato").removeClass("quadrato").addClass("rettangolo");
                        });

                        $("#scelta_accesso_registrazione").click(function(){
                            $("#scelta_accesso").hide();
                            $("#registrazione").show();
                            $("#submit").show();
                            $("#reset").show();
                        });

                         $("#nome_utente_annulla").click(function(){
                            $("#quadrato").removeClass("rettangolo").addClass("quadrato");
                            $(location).attr('href', 'index.php');
                        });
                    });

                </script>
                <!--LOGIN-->

                <div id="accesso">
                    <form method="post" id="login" name="login">
                        
                        <label>Nome utente:</label><br/>
                        <input type = "text" id = "nome_utente_accesso" name = "nome_utente_accesso" class="nome_utente_accesso" maxlength="30" /><br/><br/>
                        <label>Password:</label><br/>
                        <input type = "password" id = "password_accesso" name = "password_accesso"class="nome_utente_accesso" maxlength="20" /><br/><br/>
                        <input type="reset" name="annulla" value="Annulla" id="nome_utente_annulla"/>
                        <input type="submit" name="login" value="Login" id="nome_utente_invio" />                        

                    </form>

                    
                </div>

                <?php

                    if(isset($_POST['login'])){

                        if (empty($_POST['nome_utente_accesso']) && (empty($_POST['password'])) ) {
                            //mancano dati per l'accesso
                            ?>
                                <div id="popup1" class="overlay">
                                    <div class="popup">
                                        <h2> INSERISCI TUTTI I DATI RICHIESTI </h2>
                                        <a class="close" href="../Accesso/index.php">&times;</a>
                                        <div class="contentP">
                                            Nome utente o password mancanti
                                        </div>
                                    </div>
                                </div>
                            <?php
                        } else if ($stmt = $mysqli->prepare('SELECT NomeUtente, Password FROM utente WHERE NomeUtente = ?')) {
                            $stmt->bind_param('s', $_POST['nome_utente_accesso']);
                            $stmt->execute();
                            // Store the result so we can check if the account exists in the database.
                            $stmt->store_result();

                            if ($stmt->num_rows > 0) {
                                $stmt->bind_result($user, $pwd);
                                $stmt->fetch();
                                $stmt->close();
                                // Account exists, now we verify the password.
                                if (password_verify($_POST['password_accesso'], $pwd)) {
                                    $_SESSION['user'] = $_POST['nome_utente_accesso'];
                                    printf($_SESSION);
                                    header('Location: ../Homepage/homepage.php?stop=1');
                                } else {
                                    // Incorrect password
                                    ?>
                                    <div id="popup1" class="overlay">
                                        <div class="popup">
                                            <h2> LA TUA PASSWORD E' SBAGLIATA </h2>
                                            <a class="close" href="../Accesso/index.php">&times;</a>
                                            <div class="contentP">
                                                Riprova ad accedere!
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                // Incorrect username
                                ?>
                                <div id="popup1" class="overlay">
                                    <div class="popup">
                                        <h2> USERNAME NON ESISTENTE </h2>
                                        <a class="close" href="../Accesso/index.php">&times;</a>
                                        <div class="contentP">
                                            Riprova ad accedere o crea un nuovo account!
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    }
                ?>

                <!--FORM REGISTRAZIONE-->
                <div id="registrazione">   
                    
                    <form method="post" action= "registrazione.php?stop=1" name= "frm" id="frm">
                        
                        <div id="campi_sx"> 

                            <div class="dati" >
                                <div class="dati_label">
                                    <label for="nome">Nome:</label><br/>
                                    <input type= "text" class="dati_input" id= "nome" name= "nome" data-error="error1" maxlength="30" required placeholder="Max. 30 caratteri">
                                </div>
                                <div class='erroreTesto'> 
                                    <span id="error1"> </span>
                                </div> 
                            </div>

                            <div class="dati" >
                                <div class="dati_label">
                                    <label for="cognome">Cognome:</label><br/>
                                    <input type= "text" class="dati_input" id= "cognome" name= "cognome" data-error="error2" maxlength="30" required placeholder="Max. 30 caratteri">
                                </div>
                                <div class='erroreTesto'> 
                                    <span id="error2"> </span>
                                </div>
                            </div>

                            <div class="dati" >
                                <div class="dati_label" id="dati_label_documento">
                                    <label>Tipo di documento:</label>
                                    <select class="documento" id= "documento" name= "documento" data-error="error3" required>
                                        <option value= ""> ------- </option>
                                        <option value= "carta_identita">Carta d'identita'</option>
                                        <option value= "patente">Patente</option>
                                        <option value= "passaporto">Passaporto</option>
                                    </select>
                                </div>
                                <div class='erroreTesto'> 
                                    <span id="error3"> </span>
                                </div>
                            </div>

                            <div class="dati" >
                                <div class="dati_label" >
                                    <label for="numero_documento">Numero documento:</label><br/>
                                    <input type= "text" class="dati_input" id= "numero_documento" name= "numero_documento" data-error="error4" required placeholder="xx00000xx">
                                </div>
                                <div class='erroreTesto'> 
                                    <span id="error4"> </span>
                                </div>  
                            </div>

                            <div class="dati" >
                                <div class="dati_label">
                                    <label for="email">Email:</label><br/>
                                    <input type = "text" class="dati_input" id= "email" name="email" data-error="error5" maxlength="50" required placeholder="Inserisci un'email valida">
                                </div>
                                <div class='erroreTesto'> 
                                    <span id="error5"> </span>
                                </div>   
                            </div>
                    </div>
                    <div id="campi_dx"> 
                       
                        <div class="dati">
                            <div class="dati_label">
                                <label for="data_nascita">Data di nascita:</label><br/>
                                <input type= "date" class="dati_input" id= "data_nascita" name= "data_nascita" data-error="error6" required>
                            </div>
                            <div class='erroreTesto'> 
                                <span id="error6"> </span>
                            </div>
                        </div>

                        <div class="dati">
                            <div class="dati_label">
                                <label for="telefono">Numero di telefono:</label><br/>
                                <input type= "text" class="dati_input" id= "telefono" name= "telefono" data-error="error7" required placeholder="Esattamente 10 cifre">
                            </div>
                            <div class='erroreTesto'> 
                                <span id="error7"> </span>
                            </div>
                        </div>

                        <div class="dati">
                            <div class="dati_label">
                                <label for="nome_utente">Nome utente:</label><br/>
                                <input type= "text" class="dati_input" id= "nome_utente" name= "nome_utente" maxlength="30" required placeholder="Non sarà più modificabile">
                            </div>
                            <div id="uname_response"></div>
                        </div>

                        <div class="dati">
                            <div class="dati_label">
                                <label for="password">Password:</label><br/>
                                <input type= "password" class="dati_input" id= "password" name="password" data-error="error8" maxlength="30" required placeholder="Min. 6 caratteri">
                            </div>
                            <div class='erroreTesto'> 
                                <span id="error8"> </span>
                            </div>
                        </div>

                        <div class="dati">
                            <div class="dati_label">
                                <label for="repassword">Conferma password:</label><br/>
                                <input type= "password" class="dati_input" id= "repassword" name="repassword" data-error="error9" maxlength="30" required placeholder="Reinserisci la password">
                            </div>
                            <div class='erroreTesto'> 
                                <span id="error9"> </span>
                            </div>
                        </div>

                    </div> 
                    <div id= "button_registrazione">
                        <input type= "reset" class="button_form" name="reset" id="reset" value= "Annulla" onclick="window.location.href='index.php'" >
                        <input type= "submit" class="button_form" name="submit" id="submit" value= "Prosegui" >
                    </div> 
                    </form>
                </div>
            </div>
        </div>
        <?php
        //Se in sessione è gia presente ospite o utente, si apre popup che reindirizza direttamente alla homepage
        } else {
        ?>
            <div id="popup1" class="overlay">
              <div class="popup">
                <h2> SEI GIA' LOGGATO, SARAI REINDIRIZZATO ALLA HOMEPAGE</h2>
                <a class="close" href="../Homepage/homepage.php?stop=1">&times;</a>
                <div class="contentP">
                  Chiudendo questo popup sarai subito reindirizzato alla tua homepage personalizzata oppure cliccando il pulsante qui sotto effettuerai il logout 
                </div>
                <input type="button" id="logout" style="border: 1px solid black; font-size: 12px; color: white; background-color: #669D;" value="logout" onclick="window.location.href='logout.php?stop=1'">  
              </div>
            </div>
            <?php
        }
        ?>

    </body> 
</html>
