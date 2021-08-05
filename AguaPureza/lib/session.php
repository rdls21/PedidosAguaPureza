<?php
    class session {
        public function __construct(){
            session_start();
        }
        
        public function setCurrentUser($user, $kind, $active){
            //Guardamos el usuario y tipo de usuario
            $_SESSION["name"] = $user;
            $_SESSION["kind"] = $kind;
            $_SESSION["active"] = $active;
        }

        public function getCurrentUser(){
            return $_SESSION["name"];
        }

        public function closeSession(){
            session_unset();
            session_destroy();
        }
    }
?>
