<?php
include "../Accesso/connect.php";
session_start();
$stop = mysqli_real_escape_string($mysqli, $_GET['stop']);
if(isset($stop) && $stop==1){
    //Se lo user non è loggato redirect al login
    if ( isset($_SESSION['user']) ) {
        $utente= $_SESSION['user'];
        //prende i campi del blog scelto e li inserisce nell'intestazione della pagina
        $idPost= mysqli_real_escape_string($mysqli, $_GET["idPost"]);
        $cerca_post = "SELECT * FROM `post`  WHERE (IdPost = '$idPost')";
        $res_post = $mysqli->query($cerca_post);
        $row_post = $res_post->fetch_row();
        
        $titolo = $row_post[1];
        $sottotitolo = $row_post[2];
        $corpo = $row_post[3];
        
        
    ?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <script type="text/javascript" src="../Generici/menu_laterale.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
            <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <title> BLOGBUSTER - Modifica post </title>
            <meta charset="UTF-8" />
            <meta name="viewport" content="initial-scale=1, maximum-scale=1, minimum-style=1">
            <link rel="stylesheet" type="text/css" href="../Generici/generico.css" />
            <link rel="stylesheet" type="text/css" href="modifica_post.css" />
            
        </head>
        <body>
            <div class="container">
                <div class="container_menu_laterale">
                    <div class="menu_laterale">
                        <?php
                            $user = "Benvenuto, ". $_SESSION['user'] . " ";
                            echo "<p id='utente_r'>".$user."&#8595 </p>";
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
                        

                        <a title="Torna alla Home" href="../Homepage/homepage.php?stop=1"> <img src="../Generici/Immagini/logo.png" id="logo"> </a> 
                        
                        <!--BARRA DI RICERCA--> 
                        
                        <div class="frmSearch">
                            <div id="ricerca"><input type="text" name="scritto" id="scritto" placeholder="Cerca per..." maxlength="20"></div>
                            <div id="suggestion-box"></div>
                        </div>
                        <script type="text/javascript">
                            $(document).ready(function()  {                    
                                
                                $("#utente_r").click(function(){ //menù a tendina gestione account
                                    var x= $("#comparsa_logout").css('display');
                                    if (x=="none") {    
                                        $("#comparsa_logout").css("display","block");
                                    } else {
                                        $("#comparsa_logout").css("display","none");
                                    }
                                });

                                $("#scritto").keyup(function(){ //gestione barra di ricerca
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

                    
                    </div>
                </div>

                <div class="container_corpo">
                    <div class="corpo">
                        <h1 id="titoletto"> MODIFICA IL TUO POST </h1>
                        <div id="forma" class="rettangolo">
                           
                            <form method="post" enctype="multipart/form-data" id="crea_post" name="crea_post">
                                
                                <div id="contenitore_campi">  
                                    <label>Titolo:</label><br/>
                                    <input rows="2" type = "text" id = "titolo_post" name = "titolo_post"class="crea_post_caratteristiche" required maxlength="20" value="<?php echo $titolo;?>" />
                                    <br/>
                                    <br/>
                                    <!-- selezione degli interessi -->
                                    <label> Sottotitolo:</label><br/>
                                    <input rows="2" type = "text" id = "sottotitolo_post" name = "sottotitolo_post"class="crea_post_caratteristiche"  required value="<?php echo $sottotitolo;?>"/>
                                    <br/>
                                                                
                                    <br/><br/>
                                    
                                    <div id="contenitore_testo">
                                        <p id="titolo_corpo" > Modifica il tuo post:</p><br/>
                                        <textarea type="text" maxlength="1000" id="testo" name="testo" required > <?php echo $corpo;?></textarea> <br/><br/>
                                    </div>
                                    
                                    

                                </div>
                                
                                

                                <div id="bottoni_invio">
                                    <input type="button" value="Annulla" id="annulla" onclick="window.location.href='../Post/post.php?id=<?php echo $idPost;?>&stop=1'" />
                                    <input type="submit" value="Modifica" id="crea" name="crea"  href="#popup1"/>
                                </div>          
                            </form> 
                        </div>
                    </div>
                    
                    
                </div>    

            </div>
            <?php
            if (isset($_POST['crea'])) {
            //prendo variabili post
                    $titolo=$_POST['titolo_post'];
                    $sottotitolo=$_POST['sottotitolo_post'];
                    $testo=$_POST['testo'];

                    //inserisco in tabella nuovo post
                    $stmt = $mysqli->prepare("UPDATE `post` SET Titolo=?, Sottotitolo=?, Corpo=? WHERE IdPost=?");
                    $stmt->bind_param("sssi", $titolo, $sottotitolo, $testo, $idPost);
                    $stmt->execute() or trigger_error($stmt->error, E_USER_ERROR); 
                      
                    ?>
                    <div id="popup1" class="overlay">
                        <div class="popup">
                            <h2>HAI MODIFICATO IL POST CON SUCCESSO!!</h2>
                            <a class="close" href="../Post/post.php?id=<?php echo $idPost;?>&stop=1">&times;</a>
                        </div>
                    </div>
                <?php
                     
               
               
                }        
                ?> 
        </body>
    </html>

    <?php 
    } else {
        header("Location: ../Accesso/index.php?stop=1");
    }
} else {
    header("Location: ../Accesso/index.php?stop=1");
}



?>