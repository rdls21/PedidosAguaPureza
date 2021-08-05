<?php
    include_once "../user.php";
    include_once "../session.php";
    include_once "../alert.php";
    $session = new session();
    
    if (!isset($_SESSION["kind"])) {
        exit;
    } else {
        if ($_SESSION["kind"]!= 1) {
            if ($_SESSION["kind"]!= 3) {
                exit;
            }
        }
    }
    
    $id = $_POST["id"];
    
    $user = new user();
    $result = $user->makeSql("Select * From direction Where idCustomer = $id");
    
    foreach ($result as $row) {
?>
        <tr>
        <td align="center">
            <input type='text' id='idDirection' name='idDirection[]' required value='<?php echo $row['idDirection'];?>' maxlength='3' size='4' readonly>
        </td>
        <td align="center">
            <input type='text' id='street' name='street[]' required value='<?php echo $row['street'];?>' maxlength='50' size='30'>
        </td>
        <td align="center">
            <input type='text' id='intNumber' name='intNumber[]' value='<?php echo $row['intNumber'];?>' maxlength='6' size='6'>
        </td>
        <td align="center">
            <input type='text' id='suburb' name='suburb[]' required value='<?php echo $row['suburb'];?>' maxlength='50' size='25'>
        </td>
        <td align="center">
            <textarea id = 'ref' name='ref[]' style='width:200px;height:30px;' maxlength='250'><?php echo $row['reference'];?></textarea>
        </td>
        </tr>
<?php
    }
?>
