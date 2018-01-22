<?php
class Users{
 
    // database connection and table name
    private $conn;
    private $table_name = "users";
 
    // object properties
    public $Id;
    public $NamaPegawai;
    public $Kontak;
    public $Email;
    public $Password;
    public $Jabatan;
    
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    //read One Price
    function readOne(){
        // select all query
        $query = "SELECT * from ".$this->table_name." 
        where Email=? and Password=?";
       
          // prepare query statement
          $stmt = $this->conn->prepare($query);

          $this->Email=htmlspecialchars(strip_tags($this->Email));
          $this->Password=htmlspecialchars(strip_tags($this->Password));
         
          $stmt->bindParam(1, $this->Email);
          $stmt->bindParam(2, $this->Password);
       
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
                   NamaPegawai=:NamaPegawai, Kontak=:Kontak, Email=:Email, Password=:Password, Jabatan=:Jabatan";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->NamaPegawai=htmlspecialchars(strip_tags($this->NamaPegawai));
       $this->Kontak=htmlspecialchars(strip_tags($this->Kontak));
       $this->Email=htmlspecialchars(strip_tags($this->Email));
       $this->Password=htmlspecialchars(strip_tags($this->Password));
       $this->Jabatan=htmlspecialchars(strip_tags($this->Jabatan));
      
       // bind values
       $stmt->bindParam(":NamaPegawai", $this->NamaPegawai);
       $stmt->bindParam(":Kontak", $this->Kontak);
       $stmt->bindParam(":Email", $this->Email);
       $stmt->bindParam(":Password", $this->Password);
       $stmt->bindParam(":Jabatan", $this->Jabatan);
    
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
                    NamaPegawai=:NamaPegawai, 
                    Kontak=:Kontak,
                    Email=:Email,
                    Jabatan=:Jabatan 
               WHERE
                   Id = :Id";
    
       // prepare query statement
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->Id=htmlspecialchars(strip_tags($this->Id));
       $this->NamaPegawai=htmlspecialchars(strip_tags($this->NamaPegawai));
       $this->Kontak=htmlspecialchars(strip_tags($this->Kontak));
       $this->Email=htmlspecialchars(strip_tags($this->Email));
       $this->Jabatan=htmlspecialchars(strip_tags($this->Jabatan));
    
       // bind new values
       $stmt->bindParam(":Id", $this->Id);
       $stmt->bindParam(":NamaPegawai", $this->NamaPegawai);
       $stmt->bindParam(":Kontak", $this->Kontak);
       $stmt->bindParam(":Email", $this->Email);
       $stmt->bindParam(":Jabatan", $this->Jabatan);
    
       // execute the query
       if($stmt->execute()){
           return true;
       }else{
           return false;
       }
   }


   function updatePassword(){
    
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                 Password=:Password 
            WHERE
                Id = :Id";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->Id=htmlspecialchars(strip_tags($this->Id));
    $this->Password=htmlspecialchars(strip_tags($this->Password));
 
    // bind new values
    $stmt->bindParam(":Id", $this->Id);
    $stmt->bindParam(":Password", $this->Password);
 
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
       $query = "DELETE FROM " . $this->table_name . " WHERE Id = ?";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->Id=htmlspecialchars(strip_tags($this->Id));
    
       // bind id of record to delete
       $stmt->bindParam(1, $this->Id);
    
       // execute query
       if($stmt->execute()){
           return true;
       }
    
       return false;
        
   }

}