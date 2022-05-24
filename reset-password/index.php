
<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login");
    exit;
}
 
// Include config file
require_once "../connect/config.php";
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Por favor, introduzca la nueva contraseña.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "La contraseña debe tener al menos 6 caracteres.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Por favor, confirme la contraseña.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE usuarios SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: ../login");
                exit();
            } else{
                echo "Oops! Algo salió mal. Por favor, inténtelo de nuevo más tarde.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
 <!DOCTYPE html>
<html lang="es">
<head>
    <title>Cambiar Contraseña</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .wrapper{ width: 360px; padding: 20px; }
</style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark"> </nav>
    <div class= "row d-flex justify-content-center align-items-center">
        <div class="wrapper">
            <h2>Cambiar Contraseña</h2>
            <p>Por favor, rellene este formulario para restablecer su contraseña.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
                <div class="form-group">
                    <label>Nueva contraseña</label>
                    <input type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
                    <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Confirmar contraseña</label>
                    <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                </div>
                <div class="form-group mt-2">
                    <input type="submit" class="btn btn-primary" value="Enviar">
                    <a class="btn btn-link ml-2" href="../crud">Cancelar</a>
                </div>
            </form>
        </div>    
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
<!-- Footer -->
<footer class="text-center text-lg-start bg-dark text-muted">
    <!-- Section: Social media -->
    <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
    <!-- Left -->
        <div class="me-5 d-none d-lg-block">
            <span>Conéctate con nosotros en las redes sociales:</span>
        </div>
    <!-- Left -->
    <!-- Right -->
        <div>
            <a href="https://www.facebook.com/Coding-Noose-Group-108770114946890/" target="_blank" class="me-4 text-reset"><i class="fab fa-facebook-square"></i></a>
            <a href="https://twitter.com/GroupNoose" target="_blank" class="me-4 text-reset"><i class="fab fa-twitter-square"></i></a>
            <a href="https://www.instagram.com/coodingnoosegroup/" target="_blank" class="me-4 text-reset"><i class="fab fa-instagram"></i></a>
            <a href="https://www.linkedin.com/in/codingnoosegroup/" target="_blank" class="me-4 text-reset"><i class="fab fa-linkedin"></i></a>
            <a href="https://github.com/CodingNooseGroup" target="_blank" class="me-4 text-reset"><i class="fab fa-github"></i></a>
        </div>
    <!-- Right -->
    </section>
    <!-- Section: Social media -->
    <!-- Section: Links  -->
    <section class="">
        <div class="container text-center text-md-start mt-5">
            <!-- Grid row -->
            <div class="row mt-3">
                <div class="col-lg-1 mx-auto  mb-5 ">
                    <!-- Content -->
                    <img class="company_img" src="../img/company_img.jpg" alt="">
                </div>
                <!-- Grid column -->
                <div class=" col-xl-3 mb-1">
                    <!-- Content -->
                    <h6 class="text-uppercase fw-bold mb-4">
                        <i class="fas fa-gem me-3"></i>Coding Noose Group
                    </h6>
                    <p>
                    Coding Noose Group es una empresa de desarrollo de software enfocada en el Desarrollo Web, contamos con un equipo de trabajo especializado tanto en Frontend como en Backend y Diseñadores, para brindarle el mejor servicio a su disposicion.
                    </p>
                </div>
                <!-- Grid column -->
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4">
                        Contact
                    </h6>
                    <p>
                        <i class="fas fa-home me-1"></i>xxxxx/Santa Marta/Colombia
                    </p>
                    <p>
                        <i class="fas fa-envelope me-1"></i>coddingnoosegroup@gmail.com.
                    </p>
                    <p>
                        <i class="fas fa-phone me-1"></i>+57 300 000 0000.
                    </p>
                    <p>
                        <i class="fas fa-print me-1"></i>+57 300 000 0000.
                    </p>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->
        </div>
    </section>
    <!-- Section: Links  -->
    <!-- Copyright -->
    <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
        © 2021 Copyright:
        <a class="text-reset fw-bold" target="_blank" href="https://jesusdaconte.com/">jesusdaconte.com</a>
    </div>
    <!-- Copyright -->
</footer>
<!-- Footer -->
</html>
<style>
        .company_img{
        width: 150px;
        border-radius:75px;}
</style>
