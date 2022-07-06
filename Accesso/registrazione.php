<?php
error_reporting (E_ALL ^ E_NOTICE);
include 'connect.php';
session_start();

#passaggio parametri form con post
$stop = mysqli_real_escape_string($mysqli, $_GET['stop']);
if(isset($stop) && $stop==1){
	if (isset($_POST['submit'])) {
		$nome = $_POST['nome'];
		$cognome = $_POST['cognome'];
		$documento = $_POST['documento'];
		$numero_documento = $_POST['numero_documento'];
		$email = $_POST['email'];
		$data_nascita = $_POST['data_nascita'];
		$telefono = $_POST['telefono'];
		$nome_utente=$_POST['nome_utente'];
		$password=$_POST['password'];
	    #prepared statement x registrazione - prevenzione SQL injection
		$stmt = $mysqli->prepare("INSERT INTO blogbuster.utente(NomeUtente, Password, Nome, Cognome, TipoDocumento, NumeroDocumento, Email, DataNascita, NumeroTelefono) VALUES (?,?,?,?,?,?,?,?,?)");
		$stmt->bind_param("sssssssss", $nome_utente, password_hash($password, PASSWORD_DEFAULT), $nome, $cognome, $documento, $numero_documento, $email, $data_nascita, $telefono);
		$stmt->execute() or trigger_error($stmt->error, E_USER_ERROR);

		$stmt->close();
		$_SESSION['user'] = $nome_utente;
		//indirizzo a interessi.html per scelta
		header("Location: interessi.html");
		$mysqli->close();
	}
} else {
	header('Location: ../Accesso/index.php');
}

?>




