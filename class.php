<?php

class Config
{
    private $databaseHost = 'localhost';
    private $databaseName = 'arduino_project';
    private $databaseUsername = "root";
    private $databasePassword = "";

    function db()
    {
        try {
            $mysql_connection = "mysql:host=$this->databaseHost;dbname=$this->databaseName";
            $dbconnection = new PDO($mysql_connection, $this->databaseUsername, $this->databasePassword);
            $dbconnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dbconnection;
        } catch (PDOException $e) {
            //echo "Bağlantı Hatası: " . $e->getMessage() . "<br/>";
        }
    }
}


class Crud extends Config
{

    function insertAndUpdate($sql,$data){
        $db = $this->db();
        $sql=$db->prepare($sql);
        $sql->execute($data);
        $return = true;
        return $return;
    }

    function get($sql){
        try {
            $db = $this->db();
            $query = $db->query($sql);
            $data = $query->fetch(PDO::FETCH_OBJ); #PDO::FETCH_ASSOC
            $db=null;
            $return = false;
            
            if(!empty($data)){

                $return = $data;
            }

            return $return;

        } catch (PDOException $ex) {
            return $ex;
        }
    }

    function getAll($sql){
        try {
            $db = $this->db();
            $query = $db->query($sql);
            $data = $query->fetchAll(PDO::FETCH_OBJ); #PDO::FETCH_ASSOC
            $db=null;
            $return = false;
            
            if(!empty($data)){

                $return = $data;
            }

            return $return;

        } catch (PDOException $ex) {
            return $ex;
        }

    }
    
    function dropTable($table_name)
    {
        $db = $this->db();
        $sql=$db->prepare("DROP TABLE $table_name ");

       $result=$sql->execute();

       return $result;
    }

    function createTable()
    {
        $db = $this->db();
        $sql=$db->prepare("CREATE TABLE daytime_situation (
            id INT AUTO_INCREMENT PRIMARY KEY,
            temperature FLOAT NOT NULL DEFAULT 0,
            moisture FLOAT NOT NULL DEFAULT 0,
            soil_moisture INT NOT NULL DEFAULT 0,
            air_quality INT NOT NULL DEFAULT 0,
            co INT NOT NULL DEFAULT 0,
            co2 INT NOT NULL DEFAULT 0,
            dew_formation INT NOT NULL DEFAULT 0,
            pressure INT NOT NULL DEFAULT 0,
            create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
          
          ) ");

       $result=$sql->execute();

       return $result;
    }
}







class GeneralSituation extends Crud
{
    public function addGeneralSituation($min_temperature, $max_temperature, $min_moisture, $max_moisture, $min_soil_moisture, $max_soil_moisture,$min_air_quality, $max_air_quality, $min_co, $max_co, $min_co2, $max_co2, $min_dew_formation, $max_dew_formation,$min_pressure,$max_pressure, $volume_water_used ){
        $sql="INSERT INTO general_situation (min_temperature, max_temperature, min_moisture, max_moisture, min_soil_moisture, max_soil_moisture,min_air_quality, max_air_quality ,min_co, max_co, min_co2, max_co2, min_dew_formation, max_dew_formation,min_pressure,max_pressure, volume_water_used) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $data=[$min_temperature, $max_temperature, $min_moisture, $max_moisture, $min_soil_moisture, $max_soil_moisture,$min_air_quality, $max_air_quality, $min_co, $max_co, $min_co2, $max_co2, $min_dew_formation, $max_dew_formation, $min_pressure, $max_pressure, $volume_water_used ];
        $query["result"] = $this->insertAndUpdate($sql,$data);

        return $query;
    
    }

    public function getGeneralSituation($id){
        $sql = "Select * from general_situation WHERE id='$id' ";
        $result["data"]=$this->get($sql);
    
    return $result;

    }

    public function getAllGeneralSituation(){
        $sql = "Select * from general_situation";
        $result["data"]=$this->getAll($sql);

    return $result;
    }

