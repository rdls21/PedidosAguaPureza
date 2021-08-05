<?php
    include_once "lib/user.php";
    include_once "lib/alert.php";
    class userActions extends user {
        
        public function editUser($id, $username, $password, $kind, $active, $RFC, $Name, $Tel, $Dir) {
            if ($this->isUser()){
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $sql = $this->makeSql("Update user Set username = '$username', Password = '$hash', kind = $kind, active = $active where id = $id");
                if ($sql) {
                    alert("Usuario editado correctamente");
                } else {
                    alert("Error");
                }
                
                $result = $this->makeSql("Select id From user Where username = '$username'");
                foreach ($result as $row) {
                    $id_worker = $row['id'];
                }
                
                $sql = $this->makeSql("Update worker Set RFC = '$RFC', Name = '$Name', Tel = '$Tel', Dir = '$Dir' Where id_worker = $id_worker");
                if ($sql) {
                    alert("Datos de usuario editados correctamente");
                } else {
                    alert("Error");
                }
            } else {
                echo "No tienes privilegios";
            }
            
        }
        
        public function addUser($username, $password, $kind, $active, $RFC, $Name, $Tel, $Dir) {
            if ($this->isUser()){
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $tipo = $kind;
//                alert($username);
//                alert($kind);
//                alert($active); //Test Only
                $activo = $active; // Test Only
                $sql = $this->makeSql("Insert Into user Values (0 ,'$username', '$hash', $tipo, $activo)");
                if ($sql) {
                    alert("Usuario agregado correctamente");
                } else {
                    alert("Error");
                }
                
                $result = $this->makeSql("Select id From user Where username = '$username'");
                foreach ($result as $row) {
                    $id_worker = $row['id'];
                }
                $sql = $this->makeSql("Insert Into worker values($id_worker, '$RFC', '$Name', '$Tel', '$Dir')");
                
                if ($sql) {
                    alert("Datos de Usuario agregados correctamente");
                } else {
                    alert("Error");
                }
                
            } else {
                echo "No tienes privilegios";
            }
          
        }
        
        public function getPersonalData($id) {
            if ($this->isUser()){
                
            } else {
                echo "No tienes privilegios";
            }
        }
        
        
        public function isUser() {
            if (isset($_SESSION["name"])) {
                if ($_SESSION["kind"] == 1) {
                    return true;
                } else {
                    return false;
                }
            } else {
                alert("Operacion denegada");
                return false;
            }
        }
        
    }
?>
