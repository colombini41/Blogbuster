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
$stop = mysqli_real_escape_string($mysqli, $_GET['stop']);
if(isset($stop) && $stop==1){
    //Se lo user non è loggato e non è nemmeno un ospite redirect al login
    if (isset($_SESSION['user'])) {

        $idBlog = mysqli_real_escape_string($mysqli, $_GET['idBlog']);
        $stile_blog = "SELECT * FROM `blog` WHERE CodiceId='$idBlog'";
        $res_blog = $mysqli->query($stile_blog);
        $fetch_blog = $res_blog->fetch_row();;
        $col1 = $fetch_blog[8];
        $col2 = $fetch_blog[9];
        $stile_font = $fetch_blog[10];
        $colore_font = $fetch_blog[11];
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
            <link rel="stylesheet" type="text/css" href="modifica_blog.css" />
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
                        

                        <a title="Torna alla Home" href="../Homepage/homepage.php?stop=1"> <img src="../Generici/Immagini/logo.png" id="logo"> </a> 
                        
                        <!--BARRA DI RICERCA--> 
                        
                        <div class="frmSearch">
                            <div id="ricerca"><input type="text" name="scritto" id="scritto" placeholder="Cerca per..." maxlength="20" style='background-color: white; transform: translateY(100%);'></div>
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
                        <h1 id="titoletto"> MODIFICA LO STILE DEL TUO BLOG </h1>
                        <div class="quadrato">
                            <form method="post" enctype="multipart/form-data" id="crea_blog" name="crea_blog">
                                
                                
                                <p id="all"> Modifica la coppia di colori del tuo blog: </p>
                                <p id="label_fs"> Scegli un font e il suo colore </p>
                                <div id="campi_sx">  
                                    <canvas id="color-picker1"></canvas>
                                    <input id="changeMe" name="changeMe" class="color_picker"/>
                                    <script> 
                                        new KellyColorPicker({
                                            place : 'color-picker1', 
                                            size : 100, 
                                            input : 'changeMe', 
                                            color: '<?php echo $col1; ?>' 
                                        });
                                    </script>


                                   

                                    <select id="fs" name="fs"> 
                                        <option style="font-family: Quicksand" value="Quicksand">Quicksand</option>
                                        <option style="font-family: Montserrat"value="Montserrat">Montserrat</option>
                                        <option style="font-family: Impact" value="Impact">Impact</option>
                                        <option style="font-family: Langar" value="Langar">Langar</option>
                                        <option style="font-family: Dancing Script" value="Dancing Script">Dancing Script</option>
                                    </select> 
                                </div>
                                <input id="changeMe2" name="changeMe2" class="color_picker"  />
                                <div id="campi_dx">

                                    <canvas id="color-picker2"></canvas>
                                    <input id="changeMe1" name="changeMe1" class="color_picker"/>
                                    <script> 
                                        new KellyColorPicker({
                                            place : 'color-picker2', 
                                            size : 100, 
                                            input : 'changeMe1',  
                                            color: '<?php echo $col2 ?>'
                                        });
                                    </script>


                                    <p id="label_text_color">  </p>
                                    
                                    <canvas id="color-picker3"></canvas>
                                    
                                    <script> 
                                        new KellyColorPicker({
                                            place : 'color-picker3', 
                                            size : 100,  
                                            input : 'changeMe2', 
                                            color: '<?php echo $colore_font ?>'
                                        });
                                    </script>
                                </div>


                                <script>
                                    $(function(){
                                        $("#fs").change(function() {                  
                                            $('#changeMe2').css("font-family", $(this).val());
                                            $('#changeMe2').css("font-size", "12");
                                        });

                                        $("#changeMe2").click(function() {
                                            $("#changeMe2").css("color", $(this).val());
                                        });                                

                                    });
                                </script>

                                <div id="bottoni_invio">
                                        <input type="reset" value="Indietro" id="indietro" onclick="window.location.href='../profilo/profilo.php?stop=1'"/>
                                        <input type="submit" value="Modifica" id="modifica" name="modifica" href="#popup_modifica"/>
                                        
                                </div>          
                            </form> 
                        </div>
                    </div>
                </div>
            </div>
            <br/>

            <?php
                if(isset($_POST['modifica'])) {
                //prendo variabili post
                    $font_fs = $_POST['fs'];
                    $font_color = $_POST['changeMe2'];
                    $color1 = $_POST['changeMe']; 
                    $color2 = $_POST['changeMe1'];
                    

                    //inserisco in tabella blog
                    $stmt = $mysqli->prepare("UPDATE `blog` SET Colore1=?, Colore2=?, Font=?, ColoreFont=? WHERE CodiceId=?");
                    $stmt->bind_param("ssssi", $color1, $color2, $font_fs, $font_color, $idBlog);
                    $stmt->execute() or trigger_error($stmt->error, E_USER_ERROR); 
                      
            ?>

            <div id="popup1" class="overlay">
                <div class="popup">
                    <h2>HAI MODIFICATO LO STILE DEL TUO BLOG</h2>
                    <a class="close" href="../Blog/blog.php?id=<?php echo $idBlog ?>&stop=1">&times;</a>
                    <div class="contentP">
                        Hai modificato con successo le caratteristiche del tuo blog, al quale sarai adesso reindirizzato!
                    </div>
                </div>
            </div>

            <?php 
                }
            ?>

        </body>
    </html>

    <?php 
        
    //se utente non loggato riporta a index    
    } else {
        header("Location: ../Accesso/index.php?stop=1");
    }
} else {
    header('Location: ../Accesso/index.php');
}
?>