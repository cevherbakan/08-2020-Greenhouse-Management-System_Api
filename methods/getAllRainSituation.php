<?php
include "../class.php";

if(isset($_GET["key"])){

        $rain_situation = new RainSituation();
        echo json_encode($rain_situation->getAllRainSituation(), JSON_UNESCAPED_UNICODE);
   
}

?>