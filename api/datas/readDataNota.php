<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

session_start();
$item_Nota=array(
    "STT"=>$_SESSION['STT'],
    "ShiperName"=>$_SESSION['ShiperName'],
    "ReciverName"=>$_SESSION['ReciverName'],
    "CityName"=>$_SESSION['CityName'],
    "Colly"=>$_SESSION['Colly'],
    "Content"=>$_SESSION['Content'],
    "Weight"=>$_SESSION['Weight'],
    "PayType"=>$_SESSION['PayType'],
    "PortType"=>$_SESSION['PortType'],
    "DoNumber"=>$_SESSION['DoNumber'],
    "Price"=>$_SESSION['Price'],
    "Cost"=>$_SESSION['Cost'],
    "PackingCosts"=>$_SESSION['PackingCosts'],
    "Etc"=>$_SESSION['Etc'],
    "Tax"=>$_SESSION['Tax'],
    "Total"=>$_SESSION['Total'],
    "Note"=>$_SESSION['Note']
);
 


    echo json_encode($item_Nota);

?>