<?php
$DataPrices = new Prices();
if(isset($_GET['action']))
{
    if($_GET['action']=='GetPrices')
    {
        echo $DataPrices-> GetPrices();
    }
    if($_GET['action']=='InsertPrices')
    {
        $PostData   = file_get_contents("php://input");
        $Request    = json_decode($PostData);
        $ListData   = new Prices();
        echo $ListData->InsertPrices($Request);
    }
    if($_GET['action']=='UpdatePrices')
    {
        $PostData   = file_get_contents("php://input");
        $Request    = json_decode($PostData);
        $ListData   = new Prices();
        echo $ListData->UpdatePrices($Request);
    }
}



class Prices
{
    public function __construct() {
        include("../System/koneksi.php");
    }

    public function GetPrices()
    {
        $DataTampung;
        $q  = mysql_query("select * from Prices p, customer c where p.ShiperId=c.Id and p.ReciverId=c.Id") or die(mysql_error());
        while($LoopDataPrices= mysql_fetch_array($q))
        {
            $Id                = $LoopDataPrices[0];
            $IdPengirim       = $LoopDataPrices[1];
            $IdPenerima        = $LoopDataPrices[2];
            $PortType          = $LoopDataPrices[3];
            $JenisPembayaran   = $LoopDataPrices[4];
            $KotaPengirim      = $LoopDataPrices[5];
            $KotaPenerima      = $LoopDataPrices[6];
            $Harga             = $LoopDataPrices[7];
            $DataTampung[]=array('Id'=>$Id, 'ShiperId'=>$LoopDataPrices['ShiperId'],'ReciverId'=>$LoopDataPrices['ReciverId'], 'PortType'=>$LoopDataPrices['PortType'], 'PayType'=>$LoopDataPrices['PayType'],'FromCity'=>$LoopDataPrices['FromCity'],'ToCity'=>$LoopDataPrices['ToCity'],'Price'=>$LoopDataPrices['Price']);
        }
        return json_encode($DataTampung);

    }

    public function InsertPrices($value)
    {       
        $Insert = mysql_query("insert into Prices values('','$value->ShiperId', '$value->ReciverId','$value->PortType','$value->PayType','$value->FormCity','$value->ToCity','$value->Prices')")or die(mysql_error());
        if($Insert)
        {
            $Id = mysql_insert_id();
            return $Id;
        }else
            return json_encode($Id);
    }

    public function UpdatePrices($value)
    {
        $Update = mysql_query("update Prices set ShiperId='$value->ShiperId', ReciverId='$value->ReciverId', PortType='$value->PortType', PayType='$value->PayType', FormCity='$value->FormCity', ToCity='$value->ToCity', Prices='$value->Prices' where Id='$value->Id'")or die(mysql_error());
        if($Update)
            return 1;
        else
            return 0;
    }
}

?>