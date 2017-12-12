<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$data =json_decode(file_get_contents("php://input"));
session_start();
$_SESSION['InvoiceId']=$data->Id;
if(isset($_SESSION['InvoiceId']))
{
    echo '{';
        echo '"message":"Success"';
    echo '}';
}else
{
    echo '{';
        echo '"message":"Gagal"';
    echo '}';
}

?>