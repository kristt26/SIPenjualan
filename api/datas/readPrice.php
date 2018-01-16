<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../../api/config/database.php';
include_once '../../api/objects/Prices.php';
include_once '../../api/objects/Customer.php';
include_once '../../api/objects/City.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$prices = new Prices($db);

$customer=new Customer($db);

$city=new City($db);
 
// query products
$stmt = $prices->read();   
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
        $customer->Id=$ShiperId;
        $customer->readOne();
        $dataShiper=$customer->Name;
        $customer->Id=$ReciverId;
        $customer->readOne();
        $dataReciver=$customer->Name;
        $city->Id=$FromCity;
        $city->readOne();
        $dataFromCity=$city->CityName;
        $city->Id=$ToCity;
        $city->readOne();
        $dataToCity=$city->CityName;

 
        $price_item=array(
            "Id" => $Id,
            "ShiperName"=>$dataShiper,
            "ReciverName"=>$dataReciver,
            "ShiperId" => $ShiperId,
            "ReciverId" => $ReciverId,
            "PortType" => $PortType,
            "PayType" => $PayType,
            "FromCityName"=>$dataFromCity,
            "ToCityName"=>$dataToCity,
            "FromCity" => $FromCity,
            "ToCity" => $ToCity,
            "Price" => $Price
        );
 
        array_push($price_arr["records"], $price_item);
    }
 
    echo json_encode($price_arr);
}
 
else{
    echo json_encode(
        array("message" => "No Prices found.")
    );
}
?>