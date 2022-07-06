<?php

include "../Accesso/connect.php";
session_start();
//impedisce accesso diretto alla pagina logout.php, in un caso distrugge la sessione e reindirizza mentre nell'altro caso reindirizza solamente
$stop = mysqli_real_escape_string($mysqli, $_GET['stop']);
if(isset($stop) && $stop==1){
	session_destroy();
	header('Location: ../Accesso/index.php');
} else {
	header('Location: ../Accesso/index.php');
}
?>