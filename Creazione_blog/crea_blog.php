<style>
@import url('https://fonts.googleapis.com/css?family=Montserrat');
@import url('https://fonts.googleapis.com/css?family=Open+Sans');
@import url('https://fonts.googleapis.com/css?family=Quicksand&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Vibes&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Baloo+Tammudu+2&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Langar&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Bungee+Outline&family=Dancing+Script&display=swap');
</style>

<?php
include "../Accesso/connect.php";
session_start();
$stop= mysqli_real_escape_string($mysqli, $_GET['stop']);
if (isset($stop) && $stop==1){
    //Se lo user non è loggato e non è nemmeno un ospite redirect al login
    if (isset($_SESSION['user'])) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <script type="text/javascript" src="../Generici/menu_laterale.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
            <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <script type="text/javascript" src="crea_blog.js"></script>
            <script src="html5kellycolorpicker.min.js"></script>
            <script src="html5kellycolorpicker.js"></script>
            <title> BLOGBUSTER - Crea blog </title>
            <meta charset="UTF-8" />
            <meta name="viewport" content="initial-scale=1, maximum-scale=1, minimum-style=1">
            <link rel="stylesheet" type="text/css" href="../Generici/generico.css" />
            <link rel="stylesheet" type="text/css" href="crea_blog.css" />
            
        </head>
        <body>
            <div class="container">
                <div class="container_menu_laterale">
                        <div class="menu_laterale">
                            <?php
                                if (isset($_SESSION['user'])) {
                                    $user = "Benvenuto, ". $_SESSION['user'] . " ";
                                    echo "<p style='color:black' id='utente_r'>".$user."&#8595 </p>";

                                } else {
                                    $guest = "Benvenuto, guest_". $_SESSION['guest'] . " ";
                                    echo "<p style='color:black' id='utente_o'>".$guest." </p>";
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
                            
                            <div class="frmSearch" >
                                <div id="ricerca">
                                    <input type="text" name="scritto" id="scritto" placeholder="Cerca per blog, post o nome utente..." maxlength="20">
                                </div>
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
                                    <p id="p_accedi_ospite" style="color: black">Accedi o registrati</p>
                                    <i class="fas fa-sign-in-alt"></i>
                                </div>
                                <?php
                            }
                            ?>

                        
                        </div>
                    </div>

        		<div class="container_corpo">
        			<div class="corpo">
                        <h1 id="titoletto"> CREA IL TUO BLOG </h1>
        				<div class="quadrato">
                            <form method="post" enctype="multipart/form-data" id="crea_blog" name="crea_blog">
                                <p id="all"> Scegli una coppia di colori per il tuo blog: </p>
                                <div id="campi_sx1">
                                    <p id="titolo">Titolo:</p>
                                    <input type = "text" id = "titolo_blog" name = "titolo_blog" class="crea_blog_caratteristiche" maxlength="20" required/>
                                    <!-- selezione degli interessi -->
                                    <p id="argomento_testo">Scegli un argomento:</p> 
                                    <select class="argomento" id= "argomento" name= "argomento" >
                                            <option value= ""> ------- </option>
                                            <option value= "Sport"> Sport </option>
                                            <option value= "Elettronica"> Elettronica </option>
                                            <option value= "Intrattenimento"> Intrattenimento</option>
                                            <option value= "Informazione"> Informazione </option>
                                            <option value= "Stile"> Stile </option>
                                            <option value= "Alimentazione"> Alimentazione </option>
                                            <option value= "Mondo"> Mondo </option>
                                            <option value= "Scrittura"> Scrittura </option>
                                            <option value= "Salute"> Salute </option>
                                            <option value= "Altro"> Altro </option>
                                    </select>
                                    <br/><br/>
                                    <input type = "text" id = "altro" name = "altro" class="crea_blog_caratteristiche" placeholder="Inserisci un argomento" />
                                    <script>
                                    $(function()  {
                                        $('#argomento').change(function() {
                                            if ($('#argomento').val() == 'Altro') {
                                                $('#altro').css("display","block");
                                            }
                                            else {
                                                $('#altro').css("display","none");
                                            }
                                        });
                                    });
                                    </script>
                                    <p id="descrizione_testo">Descrivi il tuo blog:</p>
                                    <textarea name="descrizione" maxlength="100"></textarea>
                                    
            						
                                </div>
                                <div id="campi_dx1">
                                    <p id="foto_testo">Scegli la foto:</p>
                                    <input type= "file" id= "file" name= "file" accept= "image/*" onchange="loadFile_blog(event)"/> 
                                    <img id="anteprima" src="Immagini/default.jpg"/> 

                                    <p id="coautore_testo">Coautore:  </p>
                                    <input type= "text" name= "coautore" id= "coautore" placeholder= "Facoltativo">
                                    <div id="response" ></div>
                                </div>
                                
                                <div id="campi_sx2">
                                    
                                    <canvas id="color-picker1"></canvas>
                                    <input id="changeMe" name="changeMe"/>
                                    <script> 
                                        new KellyColorPicker({
                                            place : 'color-picker1', 
                                            size : 100, 
                                            input : 'changeMe', 
                                            color: '#87CEEB' 
                                        });
                                    </script>


                                    <select id="fs" name="fs"> 
                                        <option style="font-family: Quicksand" value="Quicksand">Quicksand</option>
                                        <option style="font-family: Montserrat"value="Montserrat">Montserrat</option>
                                        <option style="font-family: Impact"value="Impact ">Impact </option>
                                        <option style="font-family: Langar" value="Langar">Langar</option>
                                        <option style="font-family: Dancing Script" value="Dancing Script">Dancing Script</option>
                                    </select> 
                                    
                                </div>
                                <p id="p_fs" style="display: none;"> Scegli un font e il suo colore </p>
                                <div id="campi_dx2">

                                    <canvas id="color-picker2"></canvas>
                                    <input id="changeMe1" name="changeMe1"/>
                                    <script> 
                                        new KellyColorPicker({
                                            place : 'color-picker2', 
                                            size : 100, 
                                            input : 'changeMe1',  
                                            color: '#87CEEB'
                                        });
                                    </script>

                                    <canvas id="color-picker3"></canvas>
                                    <input id="changeMe2" name="changeMe2" class="color_picker"  />
                                    <script> 
                                        new KellyColorPicker({
                                            place : 'color-picker3', 
                                            size : 100,  
                                            input : 'changeMe2', 
                                            color: '#87CEEB'
                                        });
                                    </script>
                                </div>
                                
                                

                                <script>
                                $(function()  { 
                                    $("#coautore").keyup(function(){
                                        var coautore = $(this).val().trim();
                                        if(coautore != ''){
                                            $.ajax({
                                                url: 'check_coautore.php?stop=1',
                                                type: 'post',
                                                data: {
                                                    coautore: coautore,

                                                 },
                                                success: function(response){
                                                    $('#response').html(response);
                                                    if ($(".span_controllo").get(0).id == "0") {
                                                        $('#avanti').attr("disabled", true);
                                                        $('#coautore').css({"border": "4px solid red"});
                                                    } else {
                                                        $('#avanti').attr("disabled",false);
                                                        $('#coautore').css({"border": "4px solid green"});
                                                    }
                                                }
                                        }); 
                                           
                                        } else {
                                            $('#avanti').attr("disabled",false);
                                            $('#coautore').css({"border": "4px solid green"});
                                            $("#response").html("");
                                        }

                                        });
                                });
                                </script>
        					    <script>
        					    $(function(){
                                    $("#color1").change(function() {
                                        $("#changeMe").css("background-color", $(this).val());
                                    });

                                    $("#color2").change(function() {
                                        $("#changeMe1").css("background-color", $(this).val());
                                    });

                                    $("#fs").change(function() {				  
        						   		$('#changeMe2').css("font-family", $(this).val());
                                        $('#changeMe2').css("font-size", "12");
                                    });

        							$("#changeMe2").change(function() {
                                            $("#changeMe2").css("color", $(this).val());
                                    });    
                                    
                                });                               

        						
        						</script>

                                <script >
                                var loadFile_blog = function(event) {
                                    $dimensione_massima = 4500000;
                                    if (event.target.files[0].size < $dimensione_massima) {
                                        var output = document.getElementById('anteprima');
                                        output.src = URL.createObjectURL(event.target.files[0]);
                                        output.onload = function() {
                                            URL.revokeObjectURL(output.src) // free memory
                                        };
                                    } else { 
                                        alert ("L'immagine è troppo grande!");

                                    }
                                }
                                
                                </script>


                                <div id="bottoni_avanti">
                                    <input type="button" value="Annulla" id="annulla" onclick="window.location.href='../Homepage/homepage.php?stop=1'" />
                                    <input type="button" value="Avanti" id="avanti" name="avanti"/>
                                </div>

                                <div id="bottoni_invio">
                                    <input type="button" value="Indietro" id="indietro"/>
                                    <input type="submit" value="Crea" id="crea" name="crea" href="#popup1"/>
                                </div>			
                            </form>	
        				</div>
                    </div>
                    <br/>
                    
        			
        		</div>



        	</div>

                <!--caricamento dei dati e controllo che titolo argomento e descrizione non siano vuoti-->
            <?php
                if(isset($_POST['crea'])) {
                //prendo variabili post
                    if(!empty($_POST['titolo_blog']) && !empty($_POST['argomento']) && !empty($_POST['descrizione'])){
                        $titolo=$_POST['titolo_blog'];
                        $argomento=$_POST['argomento'];
                        $descrizione=$_POST['descrizione'];
                        if (($_POST['coautore'])==null){
                            $coautore = null;
                        } else {
                            $coautore =  $_POST['coautore'];
                        }
                        $nome_utente = $_SESSION['user']; 
                        $font_fs = $_POST['fs'];
                        $font_color = $_POST['changeMe2'];
                        $color1 = $_POST['changeMe']; 
                        $color2 = $_POST['changeMe1'];
                        if  ($argomento == "Altro") {
                            $altro = $_POST['altro'];
                        } else {
                            $altro = null;
                        }

                        //controllo variabili post
                        
                        
                    
                    	$imgfile=$_FILES["file"]["name"];
                    	//controllo immagine
                    	if (!empty($imgfile)) {
                        $extension = substr($imgfile, strlen($imgfile)-4, strlen($imgfile));    
                    	$allowed_extensions = array(".jpg",".jpeg",".png",".gif", ".JPG", ".JPEG", ".PNG", ".GIF");
                        
                            if(!in_array($extension, $allowed_extensions)) {
                            	echo "<script>alert('Invalid format. Only jpg / jpeg / png / gif format allowed');</script>";
                        	} 
                        	else {
                            	//per evitare confusione nel momento in cui due utenti caricano un'immagine con lo stesso nome
                            	$imgnewfile = md5($imgfile).$extension;
                            	// Codice per caricare l'immagine della cartella uploads
                            	move_uploaded_file($_FILES["file"]["tmp_name"],"uploads/".$imgnewfile);
                        	} 
                        }
                        else{
                            $imgnewfile='default.jpg';
                        }
                        //trovo id sottoargomento
                        $argomento_query= "SELECT `IdArgomento` FROM `argomento` WHERE (Nome = '$argomento')";
                        $argomento_result = $mysqli -> query($argomento_query);
                        $argomento_row = $argomento_result -> fetch_row();

                            //inserisco in tabella blog
                            $stmt = $mysqli->prepare("INSERT INTO `blog` (Titolo, Descrizione, Autore, Coautore, Argomento, AltroArgomento, FotoBlog_path, Colore1, Colore2, Font, ColoreFont) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
                            $stmt->bind_param("sssssssssss", $titolo, $descrizione, $nome_utente, $coautore, $argomento_row[0], $altro, $imgnewfile, $color1, $color2, $font_fs, $font_color);
                            $stmt->execute() or trigger_error($stmt->error, E_USER_ERROR);  
                      
                        ?>
                        <div id="popup1" class="overlay">
                          <div class="popup">
                            <h2>IL TUO BLOG È STATO CREATO CON SUCCESSO</h2>
                            <a class="close" href="../Profilo/profilo.php?stop=1">&times;</a>
                            <div class="contentP">
                              Verrai subito reindirizzato al tuo profilo per continuare a navigare in Blogbuster :)
                            </div>
                          </div>
                        </div>
                		

                		<?php
                
                    } else {
                        echo 'Devi inserire un titolo, un argomento e una descrizione!';  
                    }
                }
        ?>


        </body>
    </html>

    <?php 
        
    //se utente non loggato riporta a index    
    } else {
        header("Location: ../Accesso/index.php");
    }
} else {
    header("Location: ../Accesso/index.php");
}

?>