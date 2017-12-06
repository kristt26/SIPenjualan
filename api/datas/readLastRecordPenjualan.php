<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../../api/config/database.php';
include_once '../../api/objects/Penjualan.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$penjualan = new Penjualan($db);
 
// query products
$stmt = $penjualan->readLastRecord();   
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $penjualan_arr=array();
    $penjualan_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $penjualan_item=array(
             "Id"=>$Id,
             "STT"=>$STT,
             "ShiperID"=>$ShiperID,
             "ReciverID"=>$ReciverID,
             "CityID"=>$CityID,
             "Price"=>$Price,
             "Weight"=>$Weight,
             "Colly"=>$Colly,
             "PayType"=>$PayType,
             "PortType"=>$PortType,
             "PackingCosts"=>$PackingCosts,
             "Tax"=>$Tax,
             "Etc"=>$Etc,
             "UserID"=>$UserID,
             "IsPaid"=>$IsPaid,
             "Content"=>$Content,
             "DoNumber"=>$DoNumber,
             "Note"=>$Note
        );
 
        array_push($penjualan_arr["records"], $penjualan_item);
    }
 
    echo json_encode($penjualan_arr);
}
 
else{
    echo json_encode(
        array("message" => "No Penjualan found.")
    );
}
?>