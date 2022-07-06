<?php
include "../Accesso/connect.php";
//echo ini_get("session.gc_maxlifetime");
session_start();
$stop = mysqli_real_escape_string($mysqli, $_GET['stop']);
if (isset($stop) && $stop==1){
    //Se lo user non è loggato e non è nemmeno un ospite redirect al login
    if ( isset($_SESSION['user']) || isset($_SESSION['guest'])) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
    		<script type="text/javascript" src="../Generici/menu_laterale.js"></script>
            <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <title> BLOGBUSTER - Homepage </title>
            <meta charset="UTF-8" />
            <meta name="viewport" content="initial-scale=1, maximum-scale=1, minimum-style=1">
            <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.13.0/css/all.css">
            <link rel="stylesheet" type="text/css" href="homepage.css" />
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
                        

                        <a title="Torna alla Home" href="../Homepage/homepage.php?stop=1"> <img src="../Generici/Immagini/logo.png" id="logo"> </a> 
                        
                        <!--BARRA DI RICERCA--> 
                        
                        <div class="frmSearch">
                            <div id="ricerca"><input maxlength="20" type="text" name="scritto" id="scritto" placeholder="Cerca per..."></div>
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

    			
    			<div class="container_corpo">
    				<div class="corpo">
    				    <div id="titolo">
    				    	<h1> SCEGLI TRA I MIGLIORI BLOG, POST E PROFILI  </h1>
    				    </div>

                        <!--BLOG PER TE (INTERESSI + RANDOM)-->
    				    <div id="riga1">
                            <h2 class="title_riga"> BLOG PER TE</h2>
                            <?php
                            
                            $interessi = [];
                            if (isset($_SESSION['user'])){
                                $utente = $_SESSION['user'];
                                $cerca_interessi = "SELECT * FROM `interessi` WHERE NomeUtente = '$utente'";
                                $res_interessi = $mysqli->query($cerca_interessi);
                                $x = 0;
                                while ($x < 3) {
                                    $row_interessi = $res_interessi->fetch_row();                        
                                    $interessi[$x] =  $row_interessi[1];
                                    $x = $x + 1;
                                } 
                               
                            }
                            else if (isset($_SESSION['guest'])){
                                $utente = $_SESSION['guest'];
                                $int1 = $_SESSION['interesseO1'];
                                $int2 = $_SESSION['interesseO2'];
                                $int3 =  $_SESSION['interesseO3'];
                                
                                $interessi[0] = $int1;
                                $interessi[1] = $int2;
                                $interessi[2] = $int3;

                            }
                            
                            $count = 0;

                            $blog_interessi= "SELECT * FROM `blog` WHERE Autore != '$utente' AND (Argomento = '$interessi[0]' OR Argomento = '$interessi[1]' OR Argomento = '$interessi[2]') ORDER BY RAND()";
                            $res_blog_int = $mysqli->query($blog_interessi);
                            $num_blog_int = $res_blog_int->num_rows;
                            
                            if ($num_blog_int < 4) {
                            	$num_blog_int = $num_blog_int;
                            } else {
                            	$num_blog_int = 4;
                            }

                            while ($count < $num_blog_int){

                                $row_blog_int = $res_blog_int->fetch_row();

                                $imageURL = '../Creazione_blog/uploads/'.$row_blog_int[7];
                                $id= $row_blog_int[0];
                                $titolo =  $row_blog_int[1];
                                
                                $descrizione = substr ($row_blog_int[2], 0, 50);
                                $interesse = $row_blog_int [5];
                                $interesse_nome = "SELECT * FROM `argomento` WHERE IdArgomento = '$interesse'";
                                $res_interesse_nome = $mysqli->query($interesse_nome);
                                $row_interesse_nome = $res_interesse_nome->fetch_row();
                                ?>
                                
                                <a href="../Blog/blog.php?id=<?php echo $id ?>&stop=1">
                                    <div style="background-image: url('<?php echo $imageURL;?>')" class="comparsa" >
                                        <p class="blog titolo_blog"> <?php echo $titolo;?></p>
                                        <p class="blog argomenti_blog"> <?php echo $row_interesse_nome[1];?> </p>
                                        <p class="blog descrizione_blog" > <?php echo $descrizione;?></p>
                                    </div>  
                                </a>            
                                


                            <?php
                           		$count = $count + 1;
                                
                            }

                         	$query_cas = "SELECT * FROM `blog` WHERE (Autore != '$utente' AND (Argomento != '$interessi[0]' AND Argomento != '$interessi[1]' AND Argomento != '$interessi[2]')) ORDER BY RAND()";
                         	$result_cas = $mysqli->query($query_cas);

                         	while ($count < 4) {
                                $row_blog_cas = $result_cas->fetch_row();
                                $imageURL = '../Creazione_blog/uploads/'.$row_blog_cas[7];
                                $id= $row_blog_cas[0];
                                $titolo =  $row_blog_cas[1];
                                $descrizione = substr ($row_blog_cas[2], 0, 50);
                                $interesse = $row_blog_cas [5];
                                $interesse_nome = "SELECT * FROM `argomento` WHERE IdArgomento = '$interesse'";
                                $res_interesse_nome = $mysqli->query($interesse_nome);
                                $row_interesse_nome = $res_interesse_nome->fetch_row();
                                $count= $count+1;
                                ?>
                                
                                <a href="../Blog/blog.php?id=<?php echo $id ?>&stop=1">
                                    <div style="background-image: url('<?php echo $imageURL;?>')" class="comparsa" >
                                        <p class="blog titolo_blog"> <?php echo $titolo;?> </p>
                                        <p class="blog argomenti_blog"> <?php echo $row_interesse_nome[1];?> </p>
                                        <p class="blog descrizione_blog" > <?php echo $descrizione;?> ... </p>
                                    </div>  
                                </a>            
                                <?php
                            }
                            ?>
    				    </div>


                        <!--POST PER TE (SOTTOINTERESSI + RANDOM)-->
                         <div id="riga2">
                            <h2 class="title_riga"> POST PER TE</h2>
                            <?php
                            
                            $sottointeressi = [];
                            if (isset($_SESSION['user'])){
                                $utente = $_SESSION['user'];
                                $cerca_sottointeressi = "SELECT * FROM `sottointeressi` WHERE NomeUtente = '$utente'";
                                $res_sottointeressi = $mysqli->query($cerca_sottointeressi);
                                $x = 0;
                                while ($x < 3) {
                                    $row_sottointeressi = $res_sottointeressi->fetch_row();                        
                                    $sottointeressi[$x] =  $row_sottointeressi[1];
                                    $x = $x + 1;
                                } 

                                $post_sottointeressi= "SELECT * FROM `post` WHERE Autore != '$utente' AND (Sottoargomento = '$sottointeressi[0]' OR Sottoargomento = '$sottointeressi[1]' OR Sottoargomento = '$sottointeressi[2]') ORDER BY RAND()";
                                $res_post_sottoint = $mysqli->query($post_sottointeressi);
                                $num_post_sottoint = $res_post_sottoint->num_rows;

                                $query_cas_post = "SELECT * FROM `post` WHERE (Autore != '$utente' AND (Sottoargomento != '$sottointeressi[0]' AND Sottoargomento != '$sottointeressi[1]' AND Sottoargomento != '$sottointeressi[2]')) ORDER BY RAND()";
                                $result_cas_post = $mysqli->query($query_cas_post);
                               
                               
                            }
                            else if (isset($_SESSION['guest'])){
                            $utente = $_SESSION['guest'];
                            $sottoint1 = $_SESSION['sottointO1'];
                            $sottoint2 = $_SESSION['sottointO2'];
                            $sottoint3 =  $_SESSION['sottointO3'];
                            
                            $post_sottointeressi= "SELECT * FROM `post` WHERE Autore != '$utente' AND (Sottoargomento = '$sottoint1' OR Sottoargomento = '$sottoint2' OR Sottoargomento = '$sottoint3') ORDER BY RAND()";
                            $res_post_sottoint = $mysqli->query($post_sottointeressi);
                            $num_post_sottoint = $res_post_sottoint->num_rows;

                            $query_cas_post = "SELECT * FROM `post` WHERE (Autore != '$utente' AND (Sottoargomento != '$sottoint1' AND Sottoargomento != '$sottoint2' AND Sottoargomento != '$sottoint3')) ORDER BY RAND()";
                            $result_cas_post = $mysqli->query($query_cas_post);
                            }   

                            $count = 0;

                            if ($num_post_sottoint > 4){
                                $num_post_sottoint = 4;
                            } else {
                                $num_post_sottoint = $num_post_sottoint;
                            }

                            while ($count < $num_post_sottoint){

                                $row_post_sottoint = $res_post_sottoint->fetch_row();
                                $id_post= $row_post_sottoint[0];
                                $titolo_post =  $row_post_sottoint[1];                            
                                $sottotitolo = substr($row_post_sottoint[2], 0, 25);
                                $sottoint = $row_post_sottoint[4];
                                $blog_padre = $row_post_sottoint [7];

                                //ho l'id del sottoargomento, cerco il suo nome
                                $nome_sottoargomento = "SELECT nome FROM `sottoargomento` WHERE idSottoargomento = '$sottoint'";
                                $res_nome = $mysqli -> query($nome_sottoargomento);
                                $row_nome_sottoargomento = $res_nome -> fetch_row();

                                $caratteristiche_blog = "SELECT * FROM `blog` WHERE CodiceId = '$blog_padre'";
                                $result_caratteristiche = $mysqli -> query($caratteristiche_blog);
                                $row_caratteristiche = $result_caratteristiche -> fetch_row();
                                //prendo le caratteristiche del blog scelto
                                $colore1 = $row_caratteristiche[8];
                                $colore2 = $row_caratteristiche[9];
                                $font = $row_caratteristiche [10];
                                $colore_font = $row_caratteristiche[11];
                                ?>
                                
                                <a href="../Post/post.php?id=<?php echo $id_post ?>&stop=1">
                                     <div style="background-color: <?php echo $colore2;?>" class="comparsa" >
                                        <p class="post2 titolo_post" style="background-color: <?php echo $colore1 ?>; color: <?php echo $colore_font ?>"> <?php echo $titolo_post;?></p>
                                        <p class="post2 argomenti_post"> <?php echo $row_nome_sottoargomento[0];?> </p>
                                        <p class="post2 descrizione_post" > <?php echo $sottotitolo;?></p>
                                    </div>  
                                </a>            
                            <?php
                                $count = $count + 1;
                            }

                            while ($count < 4) {

                                $row_post_cas = $result_cas_post->fetch_row();
                                $imageURL = '../Creazione_post/Immagini/default.jpg';
                                $id_post= $row_post_cas[0];
                                $titolo_post =  $row_post_cas[1];
                                $sottotitolo = substr($row_post_cas[2], 0, 50);
                                $sottointeresse = $row_post_cas [4];
                                $blog_padre = $row_post_cas [7];
                                //ho l'id del sottoargomento, cerco il suo nome
                                $nome_sottoargomento = "SELECT nome FROM `sottoargomento` WHERE idSottoargomento = '$sottointeresse'";
                                $res_nome = $mysqli -> query($nome_sottoargomento);
                                $row_nome_sottoargomento = $res_nome -> fetch_row();

                                $caratteristiche_blog = "SELECT * FROM `blog` WHERE CodiceId = $blog_padre";
                                $result_caratteristiche = $mysqli -> query($caratteristiche_blog);
                                $row_caratteristiche = $result_caratteristiche -> fetch_row();
                                //prendo le caratteristiche del blog scelto
                                $colore1 = $row_caratteristiche[8];
                                $colore2 = $row_caratteristiche[9];
                                $font = $row_caratteristiche [10];
                                $colore_font = $row_caratteristiche[11];
                                
                                ?>
                                
                                <a href="../Post/post.php?id=<?php echo $id_post ?>&stop=1">
                                    <div style="background-color: <?php echo $colore2;?>" class="comparsa" >
                                        <p class="post2 titolo_post" style="background-color: <?php echo $colore1 ?>; color: <?php echo $colore_font ?>"> <?php echo $titolo_post;?> </p>
                                        <p class="post2 argomenti_post"> <?php echo $row_nome_sottoargomento[0];?> </p>
                                        <p class="post2 descrizione_post" > <?php echo $sottotitolo;?> ... </p>

                                    </div>  
                                </a>            
                                
                                <?php

                                $count= $count+1;
                            }


                            ?>
                        </div>


                        <!--POST PIU VISITATI (LIKES)-->
    				    <div id="riga3">
                            <h2 class="title_riga"> I POST PIÙ VISITATI </h2>
                            <?php
                            
                            $conta_reactions = "SELECT COUNT(*), IdPost FROM `reactions` GROUP BY `IdPost` ORDER BY COUNT(*) DESC";
                            $res_conta_reactions = $mysqli->query($conta_reactions);          
                            $count = 0;
                            while ($count < 4){

                                $row_conta_reactions = $res_conta_reactions->fetch_row();
                               	$id_top_post = $row_conta_reactions[1];
                               	$trova_post = "SELECT * FROM `post` WHERE IdPost='$id_top_post'";
                               	$result_trova = $mysqli->query($trova_post);
                               	$post_trovato = $result_trova->fetch_row();
                                $imageURL = '../Creazione_post/Immagini/default.jpg';
                                $titolo =  $post_trovato[1];
                                $sottotitolo = $post_trovato[2];
                                $interesse = $post_trovato[4];
                                $blog_padre = $post_trovato [7];
                                $altro_argomento= $post_trovato [9];
                                if ($interesse != null) {
                                     //ho l'id del sottoargomento, cerco il suo nome
                                    $nome_sottointeresse = "SELECT nome FROM `sottoargomento` WHERE idSottoargomento = '$interesse'";
                                    $res_nome_sottointeresse = $mysqli -> query($nome_sottointeresse);
                                    $row_nome_sottointeresse = $res_nome_sottointeresse -> fetch_row();
                                    $interesse= $row_nome_sottointeresse[0];
                                } else{
                                    $interesse =  $altro_argomento;
                                }
                                $caratteristiche_blog = "SELECT * FROM `blog` WHERE CodiceId = $blog_padre";
                                $result_caratteristiche = $mysqli -> query($caratteristiche_blog);
    						    $row_caratteristiche = $result_caratteristiche -> fetch_row();
    						    //prendo le caratteristiche del blog scelto
    						    $colore1 = $row_caratteristiche[8];
    						    $colore2 = $row_caratteristiche[9];
    						    $font = $row_caratteristiche [10];
    						    $colore_font = $row_caratteristiche[11];
                                
                                ?>
                                
                                <a href="../Post/post.php?id=<?php echo $id_top_post ?>&stop=1">
                                    <div style="background-color: <?php echo $colore2;?>" class="comparsa" >
                                      
                                        <p class="post titolo_post" style="background-color: <?php echo $colore1 ?>; color: <?php echo $colore_font ?>"> <?php echo $titolo;?> </p>
                                        <p class="post argomenti_post"> <?php echo $interesse;?> </p>
                                        <p class="post descrizione_post" >  <?php echo $sottotitolo;?> </p>
                                    </div>  
                                </a>

                            <?php
                                $count = $count + 1;
                            }

                            ?>
    				    </div>
                        <!--PROFILI( RANDOM) con descrizione o interessi mostrati on hover-->
    				    <div id="riga4">
                            <h2 class="title_riga"> VISITA QUALCHE NUOVO PROFILO </h2>
                            <?php
                            
                            $utenti = "SELECT * FROM `utente` WHERE NomeUtente != '$utente' ORDER BY RAND() LIMIT 4";
                            $res_utenti = $mysqli->query($utenti); 
                            $num_utenti = $res_utenti->num_rows;
                            $count = 0;
                            
                            //se gli account che trovo sono 4 o più di 4 ne utilizzo 4, altrimenti se sono meno di 4 utilizzo quelli che trovo
                            if ($num_utenti >= 4) {
                                $num_utenti = 4;
                            } else {
                                $num_utenti = $num_utenti;
                            }

                            while ($count < $num_utenti){

                                $row_profilo = $res_utenti->fetch_row();
                                $nome_utente = $row_profilo[0]; 
                                $descrizione_utente = substr($row_profilo[2], 0, 40);

                                if (is_null($row_profilo[3])){
                                	$image_profilo = '../Profilo/uploads/default.jpg';
                                } else {
                                	$image_profilo = '../Profilo/uploads/'.$row_profilo[3];
                                }
                                
    	                        $cerca_interessi_profilo = "SELECT * FROM `interessi` WHERE NomeUtente = '$nome_utente'";
    	                        $res_interessi_profilo = $mysqli->query($cerca_interessi_profilo);
    	                        $num_rows_interessi_profilo = $res_interessi_profilo->num_rows;
    	                        $x = 0;
    	                        while ($x < $num_rows_interessi_profilo) {
    	                            $row_interessi_profilo = $res_interessi_profilo->fetch_row();                        
    	                            
    	                            $argomenti_profilo = "SELECT * FROM `argomento` WHERE IdArgomento = '$row_interessi_profilo[1]' ";
    	                            $res_argomenti_profilo = $mysqli->query($argomenti_profilo);
    	                            $row_argomenti_profilo = $res_argomenti_profilo->fetch_row();

    	                            $interesse_profilo[$x] = $row_argomenti_profilo[1]; #prendo il nome di quell'argomento selezionato
    	                            $x = $x + 1;
    	                        }    
                                ?>
                                <a href="../Profilo/profilo.php?id=<?php echo $nome_utente ?>&stop=1">
                                    <div  class="comparsa comparsa_profilo" >
                                        <p class="profilo nome_utente" > <?php echo $nome_utente;?></p>
                                        <img src="<?php echo $image_profilo;?>" class="foto_profilo_piccola" >

                                        <?php 
                                        /* se la descrizione non c'è mette gli interessi*/
                                        if (is_null($row_profilo[2])){ 
                                        ?>
                                        	<p class="profilo interesse_utente int1"> <?php echo $interesse_profilo[0];?></p>
                                        	<p class="profilo interesse_utente int2"> <?php echo $interesse_profilo[1];?></p>
                                        	<p class="profilo interesse_utente int3"> <?php echo $interesse_profilo[2];?></p>
                                        <?php 
                                    	} else {
                                        ?>
                                        	<p class="profilo descrizione_utente"> <?php echo $descrizione_utente;?><i>... continua a leggere</i></p>
                                        <?php
                                        }
                                        ?>
                                    </div>  
                                </a>            
                                
                            <?php
                                $count = $count + 1;
                            }
                            ?>
    				    </div>
    				</div>
            	</div>
            </div>	
        </body>
    </html>

<?php
	} else {
	    header("Location: ../Accesso/index.php?stop=1");
	};
} else {
    header("Location: ../Accesso/index.php?stop=1");
};
?>



