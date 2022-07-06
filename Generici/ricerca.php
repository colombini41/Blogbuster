<?php
include'../Accesso/connect.php';
session_start();

$stop = mysqli_real_escape_string($mysqli, $_GET['stop']);
if(isset($stop) && $stop==1){
    $chiave = $_POST["keyword"];
    if(!empty($chiave)) {
        $query_blog="SELECT * FROM blog, argomento WHERE (blog.Titolo LIKE '%$chiave%') OR ((argomento.Nome LIKE '%$chiave%') AND (blog.Argomento = argomento.IdArgomento)) OR (blog.AltroArgomento LIKE '%$chiave%') GROUP BY blog.Titolo";
        $query_post ="SELECT * FROM post WHERE ((post.Titolo LIKE '%$chiave%') OR (post.Sottoargomento LIKE '%$chiave%')) OR (post.AltroSottoargomento LIKE '%$chiave%') GROUP BY post.Titolo";
        $query_utente_profilo ="SELECT * FROM utente WHERE utente.NomeUtente LIKE '%$chiave%'";
        
        $result_b = $mysqli->query($query_blog);
        $result_p = $mysqli->query($query_post);
        $result_up = $mysqli->query($query_utente_profilo);


        if(!empty($result_b)||!empty($result_p)||!empty($result_up)) {
            ?>
            <ul id="list">
                <li class="divisori" >BLOG</li>
                <?php
                $b=0;
                $p=0;
                $u=0;
                foreach($result_b as $risultato_blog) if($b<3) {                     
                    ?>
                    <li onClick="location.href = '../Blog/blog.php?id=<?php echo $risultato_blog["CodiceId"] ?>&stop=1'"><?php echo $risultato_blog["Titolo"]; ?></li>
                    <?php
                    $b= $b + 1;    
                }
                ?>
                <li class="divisori">POST</li>
                <?php
                foreach($result_p as $risultato_post) if ($p<3) {                       
                    ?>
                    <li onClick="location.href = '../Post/post.php?id=<?php echo $risultato_post["IdPost"] ?>&stop=1'"><?php echo $risultato_post["Titolo"]; ?></li>
                    <?php  
                    $p= $p + 1;   
                }
                ?>
                <li class="divisori">UTENTI</li>
                <?php
                foreach($result_up as $risultato_utente) if($u<3) {                     
                    ?>
                    <li onClick="location.href = '../Profilo/profilo.php?id=<?php echo $risultato_utente["NomeUtente"] ?>&stop=1'"><?php echo $risultato_utente["NomeUtente"]; ?></li>
                    <?php   
                    $u= $u + 1; 
                }
                ?>
            </ul>
            <?php 
        } 
    }
} else {
    header('Location: ../Accesso/index.php');
}
?>
