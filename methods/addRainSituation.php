<?php
include "../class.php";

if(isset($_GET["key"])){
        $situation = $_GET["situation"];

        $rain_situation = new RainSituation();
        echo json_encode($rain_situation->addRainSituation($situation), JSON_UNESCAPED_UNICODE);
   
}

?>