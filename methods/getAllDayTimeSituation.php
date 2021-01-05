<?php
include "../class.php";

if(isset($_GET["key"])){

        $daytime_situation = new DayTimeSituation();
        echo json_encode($daytime_situation->getAllDayTimeSituation(), JSON_UNESCAPED_UNICODE);
   
}

?>