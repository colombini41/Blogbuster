<?php
include "../Accesso/connect.php";
session_start();
$stop = mysqli_real_escape_string($mysqli, $_GET['stop']);
if(isset($stop) && $stop==1){
	if ( isset($_SESSION['user'])) {
		$user = $_SESSION['user'];
		//CERCO BLOG DELL'AUTORE CHE HANNO COAUTORE - METTO NOME COAUTORE IN CAMPO AUTORE E SETTO COAUTORE A NULL 
		$cerca_blog_SC = "SELECT * FROM `blog` WHERE Autore = '$user' AND Coautore is not null";
		$res_cerca = $mysqli->query($cerca_blog_SC);
		$num_cerca = $res_cerca->num_rows;
		$i = 0;
		while ($i < $num_cerca) {
			$row_cerca = $res_cerca->fetch_row();
			$coautore = $row_cerca[4];
			$codice =  $row_cerca[0];
			$update_autore = "UPDATE `blog` SET Autore = '$coautore' WHERE CodiceId  = '$codice'";
			$res_update = $mysqli->query($update_autore);

			$delete_coautore = "UPDATE `blog` SET Coautore = NULL WHERE CodiceId = '$codice'";
			$res_delete = $mysqli->query($delete_coautore);
			if ($mysqli->query($update_autore) === TRUE && $mysqli->query($delete_coautore)) {
				printf("UTENTE ELIMINATO CON SUCCESSO");
			} else {
				echo($mysqli->error);
			}

			$i = $i + 1;
		}
		//ELIMINO TUTTI I BLOG IN CUI L'AUTORE E' L'UTENTE REGISTRATO (SE UN BLOG AVEVA UN COAUTORE E' GIA' STATA MODIFCIATA LA SUA RIGA, QUINDI NON VIENE ELIMINATO)
		//POST DEL BLOG, INTERESSI, SOTTOINTERESSI E FILE- COMMENTI-REACTION DEI POST DEL BLOG SI ELIMINANO IN AUTOMATICO X VINCOLI
		$elimina_profilo = "DELETE FROM `utente` WHERE NomeUtente = '$user'";
		$res_elimina_p = $mysqli->query($elimina_profilo);
		if ($mysqli->query($elimina_profilo) === TRUE) {
			session_destroy();
			header('Location: ../Accesso/index.php');
			
		} else {
			echo($mysqli->error);
		}
	}else {
		echo "boh";
	}
} else {
	header('Location: ../Accesso/index.php');
}
?>

