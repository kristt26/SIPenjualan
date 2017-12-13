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
include_once '../../api/objects/Customer.php';
 
$database = new Database();
$db = $database->getConnection();
 
$customer = new Customer($db);
 
// get posted data
$data =json_decode(file_get_contents("php://input"));

$customer->Name = $data->Name;
$customer->CustomerType = $data->CustomerType;
$customer->ContactName = $data->ContactName;
$customer->Phone1 = $data->Phone1;
$customer->Phone2 = $data->Phone2;
$customer->Handphone = $data->Handphone;
$customer->Address = $data->Address;
$customer->Email = $data->Email;
$customer->CityID = $data->CityID;
//$penjualan->UserID= $data->UserID;


 
// create the product
if($customer->create()){
    echo '{';
        echo '"message": "'.$customer->Id.'"';
    echo '}';
}
 
// if unable to create the product, tell the user
else{
    echo '{';
        echo '"message": "Unable to create Customer."';
    echo '}';
}


?>