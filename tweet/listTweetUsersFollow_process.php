<?php
session_start();

require_once "../connection/connection.php";
    
$connect = connection();
echo "Estoy dentro de listUser";
// Si el usuario no existe, no te va a poder mostrar los tweets de sus seguidores
if (isset($_SESSION["usuario"])) {

    // Rescatamos el usuario y lo almacenamos en una variable
    $usuario = $_SESSION["usuario"];
    // Almacenamos en otra variable el id del usuario
    $userId = $usuario["id"];
    
    // Verificamos si el usuario sigue a alguien
    $checkFollowsSql = "SELECT COUNT(*) AS followCount FROM follows WHERE users_id = $userId";
    echo $checkFollowsSql;
    $checkFollowsRes = mysqli_query($connect, $checkFollowsSql);
    $followData = mysqli_fetch_assoc($checkFollowsRes);

    if ($followData['followCount'] > 0) {
        // Si el usuario sigue a alguien, ejecutamos la consulta de tweets
        $sql = "SELECT p.text, p.createDate, p.userId, u.username
        FROM follows f
        JOIN publications p ON f.userToFollowId = p.userId
        JOIN users u ON p.userId = u.id
        WHERE f.users_id = $userId
        ORDER BY p.createDate DESC";
        
        $res = mysqli_query($connect, $sql);  

        if ($res && mysqli_num_rows($res) > 0) {
            $listUsersTweets = [];
        
            // Recorremos los resultados y los almacenamos en un array
            while ($tweet = mysqli_fetch_assoc($res)) {
                $listUsersTweets[] = $tweet;
            }
        
            // Almacenamos los tweets en la sesión para mostrarlos posteriormente
            $_SESSION["listUsersTweet"] = $listUsersTweets;
        } else {
            // Si no hay tweets de los usuarios que sigue, mostramos mensaje específico
            $_SESSION["error_listUsersFollow"] = "The users you follow haven't posted any tweets yet.";
        }
    } else {
        // Si el usuario no sigue a nadie, mostramos un mensaje específico
        $_SESSION["error_listUsersFollow"] = "You are not following anyone. Start following users to see their tweets!";
    }
    
    // Redirigimos a la página principal
    header("Location: ../pages/landingPage.php");
}
?>
