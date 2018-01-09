<?php
	session_start();
	if (empty($_POST['mod_id'])) {
           $errors[] = "ID vacío";
        } else if (empty($_POST['priority_id'])){
			$errors[] = "Prioridad Vaciao";
		} else if (empty($_POST['status_id'])){
			$errors[] = "Estado Vacio";
		}  else if (
			!empty($_POST['priority_id']) &&
			!empty($_POST['status_id'])
		){

		include "../config/config.php";//Contiene funcion que conecta a la base de datos



		
		$priority_id = $_POST["priority_id"];
        
		
		$status_id = $_POST["status_id"];
		
		$id=$_POST['mod_id'];

		$sql = "update ticket set priority_id=\"$priority_id\",status_id = \"$status_id\",updated_at=NOW() where id=$id";
		// echo $sql;
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "El ticket ha sido actualizado satisfactoriamente.";
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
			}
		} else {
			$errors []= "Error desconocido.";
		}
		
		if (isset($errors)){
			
			?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong> 
					<?php
						foreach ($errors as $error) {
								echo $error;
							}
						?>
			</div>
			<?php
			}
			if (isset($messages)){
				
				?>
				<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>¡Bien hecho!</strong>
						<?php
							foreach ($messages as $message) {
									echo $message;
								}
							?>
				</div>
				<?php
			}

?>