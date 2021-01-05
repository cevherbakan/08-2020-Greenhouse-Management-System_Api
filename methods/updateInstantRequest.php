<?php
include "../class.php";

if(isset($_GET["key"])){
    $situation = $_GET["situation"];
        


        $instant_situation = new InstantSituation();
        echo json_encode($instant_situation->updateInstantRequest($situation), JSON_UNESCAPED_UNICODE);
   


}

?>

