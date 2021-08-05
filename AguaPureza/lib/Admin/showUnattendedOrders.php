<?php
include_once "../user.php";
include_once "../session.php";
include_once "../alert.php";
$session = new session();

if (!isset($_SESSION["kind"])) {
    exit;
}

$user = new user();
$result = $user->makeSql("Select oi.idOrder, oi.Date, oi.Quantity As quantity, p.Name As product, d.street As street, w.name From orderInfo as oi, worker as w, product as p, direction as d Where p.idProduct = oi.idProduct And d.idDirection = oi.idDirection And d.idCustomer = oi.idCustomer And w.idWorker = oi.idWorker And oi.State = 0 Order By oi.idOrder");
?>
    <h1 id='Title'>Pedidos sin entregar</h1>
    <table id='PedidosSinEntregar' style="overflow-y:auto;">
    <tr>
        <th> ID </td>
        <th> Fecha </td>
        <th> Cantidad </td>
        <th> Nombre producto </td>
        <th> Dirección </td>
        <th> Empleado </th>
    </tr>
<?php
foreach ($result as $row) {
?>
<tr>
    <td align="center">
        <input type='text' id='idDirection' required value='<?php echo $row['idOrder'];?>' maxlength='4' size='4' readonly>
    </td>
    <td align="center">
        <input type='text' id='date' required value='<?php echo $row['Date'];?>' maxlength='10' size='10' readonly>
    </td>
    <td align="center">
        <input type='text' id='name' required value='<?php echo $row['quantity'];?>' maxlength='5' size='5' readonly>
    </td>
    <td align="center">
        <input type='text' id='intNumber' value='<?php echo $row['product'];?>' maxlength='15' size='15' readonly>
    </td>
    <td align="center">
        <input type='text' id='street' required value='<?php echo $row['street'];?>' maxlength='50' size='25' readonly>
    </td>
    <td align="center">
        <input type='text' id='street' required value='<?php echo $row['name'];?>' maxlength='45' size='15' readonly>
    </td>
</tr>
<?php
}
?>
</table>
<h1 id='Title'>Pedidos Pendientes</h1>
<table id='PedidosPendientes' style="overflow-y:auto;">
<?php
$result = $user->makeSql("Select oi.idOrder, oi.Date, oi.Quantity As quantity, p.Name As product, d.street As street, oi.State as state From orderInfo as oi, product as p, direction as d Where p.idProduct = oi.idProduct And d.idDirection = oi.idDirection And d.idCustomer = oi.idCustomer And oi.State = 0 And oi.isTaken = 0 Order By oi.idOrder");
?>
    <tr>
        <th> ID </td>
        <th> Fecha </td>
        <th> Cantidad </td>
        <th> Nombre producto </td>
        <th> Dirección </td>
        <th> Estado </td>
    </tr>
<?php
foreach ($result as $row) {
?>
<tr>
    <td align="center">
        <input type='text' id='idDirection' required value='<?php echo $row['idOrder'];?>' maxlength='4' size='4' readonly>
    </td>
    <td align="center">
        <input type='text' id='date' required value='<?php echo $row['Date'];?>' maxlength='10' size='10' readonly>
    </td>
    <td align="center">
        <input type='text' id='name' required value='<?php echo $row['quantity'];?>' maxlength='5' size='5' readonly>
    </td>
    <td align="center">
        <input type='text' id='intNumber' value='<?php echo $row['product'];?>' maxlength='15' size='15' readonly>
    </td>
    <td align="center">
        <input type='text' id='street' required value='<?php echo $row['street'];?>' maxlength='50' size='25' readonly>
    </td>
    <td align="center">
<?php
    switch ($row['state']){
        case 0: echo "<input type='text' id='state' name='state' required readonly value='Pendiente' size='10'>"; break;
        case 1: echo "<input type='text' id='state' name='state' required readonly value='ERROR' size='5'>"; break;
        default: echo "<input type='text' id='state' name='state' required readonly value='ERROR+' size='5'>";
    }
?>
    </td>
</tr>
<?php
}
?>
</table>
<h1 id='Title'>Pedidos Entregados</h1>
<table id='PedidosPendientes' style="overflow-y:auto;">
<?php
$result = $user->makeSql("Select oi.idOrder, oi.Date, oi.Quantity As quantity, p.Name As product, d.street As street, u.username From orderInfo as oi, user as u, product as p, direction as d Where p.idProduct = oi.idProduct And d.idDirection = oi.idDirection And d.idCustomer = oi.idCustomer And u.id = oi.idWorker And oi.State = 1 Order By oi.idOrder");
?>
    <tr>
        <th> ID </td>
        <th> Fecha </td>
        <th> Cantidad </td>
        <th> Nombre producto </td>
        <th> Dirección </td>
        <th> Usuario </td>
    </tr>
<?php
foreach ($result as $row) {
?>
<tr>
    <td align="center">
        <input type='text' id='idDirection' required value='<?php echo $row['idOrder'];?>' maxlength='4' size='4' readonly>
    </td>
    <td align="center">
        <input type='text' id='date' required value='<?php echo $row['Date'];?>' maxlength='10' size='10' readonly>
    </td>
    <td align="center">
        <input type='text' id='name' required value='<?php echo $row['quantity'];?>' maxlength='5' size='5' readonly>
    </td>
    <td align="center">
        <input type='text' id='intNumber' value='<?php echo $row['product'];?>' maxlength='15' size='15' readonly>
    </td>
    <td align="center">
        <input type='text' id='street' required value='<?php echo $row['street'];?>' maxlength='50' size='25' readonly>
    </td>
    <td align="center">
        <input type='text' id='street' required value='<?php echo $row['username'];?>' size='15' readonly>
    </td>
</tr>
<?php
}
?>
</table>
