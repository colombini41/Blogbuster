<?php
include "../Accesso/connect.php";
session_start();
$stop = mysqli_real_escape_string($mysqli, $_GET['stop']);
$idBlog = mysqli_real_escape_string($mysqli, $_GET['idBlog']);
if(isset($stop) && $stop==1){
	if (isset($idBlog) && !isset($_GET['elimina'])) {
		if (isset($_SESSION['user'])) {
		?>
			<!DOCTYPE html>
			<html lang="en">
				<head>
			        <link rel="stylesheet" type="text/css" href="../Generici/generico.css"/>
			    </head>
				<body>
					<!--POP UP CHE APPARE PER ELIMINAZIONE BLOG-->
			        <div id="popup_elimina" class="overlay">
			        	<div class="popup">
				            <h2> VUOI DAVVERO ELIMINARE QUESTO BLOG?</h2>
				            <div class="contentP">
				             Non potrai più annullare questa azione.
				            </div>
				            <input type="button" id="annulla_elimina" name="annulla_elimina" style="border: 1px solid black; font-size: 12px; color: white; background-color: #669D; cursor: pointer" value="Annulla" onclick="window.location.href='../Profilo/profilo.php?stop=1'"> 
				            <input type="button" id="conferma_elimina" name="conferma_elimina"style="border: 1px solid black; font-size: 12px; color: white; background-color: #669D; cursor: pointer" value="Elimina" onclick="window.location.href='../Profilo/elimina_blog.php?idBlog=<?php echo $idBlog ?>&elimina=1&stop=1'"> 
			          	</div>
			        </div>
				</body>	
		<?php
		}
	} else if (isset($_GET['elimina']) && mysqli_real_escape_string($mysqli, $_GET['elimina']== 1)){
		$idBlog=  mysqli_real_escape_string($mysqli, $_GET["idBlog"]);
		$stmt_elimina_blog = $mysqli->prepare("DELETE FROM `blog` WHERE CodiceId=?");
		$stmt_elimina_blog->bind_param("i", $idBlog);
	    $stmt_elimina_blog->execute() or trigger_error($stmt_elimina_blog->error, E_USER_ERROR); 
	    if ($stmt_elimina_blog->execute()){
	    	header('Location: ../Profilo/profilo.php?stop=1');
	    }
		else {
			header('Location: ../Profilo/profilo.php?stop=1');
		}
	}	
} else {
    header("Location: ../Accesso/index.php?stop=1");
}
?>