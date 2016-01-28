<?php
    require_once "Classes/Config.php";
    require_once "Classes/Roteador.php";
    require_once "Classes/Connection.php";

    error_log("Log test");

	

    $update = file_get_contents('php://input');
    //$updateArray = json_decode($update, TRUE);
    $updateArray = json_decode($update, TRUE);
    
    Roteador::direcionar($updateArray);
?>

<h2>Version 0.16</h2>