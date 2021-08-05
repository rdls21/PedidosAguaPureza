<?php
    /*
    La sentencia include_once incluye y evalúa el fichero especificado durante la ejecución del script. Tiene un comportamiento similar al de la sentencia include, siendo la única diferencia de que si el código del fichero ya ha sido incluido, no se volverá a incluir, e include_once devolverá TRUE. Como su nombre indica, el fichero será incluido solamente una vez.
    include_once se puede utilizar en casos donde el mismo fichero podría ser incluido y evaluado más de una vez durante una ejecución particular de un script, así que en este caso, puede ser de ayuda para evitar problemas como la redefinición de funciones, reasignación de valores de variables, etc.
     */
    include "lib/alert.php";
    include_once "lib/user.php";
    include_once "lib/session.php";
    
    $session = new session();
    $user = new user();
    
    if (!isset($_POST["username"], $_POST["password"])) {
        alert("Ingresa tus credenciales!");
        header("location: home.php");
    } else {
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        if($user->authUser($username, $password)){
            $session->setCurrentUser($user -> getName(), $user -> getKind(), $user -> getActive());
            header("location: home.php");
        } else {
            include "index.html";
        }
    }
?>
