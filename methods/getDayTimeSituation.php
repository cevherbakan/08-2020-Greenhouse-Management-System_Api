<?php
include "../class.php";

if(isset($_GET["key"])){
        $id = $_GET["id"];

        $daytime_situation = new DayTimeSituation();
        echo json_encode($daytime_situation->getDayTimeSituation($id), JSON_UNESCAPED_UNICODE);
   
}

?>