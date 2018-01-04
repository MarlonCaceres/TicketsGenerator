<?php	
	session_start();
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['title'])) {
           $errors[] = "Titulo vacío";
        } else if (empty($_POST['description'])){
			$errors[] = "Description vacío";
		}else if (empty($_POST['user_id'])){
			$errors[] = "Debe seleccionar un usuario.";
		} else if (empty($_POST['ticket_id'])){
			$errors[] = "Debe seleccionar un ticket";
		} else if (
			!empty($_POST['title']) &&
			!empty($_POST['description'])
		){


		include "../config/config.php";//Contiene funcion que conecta a la base de datos

		$title = $_POST["title"];
		$description = $_POST["description"];
		$user_id = $_POST["user_id"];
		$ticket_id = $_POST["ticket_id"];
		$status='';
		$company_id=$_SESSION['idEmpresa'];
		$created_date= date("Y-m-d");

		//$user_id = $_SESSION["user_id"];
		$status_id = 1;
		//$kind_id = $_POST["kind_id"];
		//$created_at="NOW()";

		//$user_id=$_SESSION['user_id'];

		$sql="insert into tareas (title,description,user_id,ticket_id,company_id,status,create_date) value (\"$title\",\"$description\",\"$user_id\",\"$ticket_id\",\"$company_id\",$status_id,\"$created_date\")";

		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				$messages[] = "La tarea ha sido ingresado satisfactoriamente.";
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