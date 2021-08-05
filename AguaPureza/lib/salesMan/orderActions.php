<?php
    include_once "lib/user.php";
    include_once "lib/alert.php";
    class orderActions extends user {
        
        public function editOrder($idOrder, $Quantity, $idProduct, $idCustomer, $idDirection, $State) {
            if ($this->isUser()){
                $sql = $this->makeSql("Update orderInfo Set Quantity='$Quantity', idProduct=$idProduct, idCustomer=$idCustomer, idDirection=$idDirection, State=$State Where idOrder=$idOrder");
                if ($sql) {
                    alert("Datos de la Orden editados correctamente");
                } else {
                    alert("Error: Orden");
                }
            } else {
                alert("Operacion denegada");
            }
        }
        
        public function addOrder($idOrder, $Date, $Quantity, $idProduct, $idCustomer, $idDirection) {
            if ($this->isUser()){
                alert($idDirection);
                $sql = $this->makeSql("Insert Into orderInfo (idOrder, Date, Quantity, idProduct, idCustomer, idDirection, State, isTaken) Values (0 , '$Date', $Quantity, $idProduct, $idCustomer, $idDirection, 0, 0)");
                if ($sql) {
                    alert("Datos del cliente editados correctamente");
                } else {
                    alert("Error: Datos cliente");
                }
            }
        }
        
        public function isUser() {
            if (isset($_SESSION["name"])) {
                if ($_SESSION["kind"] == 3) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }
?>