     //diğer get Metotları daha sonradan eklenecektir

}


class DayTimeSituation extends Crud
{
    public function endOfDay($volume_water_used){
		$dayTime=new DayTimeSituation;
        $result["result"] = $dayTime->calculateMinMax($volume_water_used);
        $dayTime->dropDayTimeSituation();
		
		

        return $result;
    }

    public function addDayTimeSituation($temperature, $moisture, $soil_moisture,$air_quality, $co, $co2, $dew_formation, $pressure){
        $sql="INSERT INTO daytime_situation (temperature, moisture, soil_moisture,air_quality, co, co2, dew_formation, pressure) VALUES (?,?,?,?,?,?,?,?)";
        $data=[$temperature, $moisture, $soil_moisture,$air_quality ,$co, $co2, $dew_formation, $pressure];
        $query["result"] = $this->insertAndUpdate($sql,$data);

        return $query;

    }

    public function dropDayTimeSituation(){
      
          $return["result"]=$this->dropTable("daytime_situation");
          $this->createTable();


        return $return;

    }

    public function calculateMinMax($volume_water_used){
		$general_situation=new GeneralSituation;
        $sql = "Select MIN(temperature) as min_temperature, MAX(temperature) as max_temperature, MIN(moisture) as min_moisture, MAX(moisture) as max_moisture, MIN(soil_moisture) as min_soil_moisture, MAX(soil_moisture) as max_soil_moisture,MIN(air_quality) as min_air_quality ,MAX(air_quality) as max_air_quality , MIN(co) as min_co, MAX(co) as max_co, MIN(co2) as min_co2, MAX(co2) as max_co2, MIN(dew_formation) as min_dew_formation, MAX(dew_formation) as max_dew_formation, MIN(pressure) as min_pressure, MAX(pressure) as max_pressure from daytime_situation";
        $result["data"]=$this->get($sql);
		
		$json = json_encode($result["data"], JSON_UNESCAPED_UNICODE); 
		$array = json_decode($json, true);
		 
		$min_temperature = $array["min_temperature"]; 
		$max_temperature = $array["max_temperature"]; 
		$min_moisture = $array["min_moisture"]; 
		$max_moisture = $array["max_moisture"]; 
		$min_soil_moisture = $array["min_soil_moisture"]; 
		$max_soil_moisture = $array["max_soil_moisture"]; 
		$min_air_quality = $array["min_air_quality"]; 
		$max_air_quality = $array["max_air_quality"]; 
		$min_co = $array["min_co"]; 
		$max_co = $array["max_co"]; 
		$min_co2 = $array["min_co2"]; 
		$max_co2 = $array["max_co2"]; 
		$min_dew_formation = $array["min_dew_formation"]; 
        $max_dew_formation = $array["max_dew_formation"]; 
        $min_pressure = $array["min_pressure"];
        $max_pressure = $array["max_pressure"];
		
		
		
  

        $result = $general_situation->addGeneralSituation($min_temperature,$max_temperature ,$min_moisture,$max_moisture,$min_soil_moisture,$max_soil_moisture, $min_air_quality,$max_air_quality, $min_co,$max_co, $min_co2, $max_co2,$min_dew_formation,$max_dew_formation,$min_pressure, $max_pressure,$volume_water_used);

        //$result = $general_situation->addGeneralSituation(1,45,72,12,24,36,2,45,85,36,14,89,20,10,2);
		return $result;

    }

    public function getDayTimeSituation($id){
        $sql = "Select * from daytime_situation WHERE id='$id' ";
        $result["data"]=$this->get($sql);
    
    return $result;
    }

    public function getAllDayTimeSituation(){
        $sql = "Select * from daytime_situation";
        $result["data"]=$this->getAll($sql);
    
    return $result;
    }
    //Daha sonra diğer get Metotları yazılacaktır



}


class InstantSituation extends Crud
{

