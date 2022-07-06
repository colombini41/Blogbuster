
<?php
#CONTROLLO LATO SERVER PER USERNAME DISPONIBILE
include 'connect.php';

$stop = mysqli_real_escape_string($mysqli, $_GET['stop']);
if (isset($stop) && $stop==1){
    if(isset($_POST['nome_utente'])){
         $nome_utente = $_POST['nome_utente'];
         $query = "SELECT count(*) as cntUser from utente where NomeUtente='".$nome_utente."'";
         $result = mysqli_query($mysqli,$query);

         $response = "<span id= '0'  class = 'span_controllo' style='color: #00FF7F;'>Questo nome utente è disponibile!</span>";

         if(mysqli_num_rows($result)){
            $row = mysqli_fetch_array($result);

            $count = $row['cntUser'];
          
            if($count > 0) {
                $response = "<span id= '1' class = 'span_controllo' style='color: red;'>Il nome utente non è disponibile, peccato!</span>";
            }
         echo $response;
         die;
        } 
    }
} else {
  header('Location: ../Accesso/index.php');
}
?>