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
 
// query products
$stmt = $users->read();   
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $users_arr=array();
    $users_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $users_item=array(
            "Id" => $Id,
            "NamaPegawai" => $NamaPegawai,
            "Kontak" => $Kontak,
            "Email" => $Email,
            "Jabatan"=>$Jabatan
        );
 
        array_push($users_arr["records"], $users_item);
    }
 
    echo json_encode($users_arr);
}
 
else{
    echo json_encode(
        array("message" => "No Users found.")
    );
}
?>