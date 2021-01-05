<?php
include "../class.php";

if(isset($_GET["key"])){
        $temperature = $_GET["temperature"];
        $moisture = $_GET["moisture"];
        $soil_moisture = $_GET["soil_moisture"];
        $co = $_GET["co"];
        $co2 = $_GET["co2"];
        $dew_formation = $_GET["dew_formation"];
        $pressure = $_GET["pressure"];
        $air_quality = $_GET["air_quality"];

        $daytime_situation = new DayTimeSituation();
        echo json_encode($daytime_situation->addDayTimeSituation($temperature, $moisture, $soil_moisture,$air_quality, $co, $co2, $dew_formation, $pressure), JSON_UNESCAPED_UNICODE);
        
}                                                           

?>