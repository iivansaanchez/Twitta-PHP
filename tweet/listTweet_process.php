<?php
session_start();

require_once "../connection/connection.php";
    
$connect = connection();

#Vamos a resctar toda la lista de tweet para mostrarlos en el homo de la pagina
$sql = "SELECT publications.*, users.username FROM publications JOIN users ON publications.userId = users.id";
$res = mysqli_query($connect, $sql);
#Una vez que hemos hecho la query comprobamos que ha funcionado
if($res && mysqli_num_rows($res) > 0){
    $listTweets = [];
    #Vamos a hacer un bucle para obtener todos los datos de la respuesta
    #Este bucle se ejecutara mientras existan rows cuando no haya el bucle parara
    while($tweet = mysqli_fetch_assoc($res)){
        $listTweets[] = $tweet;
    }
    #Lo almacenamos en una variable global para posteriormente mostrarlo
    $_SESSION["listTweetGeneral"] = $listTweets;

    #Tenemos que almacenar

    #Si es correcto redirigimos a la misma pagina para actualizar la lista de tweet
    header("Location: ../pages/landingPage.php");
}else{
    #Si la consulta es erronea mostraremos el siguiente mensaje
    $_SESSION["error_listGeneral"] = "Failed to view tweet... Sorry.";
    header("Location: ../pages/landingPage.php");
}
?>