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
include_once '../../api/objects/Invoice.php';
include_once '../../api/objects/InvoiceDetail.php';
 
$database = new Database();
$db = $database->getConnection();
 
$penjualan = new Penjualan($db);
$invoice = new Invoice($db);
$invdet = new InvoiceDetail($db);



 
// get posted data
session_start();
$invoice->Id=$_SESSION['InvoiceId'];

$stmtinv=$invoice->readOne();
$DataInvoice;

while ($rowinv = $stmtinv->fetch(PDO::FETCH_ASSOC)){
    // extract row
    // this will make $row['name'] to
    // just $name only
    extract($rowinv);

    $inv_item=array(
        "Id" => $Id,
        "Number" => $Number,
        "CustomerId" => $CustomerId,
        "InvoiceStatus" => $InvoiceStatus,
        "DeadLine" => $DeadLine,
        "InvoicePayType" => $InvoicePayType,
        "CreateDate" => $CreateDate,
        "PaidDate" => $PaidDate,
        "InvoiceDetail"=>array()
    );

    $invdet->InvoiceId=$Id;
    $stmtinvdet= $invdet->readOne();
    while ($rowinvdet = $stmtinvdet->fetch(PDO::FETCH_ASSOC)){
        extract($rowinvdet);

        $penjualan->STT=$STT;
        $stmtPenjualan=$penjualan->readBySTT();
        while ($rowpen = $stmtPenjualan->fetch(PDO::FETCH_ASSOC)){
            extract($rowpen);
            $penjualan_item=array(
                "STT" => $STT,
                "ShiperID" => $ShiperID,
                "ReciverID" => $ReciverID,
                "CityID" => $CityID,
                "Price" => $Price,
                "Weight" => $Weight,
                "Colly" => $Colly,
                "PayType" => $PayType,
                "PortType" => $PortType,
                "PackingCosts" => $PackingCosts,
                "Tax" => $Tax,
                "Etc" => $Etc,
                //"UserID" => $UserID,
                "IsPaid" => $IsPaid,
                "Content" => $Content,
                "DoNumber" => $DoNumber,
                "Note" => $Note,
                "CreateDate" => $CreateDate 
            );
            array_push($inv_item["InvoiceDetail"], $penjualan_item);
        }

    }
    $DataInvoice=$inv_item;

    
}
echo json_encode($DataInvoice);

?>