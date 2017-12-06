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
include_once '../../api/objects/Penjualan.php';
 
$database = new Database();
$db = $database->getConnection();
 
$penjualan = new Penjualan($db);
 
// get posted data
$data =json_decode(file_get_contents("php://input"));
 

// set product property values
$penjualan->STT= $data->STT;
$penjualan->ShiperID= $data->ShiperID;
$penjualan->ReciverID= $data->ReciverID;
$penjualan->CityID= $data->CityID;
$penjualan->Price= $data->Price->Price;
$penjualan->Weight= $data->Weight;
$penjualan->Colly= $data->Colly;
$penjualan->PayType= $data->PayType->status;
$penjualan->PortType= $data->PortType->port;
$penjualan->PackingCosts= $data->PackingCosts;
$penjualan->Tax= $data->Tax;
$penjualan->Etc= $data->Etc;
//$penjualan->UserID= $data->UserID;
if($penjualan->PayType=="Credit")
{
    $penjualan->IsPaid= "false";
}
else
{
    $penjualan->IsPaid= "true";
}
$penjualan->Content= $data->Content;
$penjualan->DoNumber= $data->DoNumber;
$penjualan->Note= $data->Note;
$penjualan->CreateDate=date('Y-m-d');

 
// create the product
if($penjualan->create()){
    echo '{';
        echo '"message": "'.$penjualan->PayType.'"';
    echo '}';
}
 
// if unable to create the product, tell the user
else{
    echo '{';
        echo '"message": "Unable to create product."';
    echo '}';
}


?>