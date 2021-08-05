<?php
    // Load page for a admin user
    //IF SOMETHING GOES WRHONG: https://apple.stackexchange.com/questions/306101/apache2-httpd-not-working-after-update-to-high-sierra
    include_once "lib/session.php";
    include_once "lib/alert.php";
    if(!isset($_SESSION["name"])) {
        header("location: index.html");
        exit;
    }
    include_once "lib/deliveryWoman/orderActions.php";
    $orderActions = new orderActions();
    include_once "lib/user.php";
    $repUser = new user();
    $user = $_SESSION["name"];
    $users = $repUser->makeSql("Select id From user Where UserName = '$user'");
    $id = "";
    foreach ($users as $row) {
        $id=$row["id"];
    }
    $result = $repUser->makeSql("Select * From orderInfo Where idWorker = '$id' And State = 0 And isTaken = 1");
    $num_of_rows = $result->num_rows; // Unused
    if ($num_of_rows > 1) {
        alert("Hay mas de una orden con este usuario, conctacte un administrador");
        exit;
    } else {
        if ($num_of_rows == 1) {
            if (isset($_POST["option"])){
                if ($_POST["option"]=='Tomar') {
                    alert("No puedes tomar mas pedidos, primero entrega el que tienes pendiente");
                }
                if ($_POST["option"]=='Dejar'){
                    $idOrder = $_POST["idOrder"];
                    $idWorker = $id;
                    
                    $orderActions->leaveOrder($idOrder, $idWorker);
                    header("Refresh:0");
                }
                if ($_POST["option"]=='Entregado'){
                    $idOrder = $_POST["idOrder"];
                    $idWorker = $id;
                    
                    $orderActions->deliverOrder($idOrder, $idWorker);
                    header("Refresh:0");
                }
            }
            foreach ($result as $row) {
                $idOrder=$row["idOrder"];
            }
            ?>
            <div class="content">
                <h2>Lista de pedidos por entregar</h2>
                <div class="content">
                    <table id='showToDoOrders' style="overflow-x:auto;">
                    <tr>
                        <th> ID </td>
                        <th> Producto </td>
                        <th> Cantidad </td>
                        <th> Dirección </td>
                        <th> Estado </td>
                    </tr>
                    <?php
                        $result = $repUser->makeSql("Select oi.idOrder, p.Name As name, p.unitOfMeasure as unitOfMeasure, oi.Quantity As quantity, d.street As street, oi.state From orderInfo as oi, product as p, direction as d Where p.idProduct = oi.idProduct And d.idDirection = oi.idDirection And d.idCustomer = oi.idCustomer And oi.idOrder = $idOrder And oi.isTaken = 1");
                        if ($result !== false) {
                            foreach ($result as $row){
                                echo "<tr id='toDo'>";
                                echo "<td value=" . $row['idOrder'] . ">" . $row['idOrder'] . "</td>";
                                echo "<td>" . $row["name"]." ".$row["unitOfMeasure"] . "</td>";
                                echo "<td>" . $row["quantity"] . "</td>";
                                echo "<td>" . $row["street"] . "</td>";
                                switch ($row['state']){
                                    case 0: echo "<td>Pendiente</td>"; break;
                                    case 1: echo "<td>Entregado</td>"; break;
                                    default: echo "<td>ERROR.. </td>";
                            }
                            echo "</tr>";
                            }
                        }
                    ?>
                    </table>
                </div>
            </div>
            <?php
        } else {
            if (isset($_POST["option"])) {
                if ($_POST["option"]=='Tomar'){
                    $idOrder = $_POST["idOrder"];
                    $idWorker = $id;
                    $orderActions->takeOrder($idOrder, $idWorker);
                    header("Refresh:0");
                }
            }
        }
    }
?>

<div class="content">
  <h2>Lista de pedidos</h2>
    <div class="content">
        <table id='showOrders' style="overflow-x:auto;">
        <tr>
            <th> ID </td>
            <th> Producto </td>
            <th> Cantidad </td>
            <th> Dirección </td>
            <th> Estado </td>
        </tr>
        <?php
            $result = $repUser->makeSql("Select oi.idOrder, p.Name As name, p.unitOfMeasure as unitOfMeasure, oi.Quantity As quantity, d.street As street, oi.state From orderInfo as oi, product as p, direction as d Where p.idProduct = oi.idProduct And d.idDirection = oi.idDirection And d.idCustomer = oi.idCustomer And oi.State = 0 And oi.isTaken = 0 Order By oi.idOrder");
            if ($result !== false) {
                foreach ($result as $row){
                    echo "<tr>";
                    echo "<td value=" . $row['idOrder'] . ">" . $row['idOrder'] . "</td>";
                    echo "<td>" . $row["name"]." ".$row["unitOfMeasure"] . "</td>";
                    echo "<td>" . $row["quantity"] . "</td>";
                    echo "<td>" . $row["street"] . "</td>";
                    switch ($row['state']){
                        case 0: echo "<td>Pendiente</td>"; break;
                        case 1: echo "<td>Entregado</td>"; break;
                        default: echo "<td>ERROR.. </td>";
                    }
                    echo "</tr>";
                }
            }
        ?>
        </table>
    </div>
</div>

<!-- /* MARK: Modal */ --!>
<div id="myModal" class="deliveryModal">
    <form id="modal" action"" class="modal-content"method="post">
    </form>
</div>

<!--/* MARK: JS */--!>
<script type="text/javascript">
function showDetail(id, opt){
    modal.style.display = "block";
    
    var url = "lib/deliveryWoman/orderInfoData.php";
    var params = 'id=' + getTableElement(0,id,opt) + '&opt=' + opt;
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); // LOL
    }
    
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
            document.getElementById("modal").innerHTML=xmlhttp.responseText;
        }
    }

    xmlhttp.open("POST", url, true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(params);
}

// Get the modal
var modal = document.getElementById("myModal");
// Get the <span> element that closes the modal

    var elements = document.getElementsByTagName('tr');
    for(var i=1; i<elements.length;i++) { //Skip Title
        if (((elements)[i].id) == "toDo"){
            (elements)[i].addEventListener("click", function() {
                                                 showDetail(this.rowIndex, 1);
                                                 });
            i+=1;
        } else {
            (elements)[i].addEventListener("click", function() {
            showDetail(this.rowIndex, 0);
            });
        }
    }
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }

function getTableElement(x, y, opt){
    //gets table
    
    var oTable = document.getElementById('showOrders');
    if (opt == 1) {
        oTable = document.getElementById('showToDoOrders');
    }
    //gets rows of table
    var rowLength = oTable.rows.length;
    //loops through rows
    for (i = 0; i < rowLength; i++){
        //gets cells of current row
        var oCells = oTable.rows.item(i).cells;
        //gets amount of cells of current row
        var cellLength = oCells.length;
        //loops through each cell in current row
        for(var j = 0; j < cellLength; j++){
            // get your cell info here
            if (i == y && j == x) {
                return cellVal = oCells.item(j).innerText;
            }
        }
     }
}

</script>

