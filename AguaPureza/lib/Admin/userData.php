<?php
    include_once "../user.php";
    include_once "../session.php";
    include_once "../alert.php";
    $session = new session();
    
    if (!isset($_SESSION["kind"])) {
        exit;
    }
    
    $id = $_POST["id"];
    
    $user = new user();
    $result = $user->makeSql("Select * From worker Where idWorker = ". $id ."");
    foreach ($result as $row) {
        echo "<h2 id='Title'>Detalle Usuario</h2>";
        echo "<label for='RFC'>RFC</label>";
        echo "<input type='text' id='RFC' name='RFC' value='" . $row['RFC'] . "'required maxlength='13' size='15'>";
        echo "<label for='nombre'>Nombre</label>";
        echo "<input type='text' id='nombre' name='nombre' value='" . $row['Name'] . "'required maxlength='45' size='25'><br><br>";
        echo "<label for='tel'>Teléfono:</label>";
        echo "<input type='text' id='tel' name='tel' value='" . $row['Tel'] . "'required maxlength='10' size='10'><br><br>";
        echo "<label for='dir'>Dirección:</label>";
        echo "<textarea id = 'dir' name='dir' style='width:500;height:40px;' maxlength='60' required>" . $row['Dir'] . "</textarea><br><br>";
    }
?>
