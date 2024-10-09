<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        .login-container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-form {
            width: 100%;
            max-width: 400px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container login-container">
    <div class="login-form">
        <h2 class="text-center mb-4">Login</h2>
        
        <?php if(isset($_SESSION["error"])) { ?>
            <div class="alert alert-danger text-center" role="alert">
                <?php
                echo $_SESSION["error"];
                #Una vez mostrada la borramos
                unset($_SESSION["error"]);
                ?>
            </div>
        <?php } ?>

        <form action="./login/login.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>

        <div class="text-center mt-3">
            <p>Don't have an account? <a href="/login/register.php">Register here</a></p>
        </div>
    </div>
</div>
</body>
</html>
