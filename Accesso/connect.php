<?php

$mysqli = new mysqli('localhost', 'root','', 'blogbuster');
//modifica file php.ini per tempo max durata sessione di 6 ore
ini_set("session.gc_maxlifetime", 60*60*6);
ini_set("session.gc_divisor", 1);
ini_set("session.gc_probability", 1);
	if ($mysqli->connect_error) {
		die('Errore di connessione (' . $mysqli->connect_errno . ')' . $mysqli->connect_error); 
	}
"\r\n"

?>