<?php
    include_once "lib/session.php";
    $session = new session();
    
    if(!isset($_SESSION["name"])) {
        header("location: index.html");
        exit;
    }
    
    if (isset($_POST["option"])) {
        include_once "lib/Admin/clientActions.php";
        $admin = new clientActions();
        
        if ($_POST["option"]=='Editar'){

            $id = $_POST["id_i"];
            $rfc = $_POST["rfc"];
            $name = $_POST["name"];
            $tel = $_POST["tel"];
            
            $idDirection = $_POST["idDirection"];
            $street = $_POST["street"];
            $intNumber = $_POST["intNumber"];
            $suburb = $_POST["suburb"];
            $reference = $_POST["ref"];
            
            $admin->editCustomer($id, $rfc, $name, $tel, $idDirection, $street, $intNumber, $suburb, $reference);
        }
        if ($_POST["option"]=='Agregar'){
            
            $id = $_POST["id_i"];
            $rfc = $_POST["rfc"];
            $name = $_POST["name"];
            $tel = $_POST["tel"];
            
            $idDirection = $_POST["idDirection"];
            $street = $_POST["street"];
            $intNumber = $_POST["intNumber"];
            $suburb = $_POST["suburb"];
            $reference = $_POST["ref"];
            
            $admin->addCustomer($id, $rfc, $name, $tel, $idDirection, $street, $intNumber, $suburb, $reference);
        }
    }
//  Single quoted strings are the easiest way to specify string. This method in used when we want to the string to be exactly as it is written. When string is specified in single quotes PHP will not evaluate it or interpret escape characters except single quote with backslash (‘) and backslash(\) which has to be escaped.
    
//  In double quoted strings other escape sequences are interpreted as well any variable will be replaced by their value.
    
//  I recommend using single quotes (‘ ‘) for string unless we need the double quotes (” “). This is because double quotes forces PHP to evaluate the string (even though it might not be needed), whereas string between single quotes is not evaluated. Also, parsing variables between strings takes more memory than concatenation.

//So instead of this:
//  $count = 1;
//  echo "The count is $count";
//Use this
//  $count = 1;
//  echo 'The count is ' . $count;
    
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Clientes</title>
    <link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body class="loggedin">
    <nav class="navtop">
        <div>
            <h1><l><object align='center 'height=60 width=60 data="css/svg/AguaPureza.svg">
                Tu buscador no soporta formato SVG
            </object><l></h1>
            <a href="product.php"><i class="fas fa-home"></i>Productos</a>
            <a href=""><i class="fas fa-home"></i>Clientes</a>
            <a href="home.php"><i class="fas fa-home"></i>Gestión</a>
            <a href="profile.php"><i class="fas fa-user-circle"></i>Perfil</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Cerrar sesión</a>
        </div>
    </nav>
<div class="content">
    <h2>Lista de Clientes</h2>
    <div class="content">
