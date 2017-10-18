<?php
$DataCity = new City();
if(isset($_GET['action']))
{
    if($_GET['action']=='GetCity')
    {
        echo $DataCity-> GetCity();
    }
    if($_GET['action']=='InsertCity')
    {
        $PostData   = file_get_contents("php://input");
        $Request    = json_decode($PostData);
        $ListData   = new City();
        echo $ListData->InsertCity($Request);
    }
    if($_GET['action']=='UpdateCity')
    {
        $PostData   = file_get_contents("php://input");
        $Request    = json_decode($PostData);
        $ListData   = new City();
        echo $ListData->UpdateCity($Request);
    }
}



class City
{
    public function __construct() {
        include("../System/koneksi.php");
    }

    public function GetCity()
    {
        $DataTampung;
        $q  = mysql_query("select * from city") or die(mysql_error());
        while($LoopDataCity= mysql_fetch_array($q))
        {
            $Id         = $LoopDataCity[0];
            $Provinsi   = $LoopDataCity[1];
            $Kabupaten  = $LoopDataCity[2];
            $NamaKota   = $LoopDataCity[3];
            $KodeKota   = $LoopDataCity[4];
            $DataTampung[]=array('Id'=>$Id, 'Province'=>$Provinsi,'Regency'=>$Kabupaten,'CityName'=>$NamaKota,'CityCode'=>$KodeKota);
        }
        return json_encode($DataTampung);

    }

    public function InsertCity($value)
    {       
        $Insert = mysql_query("insert into city values('','$value->Province', '$value->Regency','$value->CityName','$value->CityCode')")or die(mysql_error());
        if($Insert)
        {
            $Id = mysql_insert_id();
            return $Id;
        }else
            return json_encode($Id);
    }

    public function UpdateCity($value)
    {
        $Update = mysql_query("update city set Province='$value->Province', Regency='$value->Regency', CityName='$value->CityName', CityCode='$value->CityCode' where Id='$value->Id'")or die(mysql_error());
        if($Update)
            return 1;
        else
            return 0;
    }
}

?>