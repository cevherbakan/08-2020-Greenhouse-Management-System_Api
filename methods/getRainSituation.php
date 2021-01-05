<?php
include "../class.php";

if(isset($_GET["key"])){
        $id = $_GET["id"];

        $rain_situation = new RainSituation();
        echo json_encode($rain_situation->getRainSituation($id), JSON_UNESCAPED_UNICODE);
   
}

?>