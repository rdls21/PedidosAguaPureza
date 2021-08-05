<?php
    //IF SOMETHING GOES WRHONG: https://apple.stackexchange.com/questions/306101/apache2-httpd-not-working-after-update-to-high-sierra
    include_once "lib/session.php";
    if(!isset($_SESSION["name"])) {
        header("location: index.html");
        exit;
    }
    if (isset($_POST["option"])) {
        include_once "lib/salesMan/orderActions.php";
        $ven = new orderActions();
        if ($_POST["option"]=='Guardar'){
            $idOrder = $_POST["idOrder"];
            $Quantity = $_POST["quantity"];
            $idProduct = $_POST["product"];
            $idCustomer = $_POST["customer"];
            $idDirection = $_POST["direction"];
            $State = $_POST["state"];
            $ven->editOrder($idOrder, $Quantity, $idProduct, $idCustomer, $idDirection, $State);
        }
        if ($_POST["option"]=='Agregar'){
            $idOrder = $_POST["idOrder"];
            $Date = $_POST["date"];
            $Quantity = $_POST["quantity"];
            $idProduct = $_POST["product"];
            $idCustomer = $_POST["customer"];
            $idDirection = $_POST["direction"];
            
            $ven->addOrder($idOrder, $Date, $Quantity, $idProduct, $idCustomer, $idDirection);
        }
    }
    
?>

<?php
   date_default_timezone_set("America/Mexico_City");
?>

<div class="content">
  <h2>Lista de pedidos</h2>
    <div class="content">
        <button onclick="showDetail(false, 0)" class="addButton">Agregar pedido</button>
        <table style="overflow-x:auto;">
        <tr>
            <th> ID </td>
            <th> Producto </td>
            <th> Cantidad </td>
            <th> Dirección </td>
            <th> Estado </td>
        </tr>
        <?php
            include_once "lib/user.php";
            $user = new user();
            
            $result = $user->makeSql("Select oi.idOrder, p.Name As name, oi.Quantity As quantity, d.street As street, oi.state From orderInfo as oi, product as p, direction as d Where p.idProduct = oi.idProduct And d.idDirection = oi.idDirection And d.idCustomer = oi.idCustomer Order By oi.idOrder");
            // Load page for a admin user
            if ($result !== false) {
                foreach ($result as $row){
                    echo "<tr>";
                    echo "<td value=" . $row['idOrder'] . ">" . $row['idOrder'] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
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
<div id="myModal" class="modal">
    <form id="modal" action"" class="modal-content"method="post">
        <span class="close">&times;</span>
    </form>
</div>

<!--/* MARK: JS */--!>

<script type="text/javascript">
function updateDirections() {
    var id = document.getElementById("customer").value;
    var url = "lib/salesMan/orderDir.php";
    var params = 'id=' + id;
    //alert(params);
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); // LOL
    }
    
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
            document.getElementById("detalle").innerHTML=xmlhttp.responseText;
        }
    }

    xmlhttp.open("POST", url, true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(params);
}

function showDetail(id){
    modal.style.display = "block";
    
    var url = "lib/salesMan/orderInfoData.php";
    var params = 'id=' + id;
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
var span = document.getElementsByClassName("close")[0];

    var elements = document.getElementsByTagName('tr');
    for(var i=1; i<elements.length;i++) { //Skip Title
        (elements)[i].addEventListener("click", function() {
                                       showDetail(this.rowIndex);
                                       });
    }
    span.onclick = function() {
      modal.style.display = "none";
    }
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }


</script>
