<?php
include "../Accesso/connect.php";
session_start();
$stop = mysqli_real_escape_string($mysqli, $_GET['stop']);
if(isset($stop) && $stop==1){
    //Se lo user non è loggato, redirect al login
    if ( isset($_SESSION['user']) ) {
        $utente= $_SESSION['user'];
        //trovo i blog di questo utente
        $blogs_query= "SELECT * FROM `blog` WHERE (Autore = '$utente' OR Coautore='$utente')";
        $blogs_result = $mysqli -> query($blogs_query);
        $blogs_count= $blogs_result->num_rows;
        
        ?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <script type="text/javascript" src="../Generici/menu_laterale.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
            <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <script type="text/javascript" src="crea_post.js"></script>
            <title> BLOGBUSTER - Crea post </title>
            <meta charset="UTF-8" />
            <meta name="viewport" content="initial-scale=1, maximum-scale=1, minimum-style=1">
            <link rel="stylesheet" type="text/css" href="../Generici/generico.css" />
            <link rel="stylesheet" type="text/css" href="crea_post.css" />
            
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
                            <div id="ricerca"><input type="text" name="scritto" id="scritto" placeholder="Cerca per..." maxlength="20" style="background-color: white;"></div>
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
                        <h1 id="titoletto"> CREA IL TUO POST </h1>
        				<div id="forma" class="rettangolo">
                           
                            <form method="post" enctype="multipart/form-data" id="crea_post" name="crea_post">
                                
                                <div id="contenitore_campi">  
                                    <div id="campi_sx1">
                                        <label>Titolo:</label><br/>
                                        <input rows="2" type = "text" id = "titolo_post" name = "titolo_post"class="crea_post_caratteristiche" required maxlength="20"/>
                                        <br/>
                                        <br/>
                                        <!-- selezione degli interessi -->
                                        <label> Sottotitolo:</label><br/>
                                        <input rows="2" type = "text" id = "sottotitolo_post" name = "sottotitolo_post"class="crea_post_caratteristiche"  required/>
                                        <br/>
                                                                    
                                        <br/><br/>
                                        
                                        
                						
                                    </div>

                                    <div id="campi_dx1">
                                    
                                    <label> Scegli il blog in cui inserirlo </label> <br/>
                                        <select class="blog" id= "blog" name= "blog"  required >
                                            <option value= ""> ------- </option>
                                            <?php //OPZIONI COI BLOG SCRITTI DALL'UTENTE
                                                $i=0;
                                                while ($i < $blogs_count ) {
                                                    $blogs_row = $blogs_result -> fetch_row();
                                                    $titolo_blog =  $blogs_row[1];
                                            ?>
                                                    <option id="<?php echo $titolo_blog;?>" value= "<?php echo $titolo_blog;?>"> <?php echo $titolo_blog;?> </option>
                                            <?php 
                                                    $i = $i + 1;
                                                }
                                            ?>
                                        </select>
                                        <br/><br/>

                                  
                                        <label id="scegli"> Scegli un sottoargomento:</label> 
                                        <label id="inserisci"  style="display: none"> Inserisci un sottoargomento:</label> 
                                        <select class="sottoargomento" id= "sottoargomento" name= "sottoargomento">
                                                <option value= ""> ------- </option>
                                        </select>
                                        <input type='text' id='altrosottoargomento'  name='altrosottoargomento' style="display: none">

                                        <script>
                                        $(document).ready(function(){
                                            $('#blog').change(function() {
                                                var titolo= $(this).val();
                                                $.ajax({
                                                    url: 'getSottoargomenti.php?stop=1',
                                                    type: 'post',
                                                    data: {
                                                        titolo: titolo,
                                                    },  
                                                    success: function(response){

                                                        if (response != 0) {
                                                            $('#sottoargomento').show();
                                                            $('#scegli').show();
                                                            $('#inserisci').hide();
                                                            $('#sottoargomento').html(response);
                                                            $('#altrosottoargomento').hide();


                                                        } else {
                                                            $('#sottoargomento').hide();
                                                            $('#scegli').hide();
                                                            $('#inserisci').show();
                                                            $('#altrosottoargomento').show();
                                                        }
                                                    }                                     
                                                });
                                            });
                                        });
                                        </script>
                                       

                                    </div>
                                </div>
                                
                                <div id="scegli_foto"><br/> 
                                    <p id="titolo_scegli_foto">Scegli la foto:</p>
                                    <input type = "file" id = "file" name = "file[]" accept="image/*" multiple="multiple" /> 
                                    <div id="galleria_anteprime">
                                        <img id="default" src="../Generici/Immagini/default.jpg">
                                    </div> <br/> 
                                
                                </div>


                                <div id="contenitore_testo">
                                    <p id="titolo_corpo" > Scrivi il tuo post:</p><br/>
                                    <textarea rows= "20" id="testo" name="testo" required maxlength="1000"></textarea><br/><br/>
                                </div>

                                <div id="bottoni_invio">
                                    <input type="button" value="Annulla" id="annulla"/>
                                    <input type="submit" value="Crea" id="crea" name="crea"  href="#popup1"/>
                                </div>			
                            </form>	
        				</div>
                    </div>

                    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
                    <script language="javascript" type="text/javascript">
                    //CARICA ANTEPRIMA FOTO
                    $(function () {
                        var array_foto = [];
                        $dimensione_massima = 4500000;
                        $("#file").change(function () {
                            $("#default").hide();
                            if ($("#file")[0].files.length > 5) {
                                alert("Puoi selezionare solo 5 immagini");
                            } else { 
                                if (typeof (FileReader) != "undefined") {
                                    var galleria_anteprime = $("#galleria_anteprime");
                                    galleria_anteprime.html("");
                                    var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp|.JPG|.JPEG|.PNG|.GIF)$/;
                                    $($(this)[0].files).each(function () {
                                        var file = $(this);
                                        if (file[0].size < $dimensione_massima) {

                                            if (regex.test(file[0].name.toLowerCase())) {
                                            var reader = new FileReader();
                                            reader.onload = function (e) {
                                                var img = $("<img />");
                                                img.attr("style", "height:100px;width: 100px");
                                                img.attr("src", e.target.result);
                                                galleria_anteprime.append(img);
                                                var temp = file[0].name;
                                                array_foto.push(temp);
                                                }

                                                reader.readAsDataURL(file[0]);
                                                //alert(file[0].name);
                                            }
                                        } else {
                                            alert(file[0].name + " è un file troppo pesante o un formato non valido.");
                                            galleria_anteprime.html("");
                                            return false;
                                        }


                                    }); 

                                
                                    $("#crea").click(function () {
                                        $.ajax({
                                            type: 'post',
                                            data: {
                                                array_foto: array_foto,
                                            },
                                            error: function(xhr){
                                                alert("An error occured: " + xhr.status + " " + xhr.statusText);
                                            }                                 
                                        });

                                    });

                                } else {
                                    alert("This browser does not support HTML5 FileReader.");
                                }
                            } 
                        });
                        
                    });
                    
                    </script>
                    <br/>
                    
        			
        		</div>    

        	</div>
            <?php
            if (isset($_POST['crea'])) {
            //prendo variabili post
                if(!empty($_POST['titolo_post']) && !empty($_POST['sottotitolo_post']) && !empty($_POST['blog']) && !empty($_POST['testo'])){
                    $titolo=$_POST['titolo_post'];
                    $sottotitolo=$_POST['sottotitolo_post'];
                    $titolo_blog=$_POST['blog'];
                    $testo=$_POST['testo'];
                   
                    if (!empty( $_POST['altrosottoargomento'])) {
                        $altrosottoargomento = $_POST['altrosottoargomento'];
                        $sottoargomento = null;
                    } else {
                        $sottotemp=$_POST['sottoargomento'];
                        $altrosottoargomento = null;
                        //ho l'id del sottoargomento, cerco il suo nome
                        $nome_sottoargomento = "SELECT idSottoargomento FROM `sottoargomento` WHERE nome = '$sottotemp'";
                        $res_nome = $mysqli -> query($nome_sottoargomento);
                        $row_sottoargomento = $res_nome -> fetch_row();
                        $sottoargomento= $row_sottoargomento[0];
                    }


                    //trovo codice blog
                    $idblog_query= "SELECT `CodiceId` FROM `blog` WHERE (Titolo = '$titolo_blog')";
                    $idblog_result = $mysqli -> query($idblog_query);
                    $idblog_row = $idblog_result -> fetch_row();

                    //inserisco in tabella nuovo post
                    $stmt = $mysqli->prepare("INSERT INTO `post` (Titolo, Sottotitolo, Corpo, Sottoargomento, IdBlog, Autore, AltroSottoargomento) VALUES (?,?,?,?,?,?,?)");
                    $stmt->bind_param("sssssss", $titolo, $sottotitolo, $testo, $sottoargomento, $idblog_row[0], $utente, $altrosottoargomento);
                    $stmt->execute() or trigger_error($stmt->error, E_USER_ERROR);
                    ?>
                    <div id="popup1" class="overlay">
                          <div class="popup">
                            <h2>HAI CREATO IL POST CON SUCCESSO!!</h2>
                            <a class="close" href="../Profilo/profilo.php?stop=1">&times;</a>
                            <div class="contentP">
                                Verrai subito reindirizzato al tuo profilo :)
                            </div>
                          </div>
                        </div>
                <?php
                } 
                else {
                    echo 'Devi inserire un titolo, un sottotitolo, un blog padre, un corpo e un sottoargomento!';  
                }
                //trovo id del post appena creato per mettere foto in multimedia
                $idpost_query = "SELECT `IdPost` FROM `post` WHERE (Titolo = '$titolo')";
                $idpost_result = $mysqli -> query($idpost_query);
                $idpost_row = $idpost_result -> fetch_row();
                //inserisco eventuali foto in cartella uploads e tabella multimedia 
                $countfiles = count($_FILES['file']['name']);
                for ($i=0; $i < $countfiles; $i++) { 
                    $filename = $_FILES['file']['name'][$i];
                    move_uploaded_file($_FILES['file']['tmp_name'][$i],'uploads/'.$filename);
                $stmt = $mysqli->prepare("INSERT INTO `filemultimedia` (IdPost, foto_post) VALUES (?,?)");
                    $stmt->bind_param("ss", $idpost_row[0], $filename);
                    $stmt->execute() or trigger_error($stmt->error, E_USER_ERROR);
                }  
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