    public function updateInstantSituation($temperature, $moisture, $soil_moisture, $air_quality, $co, $co2, $dew_formation, $pressure, $ldr1, $ldr2, $ldr3, $ldr4, $valve_intensity, $water_flow, $rain_situation){
           

        $sql = "UPDATE instant_situation SET temperature = ?, moisture = ?, soil_moisture = ?, air_quality = ?, co = ?, co2 = ?, dew_formation = ?, pressure = ?, ldr1 = ?, ldr2 = ?, ldr3 = ?, ldr4 = ?, valve_intensity = ?, water_flow = ?, rain_situation = ?  WHERE id = 1";
        $data = [$temperature, $moisture, $soil_moisture, $air_quality, $co, $co2, $dew_formation, $pressure, $ldr1, $ldr2, $ldr3, $ldr4, $valve_intensity, $water_flow, $rain_situation];

        $result["data"]= $this->insertAndUpdate($sql,$data);


        return $result;

    }

    public function getInstantSituation(){
        $sql = "SELECT * from instant_situation WHERE id= 1 ";
        $result["data"]=$this->get($sql);
    
    return $result;

    }


    public function updateInstantRequest($situation){

        $sql = "UPDATE instant_request SET situation = ? WHERE id = 1";
        $data = [$situation];
        $result["data"] = $this->insertAndUpdate($sql,$data);

        return $result;

    }

    public function updateResetSituation($reset_situation){

        $sql = "UPDATE instant_request SET reset_situation = ? WHERE id = 1";
        $data = [$reset_situation];
        $result["data"] = $this->insertAndUpdate($sql,$data);

        return $result;

    }


    public function getInstantRequest(){
        $sql = "SELECT situation, valve_intensity, reset_situation from instant_request WHERE id= 1 ";
        $result=$this->get($sql);
        
        $this->updateInstantRequest(0);
        $this->updateResetSituation(0);

    return $result;

    }

}


// GPS Modülü eklendiğinde metotlar doldurulacaktır
class Location extends Crud
{

    public function updateLocation(){

    }

    public function getLocation(){

    }

}



class RainSituation extends Crud
{

    public function addRainSituation($situation){
            $sql="INSERT INTO rain_situation (situation) VALUES (?)";
            $data=[$situation];
            $query["result"] = $this->insertAndUpdate($sql,$data);
    
            return $query;
    }

    public function getRainSituation($id){
        $sql = "Select * from rain_situation WHERE id='$id' ";
        $result["data"]=$this->get($sql);
    
    return $result;
    }

    public function getAllRainSituation(){
        $sql = "Select * from rain_situation";
        $result["data"]=$this->getAll($sql);
    
    return $result;
    }

    //daha sonrasın get metotlarının devamı yazılacaktr
}


class WaterStoppage extends Crud
{
    public function addWaterStoppage($situation){
        $sql="INSERT INTO water_stoppage (situation) VALUES (?)";
        $data=[$situation];
        $query["result"] = $this->insertAndUpdate($sql,$data);

        return $query;
    }

    public function getAllWaterStoppage(){
        $sql = "Select * from water_stoppage";
        $result["data"]=$this->getAll($sql);
    
    return $result;
    }

    public function getWaterStoppage($id){
        $sql = "Select * from water_stoppage WHERE id='$id' ";
        $result["data"]=$this->get($sql);
    
    return $result;
    }


    //diğer get Metotları daha sonradan yazılacaktır

}


class ValveSituation extends Crud //Vana ile alakalı
{
    public function updateValveSituation($valve_intensity){
        $sql = "UPDATE instant_request SET valve_intensity = ?  WHERE id = 1";
        $data = [$valve_intensity];

        $result["data"] = $this->insertAndUpdate($sql,$data);


        return $result;
    }
/*
    public function getValveSituation(){
        $sql = "SELECT valve_intensity as result from valve_situation WHERE id= 1 ";
        $result=$this->get($sql);
    
    return $result;
    }
*/
}



?>
