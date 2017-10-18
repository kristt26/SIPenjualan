<?php
$ListDataCustomer = new Customer();
if(isset($_GET['action']))
{
    if($_GET['action']=="GetCustomer")
    {
        echo $ListDataCustomer->GetCustomer();
    }
}

class Customer
{
    public function __construct() {
        include("../System/koneksi.php");
    }

    public function GetCustomer()
    {
        $CustomerTampung=array();
        $QCustomer= mysql_query("select * from customer")or die(mysql_error());
        while($DtCustomer=mysql_fetch_array($QCustomer))
        {
            $CustomerTampung[]=array('Id'=>$DtCustomer['Id'], 'Name'=>$DtCustomer['Name'], 'CustomerType'=>$DtCustomer['CustomerType'], 'ContactName'=>$DtCustomer['ContactName'], 'Phone1'=>$DtCustomer['Phone1'], 'Phone2'=>$DtCustomer['Phone2'], 'Handphone'=>$DtCustomer['Handphone'], 'Address'=>$DtCustomer['Address'], 'Email'=>$DtCustomer['Email'], 'CityID'=>$DtCustomer['CityID']);
        }
        return json_encode($CustomerTampung);
    }

}
?>