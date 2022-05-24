<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Ciudadanos</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="js/script.js"></script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
        
        $(document).ready(function() {
        $('#poblacion').DataTable();
        }); 
    </script>
</head>
<body>
    <nav class=" navbar navbar-dark bg-dark ">
        <div class="nav">
            <a class="btn btn-primary   ms-2 text-light" href="../crud">Ciudadanos <span class="visually-hidden">(current)</span></a>
            <a class="btn btn-primary  active ms-2 text-light" href="../user">Usuarios <span class="visually-hidden">(current)</span></a>
        </div>
        <div class="dropdown me-2">
            <button class="btn btn-primary dropdown-toggle" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Menu
            </button>
            <div class="dropdown-menu" aria-labelledby="triggerId">
                <a href="../reset-password" class=" dropdown-item btn btn-warning me-3">Cambiar tu contraseña</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item btn btn-danger text-dark me-2" href="../logout.php">Salir</a>
            </div>
        <div class="float-end mt-2"></div>
        </div>
    </nav> 
    <div class="container">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class= "row d-flex justify-content-center align-items-center">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mt-3 mb-3 clearfix table-title">
                                    <h2 class="pull-left ">Detalles de la poblacion <div id="add-button" class="btn btn-success"><i class="fa fa-plus"></i> Agregar persona</div></h2>
                                </div>
                                <?php
                                        // Include config file
                                        require_once "../connect/config.php";
                                        if(empty($_POST)){
                                                $sql = "SELECT * FROM poblacion";
                                                $result = mysqli_query($link, $sql);  
                                                if($result = mysqli_query($link, $sql)){
                                                    if(mysqli_num_rows($result) > 0){
                                                        echo '<table id="poblacion" class="table table-bordered table-striped table-hover">';
                                                            echo "<thead>";
                                                                echo "<tr>";
                                                                echo "<th>#</th>";
                                                                echo "<th>Nombre Completo</th>";
                                                                echo "<th>Cedula</th>";
                                                                echo "<th>Fecha de Nacimieto</th>";
                                                                echo "<th>Genero</th>";
                                                                echo "<th>Departamento</th>";
                                                                echo "<th>Vereda</th>";
                                                                echo "<th>Acciones</th>";
                                                                echo "</tr>";
                                                            echo "</thead>";
                                                            echo "<tbody>";
                                                            $sql = "SELECT *FROM poblacion ";
                                                            $result = mysqli_query($link, $sql);
                                                            
                                                            while($row = mysqli_fetch_array($result)){
                                                                echo "<tr>";
                                                                echo "<td>" . $row['id'] .  "</td>";
                                                                echo "<td><a href='#'>". $row['complete_name'] . "</a></td>";
                                                                echo "<td>" . $row['id_card'] . "</td>";
                                                                echo "<td>" . $row['birthdate'] . "</td>";
                                                                echo "<td>" . $row['gender'] . "</td>";
                                                                echo "<td>" . $row['department'] . "</td>";
                                                                echo "<td>" . $row['sidewalk'] . "</td>";
                                                                    echo "<td>";
                                                                        
                                                                    echo "</td>";
                                                                echo "</tr>";
                                                            }
                                                            echo "</tbody>";                            
                                                        echo "</table>";
                                                        // Free result set
                                                        mysqli_free_result($result);
                                                    } else{
                                                        echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                                                    }
                                                } else{
                                                    echo "Oops! Something went wrong. Please try again later.";
                                                }
                                        // Close connection
                                        mysqli_close($link);}
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Modal -->
    <div class="modal fade" id="add_modal" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Persona</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form action="" id="new-author-frm">
                            <div class="form-group">
                                <label for="complete_name" class="control-label">Nombre Completo</label>
                                <input type="text" class="form-control rounded-0" id="complete_name" name="complete_name" required>
                            </div>
                            <div class="form-group">
                                <label for="id_card" class="control-label">Cedula</label>
                                <input type="text" class="form-control rounded-0" id="id_card" name="id_card" required>
                            </div>
                            <div class="form-group">
                                <label for="birthdate" class="control-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control rounded-0" id="birthdate" name="birthdate" required>
                            </div>
                            <div class="form-group">
                                <label for="gender" class="control-label">Genero</label>
                                <input type="text" class="form-control rounded-0" id="gender" name="gender" required>
                            </div>
                            <div class="form-group">
                                <label for="department" class="control-label">Departamento</label>
                                <input type="text" class="form-control rounded-0" id="department" name="department" required>
                            </div>                            <div class="form-group">
                                <label for="sidewalk" class="control-label">Vereda</label>
                                <input type="text" class="form-control rounded-0" id="sidewalk" name="sidewalk" required>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" form="new-author-frm">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Modal -->
    <!-- Edit Modal -->
    <div class="modal fade" id="edit_modal" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Detalles de Persona</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form action="" id="edit-author-frm">
                            <input type="hidden" name="id">
                            <div class="form-group">
                                <label for="complete_name" class="control-label">Nombre Completo</label>
                                <input type="text" class="form-control rounded-0" id="complete_name" name="complete_name" required>
                            </div>
                            <div class="form-group">
                                <label for="id_card" class="control-label">Cedula</label>
                                <input type="text" class="form-control rounded-0" id="id_card" name="id_card" required>
                            </div>
                            <div class="form-group">
                                <label for="birthdate" class="control-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control rounded-0" id="birthdate" name="birthdate" required>
                            </div>
                            <div class="form-group">
                                <label for="gender" class="control-label">Genero</label>
                                <input type="text" class="form-control rounded-0" id="gender" name="gender" required>
                            </div>
                            <div class="form-group">
                                <label for="department" class="control-label">Departamento</label>
                                <input type="text" class="form-control rounded-0" id="department" name="department" required>
                            </div>
                            <div class="form-group">
                                <label for="sidewalk" class="control-label">Vereda</label>
                                <input type="text" class="form-control rounded-0" id="sidewalk" name="sidewalk" required>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" form="edit-author-frm">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Modal -->
    <!-- Delete Modal -->
    <div class="modal fade" id="delete_modal" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar</h5>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form action="" id="delete-author-frm">
                            <input type="hidden" name="id">
                            <p>Estás segur@ de eliminar a <b><span id="name"></span></b> del listado?</p>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" form="delete-author-frm">Sí</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Modal -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script>
        $( "#add-button" ).click(function() {
            $('#add_modal').modal('show')
        });
    </script>
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
