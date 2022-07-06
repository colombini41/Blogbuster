<?php
  include '../Accesso/connect.php';
  $stop = mysqli_real_escape_string($mysqli, $_GET['stop']);
  if(isset($stop) && $stop==1){
    $titolo2 = $_POST['titolo'];
    if(isset($titolo2)){
      $id_query= "SELECT * FROM `blog` WHERE (Titolo = '$titolo2' )";
      $id_result = $mysqli -> query($id_query);
      $id_rows= $id_result->fetch_row();
      $id = $id_rows[5];
      $argomento_query= "SELECT * FROM `sottoargomento` WHERE (idPadre = $id) ";
      $argomento_result = $mysqli -> query($argomento_query);
      
      if ($id == 10) {
        $response=0;
        echo $response;
      } else {
        $i = 0;
        while ($i < 3 ) {
            $argomento_row = $argomento_result -> fetch_row();
            $argomento = $argomento_row[1]; 
            $response= "<option id='$argomento' value='$argomento'> $argomento </option>";
            $i = $i + 1;
            echo $response;
        }
        
      }

    }
    die;
  } else {
    header("Location: ../Accesso/index.php?stop=1");
  }

      
?>

