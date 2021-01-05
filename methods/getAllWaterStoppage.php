<?php
include "../class.php";

if(isset($_GET["key"])){

        $water_stoppage = new WaterStoppage();
        echo json_encode($water_stoppage->getAllWaterStoppage(), JSON_UNESCAPED_UNICODE);
   
}

?>