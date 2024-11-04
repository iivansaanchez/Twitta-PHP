<?php
session_start();
require_once "../connection/connection.php";

if (isset($_POST['description']) && isset($_POST['userId'])) {
    $connect = connection();
    
    $description = mysqli_real_escape_string($connect, $_POST['description']);
    $userId = $_POST['userId']; // Asegurarse de que sea un número entero

    // Actualizamos la descripción en la base de datos
    $query = "UPDATE users SET description = '$description' WHERE id = $userId";
    if (mysqli_query($connect, $query)) {
        // Redirigir al perfil del usuario actualizado
        header("Location: ./profile.php?user=$userId");
    }
} else {
    header("Location: ./landingPage.php");
}
?>
