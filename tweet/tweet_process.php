<?php
session_start();

require_once "../connection/connection.php";
    
$connect = connection();

#Rescatamos el usuario para poder asociarlo a su id
$usuario = $_SESSION["usuario"];

#Recogemos el tweet que ha hecho el usuario
$message = isset($_POST["description"]) ? mysqli_real_escape_string($connect, $_POST["description"]) : false;

#Creamos variable para validación
$messageValid = false;

#Una vez recogido validamos que no tengas un tamaño superior a 280
if(strlen($message) <= 280){
    $messageValid = true;
}

if($messageValid){
    #Si el mensaje es valido lo añadimos a la base de datos con la siguiente consulta
    $sql = "INSERT INTO publications (userId, text, createDate) VALUES ('$usuario[id]', '$message', CURDATE())";
    $res = mysqli_query($connect, $sql);
    #Una vez hecha la query compromos que ha funcionado
    if(!$res){
        #Si la consulta es erronea mostraremos el siguiente mensaje
        $_SESSION["error_message"] = "Failed to insert tweet... Try again.";
    }else{
        #Si es correcto redirigimos a la misma pagina para actualizar la lista de tweet
        header("Location: ../tweet/listTweet_process.php");
    }
}else{
    $_SESSION["error_message"] = "Message exceeds 280 characters";
    header("Location: ../pages/landingPage.php");
}
?>