<?php
include "connect.php";
session_start();

$stop = mysqli_real_escape_string($mysqli, $_GET['stop']);
if (isset($stop) && $stop==1){

    $int1 = "scope globale";
    $int2 = "scope globale";
    $int3 = "scope globale";
    $sottoint1 = "scope globale";
    $sottoint2 = "scope globale";
    $sottoint3 = "scope globale";

    $stop = mysqli_real_escape_string($mysqli, $_GET['stop']);
    if(isset($stop) && $stop==1){
        if(isset($_POST['data'])){
            $argomenti = $_POST['data'];
            //print_r($argomenti);
            global $int1;
            $int1 = $argomenti[0];
            global $int2;
            $int2 = $argomenti[1];
            global $int3; 
            $int3 = $argomenti[2];
            global $sottoint1;
            $sottoint1 = $argomenti[3];
            global $sottoint2;
            $sottoint2 = $argomenti[4];
            global $sottoint3;
            $sottoint3 = $argomenti[5];
        }   
    } else {
        header('Location: ../Accesso/index.php');
    }

    if (isset($_SESSION['user'])) {
        $nome_utente = $_SESSION['user'];

        if ($stmt = $mysqli->prepare('SELECT NomeUtente FROM `utente` WHERE NomeUtente = ?')) {
            $stmt->bind_param('s', $nome_utente);
            $stmt->execute();
            //salvo risultati per vedere se utente c'è già
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($user);
                $stmt->fetch();
                global $int1;
                global $int2;
                global $int3;
                global $sottoint1;
                global $sottoint2;
                global $sottoint3;
                  
                $query= "SELECT `IdArgomento` FROM `argomento` WHERE (Nome = '$int1')";
                $result = $mysqli -> query($query);
                $row = $result -> fetch_row();
                
                $query1= "SELECT `IdArgomento` FROM `argomento` WHERE (Nome = '$int2')";
                $result1 = $mysqli -> query($query1);
                $row1 = $result1 -> fetch_row();

                $query2= "SELECT `IdArgomento` FROM `argomento` WHERE (Nome = '$int3')";
                $result2 = $mysqli -> query($query2);
                $row2 = $result2 -> fetch_row();

                #per gli argomenti interessi.js mi restituisce i nomi, mentre per i sottoargomenti gli id
                
                $insert = "INSERT INTO `interessi` (NomeUtente, IdArgomento) VALUES ('$nome_utente', '$row[0]')";
                $insert2 = "INSERT INTO `interessi` (NomeUtente, IdArgomento) VALUES ('$nome_utente', '$row1[0]')";
                $insert3 = "INSERT INTO `interessi` (NomeUtente, IdArgomento) VALUES ('$nome_utente', '$row2[0]')";

                $insert4 = "INSERT INTO `sottointeressi` (NomeUtente, idSottoargomento) VALUES ('$nome_utente', '$sottoint1')";
                $insert5 = "INSERT INTO `sottointeressi` (NomeUtente, idSottoargomento) VALUES ('$nome_utente', '$sottoint2')";
                $insert6 = "INSERT INTO `sottointeressi` (NomeUtente, idSottoargomento) VALUES ('$nome_utente', '$sottoint3')";

                if ($mysqli->query($insert) === TRUE && $mysqli->query($insert2) === TRUE && $mysqli->query($insert3) === TRUE && $mysqli->query($insert4) === TRUE && $mysqli->query($insert5) === TRUE && $mysqli->query($insert6) === TRUE) {
                    echo "New record created successfully";
                } else {
                    echo "Error: " . $insert . "<br>" . $mysqli->error;
                    echo "Error: " . $insert2 . "<br>" . $mysqli->error;
                    echo "Error: " . $insert3 . "<br>" . $mysqli->error;
                    echo "Error: " . $insert4 . "<br>" . $mysqli->error;
                    echo "Error: " . $insert5 . "<br>" . $mysqli->error;
                    echo "Error: " . $insert6 . "<br>" . $mysqli->error;
                }
                
                var_dump($sotto_row2);
            }    
        }
    }
    else {
        $id= session_id();
        global $int1;
        global $int2;
        global $int3;
        global $sottoint1;
        global $sottoint2;
        global $sottoint3;
          
        $query= "SELECT `IdArgomento` FROM `argomento` WHERE (Nome = '$int1')";
        $result = $mysqli -> query($query);
        $row = $result -> fetch_row();
        
        
        $query1= "SELECT `IdArgomento` FROM `argomento` WHERE (Nome = '$int2')";
        $result1 = $mysqli -> query($query1);
        $row1 = $result1 -> fetch_row();

        $query2= "SELECT `IdArgomento` FROM `argomento` WHERE (Nome = '$int3')";
        $result2 = $mysqli -> query($query2);
        $row2 = $result2 -> fetch_row();

        $sotto_query= "SELECT `nome` FROM `sottoargomento` WHERE (idSottoargomento = '$sottoint1')";
        $sotto_result = $mysqli -> query($sotto_query);
        $sotto_row = $sotto_result -> fetch_row();

        $sotto_query1= "SELECT `nome` FROM `sottoargomento` WHERE (idSottoargomento = '$sottoint2')";
        $sotto_result1 = $mysqli -> query($sotto_query1);
        $sotto_row1 = $sotto_result1 -> fetch_row();

        $sotto_query2= "SELECT `nome` FROM `sottoargomento` WHERE (idSottoargomento = '$sottoint3')";
        $sotto_result2 = $mysqli -> query($sotto_query2);
        $sotto_row2 = $sotto_result2 -> fetch_row();

        $_SESSION['interesseO1'] = $row[0];
        $_SESSION['interesseO2'] = $row1[0];
        $_SESSION['interesseO3'] = $row2[0];
        $_SESSION['sottointO1'] = $sotto_row[0];
        $_SESSION['sottointO2'] = $sotto_row1[0];
        $_SESSION['sottointO3'] = $sotto_row2[0];
        $_SESSION['guest'] = $id;

    }
} else {
    header('Location: ../Accesso/index.php');
}
?>