<!--/*https://www.w3schools.com/howto/howto_js_filter_lists.asp*/--!>
        <table id="myTable" style="overflow-y:auto;">
        <tr>
            <th> ID </td>
            <th> RFC </td>
            <th> Nombre </td>
            <th> Telefono </td>
        </tr>
        <?php
            include_once "lib/user.php";
            $user = new user();
            $result = $user->makeSql("Select * From customer");
            // Load page for a admin user
            foreach ($result as $row){
                echo "<tr>";
                echo "<td value=" . $row['idCustomer'] . ">" . $row['idCustomer'] . "</td>";
                echo "<td>" . $row['RFC'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['tel'] . "</td>";
                echo "</tr>";
            }
        ?>
        </table>
        <?php
            if ($_SESSION["kind"] == 1 || $_SESSION["kind"] == 3) {
                echo "<button onclick='showDetail(false, 0)' class='addButton'>Agregar Cliente</button>";
            }
        ?>
    </div>
</div>

<!-- /* MARK: Modal */ --!>
<div id="myModal" class="modal">
  <!-- /*Contenido*/ --!>
    <form id="modal" action="" class="modal-content" method="post">
        <span class="close">&times;</span>
        <h2 id="modalTitle">Cliente</h2>
        <label type='text'>ID: </label>
        <input id='id_i' type="text" placeholder="id" name="id_i" size='3' readonly required>
        <input id='rfc' type="text" placeholder="RFC" name="rfc" readonly required maxlength='13' size='15'>
        <input id='name' type="text" placeholder="nombre" name="name" readonly required maxlength='100' size='50'>
        <input id='tel' type="text" placeholder="telefono" name="tel" readonly required maxlength=10' size='10'>
    <!--/*Detalle*/--!>
<?php
    if ($_SESSION["kind"] == 1 || $_SESSION["kind"] == 3) {
?>
        <div id="detalle">
            <h2 id='Title'>Detalle Cliente</h2>
            <table id="Detail" width="500" border="0" cellspacing="1" cellpadding="0">
            
            </table>
        </div>
<?php
        echo "<button onclick='addField()'>Agregar Campo</button>";
    }
?>
        <button onclick="modal.style.display='none';">Cancelar</button>
        <?php
            if ($_SESSION["kind"] == 1 || $_SESSION["kind"] == 3) {
                echo "<input id='option' name='option' type='submit' value=''>";
            }
        ?>
    </form>
</div>

<!--/* MARK: JS */--!>
<script type="text/javascript">
function showDetail(opt, id){
    //document.getElementById('myModal').load(window.location.href + " myModal" );
    modal.style.display = "block";
    
    if (opt){
        var url = "lib/Admin/clientData.php";
        var params = 'id=' + id;
        if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        } else {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); // LOL
        }
        
        xmlhttp.onreadystatechange=function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
                document.getElementById("Detail").innerHTML+=xmlhttp.responseText;
            }
        }

        xmlhttp.open("POST", url, true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send(params);
        
        document.getElementById('modalTitle').innerHTML = "Editar Cliente";
        document.getElementById('id_i').value = id;
        document.getElementById('rfc').value = getTableElement(1, id);
        document.getElementById('name').value = getTableElement(2, id);
        document.getElementById('tel').value = getTableElement(3, id);
        <?php
            if ($_SESSION["kind"] == 1 || $_SESSION["kind"] == 3) {
        ?>
                document.getElementById('rfc').readOnly = false;
                document.getElementById('name').readOnly = false;
                document.getElementById('tel').readOnly = false;
                document.getElementById('option').value = "Editar";
        <?php
            }
        ?>
    } else {
        document.getElementById('modalTitle').innerHTML = "Agregar Cliente";
        document.getElementById('id_i').value = elements.length;
        document.getElementById('rfc').value = "";
        document.getElementById('name').value = "";
        document.getElementById('tel').value = "";
        
        document.getElementById("Detail").innerHTML=
        "<table id='Detail' width='500' border='0' cellspacing='1' cellpadding='0'>"+
        "<tr>"+
            "<td align='center'><strong>Id</strong></td>"+
            "<td align='center'><strong>Calle y Numero</strong></td>"+
            "<td align='center'><strong>Numero Interior</strong></td>"+
            "<td align='center'><strong>Colonia</strong></td>"+
            "<td align='center'><strong>Referencia</strong></td>"+
        "</tr>"+
        "</table>";
        addField();
        <?php
            if ($_SESSION["kind"] == 1 || $_SESSION["kind"] == 3) {
        ?>
                document.getElementById('rfc').readOnly = false;
                document.getElementById('name').readOnly = false;
                document.getElementById('tel').readOnly = false;
                document.getElementById('option').value = "Editar";
        <?php
            }
        ?>
    }
}

// Get the modal
var modal = document.getElementById("myModal");
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

var elements = document.getElementsByTagName('tr');
 for(var i=1; i<elements.length;i++) { //Skip Title
     (elements)[i].addEventListener("click", function() {
                                    document.getElementById("Detail").innerHTML=
                                    "<table id='Detail' width='500' border='0' cellspacing='1' cellpadding='0'>"+
                                    "<tr>"+
                                        "<td align='center'><strong>ID</strong></td>"+
                                        "<td align='center'><strong>Calle y Numero</strong></td>"+
                                        "<td align='center'><strong>Numero Interior</strong></td>"+
                                        "<td align='center'><strong>Colonia</strong></td>"+
                                        "<td align='center'><strong>Referencia</strong></td>"+
                                    "</tr>"+
                                    "</table>";
                                    showDetail(true, this.rowIndex);
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

function getTableElement(x, y){
    //gets table
    var oTable = document.getElementById('myTable');
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

function addField(){
    document.getElementById("Detail").innerHTML+=
    "<td align='center'>" +
    "</td>" +
    "<td align='center'>" +
        "<input type='text' id='street' name='street[]' required value='' maxlength='50' size='30'>" +
    "</td>" +
    "<td align='center'>" +
        "<input type='text' id='intNumber' name='intNumber[]' value='' maxlength='6' size='6'>" +
    "</td>" +
    "<td align='center'>" +
        "<input type='text' id='suburb' name='suburb[]' required value='' maxlength='50' size='25'>" +
    "</td>" +
    "<td align='center'>" +
        "<textarea id = 'ref' name='ref[]' style='width:200px;height:30px;' maxlength='250'></textarea>" +
    "</td>";
    
    var dTable = document.getElementById("Detail");
    var rowLength = dTable.rows.length;
    //loops through rows
    for (i = 1; i < rowLength; i++){
        dTable.rows.item(i).cells.item(0).innerHTML = "<input type='text' id='idDirection' name='idDirection[]' value='"+ i +"' maxlength='3' size='4' readonly>";
     }
}
//https://codewithmark.com/easily-edit-html-table-rows-or-cells-with-jquery UPDATE METHOD
</script>
