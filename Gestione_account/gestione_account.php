<?php
include "../Accesso/connect.php";
session_start();
$stop = mysqli_real_escape_string($mysqli, $_GET['stop']);
if(isset($stop) && $stop==1){
    //Se lo user non è loggato redirect al login
    if ( isset($_SESSION['user'])) {
    ?>
    <!DOCTYPE html>
    <html lang="it">
        <head> 
            <meta charset= "UTF-8">
            
            <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
            <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
            <script type="text/javascript" src="validation.js"></script>
            <link rel="stylesheet" type="text/css" href="../Generici/generico.css" />
            <link rel="stylesheet" type="text/css" href="gestione_account.css">
            <title> Blogbuster - Gestisci il tuo account </title>
        </head>
        <body > 
            <div class="container">
                <div class="container_menu_laterale">
                    <div class="menu_laterale">
                        <?php
                            if (isset($_SESSION['user'])) {
                                $user = "Benvenuto, ". $_SESSION['user'] . " ";
                                echo "<p id='utente_r'>".$user."&#8595 </p>";
                            }
                        ?>

                        <!-- DIV A COMPARSA CON L'OPZIONE DI LOGOUT -->
                        <div> 
                            <ul id="comparsa_logout">
                                <li class="uscita_utente">
                                    <a href="../Gestione_account/gestione_account.php?stop=1"> Modifica il tuo account </a>
                                </li>
                                <li class="uscita_utente">
                                    <a href="../Accesso/logout.php?stop=1"> Logout </a>
                                </li>
                            </ul>
                        </div> 
                        

                        <a title="Torna alla Home"  href="../Homepage/homepage.php?stop=1"> <img src="../Generici/Immagini/logo.png" id="logo"> </a> 
                        
                        <!--BARRA DI RICERCA--> 
                        
                        <div class="frmSearch">
                            <div id="ricerca"><input type="text" name="scritto" id="scritto" placeholder="Cerca per..." maxlength="20"></div>
                            <div id="suggestion-box"></div>
                        </div>
                        <script type="text/javascript">
                            $(document).ready(function()  {                         
                                
                                $("#utente_r").click(function(){
                                    var x= $("#comparsa_logout").css('display');
                                    if (x=="none") {    
                                        $("#comparsa_logout").css("display","block");
                                    } else {
                                        $("#comparsa_logout").css("display","none");
                                    }
                                });

                                $("#scritto").keyup(function(){
                                $.ajax({
                                    type: "POST",
                                    url: "../Generici/ricerca.php?stop=1",
                                    data:'keyword='+$(this).val(),
                                    beforeSend: function(){
                                        $("#scritto").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
                                    },
                                    success: function(data){
                                        $("#suggestion-box").show();
                                        $("#suggestion-box").html(data);
                                        $("#scritto").css("background","#FFF");
                                    }
                                    });
                                });
                            }); 

                            function selectResult(val) {
                            $("#scritto").val(val);
                            $("#suggestion-box").hide();
                            }       
                        </script>

                        <!--ICONE CLICCABILI MENU LATERALE-->

                        <?php 
                            if (isset($_SESSION['user'])){
                        ?>
                        <a href="../Profilo/profilo.php?stop=1">
                            <img src="../Generici/Immagini/profilo.png" id="profilo" class="icone_menu">
                        </a> 


                        <a>
                            <img src="../Generici/Immagini/piu.png" id="piu" class="icone_menu">
                             <div> 
                                <ul id="comparsa_crea">
                                    <li class="crea">
                                        <a href="../Creazione_blog/crea_blog.php?stop=1"> Crea un blog </a>
                                    </li>
                                    <li class="crea">
                                        <a href="../Creazione_post/crea_post.php?stop=1"> Crea un post </a>
                                    </li>
                                </ul>
                            </div> 
                        </a>

                        <script type="text/javascript">
                            $(document).ready(function()  {                         
                                
                                $("#piu").click(function(){
                                    var x= $("#comparsa_crea").css('display');
                                    if (x=="none") {    
                                        $("#comparsa_crea").css("display","block");
                                    } else {
                                        $("#comparsa_crea").css("display","none");
                                    }
                                });
                            });
                        </script>

                        <?php 
                        }
                        ?>

                    
                    </div>
                </div>
                <div class="container_corpo">
                    <div class="corpo">
                        <h1 id="titoletto"> GESTISCI IL TUO PROFILO </h1>
                        <div class="quadrato" id="quadrato">

                            <div id="modifica">
                                <form action="" method="post" id="modifica_account" name="modifica_account">

                                    <div id="campi_sx">
                                        <div class="dati">
                                            <div class="dati_label">
                                                <label>Vecchia password:</label>
                                                <input type="password" id = "vecchia" name="vecchia" class="password" data-error-message="error1"placeholder="Inserisci la vecchia password" />
                                            </div>
                                            <div class='erroreTesto'> 
                                                <span id="error1"> </span>
                                            </div>
                                        </div>
                                        <div class="dati">
                                            <div class="dati_label">
                                                <label>Nuova password:</label>
                                                <input type="password" id="nuova" name="nuova" class="password" data-error="error2" placeholder="Scegli una nuova password" />
                                            </div>
                                            <div class='erroreTesto'> 
                                                <span id="error2"> </span>
                                            </div>
                                        </div>
                                        <div class="dati">
                                            <div class="dati_label">
                                                <label>Conferma password:</label>
                                                <input type="password" id="conferma_nuova" name="conferma_nuova" class="password" data-error="error3" placeholder="Reinserisci la tua password" />
                                            </div>
                                            <div class='erroreTesto'> 
                                                <span id="error3"> </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="campi_dx">
                                        <div class="dati">
                                            <div class="dati_label">
                                                <label> La tua nuova mail:</label>
                                                <input type="email" id="nuova_email" name="nuova_email" data-error="error4" placeholder="Inserisci un'email valida" />
                                            </div>
                                            <div class='erroreTesto'> 
                                                <span id="error4"> </span>
                                            </div>
                                        </div>
                                        <div class="dati">
                                            <div class="dati_label">
                                                <label> Il tuo nuovo numero di telefono:</label>
                                                <input type="text" id="nuovo_telefono" name="nuovo_telefono" data-error="error5" placeholder="Esattamente 10 caratteri" />
                                            </div>
                                            <div class='erroreTesto'> 
                                                <span id="error5"> </span>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <input type="button" id="bottone_elimina_account"value="ELIMINA ACCOUNT">
            

                                    <input type="reset" value="Annulla" id="annulla_modifiche" onclick="window.location.href='../Homepage/homepage.php?stop=1'" />
                                    <input type="submit" value="Conferma modifiche" id="confirm" name="confirm"/> 
                                
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="popup_elimina" class="overlay" style="display: none;">
                <div class="popup">
                    <h2> VUOI DAVVERO ELIMINARE IL TUO ACCOUNT</h2>
                    <div class="contentP">
                     Non potrai più annullare questa azione.
                    </div>
                    <input type="button" id="annulla_elimina" name="annulla_elimina" style="border: 1px solid black; font-size: 12px; color: white; background-color: #669D; cursor: pointer" value="Annulla" onclick="window.location.href='../Gestione_account/gestione_account.php?stop=1'"> 
                    <input type="button" id="conferma_elimina" name="conferma_elimina"style="border: 1px solid black; font-size: 12px; color: white; background-color: #669D; cursor: pointer" value="Elimina" onclick="window.location.href='elimina.php?stop=1'"> 
                </div>
            </div>

            <script>
                $(document).ready(function()  { 
                    $("#bottone_elimina_account").click(function(){
                         $("#popup_elimina").css("display","block");
                    });
                   
                });
            </script>
            <?php 
            $popup1=0;
            $popup2=0;
            $popup3=0;
            //CONFRONTO VECCHIA PASSWORD CON PASSWORD INSERITA NEL CAMPO 'VECCHIA PASSWORD'
            if(isset($_POST['confirm'])){
                 $user = $_SESSION['user'];
                if (!empty($_POST['vecchia']) && !empty($_POST['nuova']) && !empty($_POST['conferma_nuova'])) {
                   
                    $query_vecchia = "SELECT * FROM `utente` WHERE NomeUtente='$user'";
                    $res_vecchia = $mysqli->query($query_vecchia);
                    $row_vecchia = $res_vecchia->fetch_row();
                    $vecchia_pw = $row_vecchia[1];    
                    if (password_verify($_POST['vecchia'], $vecchia_pw)) {
                        $nuova_pw = $_POST['nuova'];
                        $pw_modificata= password_hash($nuova_pw, PASSWORD_DEFAULT);
                        $stmt_pw = $mysqli->prepare("UPDATE `utente` SET Password=? WHERE NomeUtente=?");
                        $stmt_pw->bind_param("ss", $pw_modificata, $user);
                        $stmt_pw->execute() or trigger_error($stmt_pw->error, E_USER_ERROR);
                        if ($stmt_pw-> execute()===TRUE) {
                            $popup1=1;
                        }
                        $stmt_pw->close();
                    
                    } else {
                        echo 'La password inserita non coincide con la tua vecchia password';
                        exit;
                    }

                }
                
                #prepared statement x registrazione - prevenzione SQL injection
                if(!empty($_POST['nuova_email'])) {
                    $nuova_email = $_POST['nuova_email'];
                    $stmt_email = $mysqli->prepare("UPDATE `utente` SET Email=? WHERE NomeUtente=?");
                    $stmt_email->bind_param("ss", $nuova_email, $user);
                    $stmt_email->execute() or trigger_error($stmt_email->error, E_USER_ERROR);
                    if ($stmt_email->execute()===TRUE) {
                        $popup2=1;
                    }
                    $stmt_email->close();
                }

                if(!empty($_POST['nuovo_telefono'])) {
                    $nuovo_telefono = $_POST['nuovo_telefono'];
                    $stmt_tel = $mysqli->prepare("UPDATE `utente` SET NumeroTelefono=? WHERE NomeUtente=?");
                    $stmt_tel->bind_param("ss", $nuovo_telefono, $user);
                    $stmt_tel->execute() or trigger_error($stmt_tel->error, E_USER_ERROR);
                    if ($stmt_tel-> execute()===TRUE) {
                        $popup3=1;
                    }
                    $stmt_tel->close();
                }
            
                if (($popup1 == 1 )|| ($popup2 == 1 )||($popup3 == 1 )){
                    ?>
                     <div id="popup1" class="overlay">
                        <div class="popup">
                            <h2> HAI MODIFICATO CORRETTAMENTE IL TUO ACCOUNT</h2>
                            <a class="close" href="../Homepage/homepage.php?stop=1">&times;</a>
                            <div class="contentP">
                              Chiudendo questo popup sarai subito reindirizzato alla tua homepage
                            </div>
                        </div>
                    </div>
            

            <?php
                } 
            }
            

    } else{
            header("Location: ../Accesso/index.php?stop=1");
    }
} else {
    header('Location: ../Accesso/index.php?stop=1');
}
     ?>

    </body> 
</html>
