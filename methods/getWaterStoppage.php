<?php
include "../class.php";

if(isset($_GET["key"])){
        $id = $_GET["id"];

        $water_stoppage = new WaterStoppage();
        echo json_encode($water_stoppage->getWaterStoppage($id), JSON_UNESCAPED_UNICODE);
   
}

?>