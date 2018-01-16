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
include_once '../../api/objects/Invoice.php';
include_once '../../api/objects/Penjualan.php';
 
$database = new Database();
$db = $database->getConnection();
 
$invoice = new Invoice($db);

$penjualan= new Penjualan($db);
 
// get posted data
$data =json_decode(file_get_contents("php://input"));

$a = new DateTime($data->PayDate);
$aa=str_replace('-', '/', $a->format('Y-m-d'));
$aaa = date('Y-m-d',strtotime($aa . "+1 days"));

$invoice->Id = $data->Id;
$invoice->PaidDate=$aaa;
$invoice->InvoiceStatus=$data->Paid;
$invoice->STT=$data->InvoiceDetail;

if($invoice->updateStatusPaid())
{
    if($data->Paid=="Paid")
    {
        foreach($invoice->STT as &$Value)
        {
            $penjualan->STT=$Value->STT;
            $penjualan->IsPaid="true";
            $penjualan->updatePaid();
        }
    }
    echo '{';
        echo '"message": "Invoice Was Update"';
    echo '}';
}

else{
    echo '{';
        echo '"message": "Unable to update Price"';
    echo '}';
}


?>