<?php

class User{
   private $db;
   
   public function __construct()
   {
      $this->db = new Database();
   }
   
   public function register($data)
   {
      $this->db->query('INSERT INTO users (name, email, password) values (:name, :email, :password)');
      // Bind values
      $this->db->bind(':name', $data['name']);
      $this->db->bind(':email', $data['email']);
      $this->db->bind(':password', $data['password']);
      
      // Execute
      if( $this->db->execute() ){
         return true;
      } else {
         return false;
      }
   }
   
   public function login($email,$password)
   {
      $this->db->query('SELECT * from users where email = :email');
      $this->db->bind(':email', $email);
      $row = $this->db->single();
      
      $hashed_password = $row->password;
      if( password_verify($password,$hashed_password) ){
         return $row;
      } else {
         return false;
      }
   }
   
   public function findUserByEmail($email)
   {
      $this->db->query('SELECT * FROM users WHERE email = :email');
      // Bind values
      $this->db->bind(':email', $email);
      $row = $this->db->single();
      
      // Check row
      if( $this->db->rowCount() > 0 ){
         return true;
      } else{
         return false;
      }
   }
   
   
   
}