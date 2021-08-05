<?php
    include_once "lib/user.php";
    include_once "lib/alert.php";
    class productActions extends user {
        
        public function editProduct($id, $name, $unitofmeasure) {
            if ($this->isUser()){
                $sql = $this->makeSql("Update product Set Name = '$name', UnitOfMeasure = '$unitofmeasure' where idProduct = $id");
                if ($sql) {
                    alert("Producto editado correctamente");
                } else {
                    alert("Error");
                }
            } else {
                alert("No tienes privilegios");
            }
            
        }
        
        public function addProduct($id, $name, $unitofmeasure) {
            if ($this->isUser()){
                $sql = $this->makeSql("Insert Into product Values (0 , '$name', '$unitofmeasure')");
                if ($sql) {
                    alert("Producto agregado correctamente");
                } else {
                    alert("Error");
                }
                
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
