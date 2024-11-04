<?php

require_once "../connection/connection.php";

$connect = connection();

// Aquí usamos $userId, que fue definido en el archivo principal del perfil
if (isset($userId)) {
    // Query para obtener la información del usuario, seguidores, seguidos y sus tweets
    $userInfo = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM users WHERE id = $userId"));
    $followersCount = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM follows WHERE userToFollowId = $userId"));
    $followingCount = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM follows WHERE users_id = $userId"));
    $tweets = mysqli_query($connect, "SELECT text, createDate FROM publications WHERE userId = $userId ORDER BY createDate DESC");
    $isFollowing = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM follows WHERE users_id = {$_SESSION['usuario']['id']} AND userToFollowId = $userId"));

    // Verificamos si el usuario existe
    if (!$userInfo) {
        $_SESSION['userInfo'] = $userInfo;
        $_SESSION['followersCount'] = $followersCount;
        $_SESSION['followingCount'] = $followingCount;
        $_SESSION['tweets'] = $tweets;

        // Redirigir al perfil para mostrar los datos
        header("Location: ../pages/profile.php?id=$userId");
    }
}else{
    header("Location: ../pages/landingPage.php");
}
?>