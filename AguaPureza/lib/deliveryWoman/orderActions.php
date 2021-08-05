<?php
    include_once "lib/user.php";
    include_once "lib/alert.php";
    class orderActions extends user {
        
        public function takeOrder($idOrder, $idWorker) {
            if ($this->isUser()){
                $sql = $this->makeSql("Update orderInfo Set idWorker=$idWorker, isTaken=1 Where idOrder = $idOrder");
                if ($sql) {
                    alert("Tomaste la orden");
                } else {
                    alert("Error al tomar la Orden");
                }
            } else {
                alert("Operacion denegada");
            }
        }
        public function leaveOrder($idOrder, $idWorker) {
            if ($this->isUser()){
                $sql = $this->makeSql("Update orderInfo Set idWorker=null, isTaken=0 Where idOrder = $idOrder");
                if ($sql) {
                    alert("Dejaste la orden");
                } else {
                    alert("Error al tomar la Orden");
                }
            } else {
                alert("Operacion denegada");
            }
        }
        public function deliverOrder($idOrder, $idWorker) {
            if ($this->isUser()){
                $sql = $this->makeSql("Update orderInfo Set State=1 Where idOrder = $idOrder");
                if ($sql) {
                    alert("Entregaste la orden");
                } else {
                    alert("Error al tomar la Orden");
                }
            } else {
                alert("Operacion denegada");
            }
        }
        
        public function isUser() {
            if (isset($_SESSION["name"])) {
                if ($_SESSION["kind"] == 2) {
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

