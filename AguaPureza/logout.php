<?php
//    https://www.w3schools.com/php/php_sessions.asp
    session_start();
    
    // remove all session variables
    session_unset();

    // destroy the session
    session_destroy();

    header("Location: index.html");
?>
