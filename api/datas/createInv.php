<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../../api/config/database.php';
include_once '../../api/objects/Invoice.php';
include_once '../../api/objects/InvoiceDetail.php';

 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$invoice = new Invoice($db);

$invoiceDet = new InvoiceDetail($db);
 

$data =json_decode(file_get_contents("php://input"));
$invoice->Number = $data->Number;
$invoice->CustomerId = $data->CustomerId;
$invoice->InvoiceStatus = $data->InvoiceStatus;
$invoice->DeadLine = $data->DeadLine;
$invoice->InvoicePayType = $data->InvoicePayType;
$invoice->CreateDate=date('Y-m-d');
$invoice->STT=$data->STT;


// query products

try{
    $database->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $database->conn->beginTransaction();
    $stmt = $invoice->create();    
    $invoiceDet->InvoiceId=$invoice->Id;
    $item_Invoive=array(
        "Id"=>$invoiceDet->InvoiceId,
        "CreateDate"=>$invoice->CreateDate,
        "PaidDate"=>"",
        "STT"=>array()
    );
    foreach($invoice->STT as &$Value)
    {
        $invoiceDet->STT=$Value->STT;
        $stmtinvdet = $invoiceDet->create();
        $item_InvDet = array(
            "Id"=>$invoiceDet->Id,
            "STT"=>$Value->STT
        );
        array_push($item_Invoive['STT'],$item_InvDet);

    }
    $database->conn->commit();
    
    
    echo json_encode($item_Invoive);
    /*
    echo '{';
        echo '"message": "Sukses"';
    echo '}';
    */

}catch(Exception $e)
{
    $database->conn->rollBack();
    echo "Failed: " . $e->getMessage();
}
// check if more than 0 record found

?>