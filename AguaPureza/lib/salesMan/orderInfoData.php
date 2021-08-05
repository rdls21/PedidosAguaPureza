<?php
    include_once "../user.php";
    include_once "../session.php";
    include_once "../alert.php";
    $session = new session();
    
    if (!isset($_SESSION["kind"])) {
        exit;
    }
    
    $idOrder = 0;
    $Date = date("Y/m/d");
    $Quantity = "";
    $idProduct = "";
    $idCustomer = "";
    $idDirection = "";
    $idWorker = "";
    $State = "";
    
    $user = new user();
    $id = $_POST["id"];
    if ($id > 0) {
        $result = $user->makeSql("Select * from orderInfo Where idOrder = " . $id);
        foreach ($result as $row) {
            $idOrder = $row['idOrder'];
            $Date = $row['Date'];
            $Quantity = $row['Quantity'];
            $idProduct = $row['idProduct'];
            $idCustomer = $row['idCustomer'];
            $idDirection = $row['idDirection'];
            $idWorker = $row['idWorker'];
            $State = $row['State'];
    }
        ?>
        <span onclick="modal.style.display = 'none';" class="close">&times;</span>
        <h2 id='modalTitle'>Detalle Pedido</h2>
        <?php
    } else {
        $result = $user->makeSql("Select count(*) as count from orderInfo ");
        foreach ($result as $row) {
            $idOrder = $row['count'] + 1;
        }
        ?>
        <h2 id='modalTitle'>Agregar Pedido</h2>
        <?php
    }
    if ($State == 1){
    ?>
        <label type='text'>ID: </label>
        <input type="text" placeholder="id" name="idOrder" value = '<?= $idOrder; ?>' required readonly maxlength='5' size='5'>
        <input id='date' type="text" placeholder="Fecha" name="date" value = '<?= $Date ?>' required readonly maxlength='10' size='10'>
        <input id='Quantity' type="text" placeholder="Cant" name="quantity" value = '<?= $Quantity; ?>' readonly required maxlength='3' size='4'>
            <?php
                    $result = $user->makeSql("Select * from product where idProduct = $idProduct");
                    foreach ($result as $row) {
            ?>
                    <input id='product' type="text" placeholder="Cant" name="product" value = '<?=$row['Name']?> <?=$row['unitOfMeasure']?>' readonly required maxlength='25' size='20'>
            <?php
                    }
            ?>
    <input id='state' type="text" placeholder="Cant" name="state" value = 'Entregado' readonly required maxlength='9' size='10'>
<?php
    } else {
?>
<label type='text'>ID: </label>
    <input type="text" placeholder="id" name="idOrder" value = '<?= $idOrder; ?>' required readonly maxlength='5' size='5'>
    <input id='date' type="text" placeholder="Fecha" name="date" value = '<?= $Date ?>' required readonly maxlength='10' size='10'>
    <input id='Quantity' type="text" placeholder="Cant" name="quantity" value = '<?= $Quantity; ?>' required maxlength='3' size='4'>
    <select id='product' name="product">
        <?php
                $result = $user->makeSql("Select * from product");
                foreach ($result as $row) {
        ?>
                <option value='<?=$row['idProduct'];?>' <?=$row['idProduct'] == $idProduct ? ' selected="selected"' : ''; ?>> <?=$row['Name']?> <?=$row['unitOfMeasure']?> </option>
        <?php
                }
        ?>
    </select>
    <select id='state' name="state">
        <option value='0' <?=$State == 0 ? ' selected="selected"' : '';?>>Pendiente</option>
        <option value='1' <?=$State == 1 ? ' selected="selected"' : '';?>>Entregado</option>
    </select>
<?php
    }
?>
        <!--/*Detalle*/--!>
<div id="detalle">
    <h2 id='Title'>Detalle Dirección</h2>
    <?php
        if ($State == 1) {
            $result = $user->makeSql("Select * from customer Where idCustomer = $idCustomer");
                    foreach ($result as $row) {
                ?>
                    <label type='text'>Cliente: </label>
                    <input id='customer' type="text" placeholder="Cant" name="customer" value = '<?=$row['name']?>' readonly required maxlength='25' size='15'>

                <?php
                    }
                ?>
            <?php
                $result = $user->makeSql("Select * from direction Where idCustomer = $idCustomer And idDirection = $idDirection");
                foreach ($result as $row) {
            ?>
                    <label type='text'>Dirección: </label>
                    <input id='direction' type="text" placeholder="Cant" name="direction" value = 'Calle: <?=$row['street']?>. Numero Interior: <?php echo $row['intNumber'];?>.  Colonia: <?php echo $row['suburb'];?>' readonly required maxlength='50' size='50'>
            <?php
                }
        } else {
        $result = $user->makeSql("Select * from customer");
            echo "<label type='text'>Cliente: </label>";
            echo "<select id='customer' name='customer' onchange='updateDirections()'>";
            if ($id == 0){
                echo "<option value='0' selected='selected'> -- </option>";
            }
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
        
        <option value='<?=$row['idDirection'];?>' <?=$row['idDirection'] == $idDirection ? ' selected="selected"' : ''; ?>>Calle: <?=$row['street']?>. Numero Interior: <?php echo $row['intNumber'];?>.  Colonia: <?php echo $row['suburb'];?></option>
<?php
    }
?>
        </select>
<?php
    }
?>
    </div>
<?php
if ($id > 0) {
    if ($State == 1){
?>

    <button onclick="modal.style.display='none';">Cancelar</button>
    <?php
    } else {
    ?>
    <button onclick="modal.style.display='none';">Cancelar</button>
    <input id='option' name="option" type="submit" value="Guardar">
<?php
    }
} else {
?>
<button onclick="modal.style.display='none';">Cancelar</button>
<input id='option' name="option" type="submit" value="Agregar">
<?php
}
?>
