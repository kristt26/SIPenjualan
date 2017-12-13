<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../../api/config/database.php';
include_once '../../api/objects/Prices.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$price = new Prices($db);
 

$data =json_decode(file_get_contents("php://input"));

$price->ShiperId=$data->ShiperId;
$price->ReciverId=$data->ReciverId;
$price->PortType=$data->PortType;
$price->PayType=$data->PayType;
$price->FromCity=$data->FromCity;
$price->ToCity=$data->ToCity;
// query products
$stmt = $price->read();   
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $price_arr=array();
    $price_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $price_item=array(
            "Id" => $Id,
            "ShiperId" => $ShiperId,
            "ReciverId" => $ReciverId,
            "PortType" => $PortType,
            "PayType" => $PayType,
            "FromCity"=>$FromCity,
            "ToCity"=>$ToCity,
            "Price"=>$Price
        );
 
        array_push($price_arr["records"], $price_item);
    }
 
    echo json_encode($price_arr);
}
 
else{
    echo json_encode(
        array("message" => "No Price found")
    );
}
?>