<?php
session_start(); // Asegúrate de que la sesión esté iniciada
require_once "../connection/connection.php";

$connect = connection();

if (isset($_POST['action']) && isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    // Almacenamos el ID del usuario logueado en una variable
    $loggedUserId = $_SESSION['usuario']['id'];

    // Comprobamos que el value es follow
    if ($_POST['action'] === 'follow') {
        // Consulta para seguir 
        $query = "INSERT INTO follows (users_id, userToFollowId) VALUES ($loggedUserId, $userId)";
        if (mysqli_query($connect, $query)) {
            // Si funciona correctamente redirigimos al perfil
            header("Location: ../pages/profile.php?user=$userId");
        }
    } elseif ($_POST['action'] === 'unfollow') {
        $query = "DELETE FROM follows WHERE users_id = $loggedUserId AND userToFollowId = $userId";

        if (mysqli_query($connect, $query)) {
            header("Location: ../pages/profile.php?user=$userId");
        }
    }
} else {
    header("Location: ../pages/landingPage.php");
}
?>
