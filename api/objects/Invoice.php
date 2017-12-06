<?php
class Invoice{
 
    // database connection and table name
    private $conn;
    private $table_name = "invoices";
 
    // object properties
    public $Id;
    public $Number;
    public $CustomerId;
    public $InvoiceStatus;
    public $DeadLine;
    public $InvoicePayType;
    public $CreateDate;
    public $UserId;
    public $PaidDate;
    
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
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
                   Number=:Number, CustomerId=:CustomerId, InvoiceStatus=:InvoiceStatus, DeadLine=:DeadLine, 
                   InvoicePayType=:InvoicePayType, CreateDate=:CreateDate, UserId=:UserId, PaidDate=:PaidDate";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->Number=htmlspecialchars(strip_tags($this->Number));
       $this->CustomerId=htmlspecialchars(strip_tags($this->CustomerId));
       $this->InvoiceStatus=htmlspecialchars(strip_tags($this->InvoiceStatus));
       $this->DeadLine=htmlspecialchars(strip_tags($this->DeadLine));
       $this->InvoicePayType=htmlspecialchars(strip_tags($this->InvoicePayType));
       $this->CreateDate=htmlspecialchars(strip_tags($this->CreateDate));
       $this->UserId=htmlspecialchars(strip_tags($this->UserId));
       $this->PaidDate=htmlspecialchars(strip_tags($this->PaidDate));
      
       // bind values
       $stmt->bindParam(":Number", $this->Number);
       $stmt->bindParam(":CustomerId", $this->CustomerId);
       $stmt->bindParam(":InvoiceStatus", $this->InvoiceStatus);
       $stmt->bindParam(":DeadLine", $this->DeadLine);
       $stmt->bindParam(":InvoicePayType", $this->InvoicePayType);
       $stmt->bindParam(":CreateDate", $this->CreateDate);
       $stmt->bindParam(":UserId", $this->UserId);
       $stmt->bindParam(":PaidDate", $this->PaidDate);
    
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