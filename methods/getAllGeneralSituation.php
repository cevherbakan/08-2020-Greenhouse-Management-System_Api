<?php
include "../class.php";

if(isset($_GET["key"])){

        $general_situation = new GeneralSituation();
        echo json_encode($general_situation->getAllGeneralSituation(), JSON_UNESCAPED_UNICODE);
   
}

?>