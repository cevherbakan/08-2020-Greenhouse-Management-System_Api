<?php
include "../class.php";

if(isset($_GET["key"])){
        $id = $_GET["id"];

        $general_situation = new GeneralSituation();
        echo json_encode($general_situation->getGeneralSituation($id), JSON_UNESCAPED_UNICODE);
   
}

?>