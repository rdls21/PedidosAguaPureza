<?php
    include_once "lib/session.php";
    if(!isset($_SESSION["name"])) {
        header("location: index.html");
        exit;
    }
    
    if (isset($_POST["option"])) {
        include_once "lib/Admin/userActions.php";
        $admin = new userActions();
        if ($_POST["option"]=='Guardar'){

            $id = $_POST["id_i"];
            $username = $_POST["user"];
            $password = $_POST["password"];
            $kind = $_POST["kind"];
            $active = $_POST["state"];
            
            $RFC = $_POST["RFC"];
            $Name = $_POST["nombre"];
            $Tel = $_POST["tel"];
            $Dir = $_POST["dir"];
            
            $admin->editUser($id, $username, $password, $kind, $active, $RFC, $Name, $Tel, $Dir);
        }
        if ($_POST["option"]=='Agregar'){
            $username = $_POST["user"];
            $password = $_POST["password"];
            $kind = $_POST["kind"];
            $active = $_POST["state"];
            
            $RFC = $_POST["RFC"];
            $Name = $_POST["nombre"];
            $Tel = $_POST["tel"];
            $Dir = $_POST["dir"];
            
            $admin->addUser($username, $password, $kind, $active, $RFC, $Name, $Tel, $Dir);
        }
    }
?>

<!--/*www.geeksforgeeks.org/search-bar-using-html-css-and-javascript/*/--!>
<div class="content">
  <h2>Lista de usuarios</h2>
<!--Busqueda: /* www.geeksforgeeks.org/search-bar-using-html-css-and-javascript/*/--!>

<!--AJAX:/*www.w3schools.com/js/js_ajax_php.asp*/ --!>
<!--AJAX:/*www.w3schools.com/XML/ajax_xmlhttprequest_send.asp*/ --!>
    <div class="content">
        <table id='myTable' style="overflow-y:auto;">
        <tr>
            <th> ID </td>
            <th> Usuario </td>
            <th> Tipo </td>
            <th> Estado </td>
        </tr>
        <?php
            include_once "lib/session.php";
            
            if (!isset($_SESSION["name"])) {
                header("Location: index.html");
                exit;
                if (!($_SESSION["kind"] == 1)) {
                    header("Location: index.html");
                }
            }
            
            include_once "lib/user.php";
            $user = new user();
            $result = $user->makeSql("Select * From user");
            
            // Load page for a admin user
            foreach ($result as $row){
                echo "<tr>";
                echo "<td value=" . $row['id'] . ">" . $row['id'] . "</td>";
                echo "<td>" . $row["username"] . "</td>";
                switch ($row['kind']){
                    case 1: echo "<td>Administrador</td>"; break;
                    case 2: echo "<td>Repartidor</td>"; break;
                    case 3: echo "<td>Vendedor</td>"; break;
                    default: echo "<td> ¿...? </td>";
                }
                switch ($row['active']){
                    case 0: echo "<td>Inactivo</td>"; break;
                    case 1: echo "<td>Activo</td>"; break;
                    case 2: echo "<td>Activo. </td>"; break;
                    default: echo "<td>Activo.. </td>";
                }
                echo "</tr>";
            }
        ?>
        </table>
        <button onclick="showDetail(false, 0)" class="addButton">Agregar usuario</button>
    </div>
</div>
<!-- /* MARK: Modal */ --!>
<div id="myModal" class="modal">
  <!-- Contenido --!>
  <form id="modal" action="" class="modal-content" method="post">
    <span class="close">&times;</span>
    <h2 id='modalTitle'>Usuario</h2>
    <label type='text'>ID: </label>
    <label type='text' id='id' name='id' value=''></label>
    <input id='id_i' type="hidden" placeholder="id" name="id_i" required>
    <input id='name' type="text" placeholder="usuario" name="user" required maxlength='50' size='25'>
    <input id='password' type="password" placeholder="contraseña" name="password" required maxlength='250' size='25'>
    <select id='kind' name="kind">
        <option value='1'>Administrador</option>
        <option value='2'>Repartidor</option>
        <option value='3'>Vendedor</option>
    </select>
    <select id='state' name="state">
        <option value='0'>Inactivo</option>
        <option value='1'>Activo</option>
    </select>
    <!--/*Detalle*/--!>
    <div id="detalle">
        <h2 id='Title'>Detalle Usuario</h2>
        <label for='RFC'>RFC</label>
        <input type='text' id='RFC' name='RFC' value=''required maxlength='13' size='15'>
        <label for='nombre'>Nombre</label>
        <input type='text' id='nombre' name='nombre' value=''required maxlength='45' size='20'><br><br>
        <label for='tel'>Teléfono:</label>
        <input type='text' id='tel' name='tel' value=''required maxlength='10' size='10'><br><br>
<label for='dir'>Dirección:</label>
        <textarea id = 'dir' name='dir' style='width:500;height:40px;' maxlength='60' required></textarea><br><br>
    </div>
    <button onclick="modal.style.display='none';">Cancelar</button>
    <input id='option' name="option" type="submit" value="">
  </form>
</div>

<div class="content">
    <h2>Pedidos</h2>
    <div class="content">
<!--/*https://www.w3schools.com/howto/howto_js_filter_lists.asp*/--!>
        <table id='showUnattendedOrders' style="overflow-y:auto;">
        
        </table>
        <button onclick="updatePage();">Actualizar</button>
    </div>
</div>

<div class="content">
    <h2>Historico de Pedidos</h2>
    <div class="content">
