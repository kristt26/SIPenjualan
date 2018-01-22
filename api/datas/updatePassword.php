<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../../api/config/database.php';
include_once '../../api/objects/Users.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$users = new Users($db);



 

$data =json_decode(file_get_contents("php://input"));
session_start();
$users->Id=$_SESSION['Id'];
$users->Password=$data->Password;


// query products
if($users->updatePassword())
{
    echo '{';
        echo '"message": "'.$data->ConfirmPassword.'"';
    echo '}';
}else
{
    echo '{';
        echo '"message": "Unable to Change Password."';
    echo '}';
}


?>