<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 


 
// instantiate database and product object

 

$data =json_decode(file_get_contents("php://input"));
session_start();
$_SESSION['STT']=$data->STT;
$_SESSION['ShiperName']=$data->ShiperName;
$_SESSION['ReciverName']=$data->ReciverName;
$_SESSION['CityName']=$data->CityName;
$_SESSION['Colly']=$data->Colly;
$_SESSION['Content']=$data->Content;
$_SESSION['Weight']=$data->Weight;
$_SESSION['PayType']=$data->PayType;
$_SESSION['PortType']=$data->PortType;
$_SESSION['DoNumber']=$data->DoNumber;
$_SESSION['Price']=$data->Price;
$_SESSION['Cost']=$data->Price * $data->Weight;
$_SESSION['PackingCosts']=$data->PackingCosts;
$_SESSION['Etc']=$data->Etc;
$_SESSION['Tax']=$data->Tax;
$_SESSION['Total']=$data->Total;
$_SESSION['Note']=$data->Note;

$data=$_SESSION['STT'];

echo json_encode(
    array("message" => "$data")
);


// query products


// check if more than 0 record found

?>