<?php
class Prices{
 
    // database connection and table name
    private $conn;
    private $table_name = "prices";
 
    // object properties
    public $Id;
    public $ShiperId;
    public $ReciverId;
    public $PortType;
    public $PayType;
    public $FromCity;
    public $ToCity;
    public $Price;
    
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    //read One Price
    function readOne(){
        // select all query
        $query = "SELECT * from ".$this->table_name." 
        where
        ShiperId=? and ReciverId=? and PortType=? and PayType=? and FromCity=? and ToCity=?";
       
          // prepare query statement
          $stmt = $this->conn->prepare($query);

          $this->ShiperId=htmlspecialchars(strip_tags($this->ShiperId));
          $this->ReciverId=htmlspecialchars(strip_tags($this->ReciverId));
          $this->PortType=htmlspecialchars(strip_tags($this->PortType));
          $this->PayType=htmlspecialchars(strip_tags($this->PayType));
          $this->FromCity=htmlspecialchars(strip_tags($this->FromCity));
          $this->ToCity=htmlspecialchars(strip_tags($this->ToCity));

          $stmt->bindParam(1, $this->ShiperId);
          $stmt->bindParam(2, $this->ReciverId);
          $stmt->bindParam(3, $this->PortType);
          $stmt->bindParam(4, $this->PayType);
          $stmt->bindParam(5, $this->FromCity);
          $stmt->bindParam(6, $this->ToCity);
       
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
                   ShiperId=:ShiperId, ReciverId=:ReciverId, PortType=:PortType, PayType=:PayType, 
                   FromCity=:FromCity, ToCity=:ToCity, Price=:Price";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->ShiperId=htmlspecialchars(strip_tags($this->ShiperId));
       $this->ReciverId=htmlspecialchars(strip_tags($this->ReciverId));
       $this->PortType=htmlspecialchars(strip_tags($this->PortType));
       $this->PayType=htmlspecialchars(strip_tags($this->PayType));
       $this->FromCity=htmlspecialchars(strip_tags($this->FromCity));
       $this->ToCity=htmlspecialchars(strip_tags($this->ToCity));
       $this->Price=htmlspecialchars(strip_tags($this->Price));
       // bind values
       $stmt->bindParam(":ShiperId", $this->ShiperId);
       $stmt->bindParam(":ReciverId", $this->ReciverId);
       $stmt->bindParam(":PortType", $this->PortType);
       $stmt->bindParam(":PayType", $this->PayType);
       $stmt->bindParam(":FromCity", $this->FromCity);
       $stmt->bindParam(":ToCity", $this->ToCity);
       $stmt->bindParam(":Price", $this->Price);
    
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
               ShiperId=:ShiperId, 
               ReciverId=:ReciverId, 
               PortType=:PortType, 
               PayType=:PayType, 
               FromCity=:FromCity, 
               ToCity=:ToCity, 
               Price=:Price                  
               WHERE
                   Id = :Id";
    
       // prepare query statement
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->Id=htmlspecialchars(strip_tags($this->Id));
       $this->ShiperId=htmlspecialchars(strip_tags($this->ShiperId));
       $this->ReciverId=htmlspecialchars(strip_tags($this->ReciverId));
       $this->PortType=htmlspecialchars(strip_tags($this->PortType));
       $this->PayType=htmlspecialchars(strip_tags($this->PayType));
       $this->FromCity=htmlspecialchars(strip_tags($this->FromCity));
       $this->ToCity=htmlspecialchars(strip_tags($this->ToCity));
       $this->Price=htmlspecialchars(strip_tags($this->Price));
       // bind values
       $stmt->bindParam(":Id", $this->Id);
       $stmt->bindParam(":ShiperId", $this->ShiperId);
       $stmt->bindParam(":ReciverId", $this->ReciverId);
       $stmt->bindParam(":PortType", $this->PortType);
       $stmt->bindParam(":PayType", $this->PayType);
       $stmt->bindParam(":FromCity", $this->FromCity);
       $stmt->bindParam(":ToCity", $this->ToCity);
       $stmt->bindParam(":Price", $this->Price);
    
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