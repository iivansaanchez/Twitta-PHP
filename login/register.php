<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Registration</title>
    <style>
        body {
            background-color: #f8f9fa; /* Light background color */
        }
        .register-container {
            height: 100vh; /* Full height of the viewport */
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-form {
            background-color: #fff; /* White background for the form */
            padding: 30px;
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            width: 400px; /* Wider form */
        }
    </style>
</head>
<body>

<div class="container register-container">
    <div class="register-form">
        <h2 class="text-center mb-4">Register</h2>

        <?php if(isset($_SESSION["errores"]) && count($_SESSION["errores"]) > 0) { ?>
            <div class="alert alert-danger text-center" role="alert">
                <p>
                    <?php
                    // Recorremos el array de errores y mostramos cada uno en una lista
                    foreach($_SESSION["errores"] as $error) {
                        echo "<li>$error</li>";
                    }
                    unset($_SESSION["errores"]); // Limpiar los errores después de mostrarlos
                    ?>
                </p>  
            </div>
        <?php } ?>


        <form action="./register_process.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="form-group">
                <label for="password">Repeat your password</label>
                <input type="password" class="form-control" id="password2" name="password2" placeholder="Repeat your password" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" placeholder="Enter a brief description" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </form>

        <div class="text-center mt-3">
            <p>Already have an account? <a href="./login.php">Login here</a></p>
        </div>
    </div>
</div>

</body>
</html>
