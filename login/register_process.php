<?php
session_start();

if(isset($_POST["submit"])){
    #Hacemos la conexion a la base da datos para poder hacer luego consultas de validación
    require_once "../connection/connection.php";

    #Recogemos los datos del formulario
    #Esto valida que en la entrada de datos se ha enviado un username sino te lo pone como false
    $username = isset($_POST["username"]) ? mysqli_real_escape_string($connect, $_POST["username"]) : false;
    $email = isset($_POST["email"]) ? mysqli_real_escape_string($connect, trim($_POST["email"])) : false;
    $password = isset($_POST["password"]);
    $repeatPassword = isset($_POST["password2"]);

    #Creamos un array para almacenar los errores posibles
    $arrayErrores = array();

    #Hacemos las validaciones necesarias
    #Creamos variables para controlar que campo es valido y cual no
    $usernameValido;
    $emailValido;
    
    #El username no puede ser numerico ni estar vacio
    if(! empty($username) && !is_numeric($usernmae)){

    }

}

?>