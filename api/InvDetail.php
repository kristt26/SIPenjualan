<?php
$ListDataInvDetail = new InvDetail();
if(isset($GET['action']))
{
    if($_GET['action']=="GetInvDetail")
    {
        echo $ListDataInvDetail->GetInvDetail();
    }
    if($_GET['action']=='insertInvDetail')
    {
        $PostData   = file_get_contents("php://input");
        $Request    = json_decode($PostData);
        $ListData   = new GetInvDetail();
        echo $ListData-> InsertInvDetail($Request); 
    }
    if($_GET['action']=='UpdateInvDetail')
    {
        $PostData   = file_get_contents("php://input");
        $Request    = json_decode($PostData);
        $ListData   = new InvDetail();
        echo $ListData->UpdateInvDetail($Request);
    }
}



class InvDetail
{
    public function _construct() {
        include("../System/koneksi.php");
    }

    public function GetInvDetail()
    {
        $InvDetailTampung=array();
        $q= mysql_query("select * from invoicedetail")or die(mysql_error());
        while($DtInvDetail=mysql_fetch_array($QCustomer))
        {
            $InvDetailTampung[]=array('Id'=>$DtInvDetail['Id'], 'InvoiceId'=>$DtInvDetail['InvoiceId'], 'STT'=>$ListDataInvDetail['STT']);  
        }
        return json_encode($InvDetailTampung);
    }

}
?>




}