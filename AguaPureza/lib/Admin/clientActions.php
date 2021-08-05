<?php
    include_once "lib/user.php";
    include_once "lib/alert.php";
    class clientActions extends user {
        
        public function editCustomer($id, $rfc, $name, $tel, $idDirection, $street, $intNumber, $suburb, $reference) {
            if ($this->isUser()){
                $sql = $this->makeSql("Update customer Set RFC = '$rfc', name = '$name', tel = '$tel' Where idCustomer = $id");
                if ($sql) {
                    alert("Datos del cliente editados correctamente");
                } else {
                    alert("Error: Datos cliente");
                }
                
                $result = $this->makeSql("Select count(*) as count From direction Where idCustomer = $id");
                foreach ($result as $row) {
                    $count = $row['count'];
                }
                //alert($count);//TEST
                
                for($i=0;$i<$count;$i++){
                    $sql = $this->makeSql("Update direction Set street = '$street[$i]', intNumber = '$intNumber[$i]', suburb = '$suburb[$i]', reference = '$reference[$i]' Where idDirection = $idDirection[$i] AND idCustomer = $id");
                    if ($sql) {
                    } else {
                        alert("Error: Dirección: del cliente");
                    }
                }
                $countpost = count($idDirection);
                //alert($countpost);//TEST
                $newDirections = $countpost - $count;
                //alert($newDirections);//TEST
                if ($newDirections > 0){
                    for($i=$count;$i<$countpost;$i++){
                        $sql = $this->makeSql("Insert Into direction values ($idDirection[$i], '$street[$i]', '$intNumber[$i]', '$suburb[$i]', '$reference[$i]', $id)");
                        if ($sql) {
                            alert("Nuevo Domicilio Agregado");
                        } else {
                            alert("Error: Direccion: cliente");
                        }
                    }
                } else { alert("Ningún Nuevo Domicilio"); }
            } else {
                alert("No tienes privilegios");
            }
        }
        
        public function addCustomer($id, $rfc, $name, $tel, $idDirection, $street, $intNumber, $suburb, $reference) {
            if ($this->isUser()){
                $sql = $this->makeSql("Insert Into customer Values (0 , '$rfc', '$name', '$tel')");
                if ($sql) {
                    alert("Datos del cliente editados correctamente");
                } else {
                    alert("Error: Datos cliente");
                }
                
                $result = $this->makeSql("Select idCustomer From customer Where RFC = '$rfc' AND name = '$name' AND tel = '$tel'");
                foreach ($result as $row) {
                    $idCustomer = $row['idCustomer'];
                }
                alert($idCustomer);//TEST
                $countpost = count($idDirection);
                for($i=0;$i<$countpost;$i++){ //i+1 id;
                    $sql = $this->makeSql("Insert Into direction values (1, '$street[$i]', '$intNumber[$i]', '$suburb[$i]', '$reference[$i]', $idCustomer)");
                    if ($sql) {
                            alert("Dirección: ", $i+1 ," del cliente Agregada correctamente");
                    } else {
                            alert("Error: Direccion: ", $i+1 ," cliente");
                    }
                }
            } else {
                alert("No tienes privilegios");
            }
        }
        
        public function isUser() {
            if (isset($_SESSION["name"])) {
                if ($_SESSION["kind"] == 1 || $_SESSION["kind"] == 3) {
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
