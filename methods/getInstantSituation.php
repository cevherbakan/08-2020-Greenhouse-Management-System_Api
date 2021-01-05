<?php
include "../class.php";

if(isset($_GET["key"])){

        $instant_situation = new InstantSituation();
        echo json_encode($instant_situation->getInstantSituation(), JSON_UNESCAPED_UNICODE);
   
}

?>