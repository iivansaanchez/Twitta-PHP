<?php
session_start();
require_once "../connection/connection.php";

if (isset($_POST['description']) && isset($_POST['userId'])) {
    $connect = connection();
    
    // Escapamos los datos recibidos
    $description = mysqli_real_escape_string($connect, $_POST['description']);
    $userId = $_POST['userId']; // Asegurarse de que sea un número entero

    // Actualizamos la descripción en la base de datos
    $query = "UPDATE users SET description = '$description' WHERE id = $userId";
    if (mysqli_query($connect, $query)) {
        // Redirigir al perfil del usuario actualizado
        header("Location: ./profile.php?user=$userId");
        exit();
    } else {
        // Manejo de error en caso de que la actualización falle
        echo "Error updating description: " . mysqli_error($connect);
    }
} else {
    header("Location: ./landingPage.php");
    exit();
}
?>
