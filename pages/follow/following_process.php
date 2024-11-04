<?php
session_start();
require_once "../../connection/connection.php";

$connect = connection();

// Obtener el ID del usuario a ver (por ejemplo, desde la URL)
if (isset($_GET['userId'])) {
    $userId = intval($_GET['userId']); // Asegurarse de que sea un número entero

    // Obtener información del usuario
    $userInfo = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM users WHERE id = $userId"));

    // Obtener los usuarios que sigue
    $followingQuery = "SELECT u.id, u.username FROM follows f JOIN users u ON f.userToFollowId = u.id WHERE f.users_id = $userId";
    $followingResult = mysqli_query($connect, $followingQuery);

    if (!$userInfo) {
        echo "User not found.";
    }
} else {
    echo "Invalid request.";
}
?>