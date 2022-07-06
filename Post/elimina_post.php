<?php
include "../Accesso/connect.php";
session_start();
$stop = mysqli_real_escape_string($mysqli, $_GET['stop']);
if(isset($stop) && $stop==1){
	if (isset($_SESSION['user'])) {
		$idPost= mysqli_real_escape_string($mysqli, $_GET["id"]);
	 	$elimina_post = "DELETE FROM `post` WHERE IdPost='$idPost'";
	 	$res_elimina = $mysqli->query($elimina_post);
	 	if ($mysqli->error)  {
			echo "Error: " . $elimina_post . "<br>" . $mysqli->error;
	 	} else {
	 		header("Location: ../Profilo/profilo.php?stop=1");
	 	}
	} else {
	        header("Location: ../Accesso/index.php");
	}
} else {
        header("Location: ../Accesso/index.php");
}
?>