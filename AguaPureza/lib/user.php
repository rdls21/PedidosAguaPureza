<?php
    include "db.php";
    include_once "alert.php";
    
    class user extends db {
        private $name;
        private $kind;
        private $active;
        
        public function authUser($user, $pass){
            $sql = "Select * From user Where userName = '$user'";
            $result = $this->connect()->query($sql);
            /* Get the number of rows */
            $num_of_rows = $result->num_rows; // Unused
            if ($num_of_rows > 1) {
                alert("Hay mas de un usuario con este nombre, conctacte un administrador");
                exit;
            }
            if ($result->num_rows > 0) {
                $password = "";
                foreach ($result as $row){
                    $password = $row["password"];
                }
                //Acceder?
                if (password_verify($pass, $password)) {
                    session_regenerate_id(); //Update the current session id with a newly generated one
                    foreach ($result as $row){
                        $this -> name = $row["username"]; //mayusculas importan
                        $this -> kind = $row["kind"];
                        $this -> active = $row["active"];
                    }
                    return true;
                } else {
                    alert("Contraseña Incorrecta!");
                    return false;
                }
            } else {
                alert("Usuario incorrecto!");
                return false;
            }
        }
        
        public function getName() {
            return $this -> name;
        }

        public function getKind() {
            return $this -> kind;
        }
        
        public function getActive() {
            return $this -> active;
        }
        
        public function makeSql($sql) { //Look for security
            try {
                $result = $this->connect()->query($sql);
                return $result;
            } catch (mysqli_sql_exception $e) {
                alert("Excepción capturada: " .  $e->getMessage());
            }
        }

    }
?>
