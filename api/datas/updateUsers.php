<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../../api/config/database.php';
include_once '../../api/objects/Users.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$users = new Users($db);

 

$data =json_decode(file_get_contents("php://input"));

$users->Id=$data->Id;
$users->NamaPegawai=$data->NamaPegawai;
$users->Kontak=$data->Kontak;
$users->Email=$data->Email;
//$users->Password=md5($data->Password);
$users->Jabatan=$data->Jabatan;


// query products
if($users->update())
{
    echo '{';
        echo '"message": "User Was Update"';
    echo '}';
}else
{
    echo '{';
        echo '"message": "Unable to create users."';
    echo '}';
}


?>