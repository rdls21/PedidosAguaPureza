<?php
    class db {
        //Utilizamos encapsulamiento, solo esta clase podra utilizar estos atributos
        private $DB_host;
        private $DB_user;
        private $DB_pass;
        private $DB_dbna;
        
        //viewDidLoad
        public function __construct() {
            $this -> DB_host = "localhost";
            $this -> DB_user = "admin";
            $this -> DB_pass = "HEHE_NOPE";
            $this -> DB_dbna = "aguapureza";
        }
        
        function connect() {
            try {
                $con = new mysqli($this->DB_host, $this->DB_user, $this->DB_pass, $this->DB_dbna);
                return $con;
            } catch(mysqli_exception $e) {
                print_r("Error de conexión" . $e->getMessage());
            }
            //Whats the diference between mysqli_ exception and connect_errno?
        }
    }
?>
