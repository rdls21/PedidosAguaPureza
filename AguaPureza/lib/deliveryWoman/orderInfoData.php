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
    $idOrder = $_POST["id"];
    $opt = $_POST["opt"];
    alert($_POST["id"]);
    alert($_POST["opt"]);
    alert($opt);
    if ($idOrder > 0) {
        $result = $user->makeSql("Select * from orderInfo Where idOrder = $idOrder");
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
        <h2 id='modalTitle'>Detalle Pedido</h2>
        <?php
    }
?>
<label type='text'>ID: </label>
    <input type="text" placeholder="id" name="idOrder" value ='<?=$idOrder;?>' required readonly maxlength='25' size='5'>
    <input id='date' type="text" placeholder="Fecha" name="date" value = '<?= $Date ?>' required readonly maxlength='10' size='10'>
    <input id='Quantity' type="text" placeholder="Cant" name="quantity" value = '<?= $Quantity; ?>' required readonly maxlength='3' size='4'>
        <?php
        $result = $user->makeSql("Select * from product Where idProduct = $idProduct");
        foreach ($result as $row) {
        ?>
            <input type='text' id='product' name='product' required readonly value='<?=$row['Name'].' '.$row['unitOfMeasure'];?>' . size='30'>
        <?php
        }
    switch ($State){
        case 0: echo "<input type='text' id='state' name='state' required readonly value='Pendiente' size='10'>"; break;
        case 1: echo "<input type='text' id='state' name='state' required readonly value='ERROR' size='5'>"; break;
        default: echo "<input type='text' id='state' name='state' required readonly value='ERROR+' size='5'>";
    }
?>
        <!--/*Detalle*/--!>
<div id="detalle">
    <h2 id='Title'>Detalle Dirección</h2>
    <table style="overflow-x:auto;">
    <tr>
        <th> Cliente </td>
        <th> Calle y Numero </td>
        <th> Num Ext. </td>
        <th> Colonia </td>
        <th> Referencia </td>
    </tr>
    <?php
        $result = $user->makeSql("Select name from customer Where idCustomer=$idCustomer");
        foreach ($result as $row) {
            ?>
            <tr>
            <td><input type='text' id='street' name='street' required readonly value='<?php echo $row['name'];?>' size='15'></td>
        <?php
        }
        $result = $user->makeSql("Select * from direction Where idCustomer = $idCustomer AND idDirection = $idDirection");
        foreach ($result as $row) {
            ?>
        <td><input type='text' id='street' name='street' required readonly value='<?php echo $row['street'];?>' size='35'></td>
        <td><input type='text' id='intNumber' name='intNumber' value='<?php echo $row['intNumber'];?>' readonly size='6'></td>
        <td><input type='text' id='suburb' name='suburb' required value='<?php echo $row['suburb'];?>' readonly size='25'></td>
        <td><textarea id = 'ref' name='ref[]' style='width:500;height:40px;' maxlength='250' readonly><?php echo $row['reference'];?></textarea></td>
        </tr>
        <?php
        }
            ?>
     </table>
    <p>
        Direcciones con:
        <a href = "https://maps.apple.com/?address=<?=$row['street']?>,%20<?php echo $row['suburb'];?>,%20Aguascalientes,%20AGS,%20M%C3%A9xico&ll&_ext=EiYpZqX/fXnaNUAxUW7AF/uQWcA5YlBLNsbcNUBBHRoxg1yQWcBQBA%3D%3D">Apple Maps.</a>
        (¡Usar solo como aproximación!)
    </p>
</div>
<?php
    if ($opt == 1) {
?>
<button onclick="modal.style.display='none';">Cancelar</button>
<input id='option' name="option" type="submit" value="Dejar">
<input id='option' name="option" type="submit" value="Entregado">
        <?php
    } else {
        ?>
<button onclick="modal.style.display='none';">Cancelar</button>
<input id='option' name="option" type="submit" value="Tomar">
        <?php
    }
?>
