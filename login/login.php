<?php

require_once "../connection/connection.php";

$connect = connection(); // Establecer la conexión

if(isset($_POST)){
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
}

// Preparar la consulta
$sql = "SELECT * FROM users WHERE username = '$username'";
$res = mysqli_query($connect, $sql);

// Comprobar que solo devuelve una fila y que la contraseña sea válida
if($res && mysqli_num_rows($res) == 1){
    // Almacenar el usuario en una variable
    $usuario = mysqli_fetch_assoc($res);

    // Verificar la contraseña
    if(password_verify($password, $usuario["password"])){
        // Almacenar el usuario en la sesión y redirigir
        $_SESSION["usuario"] = $usuario;
        header("Location: ./pages/landingPage.php");
    }else{
        // Contraseña incorrecta
        $_SESSION["error"] = "Incorrect username and/or password";
        header("Location: ../index.php");
    }
}else{
    // Usuario no encontrado o error en la consulta
    $_SESSION["error"] = "User does not exist";
    header("Location: ../index.php");
}
?>