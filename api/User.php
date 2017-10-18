<?php
$DataUsers = new User();
if(isset($_GET['action']))
{
    if($_GET['action']=='GetUser')
    {
        echo $DataUsers->GetUser();
    }
    if($_GET['action']=='InsertUser')
    {
        $PostData   = file_get_contents("php://input");
        $Request    = json_decode($PostData);
        $ListData   = new User();
        echo $ListData->InsertUser($Request);
    }
}


class User{
    public function __construct() {
        include("../System/koneksi.php");
    }

    public function GetUser()
    {
        $TampungDataUser=array();
        $QUser=mysql_query("select * from users")or die(mysql_error());
        while($LoopUser = mysql_fetch_array($QUser))
        {
            $TampungDataUser[]=array('NamaPegawai'=>$LoopUser['NamaPegawai'], 'Username'=>$LoopUser['Username'], 'Kontak'=>$LoopUser['Kontak'], 'Email'=>$LoopUser['Email']);
        }
        return json_encode($TampungDataUser);
    }

    public function InsertUser($value)
    {
        $Simpan = mysql_query("insert into users values('', '$value->NamaPegawai', '$value->Username', '$value->Password','$value->Kontak','$value->Email')")or die(mysql_error());
        if($Simpan)
        {
            $Id= mysql_insert_id();
            return $Id;
        }
    }
}
?>