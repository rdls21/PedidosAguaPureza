<?php
    include_once "lib/session.php";
    $session = new session();
    
    if(!isset($_SESSION["name"])) {
        header("location: index.html");
        exit;
    }
    
    if (isset($_POST["option"])) {
        include_once "lib/Admin/productActions.php";
        $admin = new productActions();
        
        if ($_POST["option"]=='Editar'){

            $id = $_POST["id_i"];
            $name = $_POST["name"];
            $unitofmeasure = $_POST["unitofmeasure"];
            
            
            $admin->editProduct($id, $name, $unitofmeasure);
        }
        if ($_POST["option"]=='Agregar'){
            
            $id = 0;
            $name = $_POST["name"];
            $unitofmeasure = $_POST["unitofmeasure"];
            
            $admin->addProduct($id, $name, $unitofmeasure);
        }
    }
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Producto</title>
    <link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body class="loggedin">
    <nav class="navtop">
        <div>
            <h1><l><object align='center 'height=60 width=60 data="css/svg/AguaPureza.svg">
                Tu buscador no soporta formato SVG
            </object><l></h1>
            <a href=""><i class="fas fa-home"></i>Productos</a>
            <a href="customer.php"><i class="fas fa-home"></i>Clientes</a>
            <a href="home.php"><i class="fas fa-home"></i>Gestión</a>
            <a href="profile.php"><i class="fas fa-user-circle"></i>Perfil</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Cerrar sesión</a>
        </div>
    </nav>
<div class="content">
  <h2>Lista de Productos</h2>
    <div class="content">
        <table id='myTable' style="overflow-y:auto;">
        <tr>
            <th> ID </td>
            <th> Nombre </td>
            <th> Unidad de medida </td>
        </tr>
        <?php
            $user = new user();
            $result = $user->makeSql("Select * From product");
            // Load page for a admin user
            foreach ($result as $row){
                echo "<tr>";
                echo "<td value=" . $row['idProduct'] . ">" . $row['idProduct'] . "</td>";
                echo "<td>" . $row['Name'] . "</td>";
                echo "<td>" . $row['unitOfMeasure'] . "</td>";
                echo "</tr>";
            }
        ?>
        </table>
        <?php
            if ($_SESSION["kind"] == 1) {
                echo "<button onclick='showDetail(false, 0)' class='addButton'>Agregar Producto</button>";
            }
        ?>
    </div>
</div>



<!-- /*MARK: MODAL*/ --!>
<div id="myModal" class="modal">
  <form id="modal" action="" class="modal-content" method="post">
    <span class="close">&times;</span>
    <h2 id='modalTitle'>Producto</h2>
    <label type='text'>ID: </label>
    <label type='text' id='id' name='id' value=''></label>
    <input id='id_i' type="hidden" placeholder="id" name="id_i" required>
    <input id='name' type="text" placeholder="Nombre" name="name" required readonly maxlength='30' size='25'>
    <input id='unitofmeasure' type="text" placeholder="Unidad de medida" name="unitofmeasure" required readonly maxlength='15' size='10'>
    <button onclick="modal.style.display='none';">Cancelar</button>
    <?php
        if ($_SESSION["kind"] == 1) {
            echo "<input id='option' name='option' type='submit' value='Editar'>";
        }
    ?>
  </form>
</div>

<!--/*MARK: JS*/ --!>
<script type="text/javascript">
// Get the modal
var modal = document.getElementById("myModal");
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

var elements = document.getElementsByTagName('tr');
    for(var i=1; i<elements.length;i++) { //Skip Title
        (elements)[i].addEventListener("click", function() {
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

function showDetail(opt, id){
    //document.getElementById('myModal').load(window.location.href + " myModal" );
    modal.style.display = "block";
    
    if (opt){
        document.getElementById('id').innerHTML = id;
        document.getElementById('id_i').value = id;
        document.getElementById('modalTitle').innerHTML = "Editar Producto";
        document.getElementById('name').value = getTableElement(1, id);
        document.getElementById('unitofmeasure').value = getTableElement(2, id);
        
        <?php
            if ($_SESSION["kind"] == 1) {
        ?>
                document.getElementById('unitofmeasure').readOnly = false;
                document.getElementById('name').readOnly = false;
                document.getElementById('option').value = "Editar";
        <?php
            }
        ?>
        
    } else {
        document.getElementById('id').innerHTML = elements.length;
        document.getElementById('modalTitle').innerHTML = "Agregar Producto";
        document.getElementById('name').value = "";
        document.getElementById('unitofmeasure').value = "";
        <?php
            if ($_SESSION["kind"] == 1) {
        ?>
            document.getElementById('unitofmeasure').readOnly = false;
            document.getElementById('name').readOnly = false;
            document.getElementById('option').value = "Agregar";
        <?php
            }
        ?>
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

</script>
