<?php
$DataPenjualan = new City();
if(isset($_GET['action']))
{
    if($_GET['action']=='GetPenjualan')
    {
        echo $DataPenjualan->GetPenjualan();
    }
    if($_GET['action']=='InsertPenjualan')
    {
        $PostData   = file_get_contents("php://input");
        $Request    = json_decode($PostData);
        $ListData   = new Penjualan();
        echo $ListData->InsertPenjualan($Request);
    }
    if($_GET['action']=='UpdatePenjualan')
    {
        $PostData   = file_get_contents("php://input");
        $Request    = json_decode($PostData);
        $ListData   = new penjualan();
        echo $ListData->UpdatePenjualan($Request);
    
    }
}


class Penjualan{
    public function __construct() {
        include("../System/koneksi.php");
    }

    public function GetPenjualan()
    {
        $TampungDataPenjualan=array();
        $QUser=mysql_query("select * from Penjualan")or die(mysql_error());
        while($LoopUser = mysql_fetch_array($QUser))
        {
            $Id                 = $LoopDataPenjualan[1];
            $STT                = $LoopDataPenjualan[2];
            $Shiper             = $LoopDataPenjualan[3];
            $Reciver            = $LoopDataPenjualan[4];
            $Kota               = $LoopDataPenjualan[5];
            $Harga              = $LoopDataPenjualan[6];
            $JenisBerat         = $LoopDataPenjualan[7];
            $JenisPembayaran    = $LoopDataPenjualan[8];
            $JenisPort          = $LoopDataPenjualan[9];
            $Pembayar           = $LoopDataPenjualan[10];
            $BiayaPaking        = $LoopDataPenjualan[11];
            $Pajak              = $LoopDataPenjualan[12];
            $Lainlain           = $LoopDataPenjualan[14];
            $UserId             = $LoopDataPenjualan[15];
            $UbahTanggal        = $LoopDataPenjualan[16];
            $PerbaruiTanggal    = $LoopDataPenjualan[17];
            $Actived            = $LoopDataPenjualan[18];
            $KeteranganBayar    = $LoopDataPenjualan[19];
            $JenisBarang        = $LoopDataPenjualan[20];
            $NomorDo            = $LoopDataPenjualan[21];
            $Keterangan         = $LoopDataPenjualan[22];
            $DataTampung[]=array('Id'=>$Id, 'STT'=>$STT,'ShiperID'=>$Shiper,'ReciverID'=>$Reciver,'CityID'=>$Kota,'Price'=>$Harga,'TypeOfWeight'=>$JenisBerat,'PayType'=>$JenisPembayaran,'PortType'=>$JenisPort,'CustomerIdIsPay'=>$Pembayar,'PackingCosts'=>$BiayaPaking,'Tax'=>$Pajak,'Etc'=>$LainLain,'UserID'=>$UserId,'ChangeDate'=>$UbahTanggal,'UpdateDate'=>$PerbaruiTanggal,'Actived'=>$Actived,'IsPaid'=>$KeteranganBayar,'Content'=>$JenisBarang,'DoNumber'=>$NomorDo,'Note'=>$Keterangan);
        }
        return json_encode($TampungDataPenjualan);
    }

    public function InsertPenjualan($value)
    {       
        $Insert = mysql_query("insert into Penjualan values('','$value->Shiper', '$value->ReciverID','$value->CityID','$value->price,'$value->TypeOfWeight,'$value->PayType,'$value->PortType,'$value->CustomerIdIsPay,'$value->PackingCosts,'$value->Tax,'$value->Etc,'$value->UserID'$value->ChangeDate'$value->UpdateDate'$value->Actived,'$value->IsPaid,'$value->Content,'$value->DoNumber,'$value->Note')")or die(mysql_error());
        if($Insert)
        {
            $Id = mysql_insert_id();
            return $Id;
        }else
            return json_encode($Id);
    }

    public function UpdatePenjualan($value)
    {
        $Update = mysql_query("update Penjualan set STT='$value->STT', ShiperID='$value->Shiper', CityId='$value->Kota', Price='$value->Harga',TypeOfWeight='$value->JenisBerat',PayType='$value->JenisPembayaran',PortType='$value->JenisPort',CustomerIdIsPay='$value->Pembayar',PackingCosts='$value->BiayaPaking',Tax='$value->Pajak',Etc='$value->Lainlain',UserID='$value->UserId',ChangeDate='$value->UbahTanggal',ChangeDate='$value->PerbaruiTanggal',Actived='$value->Actived',IsPaid='$value->KeteranganBayar',Content='$value->JenisBarang',DoNumber='$value->NomorDo',Note='$value->Keterangan' where Id='$value->Id'")or die(mysql_error());
        if($Update)
            return 1;
        else
            return 0;
    }
}

?>