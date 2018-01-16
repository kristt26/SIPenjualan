<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../../api/config/database.php';
include_once '../../api/objects/Customer.php';
include_once '../../api/objects/City.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$customer = new Customer($db);

$city = new City($db);
 
// query products
$stmt = $customer->read();   
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $customer_arr=array();
    $customer_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $city->Id=$CityID;
        $city->readOne();

        $customer_item=array(
             "Id"=>$Id,
             "Name"=>$Name,
             "CustomerType"=>$CustomerType,
             "ContactName"=>$ContactName,
             "Phone1"=>$Phone1,
             "Phone2"=>$Phone2,
             "Handphone"=>$Handphone,
             "Address"=>$Address,
             "Email"=>$Email,
             "CityID"=>$CityID,
             "CityName"=>$city->CityName
        );
 
        array_push($customer_arr["records"], $customer_item);
    }
 
    echo json_encode($customer_arr);
}
 
else{
    echo json_encode(
        array("message" => "No Customer found.")
    );
}
?>