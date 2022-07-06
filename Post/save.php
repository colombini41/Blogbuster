<?php
include "../Accesso/connect.php";
session_start();
$stop = mysqli_real_escape_string($mysqli, $_GET['stop']);
if(isset($stop) && $stop==1){
     
    $reaction = $_POST['value'];
    $user = $_SESSION['user'];
    $idPost = mysqli_real_escape_string($mysqli, $_GET['id']);
         
    $query_controllo = "SELECT * FROM `reactions` WHERE (Utente='$user' AND IdPost='$idPost')";
    $result_controllo = $mysqli->query($query_controllo);

    if ($result_controllo->num_rows == 0 ){
        $query_inserimento = "INSERT INTO `reactions` (IdPost, Utente, Reaction) VALUES ('$idPost', '$user','$reaction')";
        $result_inserimento = $mysqli->query($query_inserimento);
    } else if ($reaction != "null"){
    	$query_modifica = "UPDATE `reactions` SET Reaction = '$reaction' WHERE IdPost = '$idPost' AND Utente = '$user'";
    	$result_modifica = $mysqli->query($query_modifica);
    } else {
    	$query_elimina = "DELETE FROM `reactions` WHERE (Utente='$user' AND IdPost='$idPost') ";
    	$result_elimina = $mysqli->query($query_elimina);
    }
} else {
    header("Location: ../Accesso/index.php?stop=1");
}



?>