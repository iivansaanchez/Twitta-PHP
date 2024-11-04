<?php
#Inicializamos la sesion
session_start();
#Destruimos la sesion
session_destroy();
#Mandamos al usuario al login
header("Location: ../index.php");
?>