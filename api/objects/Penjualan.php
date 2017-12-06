<?php
class Penjualan{
 
    // database connection and table name
    private $conn;
    private $table_name = "penjualan";
 
    // object properties
    public $Id;
    public $STT;
    public $ShiperID;
    public $ReciverID;
    public $CityID;
    public $Price;
    public $Weight;
    public $Colly;
    public $PayType;
    public $PortType;
    public $PackingCosts;
    public $Tax;
    public $Etc;
    public $UserID;
    public $IsPaid;
    public $Content;
    public $DoNumber;
    public $Note;
    public $CreateDate;
    
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }


    // read Last Record
    function readLastRecord(){
        
           // select all query
           $query = "SELECT * from ".$this->table_name." ORDER BY STT DESC LIMIT 1";
        
           // prepare query statement
           $stmt = $this->conn->prepare($query);
        
           // execute query
           $stmt->execute();
        
           return $stmt;
    }

    // read products
    function read(){
    
       // select all query
       $query = "SELECT * from ".$this->table_name."";
    
       // prepare query statement
       $stmt = $this->conn->prepare($query);
    
       // execute query
       $stmt->execute();
    
       return $stmt;
    }

   // create product
    function create(){
    
       // query to insert record
       $query = "INSERT INTO
                   " . $this->table_name . "
               SET
                   STT=:STT, ShiperID=:ShiperID, ReciverID=:ReciverID, CityID=:CityID, Price=:Price, 
                   Weight=:Weight, Colly=:Colly, PayType=:PayType, PortType=:PortType, PackingCosts=:PackingCosts, 
                   Tax=:Tax, Etc=:Etc, IsPaid=:IsPaid, Content=:Content, DoNumber=:DoNumber, Note=:Note, CreateDate=:CreateDate";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->STT=htmlspecialchars(strip_tags($this->STT));
       $this->ShiperID=htmlspecialchars(strip_tags($this->ShiperID));
       $this->ReciverID=htmlspecialchars(strip_tags($this->ReciverID));
       $this->CityID=htmlspecialchars(strip_tags($this->CityID));
       $this->Price=htmlspecialchars(strip_tags($this->Price));
       $this->Weight=htmlspecialchars(strip_tags($this->Weight));
       $this->Colly=htmlspecialchars(strip_tags($this->Colly));
       $this->PayType=htmlspecialchars(strip_tags($this->PayType));
       $this->PortType=htmlspecialchars(strip_tags($this->PortType));
       $this->PackingCosts=htmlspecialchars(strip_tags($this->PackingCosts));
       $this->Tax=htmlspecialchars(strip_tags($this->Tax));
       $this->Etc=htmlspecialchars(strip_tags($this->Etc));
       //$this->UserID=htmlspecialchars(strip_tags($this->UserID));
       $this->IsPaid=htmlspecialchars(strip_tags($this->IsPaid));
       $this->Content=htmlspecialchars(strip_tags($this->Content));
       $this->DoNumber=htmlspecialchars(strip_tags($this->DoNumber));
       $this->Note=htmlspecialchars(strip_tags($this->Note));
       $this->CreateDate=htmlspecialchars(strip_tags($this->CreateDate));
      
       // bind values
       $stmt->bindParam(":STT", $this->STT);
       $stmt->bindParam(":ShiperID", $this->ShiperID);
       $stmt->bindParam(":ReciverID", $this->ReciverID);
       $stmt->bindParam(":CityID", $this->CityID);
       $stmt->bindParam(":Price", $this->Price);
       $stmt->bindParam(":Weight", $this->Weight);
       $stmt->bindParam(":Colly", $this->Colly);
       $stmt->bindParam(":PayType", $this->PayType);
       $stmt->bindParam(":PortType", $this->PortType);
       $stmt->bindParam(":PackingCosts", $this->PackingCosts);
       $stmt->bindParam(":Tax", $this->Tax);
       $stmt->bindParam(":Etc", $this->Etc);
       //$stmt->bindParam(":UserID", $this->UserID);
       $stmt->bindParam(":IsPaid", $this->IsPaid);
       $stmt->bindParam(":Content", $this->Content);
       $stmt->bindParam(":DoNumber", $this->DoNumber);
       $stmt->bindParam(":Note", $this->Note);
       $stmt->bindParam(":CreateDate", $this->CreateDate);
    
       // execute query
       if($stmt->execute()){
           $this->Id = $this->conn->lastInsertId();
           return true;
       }else{
           return false;
       }
   }


   //Update Bidang
   function update(){
    
       // update query
       $query = "UPDATE
                   " . $this->table_name . "
               SET
                    NamaBidang=:NamaBidang, 
                    KepalaBagian=:KepalaBagian                  
               WHERE
                   IdBidang = :IdBidang";
    
       // prepare query statement
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->IdBidang=htmlspecialchars(strip_tags($this->IdBidang));
       $this->NamaBidang=htmlspecialchars(strip_tags($this->NamaBidang));
       $this->KepalaBagian=htmlspecialchars(strip_tags($this->KepalaBagian));
    
       // bind new values
       $stmt->bindParam(":IdBidang", $this->IdBidang);
       $stmt->bindParam(":NamaBidang", $this->NamaBidang);
       $stmt->bindParam(":KepalaBagian", $this->KepalaBagian);
    
       // execute the query
       if($stmt->execute()){
           return true;
       }else{
           return false;
       }
   }

   // delete the Bidang
   function delete(){
    
       // delete query
       $query = "DELETE FROM " . $this->table_name . " WHERE IdBidang = ?";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->IdBidang=htmlspecialchars(strip_tags($this->IdBidang));
    
       // bind id of record to delete
       $stmt->bindParam(1, $this->IdBidang);
    
       // execute query
       if($stmt->execute()){
           return true;
       }
    
       return false;
        
   }

}