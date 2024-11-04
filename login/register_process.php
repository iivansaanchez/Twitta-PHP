<?php
session_start();
    
    #Hacemos la conexion a la base da datos para poder hacer luego consultas de validación
    require_once "../connection/connection.php";
    
    $connect = connection(); // Establecer la conexión
    
    #Recogemos los datos del formulario
    #Esto valida que en la entrada de datos se ha enviado un username sino te lo pone como false
    $username = isset($_POST["username"]) ? mysqli_real_escape_string($connect, $_POST["username"]) : false;
    $email = isset($_POST["email"]) ? mysqli_real_escape_string($connect, trim($_POST["email"])) : false;
    $password = isset($_POST["password"]) ? $_POST["password"] : '';
    $repeatPassword = isset($_POST["password2"]) ? $_POST["password2"] : '';
    $description = isset($_POST["description"]) ? mysqli_real_escape_string($connect, $_POST["description"]) : '';    
    
    #Creamos un array para almacenar los errores posibles
    $arrayErrores = array();
    
    #Hacemos las validaciones necesarias
    #Creamos variables para controlar que campo es valido y cual no
    $usernameValido;
    $emailValido;
    $passwordValido;
    $passwordRepeatValido;
    $descriptionValido;
    
    #El username no puede ser numerico ni estar vacio
    if(! empty($username) && !is_numeric($username)){
        $usernameValido = true;
    }else{
        $usernameValido = false;
        $arrayErrores["username"] = "Username not valid.";
    }
    
    #El correo no puede estar vacio ni no tener formato de correo
    if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailValido = true;
    }else{
        $emailValido = false;
        $arrayErrores["email"] = "Email not valid";
    }
    
    #La contraseña no puede estar vacía
    if(!empty($password)){
        $passwordValido = true;
    }else{
        $passwordValido = false;
        $arrayErrores["password"] = "Password not valid";
    }
    
    #La repeticion de la contraseña debe ser igual que la otra que hemos introducido
    if(!empty($repeatPassword) && $repeatPassword===$password){
        $passwordRepeatValido = true;
    }else{
        $passwordRepeatValido = false;
        $arrayErrores["repeatPassword"] = "Repeated password is not equal to the first password";
    }
    
    #Validamos que la descripcion no tenga mas de 140 caracteres
    if(strlen($description) <= 140){
        $descriptionValido = true;
    }else{
        $descriptionValido = false;
        $arrayErrores["description"] = "Description exceeds 140 characters";
    }
    
    
    #Una vez hecha todas las validaciones de los campos comprobamos que todas sean true para poder añadir el nuevo usuario
    if($usernameValido && $emailValido && $passwordValido && $passwordRepeatValido && $descriptionValido){
        #Una vez comprobado que todos los campos son validos encriptamos la contraseña para mayor seguridad para el usuario
        $passwordSegura = password_hash($password, PASSWORD_BCRYPT);
    
        #A continuación vamos a hacer la consulta introduciendo el nuevo usuario
        $sql = "INSERT INTO users (id, username, email, password, description, createDate) 
        VALUES (null, '$username', '$email', '$passwordSegura', '$description', CURDATE())";
        $guardarConsulta =  mysqli_query($connect, $sql);
    
        #Si la consulta es erronea mostraremos un error
        if(!$guardarConsulta){
            $_SESSION["errores"]["general"] = "Failed to register...";
            #Redirigimos al propio registro para mostrar los errores
            header("Location: ./register.php");
        }else{
            #Si es correcto enviaremos al usuario al login de nuevo para que pueda loguearse
            header("Location: ../index.php");
        }
    }else{
        #Si hay algo que no es válido o más de una cosa mostraremos el array completo de los errores
        $_SESSION["errores"] = $arrayErrores;
        header("Location: ./register.php");
    }
?>