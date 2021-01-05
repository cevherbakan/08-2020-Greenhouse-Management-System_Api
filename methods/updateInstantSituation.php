<?php
include "../class.php";

if(isset($_GET["key"])){
        $temperature = $_GET["temperature"];
        $moisture = $_GET["moisture"];
        $soil_moisture = $_GET["soil_moisture"];
        $air_quality = $_GET["air_quality"];
        $co = $_GET["co"];
        $co2 = $_GET["co2"];
        $dew_formation = $_GET["dew_formation"];
        $pressure = $_GET["pressure"];
        $ldr1=$_GET["ldr1"];
        $ldr2= $_GET["ldr2"];
        $ldr3 = $_GET["ldr3"];
        $ldr4 = $_GET["ldr4"];
        $valve_intensity = $_GET["valve_intensity"];
        $water_flow = $_GET["water_flow"];
        $rain_situation = $_GET["rain_situation"];


        $instant_situation = new InstantSituation();
        echo json_encode($instant_situation->updateInstantSituation($temperature, $moisture, $soil_moisture, $air_quality, $co, $co2, $dew_formation, $pressure, $ldr1, $ldr2, $ldr3, $ldr4, $valve_intensity, $water_flow, $rain_situation), JSON_UNESCAPED_UNICODE);
   


}

?>


