<?php
include "../class.php";

if(isset($_GET["key"])){
        $valve_intensity = $_GET["valve_intensity"];

        $valve_situation = new ValveSituation();
        echo json_encode($valve_situation->updateValveSituation($valve_intensity), JSON_UNESCAPED_UNICODE);
   
}

?>