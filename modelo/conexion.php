<?php
   class Conexion{
    private $host= 'localhost';
    private $db_name ='mydb';
    private $username = 'root';
    private $password = '12345678';
    public  $conn;


    public function getConection(){
        $this->conn = null;

        try{
             $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}",$this->username,$this->password);
             $this->conn->exec("set names UTF8");
        } catch (PDOException $exception){
            echo "Error de Conexion".$exception->getMessage();
        }

        return $this->conn;
    }
   }
?>