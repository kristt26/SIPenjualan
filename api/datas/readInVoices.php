<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../../api/config/database.php';
include_once '../../api/objects/Invoice.php';
include_once '../../api/objects/InvoiceDetail.php';
include_once '../../api/objects/Customer.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$invoice = new Invoice($db);

$invoicedetail = new InvoiceDetail($db);

$customer = new Customer($db);
 
// query products
$stmtInvoice = $invoice->read();   
$numInv = $stmtInvoice->rowCount();
 
// check if more than 0 record found
if($numInv>0){
 
    // products array
    $invoice_arr=array();
    $invoice_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($rowInv = $stmtInvoice->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($rowInv);
        $customer->Id=$CustomerId;
        $customer->readOne();

 
        $invoice_item=array(
            "Id" => $Id,
            "Number" => $Number,
            "CustomerId" => $CustomerId,
            "InvoiceStatus" => $InvoiceStatus,
            "DeadLine" => $DeadLine,
            "InvoicePayType" => $InvoicePayType,
            "CreateDate" => $CreateDate,
            "PaidDate" => $PaidDate,
            "CustomerName"=>$customer->Name,
            "InvoiceDetail"=>array()
        );
        $invoicedetail->InvoiceId=$Id; 
        $stmtInvDet=$invoicedetail->readByInvoice();
        while ($rowInvDet = $stmtInvDet->fetch(PDO::FETCH_ASSOC)){
            extract($rowInvDet);

            $invoiceDet_item=array(
                "Id" => $Id,
                "InvoiceId" => $InvoiceId,
                "STT" => $STT
            );      
            array_push($invoice_item["InvoiceDetail"],$invoiceDet_item);              
        }
        array_push($invoice_arr["records"], $invoice_item);        
    }
    echo json_encode($invoice_arr);
}
 
else{
    echo json_encode(
        array("message" => "No Invoice found.")
    );
}
?>