<!--/*https://www.w3schools.com/howto/howto_js_filter_lists.asp*/--!>
        <div id="showTimeOrders" style="width: 900px; margin: 0 auto; height: 500px;">
        </div>
    </div>
</div>

<div class="content">
    <h2>Historico de Pedidos atendidos por repartidor</h2>
    <div class="content">
<!--/*https://www.w3schools.com/howto/howto_js_filter_lists.asp*/--!>
        <div id="showTimeOrdersPerWorker" style="width: 900px; margin: 0 auto; height: 500px;">
        </div>
    </div>
</div>
<script src="//www.amcharts.com/lib/4/core.js"></script>
<script src="//www.amcharts.com/lib/4/charts.js"></script>

<!--/*MARK: FIRST CHART*/--!>
<script>
/**
 * ---------------------------------------
 * This demo was created using amCharts 4.
 *
 * For more information visit:
 * https://www.amcharts.com/
 *
 * Documentation is available at:
 * https://www.amcharts.com/docs/v4/
 * ---------------------------------------
 */

// Create chart instance
var chart = am4core.create("showTimeOrders", am4charts.XYChart);

// Add data
<?php $result = $user->makeSql("Select Year(Date) as Year, Month(Date) as Month, Day(Date) as Day, count(*) as Orders, Sum(State) as Sells From orderInfo Group By Date"); ?>

chart.data = [<?php foreach($result as $row) {?>{
    "date": new Date(<?=$row['Year']?>, <?=$row['Month']?>, <?=$row['Day']?>),
    "value": <?=$row['Orders']?>,
    "value2": <?=$row['Sells']?>
    },
    <?php } ?>
 ];

// Create axes
var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
dateAxis.renderer.grid.template.location = 1;
dateAxis.renderer.labels.template.location = 1;


var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
//var series = chart.series.push(new am4charts.ColumnSeries());
//series.dataFields.valueY = "value";
//series.dataFields.dateX = "date";
//series.name = "Sales";

// Create series
function createSeries(field, name) {
  var series = chart.series.push(new am4charts.LineSeries());
  series.dataFields.valueY = field;
  series.dataFields.dateX = "date";
  series.name = name;
  series.tooltipText = "{dateX}: [b]{valueY}[/]";
  series.strokeWidth = 2;
  
  var bullet = series.bullets.push(new am4charts.CircleBullet());
  bullet.circle.stroke = am4core.color("#fff");
  bullet.circle.strokeWidth = 2;
}

createSeries("value", "Pedidos");
createSeries("value2", "Ventas");

chart.legend = new am4charts.Legend();

// Create scrollbars
chart.scrollbarX = new am4core.Scrollbar();
chart.scrollbarY = new am4core.Scrollbar();
</script>

<!--/*MARK: SECOND CHART*/--!>
<script>
// Create chart instance
var chart = am4core.create("showTimeOrdersPerWorker", am4charts.PieChart);

// Create pie series
var series = chart.series.push(new am4charts.PieSeries());
series.dataFields.value = "litres";
series.dataFields.category = "country";

// Add data
<?php $result = $user->makeSql("Select u.username As Name, Sum(oi.isTaken) As SUM from orderInfo as oi, user as u Where u.id = oi.idWorker Group By idWorker"); ?>
chart.data = [<?php foreach($result as $row) {?>{
    "country": "<?=$row['Name']?>",
    "litres": <?=$row['SUM']?>
    },
    <?php } ?>
];

// And, for a good measure, let's add a legend
chart.legend = new am4charts.Legend();
</script>

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
        var url = "lib/Admin/userData.php";
        var params = 'id=' + id;
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

        xmlhttp.open('POST', url, true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send(params);
        
        document.getElementById('id').innerHTML = id;
        document.getElementById('id_i').value = id;
        document.getElementById('modalTitle').innerHTML = "Editar Usuario";
        document.getElementById('name').value = getTableElement(1, id);
        if (getTableElement(2, id) == "Vendedor"){
            document.getElementById('kind').selectedIndex = "2";
        } else if (getTableElement(2, id) == "Repartidor"){
            document.getElementById('kind').selectedIndex = "1";
        } else {
            document.getElementById('kind').selectedIndex = "0";
        }
        
        if (getTableElement(3, id) == "Activo"){
            document.getElementById('state').selectedIndex = "1";
        } else if (getTableElement(2, id) == "Inactivo"){
            document.getElementById('state').selectedIndex = "0";
        }
        document.getElementById('option').value = "Guardar";
    } else {
        document.getElementById('id').innerHTML =  oTable = document.getElementById('myTable').rows.length;
        document.getElementById('modalTitle').innerHTML = "Agregar Usuario";
        document.getElementById('name').value = "";
        document.getElementById('password').value = "";
        document.getElementById('kind').selectedIndex = "0";
        document.getElementById('state').selectedIndex = "0";
        
        document.getElementById('RFC').value = "";
        document.getElementById('nombre').value = "";
        document.getElementById('tel').value = "";
        document.getElementById('dir').value = "";
        
        document.getElementById('option').value = "Agregar";
    }
}

function updatePage() {
    location.reload();
}

showUnattendedOrders();
function showUnattendedOrders() {
    var url = "lib/Admin/showUnattendedOrders.php";
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); // LOL
    }
    
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
            document.getElementById("showUnattendedOrders").innerHTML=xmlhttp.responseText;
        }
    }

    xmlhttp.open('POST', url, true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send();
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
<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
