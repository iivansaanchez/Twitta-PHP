<?php
session_start();

require_once "../connection/connection.php";

$connect = connection();

#En primer lugar, debemos eliminar o inicializar a 0 la lista de usuarios que seguimos
$_SESSION["listUsersTweet"] = [];

# Vamos a rescatar toda la lista de tweets para mostrarlos en el home de la página
$sql = "SELECT publications.*, users.username FROM publications JOIN users ON publications.userId = users.id";
$res = mysqli_query($connect, $sql);

# Comprobamos que la conexión y la consulta han sido exitosas
if ($res && mysqli_num_rows($res) > 0) {
    $listTweets = [];

    # Recorremos los resultados y los almacenamos en un array
    while ($tweet = mysqli_fetch_assoc($res)) {
        $listTweets[] = $tweet;
    }

    # Almacenamos los tweets en la sesión para mostrarlos posteriormente
    $_SESSION["listTweetGeneral"] = $listTweets;

    # Redirigimos a la página principal para actualizar la lista de tweets
    header("Location: ../pages/landingPage.php");

} else {
    # Si la consulta falla, mostramos un mensaje de error y limpiamos la lista de tweets
    $_SESSION["listTweetGeneral"] = [];
    $_SESSION["error_listGeneral"] = "Failed to view tweets... Sorry.";
    header("Location: ../pages/landingPage.php");

}

?>
