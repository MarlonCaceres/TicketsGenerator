<?php
	session_start();
	if (empty($_POST['mod_id'])) {
           $errors[] = "ID vacío";
        } else if (empty($_POST['title'])){
			$errors[] = "Titulo vacío";
		} else if (empty($_POST['description'])){
			$errors[] = "Description vacío";
		}  else if (empty($_POST['empresa_id'])){
			$errors[] = "Empresa sin elegir";
		} else if (
			!empty($_POST['title']) &&
			!empty($_POST['description'] &&
			!empty($_POST['empresa_id'])
			)
		){

		include "../config/config.php";//Contiene funcion que conecta a la base de datos



		$title = $_POST["title"];
		$description = $_POST["description"];
		$category_id = (isset($_POST['category_id']) && !empty($_POST["category_id"]))? $_POST["category_id"] :0;
		$project_id = (isset($_POST['project_id']) && !empty($_POST["project_id"]))? $_POST["project_id"] :0;
		//$priority_id =  (isset( $_POST["priority_id"])&& !empty($_POST["priority_id"]))?$_POST["priority_id"]:1;
		$empresa_id=$_POST["empresa_id"];

        $fecha_entrega= (isset($_POST['fecha_entrega']) && !empty($_POST["fecha_entrega"]))? date("Y-m-d", strtotime($_POST["fecha_entrega"])):null;
		$user_id = $_SESSION["user_id"];
		//$status_id = $_POST["status_id"];
		//$kind_id = $_POST["kind_id"];
		$id=$_POST['mod_id'];


		
		if (isset($_FILES["adjunto"]))
		{
			
			$file = $_FILES["adjunto"];
			
			$name = $file["name"];
			
			$type = pathinfo ($file["name"], PATHINFO_EXTENSION);
			//echo $type;
			$name= basename($name,".".$type).rand(10,1000);
			$name= $name.".".$type;
			$tmp_n = $file["tmp_name"];
			$size = $file["size"];
			$folder = "../Adjuntos/";
			//css js php cpp exe 
			if ($type =='js' || $type =='exe' ||$type=='css'|| $type=='cpp'||$type=='apk' )
			{
			 $errors[] = "Error, archvio no permitido. <br>"; 
			$name=null;
			}
			else if ($size > (1024*1024)*10)
			{
			$errors[] = "Error, el tamaño máximo permitido es un 10MB  <br>";
			$name=null;
			}
			else
			{
				$src = $folder.$name;
				@move_uploaded_file($tmp_n, $src);
				// echo "Subir archivo".$src;
				// echo "antes".$tmp_n;
			}
			$sql = "update ticket set title=\"$title\",category_id=\"$category_id\",project_id=\"$project_id\",description=\"$description\",fecha_entrega=\"$fecha_entrega\",empresa_id_asig=\"$empresa_id\" ,adjunto=\"$name\" ,updated_at=NOW() where id=$id";
		}else{
			$sql = "update ticket set title=\"$title\",category_id=\"$category_id\",project_id=\"$project_id\",description=\"$description\",fecha_entrega=\"$fecha_entrega\",empresa_id_asig=\"$empresa_id\" ,updated_at=NOW() where id=$id";
		}


		

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