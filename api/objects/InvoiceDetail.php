<?php
class InvoiceDetail{
 
    // database connection and table name
    private $conn;
    private $table_name = "invoicedetail";
 
    // object properties
    public $Id;
    public $InvoiceId;
    public $STT;
    
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function readBySTT(){
        
           // select all query
           $query = "SELECT * from ".$this->table_name." where STT=?";
        
           // prepare query statement
           $stmtBySTT = $this->conn->prepare($query);

           $this->STT=htmlspecialchars(strip_tags($this->STT));

           $stmtBySTT->bindParam(1, $this->STT);
        
           // execute query
           $stmtBySTT->execute();
        
           return $stmtBySTT;
    }

    function readByInvoice(){
        
        // select all query
        $query = "SELECT * from ".$this->table_name." where InvoiceId=?";
     
        // prepare query statement
        $stmtBySTT = $this->conn->prepare($query);

        $this->InvoiceId=htmlspecialchars(strip_tags($this->InvoiceId));

        $stmtBySTT->bindParam(1, $this->InvoiceId);
     
        // execute query
        $stmtBySTT->execute();
     
        return $stmtBySTT;
    }

    // read products
    function readOne(){
        
           // select all query
           $query = "SELECT * from ".$this->table_name." where InvoiceId=?";
        
           // prepare query statement
           $stmt = $this->conn->prepare($query);

           $this->InvoiceId=htmlspecialchars(strip_tags($this->InvoiceId));

           $stmt->bindParam(1, $this->InvoiceId);
        
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
                   InvoiceId=:InvoiceId, STT=:STT";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->InvoiceId=htmlspecialchars(strip_tags($this->InvoiceId));
       $this->STT=htmlspecialchars(strip_tags($this->STT));
      
       // bind values
       $stmt->bindParam(":InvoiceId", $this->InvoiceId);
       $stmt->bindParam(":STT", $this->STT);
    
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