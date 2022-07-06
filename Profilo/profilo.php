<?php
include "../Accesso/connect.php";
session_start();
$stop = mysqli_real_escape_string($mysqli, $_GET['stop']);
if(isset($stop) && $stop==1){
    //Se lo user non è loggato e non è nemmeno un ospite redirect al login
    if (isset($_SESSION['user']) || isset($_SESSION['guest'])) {
        if (isset($_SESSION['user'])) {
            $user_id = $_SESSION['user'];   
        } else {
            $user_id = $_SESSION['guest'];
        }
        if (isset($_GET['id'])) {
            //se l'utente visita il profilo di un altro utente, come profilo_id prendo l'id passato con il GET attraverso l'indirizzo URL 
            $profilo_id = $_GET['id'];
        } else {
            //se invece è nel suo profilo, come profilo_id prendo l'id di sessione
            $profilo_id = $user_id;
        }
    ?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <script type="text/javascript" src="../Generici/menu_laterale.js"></script>
            <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.13.0/css/all.css"> <!-- libreria per icona edi -->
            <title> BLOGBUSTER - Profilo </title>
            <meta charset="UTF-8" />
            <meta name="viewport" content="initial-scale=1, maximum-scale=1, minimum-style=1">
            <link rel="stylesheet" type="text/css" href="profilo.css" />
            <link rel="stylesheet" type="text/css" href="../Generici/generico.css" />

        </head>
        <body>
            <div class="container">
                <div class="container_menu_laterale">
                    <div class="menu_laterale">
                        <?php
                            if (isset($_SESSION['user'])) {
                                $user = "Benvenuto, ". $_SESSION['user'] . " ";
                                echo "<p id='utente_r'>".$user."&#8595 </p>";
                            } else {
                                $guest = "Benvenuto, guest_". $_SESSION['guest'] . " ";
                                echo "<p id='utente_o'>".$guest." </p>";
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
                            if (isset($_SESSION['guest']) && isset($_SESSION['user']) || isset($_SESSION['user'])){
                        ?>
                        <a href="../Profilo/profilo.php?stop=1">
                            <img src="../Generici/Immagini/profilo.png" id="profilo" class="icone_menu">
                        </a> 

                       

                        <a>
                            <div id="contenitore_piu">
                                <img src="../Generici/Immagini/piu.png" id="piu" class="icone_menu">
                            </div>
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
                        } else { 
                        ?>
                        <div id="contenitore_accedi_ospite" onclick="location.href='../Accesso/index.php?stop=1';">
                            <p id="p_accedi_ospite">Accedi o registrati</p>
                            <i class="fas fa-sign-in-alt"></i>
                        </div>
                        <?php
                        }
                        ?>

                    
                    </div>
                </div>



                
                <div class="container_corpo">
                    <div class="corpo">
                        <div class="contenitore_profilo">
                            <?php  
                                $query_utente = "SELECT * FROM `utente` WHERE NomeUtente= '$profilo_id' "; 
                                $result_utente = $mysqli->query($query_utente);
                                $row_utente = $result_utente->fetch_row();
                                $utente_count= $result_utente->num_rows;
                                $foto = $row_utente[3];
                                if( $foto != '') {
                                    $imageURL = 'uploads/'.$foto;
                                }
                                else {
                                    $imageURL = 'Immagini/default.jpg';
                            ?>
                            <?php
                                }
                            ?>

                            <form id="uploadimage" name="uploadimage" enctype="multipart/form-data" method="post" action="modifica_profilo.php?stop=1">    
                                <img src="<?php echo $imageURL; ?>" id="foto_profilo" />
                                    <div class="image-upload">
                                        <label for="file-input">
                                            <i class="fas fa-edit" id="modifica_foto"> </i>
                                        </label>

                                        <input id="file-input" type="file" id = "file" name = "file" accept="image/*" onchange="loadFile_foto_profilo(event)"/>
                                    </div>

                            
                            <fieldset class="span_profilo" id="nome_utente"> 
                                <legend> Nome utente: </legend>
                                <?php
                                    echo "$profilo_id"; 
                                ?> 

                            </fieldset>
                            <fieldset class="span_profilo" id="descrizione_utente">
                                <legend> Descrizione utente: </legend>
                                <?php 
                                    $query_descrizione=  "SELECT * FROM `utente` WHERE NomeUtente= '$profilo_id'";
                                    $result_descrizione = $mysqli->query($query_descrizione);
                                    $row_descrizione = $result_descrizione -> fetch_row();
                                    $descrizione = $row_descrizione[2];
                                    if (isset($descrizione)){
                                        echo $descrizione; 
                                    }
                                    else {
                                        echo 'Puoi modificare la tua descrizione in qualsiasi momento';
                                    }
                                ?>

                            </fieldset>

                            <div class="descrizione-upload" onclick="visualizza_TextA(event)">
                                <i class="fas fa-edit" id="modifica_descrizione"> </i>
                            </div>
                                
                            <div id="contenitore_text_descrizione">
                                <textarea id="text_descrizione" name="text_descrizione"><?php echo $descrizione ?></textarea>
                            </div>

                            <input type="submit" name="conferma_modifiche" id="conferma_modifiche" value="Conferma modifiche" />

                            </form>

                        </div>
                        <div id="contenitore_titolo">
                            <h1 id="titolo">I BLOG</h1>
                        </div>

                        <div class ="contenitore_blogs">
                            
                            <?php
                            if (isset($profilo_id)){
                                $utente = $profilo_id;
                            } else {
                                $utente = $user_id;
                            }
                            $cerca_blog = "SELECT * FROM `blog` WHERE Autore = '$utente' OR Coautore='$utente'";
                            $res_blog = $mysqli->query($cerca_blog);
                            $row_count= $res_blog->num_rows;

                            $i=0;
                            while ($i < $row_count ) {
                                $row_blog = $res_blog->fetch_row();
                                $imageURL = '../Creazione_blog/uploads/'.$row_blog[7];
                                $titolo =  $row_blog[1];
                                $descrizione = $row_blog[2];
                                $autore = $row_blog[3];
                                $id= $row_blog[0];
                                $query= "SELECT * FROM `argomento` WHERE IdArgomento = '$row_blog[5]' ";
                                $result = $mysqli -> query($query);
                                $row = $result -> fetch_row();
                                if ($row[1] == "Altro") {
                                    $query_altro = "SELECT * FROM `blog` WHERE CodiceId = '$row_blog[0]'";
                                    $res_altro = $mysqli->query($query_altro);
                                    $row_altro = $res_altro->fetch_row();
                                    $argomenti = $row_altro[6];
                                } else {
                                    $argomenti=$row[1];
                                }
                                
                                $i = $i + 1;
                                
                            ?>
                                <div class="blog_contenitore" >
                                    <!--modifica POST-->
                                    <div class="modifica_blog_contenitore">
                                        <a  href="../Modifica_blog/modifica_blog.php?idBlog=<?php echo $id ?>&stop=1">
                                            <i class="fas fa-edit modifica_icon"> </i> 
                                        </a>
                                    </div>
                                    <!--ELIMINA POST-->
                                    <div class="elimina_blog_contenitore">
                                         <a  href="../Profilo/elimina_blog.php?idBlog=<?php echo $id ?>&stop=1">
                                            <i class="fa fa-trash elimina_icon" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                    <!--genera quadrato comparsa-->
                                    <?php
                                    if ($autore == $profilo_id){
                                    ?>
                                    <a href="../Blog/blog.php?id=<?php echo $id ?>&stop=1">
                                    <div style="background-image: url('<?php echo $imageURL;?>')" class="comparsa" >
                                        <p class="blog titolo_blog"> <?php echo $titolo;?></p>
                                        <p class="blog argomenti_blog"> Argomento: <?php echo $argomenti;?> </p>
                                        <p class="blog descrizione_blog" > <?php echo $descrizione;?></p>
                                    </div>  
                                    </a>            

                                    <?php 
                                    } else {
                                    ?>
                                        <a href="../Blog/blog.php?id=<?php echo $id ?>&stop=1">
                                        <div style="background-image: url('<?php echo $imageURL;?>'); border-color: #00C196;" class="comparsa" >
                                            <p class="blog titolo_blog"> <?php echo $titolo;?></p>
                                            <p class="blog argomenti_blog"> Argomento: <?php echo $argomenti;?> </p>
                                            <p class="blog autore_blog" > Scritto con <?php echo $autore;?></p>
                                        </div>  
                                        </a> 
                                    <?php
                                    }
                                ?>
                                </div>
                                <?php
                            }
                        ?>
                        </div>
                    </div>

                </div>
            <script>                
                var loadFile_foto_profilo = function(event) {
                    $dimensione_massima = 500000;
                    if (event.target.files[0].size < $dimensione_massima) {
                        var output = document.getElementById('foto_profilo');
                        output.src = URL.createObjectURL(event.target.files[0]);
                        output.onload = function() {
                        URL.revokeObjectURL(output.src) // free memory
                        }
                        $("#conferma_modifiche").css("display", "block");
                    } else {
                        alert ("L'immagine è troppo grande!");
                    }
                };

                var visualizza_TextA = function(event) {
                    $('#contenitore_text_descrizione').css("display", "block");
                    $("#conferma_modifiche").css("display", "block");
                    $('#contenitore_titolo').css("transform","translate(300px,80px)");
                };  

            </script>
            <input id="profilo_id" type="button" name="profilo_id" value="<?php echo $profilo_id; ?>">
            <input id="user_id" type="button" name="user" value="<?php echo $user_id; ?>">
            <script>
                var profilo = document.getElementById('profilo_id').value;
                var user_id =  document.getElementById('user_id').value;
                $(document).ready(function()  { 
                    //permette di mmodificare descrizione e foto profilo solo se utente = session user
                    if(profilo != user_id) {             
                        $(".image-upload").css("display", "none");
                        $(".descrizione-upload").css("display", "none");
                        $("#conferma_modifiche").css("display", "none");
                        $(".modifica_blog_contenitore").css("display", "none");
                        $(".elimina_blog_contenitore").css("display", "none");
                    } else {
                        $(".span_profilo").css('transform', 'translateY(-230px)');
                        $(".comparsa").css("transform", "translateY(-250px)");

                    }
                });
            </script>
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
