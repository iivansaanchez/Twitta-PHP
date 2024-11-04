<?php
session_start();
#Si existe el usuario te muestra la landing page sino te redirige al login
if(isset($_SESSION["usuario"])){?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Twitter Clone</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            body {
                display: flex;
                height: 100vh;
                margin: 0;
            }
            .sidebar {
                width: 250px;
                height: 100%; /* Altura completa */
                background-color: #343a40;
                color: white;
                padding: 15px;
                position: fixed; /* Fijo */
            }
            .sidebar a {
                color: white;
            }
            .sidebar a:hover {
                background-color: #495057;
                border-radius: 4px;
            }
            .content {
                margin-left: 250px; /* Deja espacio para el sidebar */
                padding: 20px;
                background-color: #f8f9fa;
                flex: 1; /* Esto asegura que el contenido ocupe el resto del espacio */
            }
            .tweet-input {
                border: 1px solid #ced4da;
                border-radius: 5px;
                padding: 10px;
                margin-bottom: 20px;
            }
        </style>
    </head>
    <body>
        <?php
        $usuario = $_SESSION["usuario"];
        ?>

        <div class="sidebar">
            <h4 class="text-center"><?php echo "@".$usuario["username"] ?></h4>
            <p class="text-center"><?php echo $usuario["email"] ?></p>
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
        <div class="content">
            <?php if(isset($_SESSION["error_message"])) { ?>
                <div class="alert alert-danger text-center" role="alert">
                    <?php
                    echo $_SESSION["error_message"];
                    #Una vez mostrada la borramos
                    unset($_SESSION["error_message"]);
                    ?>
                </div>
            <?php 
            } 
            ?>
            <form action="../tweet/tweet_process.php" method="POST" class="border p-3 rounded" style="background-color: white;">
                <div class="form-group">
                    <h5 class="font-weight-bold" for="description" style="color: #333;">What's happening?</h5>
                    <textarea class="form-control border-0" id="description" name="description" placeholder="Write your tweet..." rows="3" style="resize: none; font-size: 1.2em;" required></textarea>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <small class="text-muted">280 characters remaining</small>
                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4" style="background-color: #1da1f2; border-color: #1da1f2;">Tweet</button>
                </div>
            </form>

            <div class="d-flex justify-content-center mt-4">
                <a href="../tweet/listTweetUsersFollow_process.php" class="btn btn-light w-50 border-right-strong mx-0" >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" style="width: 20px; height: 20px;">
                        <path d="M575.8 255.5c0 18-15 32.1-32 32.1l-32 0 .7 160.2c0 2.7-.2 5.4-.5 8.1l0 16.2c0 22.1-17.9 40-40 40l-16 0c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1L416 512l-24 0c-22.1 0-40-17.9-40-40l0-24 0-64c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32 14.3-32 32l0 64 0 24c0 22.1-17.9 40-40 40l-24 0-31.9 0c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2l-16 0c-22.1 0-40-17.9-40-40l0-112c0-.9 0-1.9 .1-2.8l0-69.7-32 0c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/>
                    </svg>       
                </a>
                <a href="../tweet/listTweet_process.php" class="btn btn-light w-50 border-right-strong mx-0" >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 20px; height: 20px;">
                        <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/>
                    </svg>      
                </a>
            </div>
            <div id="tweetsSection" class="mt-4">
                
            <?php if (!empty($_SESSION["listUsersTweet"])): ?>
            <?php foreach ($_SESSION["listUsersTweet"] as $tweet): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title d-flex justify-content-between align-items-center">
                            <a href="../pages/profile.php?user=<?php echo ($tweet['userId']); ?>" class="text-decoration-none text-dark">
                                <?php echo ($tweet['username']); ?>
                            </a>
                            <small class="text-muted"><?php echo ($tweet['createDate']); ?></small>
                        </h5>
                        <p class="card-text"><?php echo ($tweet['text']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php elseif (!empty($_SESSION["error_listUsersFollow"]) && empty($_SESSION["listTweetGeneral"])): ?>
                <div class="alert alert-light" role="alert">
                    No tweets from followed users.
                </div>
            <?php endif; ?>


            <?php if (!empty($_SESSION["listTweetGeneral"]) && empty($_SESSION["listUsersTweet"])): ?>
                <?php foreach ($_SESSION["listTweetGeneral"] as $tweet): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title d-flex justify-content-between align-items-center">
                                <a href="../pages/profile.php?user=<?php echo htmlspecialchars($tweet['userId']); ?>" class="text-decoration-none text-dark">
                                    <?php echo htmlspecialchars($tweet['username']); ?>
                                </a>
                                <small class="text-muted"><?php echo htmlspecialchars($tweet['createDate']); ?></small>
                            </h5>
                            <p class="card-text"><?php echo htmlspecialchars($tweet['text']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php elseif (!empty($_SESSION["error_listGeneral"])): ?>
                <div class="alert alert-light" role="alert">
                    No tweets from general.
                </div>
            <?php endif; ?>
            </div>
        </div>
    </body>
    </html>
<?php
}else{
   header("Location: ../index.php");
}
?>
