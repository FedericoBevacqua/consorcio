<?php
require_once '../config/Conexion.php'; 
session_start();
if(!isset($_SESSION['sinRol'])){  // verificar si un usuario sin Rol.
    header("Location: index.php");} ?>

<!DOCTYPE html>
<html lang="es">
<?php include('template/head.php'); ?>

    <body>
    <?php 
        include('template/header.php'); ?>
    
    <title>Consorcios del Valle - SinRol</title>
    <br>
    <h5 class="center-align">No puedes visualizar esta pagina porque no tienes asignado un Rol. Ponte en contacto con un administrador.</h5>

    <div class="form-row">
        <div class="form-group col-md-6">
            <input class="btn btn-dark" type="button" value="Volver al Inicio" onClick="window.location = 'index.php';">  
        </div>
    </div>

    <div class="corte">
    </div>
    <?php include('template/footer.php'); ?>
    </body>
</html>