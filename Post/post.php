<?php
include "../Accesso/connect.php";
session_start();
$stop = mysqli_real_escape_string($mysqli, $_GET['stop']);
if(isset($_GET['stop']) && $_GET['stop']==1){
    //Se lo user non è loggato e non è nemmeno un ospite redirect al login
    if (isset($_SESSION['user']) || isset($_SESSION['guest'])) {
        $idPost= mysqli_real_escape_string($mysqli, $_GET["id"]);
        //assegno alla variabile username session[user] o session[guest] a seconda di chi sta navigando nel sito
        if (isset ($_SESSION['user'])){
            $username = $_SESSION['user'];
        } else if (isset($_SESSION['guest'])) {
            $username = $_SESSION['guest'];
        }
        //prende i campi del blog scelto e li inserisce nell'intestazione della pagina
        $cerca_blog = "SELECT * FROM `blog`, `post`  WHERE (post.IdPost = $idPost AND post.IdBlog= blog.CodiceId)";
        $res_blog = $mysqli->query($cerca_blog);
        $row_blog = $res_blog->fetch_row();
        $id_blog = $row_blog[0];
        $titolo = $row_blog[1];
        $autore = $row_blog[3];
        $coautore= $row_blog[4];
        $imageURL = '../Creazione_blog/uploads/'.$row_blog[7];
        //prendo caratteristiche colori e font dal blog
        $colore1 = $row_blog[8];
        $colore2 = $row_blog[9];
        $_SESSION['colore1']=$colore1;
        $_SESSION['colore2']=$colore2;

        $font = $row_blog [10];
        $colore_font = $row_blog[11];

    ?>

    <!DOCTYPE html>
    <html lang="en">
        <head>
    		<script type="text/javascript" src="../Generici/menu_laterale.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
            <!--script presi da sito https://www.9lessons.info/2016/04/facebook-like-reactions-using-php-mysql.html x reactions-->
            <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.13.0/css/all.css"> <!-- libreria per icona edi -->

            <script src="jquery-2.1.4.js"></script>
            <script src="jquery-ui_1.12.1_.min.js"></script>
            <script src="facebook-reactions.js"></script>
            
            <!---->
            <title> BLOGBUSTER - # nome Blog </title>
            <meta charset="UTF-8" />
            <meta name="viewport" content="initial-scale=1, maximum-scale=1, minimum-style=1">
            <link rel="stylesheet" type="text/css" href="post.css" />
            <link rel="stylesheet" type="text/css" href="../Generici/generico.css" />
            
        </head>
        <body style="background-color: <?php echo $colore1;?>">
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
                <?php
                    $query= "SELECT * FROM `argomento` WHERE IdArgomento = '$row_blog[5]' ";
                    $result = $mysqli -> query($query);
                    $row = $result -> fetch_row();
                    $argomenti = $row[1];
                ?>

    			<div class="container_corpo" >
    			   <div class="corpo">
                        

                        <div id="campi_intestazione">
                        
                            <img src="<?php echo $imageURL; ?>" id="foto_blog" alt="" />
                            <div id="campi_sx">
                                <fieldset id="titolo" style="background-color: <?php echo $colore2; ?>">  
                                    <legend><span>Blog:</span></legend>
                                    <p id="titolo_variabile" style="color: <?php echo $colore_font;?>; font-family: <?php echo $font;?>;"> <a title="Torna al blog" style="color:<?php echo $colore_font; ?> " href="../Blog/blog.php?id=<?php echo $id_blog ?>&stop=1"> <?php echo $titolo;?> </a> </p>
                                </fieldset>
                                <fieldset id="argomenti" style="background-color: <?php echo $colore2; ?>">
                                    <legend><span>Argomento:</span></legend>
                                    <p id="argomenti_variabile" style="color: <?php echo $colore_font;?>; font-family: <?php echo $font;?>;"> <?php echo $argomenti;?> </p>
                                </fieldset>
                            </div>
                            <div id="campi_dx">
                                <fieldset id="autore" style="background-color: <?php echo $colore2; ?>">
                                    <legend><span>Autore:</span></legend>
                                    <p id="autore_variabile" style="color: <?php echo $colore_font;?>; font-family: <?php echo $font;?>;"> <a title="Visita il profilo" style="color:<?php echo $colore_font; ?>" href="../Profilo/profilo.php?id=<?php echo $autore ?>&stop=1"> <?php echo $autore;?> </a> </p>
                                </fieldset>
                                <fieldset id="coautore" style="background-color: <?php echo $colore2; ?>">
                                    <legend><span>Co-autore:</span></legend>
                                    <p id="coautore_variabile" style="color: <?php echo $colore_font;?>; font-family: <?php echo $font;?>;"> <?php echo $coautore;?></p>
                                </fieldset>
                            </div>
                        </div>
                        <div id ="contenitore_post" style="background-color: <?php echo $colore2; ?>">
                            
            					<?php
            						//prendo i campi del post scelto precedentemente
            						$cerca_post = "SELECT * FROM `post` WHERE IdPost=$idPost";
            						$res_post = $mysqli->query($cerca_post);
                                    $row_count= $res_post->num_rows;
                                    $row_post = $res_post->fetch_row();
                                    $titolo =  $row_post[1];
                                    $sottotitolo = $row_post[2];
                                    $corpo = $row_post[3];
                                    $sottoargomento = $row_post[4];
                                    $data = $row_post[5];
                                    $ora = $row_post[6];
                                    $idBlog = $row_post[7];
                                    $autore_principale = $row_post[8];
                                    $altro_argomento = $row_post[9];
                                    ?> 
                                    <p id="data_post" style="color: <?php echo $colore_font;?>; font-family: <?php echo $font;?>;">Data: <?php echo $data;?></p>
                                    </br></br>
                                    <p id="ora_post" style="color: <?php echo $colore_font;?>; font-family: <?php echo $font;?>;">Ora: <?php echo $ora;?></p>
                                    <!--SOLO SE AUTORE = UTENTE LOGGATO-->
                                    <?php 
                                    if($autore==$username){
                                    ?>
                                    <!--MODIFICA POST-->
                                        <div id="modifica_post_contenitore">
                                            <a title="Modifica post" href="../Modifica_post/modifica_post.php?idPost=<?php echo $idPost ?>&stop=1">
                                                <i class="fas fa-edit" id="modifica_icon"> </i> 
                                            </a>
                                         </div>
                                        <!--ELIMINA POST-->
                                       
                                        <div title="Elimina post" id="elimina_post_contenitore">
                                               <i class="fa fa-trash" id="elimina_icon" aria-hidden="true"></i>
                                        </div>
                                    <?php 
                                    }
                                    ?>
                                    <p id="autore_principale_post" style="color: <?php echo $colore_font;?>; font-family: <?php echo $font;?>;">Scritto da: <?php echo $autore_principale;?></p>
                                    <p id="titolo_post" style="color: <?php echo $colore_font;?>; font-family: <?php echo $font;?>;"><?php echo $titolo;?></p>
                                    <br/>
                                    <p id="sottotitolo_post" style="color: <?php echo $colore_font;?>; font-family: <?php echo $font;?>;"> <?php echo $sottotitolo;?></p>
                                    <?php 
                                    if ($sottoargomento == null) {
                                        $sottoargomento =  $altro_argomento;
                                    }
                                    else{
                                        //ho l'id del sottoargomento, cerco il suo nome
                                        $nome_sottoargomento = "SELECT nome FROM `sottoargomento` WHERE idSottoargomento = '$sottoargomento'";
                                        $res_nome = $mysqli -> query($nome_sottoargomento);
                                        $row_nome_sottoargomento = $res_nome -> fetch_row();
                                        $sottoargomento =  $row_nome_sottoargomento[0];
                                    }
                                    ?>
                                    <p id="argomento_post" style="background-color: <?php echo $colore1;?>"><?php echo $sottoargomento;?> </p>
                                    
                                    <div id="contenitore_img">
                                    <?php 
                                    //query per prendere le immagini
                                    $imgs_query = "SELECT * FROM `filemultimedia` WHERE IdPost=$idPost";
                                    $res_imgs = $mysqli->query($imgs_query);
                                    $row_count= $res_imgs->num_rows;
                                    $i=0;
                                    while ($i < $row_count) { 
                                    	$row_imgs = $res_imgs->fetch_row();
                                    	$imageURL = '../Creazione_post/uploads/'.$row_imgs[1];
                                ?>
                            	<img src='<?php echo $imageURL;?>' class = "imgs" >
                                <?php
                                $i = $i + 1;
                            }
    					?>
                        </div>
                        <p id="corpo_post" style="color: <?php echo $colore_font;?>; font-family: <?php echo $font;?>; line-height: 30px;"><?php echo $corpo;?></p>
                    </div>
    			</div>
                <!--SEZIONE REACTION -->
                <?php
                if (isset($_SESSION['user'])){
                    //query per emoji se reaction già messa
                    $query_emoji = "SELECT * FROM `reactions` WHERE (IdPost = '$idPost' AND Utente='$username')"; 
                    $result_emoji = $mysqli->query($query_emoji);
                    $row =  $result_emoji->fetch_row();
                    if ($result_emoji->num_rows != 0) {
                        $emoji = $row[3];
                    } else {
                        $emoji = 'REACT';
                    }
                    ?>
                    <a class="FB_reactions" data-reactions-type='horizontal' data-unique-id="1" data-emoji-class="<?php echo $emoji; ?>">
                    <span style=""><?php echo $emoji; ?></span>
                    </a>
                
                    <!--SEZIONE COMMENTI -->
                    <div class="comments"></div>
                    <br/>
                    <br/>
                <?php 
                } else if (isset($_SESSION['guest'])){
                    ?>
                    <br/>
                    <div id="restrizione_ospite">
                        <p style="font-size: 15px; font-family: <?php echo $font?>;"> <a href="../Accesso/index.php&stop=1" style="color: black">Accedi</a> o <a href="../Accesso/index.php&stop=1" style="color: black">registrati</a> per entrare nella community BLOGBUSTER! Potrai vedere i commenti degli altri utenti, scrivere commenti o lasciare una reaction. </p>
                    </div>
                    <br/>

                <?php
                }
                ?>
            </div>
             <div id="popup_elimina" style="display:none;" class="overlay">
              <div class="popup">
                <h2> VUOI DAVVERO ELIMINARE QUESTO POST?</h2>
                <div class="contentP">
                 Non potrai più annullare questa azione.
                </div>
                <input type="button" id="annulla_elimina" style="border: 1px solid black; font-size: 12px; color: white; background-color: #669D;" value="Annulla" onclick="window.location.href='../Post/post.php?id=<?php echo $idPost;?>&stop=1'"> 
                <input type="button" id="conferma_elimina" style="border: 1px solid black; font-size: 12px; color: white; background-color: #669D;" value="Elimina" onclick="window.location.href='elimina_post.php?id=<?php echo $idPost;?>&stop=1'">  
              </div>
            </div>
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


<!--SCRIPT REACTION -->
<script>
    $(document).ready(function() {
        //FAR APPARIRE POP UP PRE-ELIMINAZIONE
         $('#elimina_post_contenitore').click(function() {
            $('#popup_elimina').show();
         });
        //SCRIPT REACTION 
        $('.FB_reactions').facebookReactions({
                 postUrl: "save.php?id=<?php echo $idPost?>&stop=1"
        });
    });
</script>


<!--SCRIPT COMMENTI - codice adattato da https://codeshack.io/commenting-system-php-mysql-ajax/-->
<script>
var comments_page_id = <?php echo $idPost; ?>; // This number should be unique on every page
fetch("commenti.php?stop=1&page_id=" + comments_page_id).then(response => response.text()).then(data => {
    document.querySelector(".comments").innerHTML = data;
    document.querySelectorAll(".comments .write_comment_btn, .comments .reply_comment_btn").forEach(element => {
        element.onclick = event => {
            event.preventDefault();
            document.querySelectorAll(".comments .write_comment").forEach(element => element.style.display = 'none');
            document.querySelector("div[data-comment-id='" + element.getAttribute("data-comment-id") + "']").style.display = 'block';
        };
    });
    document.querySelectorAll(".comments .write_comment form").forEach(element => {
        element.onsubmit = event => {
            event.preventDefault();
            fetch("commenti.php?stop=1&page_id=" + comments_page_id, {
                method: 'POST',
                body: new FormData(element)
            }).then(response => response.text()).then(data => {
                element.parentElement.innerHTML = data;
            });
        };
    });
});


</script>


      