<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../../api/config/database.php';
 
// instantiate product object
include_once '../../api/objects/Prices.php';
 
$database = new Database();
$db = $database->getConnection();
 
$price = new Prices($db);
 
// get posted data
$data =json_decode(file_get_contents("php://input"));

$price->Id = $data->Id;
$price->ShiperId = $data->ShiperId;
$price->ReciverId = $data->ReciverId;
$price->PortType = $data->PortType;
$price->PayType = $data->PayType;
$price->FromCity = $data->FromCity;
$price->ToCity = $data->ToCity;
$price->Price = $data->Price;
//$penjualan->UserID= $data->UserID;


 
// create the product
if($price->update()){
    echo '{';
        echo '"message": "Price Was Update"';
    echo '}';
}
 
// if unable to create the product, tell the user
else{
    echo '{';
        echo '"message": "Unable to update Price"';
    echo '}';
}


?>