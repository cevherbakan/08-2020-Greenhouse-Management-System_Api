<?php
include "../class.php";

if(isset($_GET["key"])){
        $situation = $_GET["situation"];

        $water_stoppage = new WaterStoppage();
        echo json_encode($water_stoppage->addWaterStoppage($situation), JSON_UNESCAPED_UNICODE);
   
}

?>