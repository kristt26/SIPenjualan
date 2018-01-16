<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../../api/config/database.php';
include_once '../../api/objects/Penjualan.php';
include_once '../../api/objects/Customer.php';
include_once '../../api/objects/City.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$penjualan = new Penjualan($db);

$customer = new Customer($db);

$city = new City($db);

// get posted data
$data =json_decode(file_get_contents("php://input"));

$a = new DateTime($data->TglAwal);
$aa=str_replace('-', '/', $a->format('Y-m-d'));
$aaa = date('Y-m-d',strtotime($aa . "+1 days"));
$b = new DateTime($data->TglAkhir);
$bb=str_replace('-', '/', $b->format('Y-m-d'));
$bbb = date('Y-m-d',strtotime($bb . "+1 days"));

$penjualan->IsPaid=$data->IsPaid;
$penjualan->TglAwal=$aaa;
$penjualan->TglAkhir=$bbb;

// query products
$stmt = $penjualan->readByDate();   
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $penjualan_arr=array();
    $penjualan_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $customer->Id=$ShiperID;
        $customer->readOne();
        $dataShiper=$customer->Name;
        $customer->Id=$ReciverID;
        $customer->readOne();
        $dataReciver=$customer->Name;
        $city->Id=$CityID;
        $city->readOne();
        $dataFromCity=$city->CityName;
        
 
        $penjualan_item=array(
            "STT" => $STT,
            "ShiperName"=>$dataShiper,
            "ReciverName"=>$dataReciver,
            "ShiperID" => $ShiperID,
            "CityName"=>$dataFromCity,
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
 
        array_push($penjualan_arr["records"], $penjualan_item);
    }
 
    echo json_encode($penjualan_arr);
}
 
else{
    echo json_encode(
        array("message" => "'$penjualan->TglAwal.$penjualan->IsPaid.$penjualan->TglAkhir'")
    );
}
?>