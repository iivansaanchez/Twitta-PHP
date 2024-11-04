<?php
session_start();

// Comprobamos si el id existe en la URL y lo almacenamos en una variable
if (isset($_GET['user'])) {
    $userId = $_GET['user'];

    // Incluimos el archivo que contiene la lógica de procesamiento, pasando el $userId
    require_once "./profile_process.php";

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($userInfo['username']); ?> - Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #343a40;
            color: white;
            padding: 20px;
            position: fixed;
            overflow-y: auto;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
            border-radius: 4px;
        }
        .content-container {
            margin-left: 250px;
            padding: 20px;
            flex: 1;
        }
        .card-header {
            background-color: #343a40;
            color: white;
        }
        .profile-header {
            padding: 20px;
            text-align: center;
        }
        .profile-header img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }
        .tweet-card {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .tweet-card .tweet-meta {
            font-size: 0.85rem;
            color: #6c757d;
        }
    </style>
</head>
<body>

        <?php
        // Obtener el usuario actual desde la sesión
        $usuario = $_SESSION["usuario"];
        ?>

        <div class="sidebar">
            <h4 class="text-center"><?php echo "@" . htmlspecialchars($usuario["username"]) ?></h4>
            <p class="text-center"><?php echo htmlspecialchars($usuario["email"]) ?></p>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="../pages/landingPage.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../pages/profile.php?user=<?php echo $usuario["id"]; ?>">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../login/logout_process.php">Logout</a>
                </li>
            </ul>
        </div>

<div class="content-container">
    <!-- Perfil del usuario -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header text-center">
            <h2 class="mb-0"><?php echo htmlspecialchars($userInfo['username']); ?></h2>
        </div>
        <div class="card-body profile-header">
            <div class="d-flex justify-content-around mt-4">
                <div class="text-center">
                    <h6 class="font-weight-bold">Followers</h6>
                    <p class="mb-0"><?php echo $followersCount; ?></p>
                </div>
                <div class="text-center">
                    <h6 class="font-weight-bold">Following</h6>
                    <p class="mb-0"><?php echo $followingCount; ?></p>
                </div>
            </div>
            <div>
                <p class="text-muted" id="user-description"><?php echo htmlspecialchars($userInfo['description']); ?></p>
            </div>

            <?php if ($usuario['id'] == $userInfo['id']):?>
                <div class="card mt-4 shadow-sm">
                    <div class="card-body">
                        <form action="./description_process.php" method="POST">
                            <div class="form-group">
                                <textarea id="description" name="description" class="form-control" rows="3" placeholder="Write something about yourself..."><?php echo htmlspecialchars($userInfo['description']); ?></textarea>
                                <small class="form-text text-muted">You can update your description here. Maximum 160 characters.</small>
                            </div>
                            <input type="hidden" name="userId" value="<?php echo $userId; ?>">
                            <button type="submit" class="btn btn-success btn-block">Save Changes</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>

            <div class="text-center my-3">
                <?php if ($usuario['id'] != $userInfo['id']):?>
                    <form action="./follows_process.php" method="POST">
                        <input type="hidden" name="userId" value="<?php echo $userId; ?>">
                        <?php if ($isFollowing > 0):?>
                            <button type="submit" class="btn btn-danger btn-lg" name="action" value="unfollow">Unfollow</button>
                        <?php else:?>
                            <button type="submit" class="btn btn-primary btn-lg" name="action" value="follow">Follow</button>
                        <?php endif; ?>
                    </form>
                <?php endif; ?>
            </div>


        </div>
    </div>

    <h3 class="font-weight-bold">Tweets</h3>
    <div class="list-group">
        <?php if (!empty($tweets)): ?>
            <?php foreach ($tweets as $tweet): ?>
                <div class="tweet-card">
                    <div class="tweet-meta">
                        <strong><?php echo htmlspecialchars($userInfo['username']); ?></strong>
                        <small class="float-right"><?php echo htmlspecialchars($tweet['createDate']); ?></small>
                    </div>
                    <p><?php echo htmlspecialchars($tweet['text']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-info mt-3">
                No tweets to show.
            </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>