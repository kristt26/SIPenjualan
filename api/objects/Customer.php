<?php
class Customer{
 
    // database connection and table name
    private $conn;
    private $table_name = "customer";
 
    // object properties
    public $Id;
    public $Name;
    public $CustomerType;
    public $ContactName;
    public $Phone1;
    public $Phone2;
    public $Handphone;
    public $Address;
    public $Email;
    public $CityID;
    
 
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

    function readOne(){
    
        // select all query
        $query = "SELECT * from ".$this->table_name." WHERE Id=?";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $this->Id=htmlspecialchars(strip_tags($this->Id));
    
       // bind id of record to delete
       $stmt->bindParam(1, $this->Id);
     
        // execute query
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->Name = $row['Name'];
        $this->CustomerType=$row['CustomerType'];
        $this->ContactName=$row['ContactName'];
        $this->Phone1=$row['Phone1'];
        $this->Phone2=$row['Phone2'];
        $this->Handphone=$row['Handphone'];
        $this->Address=$row['Address'];
        $this->Email=$row['Email'];
        $this->CityID=$row['CityID'];
     
     }

   // create product
    function create(){
    
       // query to insert record
       $query = "INSERT INTO
                   " . $this->table_name . "
               SET
                   Name=:Name, CustomerType=:CustomerType, ContactName=:ContactName, Phone1=:Phone1, 
                   Phone2=:Phone2, Handphone=:Handphone, Address=:Address, Email=:Email, CityID=:CityID";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->Name=htmlspecialchars(strip_tags($this->Name));
       $this->CustomerType=htmlspecialchars(strip_tags($this->CustomerType));
       $this->ContactName=htmlspecialchars(strip_tags($this->ContactName));
       $this->Phone1=htmlspecialchars(strip_tags($this->Phone1));
       $this->Phone2=htmlspecialchars(strip_tags($this->Phone2));
       $this->Handphone=htmlspecialchars(strip_tags($this->Handphone));
       $this->Address=htmlspecialchars(strip_tags($this->Address));
       $this->Email=htmlspecialchars(strip_tags($this->Email));
       $this->CityID=htmlspecialchars(strip_tags($this->CityID));
      
       // bind values
       $stmt->bindParam(":Name", $this->Name);
       $stmt->bindParam(":CustomerType", $this->CustomerType);
       $stmt->bindParam(":ContactName", $this->ContactName);
       $stmt->bindParam(":Phone1", $this->Phone1);
       $stmt->bindParam(":Phone2", $this->Phone2);
       $stmt->bindParam(":Handphone", $this->Handphone);
       $stmt->bindParam(":Address", $this->Address);
       $stmt->bindParam(":Email", $this->Email);
       $stmt->bindParam(":CityID", $this->CityID);
    
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
                    Name=:Name, 
                    CustomerType=:CustomerType, 
                    ContactName=:ContactName, 
                    Phone1=:Phone1, 
                    Phone2=:Phone2, 
                    Handphone=:Handphone, 
                    Address=:Address, 
                    Email=:Email, 
                    CityID=:CityID                  
               WHERE
                   Id = :Id";
    
       // prepare query statement
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->Id=htmlspecialchars(strip_tags($this->Id));
       $this->Name=htmlspecialchars(strip_tags($this->Name));
       $this->CustomerType=htmlspecialchars(strip_tags($this->CustomerType));
       $this->ContactName=htmlspecialchars(strip_tags($this->ContactName));
       $this->Phone1=htmlspecialchars(strip_tags($this->Phone1));
       $this->Phone2=htmlspecialchars(strip_tags($this->Phone2));
       $this->Handphone=htmlspecialchars(strip_tags($this->Handphone));
       $this->Address=htmlspecialchars(strip_tags($this->Address));
       $this->Email=htmlspecialchars(strip_tags($this->Email));
       $this->CityID=htmlspecialchars(strip_tags($this->CityID));
      
       // bind values
       $stmt->bindParam(":Id", $this->Id);
       $stmt->bindParam(":Name", $this->Name);
       $stmt->bindParam(":CustomerType", $this->CustomerType);
       $stmt->bindParam(":ContactName", $this->ContactName);
       $stmt->bindParam(":Phone1", $this->Phone1);
       $stmt->bindParam(":Phone2", $this->Phone2);
       $stmt->bindParam(":Handphone", $this->Handphone);
       $stmt->bindParam(":Address", $this->Address);
       $stmt->bindParam(":Email", $this->Email);
       $stmt->bindParam(":CityID", $this->CityID);
    
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