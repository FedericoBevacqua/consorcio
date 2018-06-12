<?php
require_once '../config/Conexion.php'; 
session_start();
if(isset($_SESSION['username'])){} ?>

<!DOCTYPE html>
<html lang="es">
<?php include('template/head.php'); ?>

    <body>
    <?php 
        include('template/nav.php');  
        include('template/header.php'); ?>

		<title>Consorcios del Valle - Lista de Unidades Funcionales</title>

        <div class="container">
		<div class="content">
			<h2>Lista de UF</h2>
			<hr />


			<br />
			<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tr>
                    <!--<th>No</th> -->
					<th>Id Propiedad</th>
					<th>Id Usuario</th>
                    <th>Porcentaje</th>
                    <th>Piso</th>
                    <th>Departamento</th>
                    <th>Unidad Funcional</th>
					<th>Consorcio</th>
                    <th>Acciones</th>
				</tr>
				<?php
					$sql = mysqli_query($conexion, "SELECT * FROM propiedad ORDER BY idPropiedad ASC");
				if(mysqli_num_rows($sql) == 0){
					echo '<tr><td colspan="8">No hay datos.</td></tr>';
				}else{
					//$no = 1;
					while($row = mysqli_fetch_assoc($sql)){
                        /* <td>'.$no.'</td> encima del $row */
                        /* Falta linkear unir las tablas idRol para que muestre nombre del rol */
						echo '
						<tr>
							<td>'.$row['idPropiedad'].'</td>
                            <td><a href="perfil.php?nik='.$row['idUsuarios'].'"><span class="fas fa-user" aria-hidden="true"></span> '.$row['idUsuarios'].'</a></td>
                            <td>'.$row['porcentajeParticipacion'].'</td>
                            <td>'.$row['piso'].'</td>
                            <td>'.$row['departamento'].'</td>
                            <td>'.$row['unidadFuncionalLote'].'</td>
							<td>'.$row['idConsorcio'].'</td>   
							<td>

								<a href="abm/editarUF.php?nik='.$row['idPropiedad'].'" title="Editar Usuario Asignado" class="btn btn-primary btn-sm"><span class="fas fa-edit" aria-hidden="true"></span></a>
							</td>
						</tr>
						';
						//$no++;
					}
				}
				?>
			</table>
			</div>
		</div>
	</div><center>



    <?php include('template/footer.php'); ?>
    </body>

</html>