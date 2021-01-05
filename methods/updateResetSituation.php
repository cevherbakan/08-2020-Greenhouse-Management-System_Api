<?php
include "../class.php";

if(isset($_GET["key"])){
    $reset_situation = $_GET["reset_situation"];
        


        $instant_situation = new InstantSituation();
        echo json_encode($instant_situation->updateResetSituation($reset_situation), JSON_UNESCAPED_UNICODE);
   


}

?>

