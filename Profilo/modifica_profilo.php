<?php
include "../Accesso/connect.php";
session_start();
$stop = mysqli_real_escape_string($mysqli, $_GET['stop']);
if(isset($stop) && $stop==1){
	$nome_utente = $_SESSION['user'];

	if (isset($_POST['conferma_modifiche'])) {
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
		        $modifica_foto = md5($imgfile).$extension;
		        // Codice per caricare l'immagine della cartella uploads
		        move_uploaded_file($_FILES["file"]["tmp_name"],"uploads/".$modifica_foto);

		        $stmt_foto = $mysqli->prepare("UPDATE `utente` SET FotoProfilo=? WHERE NomeUtente=?");

				$stmt_foto->bind_param("ss", $modifica_foto, $nome_utente);
				$stmt_foto->execute() or trigger_error($stmt_foto->error, E_USER_ERROR);
				header("Location: profilo.php?stop=1");
				
    
		    } 
		}
		

		if (($_POST['text_descrizione'])==""){
			  header("Location: profilo.php?stop=1");
		} else {
			$nuova_descrizione= $_POST['text_descrizione'];
			$stmt_descrizione = $mysqli->prepare("UPDATE `utente` SET Descrizione=? WHERE NomeUtente=?");
			
			$stmt_descrizione->bind_param("ss", $nuova_descrizione, $nome_utente);
			$stmt_descrizione->execute() or trigger_error($stmt_descrizione->error, E_USER_ERROR);
	        header("Location: profilo.php?stop=1");
    
		}

	}
} else {
	header("Location: ../Accesso/index.php?stop=1");
}
    

    ?>