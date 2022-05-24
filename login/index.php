

<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  switch($_SESSION["rol_id"]){
    case 1:
        header('location: ../crud');
    break;

    case 2:
    header('location: ../crud');
    break;

    default:
}
  exit;
}
 
// Include config file
require_once "../connect/config.php";
 
// Define variables and initialize with empty values
$username = $password = $rol_id = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
      $username_err = "Por favor, indtroduzca su nombre de usuario.";
    } else{
      $username = trim($_POST["username"]);
    }
  
  // Check if password is empty
    if(empty(trim($_POST["password"]))){
      $password_err = "Por favor, introduzca su contraseña.";
    } else{
      $password = trim($_POST["password"]);
    }
  
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        
      // Prepare a select statement
        $sql = "SELECT id, username, password, rol_id FROM usuarios WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            $param_rol_id = $rol_id;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $rol_id);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["rol_id"] =  $rol_id;

                            // Redirect user to welcome page
                            switch( $rol_id){
                              case 1:
                                  header('location: ../user');
                              break;
                
                              case 2:
                              header('location: ../crud');
                              break;
                
                              default:
                          }
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Nombre de usuario o contraseña invalido.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Nombre de usuario o contraseña invalido.";
                }
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
  <title>Iniciar Sesion</title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <style>
  .company_img{
    width: 150px;
    border-radius:75px;
  }
  </style>
</head>
<body>
<nav class="navbar navbar-dark bg-dark"> </nav>
<section class="mt-5 mb-5">
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp" class="img-fluid"
          alt="Sample image">
      </div>
      
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
      <h2>Iniciar Sesión</h2>
        <p>Por favor, complete sus credenciales para iniciar sesión.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <!-- Username input -->
          <div class="form-group form-outline mb-4">
          <label class="form-label" for="form3Example3">Usuario</label>
            <input type="text" name="username" id="form3Example3" class="form-control form-control-lg <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" 
              placeholder="Introduzca un usuario válido" />
              <span class="invalid-feedback"><?php echo $username_err; ?></span>
            
          </div>

          <!-- Password input -->
          <div class="form-group form-outline mb-3">
          <label class="form-label" for="form3Example4">Contraseña</label>
            <input type="password" name="password" id="form3Example4" class="form-control form-control-lg  <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
             placeholder="Introducir la contraseña" />
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
          </div>
          <div class="form-group text-center text-lg-start mt-4 pt-2">
                <input type="submit" class="btn btn-primary" value="Entrar">
            <p class="small fw-bold mt-2 pt-1 mb-0">No tienes una cuenta? <a href="../register"
                class="link-danger">Registrate Aquí</a></p>
          </div>

        </form>
      </div>
    </div>
  </div>

</section>
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
