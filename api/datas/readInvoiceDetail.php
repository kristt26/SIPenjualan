<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../../api/config/database.php';
include_once '../../api/objects/InvoiceDetail.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$invoicedetail = new InvoiceDetail($db);
 
// query products
$stmt = $invoicedetail->read();   
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $invdet_arr=array();
    $invdet_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $invdet_item=array(
            "Id" => $Id,
            "InvoiceId" => $InvoiceId,
            "STT" => $STT
        );
 
        array_push($invdet_arr["records"], $invdet_item);
    }
 
    echo json_encode($invdet_arr);
}
 
else{
    echo json_encode(
        array("message" => "No City found.")
    );
}
?>