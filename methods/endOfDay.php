<?php
include "../class.php";

if(isset($_GET["key"])){

        $volume_water_used = $_GET["volume_water_used"];
		$daytime_situation = new DayTimeSituation();
        echo json_encode($daytime_situation->endOfDay($volume_water_used), JSON_UNESCAPED_UNICODE);
   
}

?>