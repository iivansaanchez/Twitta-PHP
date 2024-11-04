<?php
// Comprobamos si el id existe en la URL y lo almacenamos en una variable
if (isset($_GET['userId'])) {
    $userId = $_GET['userId'];

    // Incluimos el archivo que contiene la lógica de procesamiento, pasando el $userId
    require_once "./following_process.php";

    if (empty($userInfo)) {
        header("Location: ./landingPage.php");
        exit();
    }
    
} else {
    header("Location: ./landingPage.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($userInfo['username']); ?>'s Following</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center"><?php echo htmlspecialchars($userInfo['username']); ?> is Following</h2>
        <div class="list-group mt-4">
            <?php while ($following = mysqli_fetch_assoc($followingResult)): ?>
                <a href="../profile.php?user=<?php echo $following['id']; ?>" class="list-group-item list-group-item-action">
                    <?php echo htmlspecialchars($following['username']); ?>
                </a>
            <?php endwhile; ?>
        </div>
        <a href="../profile.php?user=<?php echo $userId; ?>" class="btn btn-secondary mt-4">Back to Profile</a>
    </div>
</body>
</html>