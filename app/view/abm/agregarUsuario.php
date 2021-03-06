<?php
require_once '../../config/Conexion.php';
require_once '../../clases/Usuario.php';
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: index.php");} ?>

<!DOCTYPE html>
<html lang="es">
<?php include('../template/head.php'); ?>

    <body>
    <?php 
        include('../template/nav.php');  
        include('../template/header.php'); ?>

        <title>Consorcios del Valle - Agregar Usuario</title>

        <div class="container">
		<div class="content">
			<h2>Datos del usuario &raquo; Agregar datos</h2>
			<hr />

			<?php
			if(isset($_POST['add'])){
				$apellido		     = mysqli_real_escape_string($conexion,(strip_tags($_POST["apellido"],ENT_QUOTES)));//Escanpando caracteres 
				$apellido = ucfirst($apellido);
				$nombre		     = mysqli_real_escape_string($conexion,(strip_tags($_POST["nombre"],ENT_QUOTES)));//Escanpando caracteres 
				$nombre = ucfirst($nombre);
                $cuil		     = mysqli_real_escape_string($conexion,(strip_tags($_POST["cuil"],ENT_QUOTES)));//Escanpando caracteres     
                $email		     = mysqli_real_escape_string($conexion,(strip_tags($_POST["email"],ENT_QUOTES)));//Escanpando caracteres     
                $dni		     = mysqli_real_escape_string($conexion,(strip_tags($_POST["dni"],ENT_QUOTES)));//Escanpando caracteres 
				$telefono		 = mysqli_real_escape_string($conexion,(strip_tags($_POST["telefono"],ENT_QUOTES)));//Escanpando caracteres 
				$idRol          = mysqli_real_escape_string($conexion,(strip_tags($_POST["idRol"],ENT_QUOTES)));//Escanpando caracteres 
				$estado			 = mysqli_real_escape_string($conexion,(strip_tags($_POST["estado"],ENT_QUOTES)));//Escanpando caracteres 
				//Password es igual al DNI
				$pass		     = mysqli_real_escape_string($conexion,(strip_tags($_POST["dni"],ENT_QUOTES)));//Escanpando caracteres 
				$pass_sha1 = sha1($pass);
				$primeraVez = 1;

				$error = array();
				//Validaciones
				if(!(ctype_alpha($nombre) && strlen($nombre) >= 3 && strlen($nombre) <= 20)){
					$error[] = "Nombre debe tener al menos 3 caracteres, solo alfabeticos";
				  }        
				
				if(!(ctype_alpha($apellido) && strlen($apellido) >= 3 && strlen($apellido) <= 20)){
					$error[] = "Apellido debe tener al menos 3 caracteres, solo alfabeticos";
				  }
				if(!(ctype_digit($cuil) && strlen($cuil) == 11)){
					$error[] = "Cuil debe tener 11 digitos sin guiones.";
				  }
                $usuario = new Usuario();
				$cuilValido = $usuario::validarCuil($cuil);
                if(!$cuilValido){
					$error[] = "Cuil invalido.";
				  }
                $cek3 = mysqli_query($conexion, "SELECT * FROM usuarios WHERE cuil='$cuil'");
                    if(!(mysqli_num_rows($cek3) == 0)){
                        $error[] = "Cuil ya utilizado en otro usuario.";
                    }
                
				if(!(ctype_digit($dni) && strlen($dni) == 8)){
					$error[] = "Dni debe tener 8 digitos sin guiones.";
				  }
				
				$cek4 = mysqli_query($conexion, "SELECT * FROM usuarios WHERE dni='$dni'"); //and idUsuarios<>'$nik'
                if(!(mysqli_num_rows($cek4) == 0)){
                    $error[] = "Dni está utilizado en otro usuario.";
                }

				if(!(ctype_digit($telefono) && strlen($telefono) >= 8 && strlen($telefono) <= 10)){
					$error[] = "Teléfono debe tener entre 8 y 10 digitos sin guiones.";
				  }

				if(!(filter_var($email, FILTER_VALIDATE_EMAIL))){
					$error[] = "Email incorrecto";
				}
				$cek5 = mysqli_query($conexion, "SELECT * FROM usuarios WHERE email='$email'");
                if(!(mysqli_num_rows($cek5) == 0)){
                    $error[] = "Email está utilizado en otro usuario.";
				}
				
				if(sizeof($error) == 0){

				//Realiza el Insert solo si no existe otro usuario con el mismo DNI
				$cek = mysqli_query($conexion, "SELECT * FROM usuarios WHERE idUsuarios='$dni'");
				if(mysqli_num_rows($cek) == 0){
						$insert = mysqli_query($conexion, "INSERT INTO usuarios(apellido, nombre, cuil, email, dni, telefono, idRol, estado, pass, primeraVez)
															VALUES('$apellido', '$nombre', '$cuil', '$email', '$dni', '$telefono', '$idRol', '$estado', '$pass_sha1', '$primeraVez')") or die(mysqli_error($conexion));
						if($insert){
							echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! Los datos han sido guardados con éxito.</div>';
						}else{
							echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. No se pudo guardar los datos !</div>';
						}
					 
				}else{
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. El DNI ya existe!</div>';
				}
			}else{
                echo "Ocurrio un error en los siguientes campos: ";
                foreach($error as $er){
                    echo "</br><strong>$er</strong>";
                  }
				}
		}
			?>

			<form class="form-horizontal" action="" method="post">
                <div class="form-group">
					<label class="col-sm-3 control-label">Apellido</label>
					<div class="col-sm-4">
						<input type="text" name="apellido" class="form-control" maxlength="50" placeholder="Apellido" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Nombre</label>
					<div class="col-sm-4">
						<input type="text" name="nombre" class="form-control" maxlength="50" placeholder="Nombre" required>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-3 control-label">CUIL</label>
					<div class="col-sm-4">
						<input type="text" name="cuil" class="form-control" maxlength="11" placeholder="Cuil" required><small class="form-text text-muted">Solo ingresar números, sin letras ni caracteres especiales.</small>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-3 control-label">Correo Electrónico</label>
					<div class="col-sm-4">
						<input type="text" name="email" class="form-control" maxlength="50" placeholder="E-mail" required>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-3 control-label">DNI</label>
					<div class="col-sm-4">
						<input type="text" name="dni" class="form-control" maxlength="8" placeholder="Dni" required><small class="form-text text-muted">Solo ingresar números, sin letras ni caracteres especiales.</small>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Teléfono</label>
					<div class="col-sm-3">
						<input type="text" name="telefono" class="form-control" maxlength="11" placeholder="Teléfono" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Rol</label>
					<div class="col-sm-3">
					<select name="idRol" class="form-control">
                            <?php  $datos = mysqli_query($conexion, "SELECT * FROM roles"); //muestra todos los roles
                             while ($row2 = mysqli_fetch_assoc($datos)) { ?>
                            <option value="<?php echo $row2['idRoles']; ?>">
                                <?php echo $row2['descripcion']; ?>
                                </option>
                            <?php } ?>
                        </select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Estado</label>
					<div class="col-sm-3">
						<select name="estado" class="form-control">
							<option value="Pendiente">Pendiente</option>
                            <option value="Activo">Activo</option>
							<option value="Inactivo">Inactivo</option>
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">&nbsp;</label>
					<div class="col-sm-6">
						<input type="submit" name="add" class="btn btn-sm btn-primary" value="Guardar datos">
						<a href="../listaUsuario.php" class="btn btn-sm btn-danger">Cancelar</a>
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="corte">
    </div>
    <?php include('../template/footer.php'); ?>
    </body>

</html>