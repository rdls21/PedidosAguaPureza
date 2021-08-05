<?php
    include_once "../user.php";
    include_once "../session.php";
    include_once "../alert.php";
    $session = new session();
    
    if (!isset($_SESSION["kind"])) {
        exit;
    }
    
    $user = new user();
    $idCustomer = $_POST["id"]; //idCustomer
?>
    <h2 id='Title'>Detalle Dirección</h2>
    <label type='text'>Cliente: </label>
    <select id='customer' name="customer" onchange="updateDirections()">
<?php
    $result = $user->makeSql("Select * from customer");
    foreach ($result as $row) {
?>
        <option value='<?=$row['idCustomer'];?>' <?=$row['idCustomer'] == $idCustomer ? ' selected="selected"' : ''; ?>> <?=$row['name']?> </option>
<?php
    }
?>
    </select>
    <label type='text'>Dirección: </label>
    <select id='direction' name="direction">
<?php
    $result = $user->makeSql("Select * from direction Where idCustomer = ". $idCustomer);
    foreach ($result as $row) {
?>
        <option value='<?=$row['idDirection'];?>'>Calle: <?=$row['street']?>. Numero Interior: <?php echo $row['intNumber'];?>.  Colonia: <?php echo $row['suburb'];?></option>
<?php
    }
?>
    </select>

