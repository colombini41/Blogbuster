<?php
#CONTROLLO LATO SERVER PER USERNAME DISPONIBILE
include '../Accesso/connect.php';

$stop= mysqli_real_escape_string($mysqli, $_GET['stop']);
if (isset($stop) && $stop==1){
  if(isset($_POST['coautore'])){
     $coautore = $_POST['coautore'];
     $query = "SELECT count(*) as cntUser from utente where NomeUtente='".$coautore."'";
     $result = mysqli_query($mysqli, $query);
     $response = "<span id= '0'  class = 'span_controllo'></span>";
    
     if(mysqli_num_rows($result)){
        $row = mysqli_fetch_array($result);
        $count = $row['cntUser'];
      
        if($count > 0) {
            $response = "<span id= '1' class = 'span_controllo'></span>";
        }
     echo $response;
     die;
    } 
  }
} else {
  header('Location: ../Accesso/index.php');
}
?>