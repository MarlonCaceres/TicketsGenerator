<?php	
	session_start();	
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['title'])) {
           $errors[] = "Titulo vacío";
        } else if (empty($_POST['description'])){
			$errors[] = "Description vacío";
		} else if (empty($_POST['empresa_id'])){
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
		$priority_id =  (isset( $_POST["priority_id"])&& !empty($_POST["priority_id"]))?$_POST["priority_id"]:1;
		$empresa_id=$_POST["empresa_id"];		
		$fecha_entrega= (isset($_POST['fecha_entrega']) && !empty($_POST["fecha_entrega"]))? date("Y-m-d", strtotime($_POST["fecha_entrega"])):null;


	

		//console_log($_POST);		
		//console_log($_FILES);


		$user_id = $_SESSION["user_id"];
		$status_id = 1;
		//$kind_id = $_POST["kind_id"];
		$kind_id = 1;
		$created_at="NOW()";
		$name=null;
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
		}
		

		$sql="insert into ticket (title,description,category_id,project_id,priority_id,user_id,status_id,kind_id,created_at,fecha_entrega,empresa_id_asig,adjunto) value (\"$title\",\"$description\",\"$category_id\",\"$project_id\",$priority_id,$user_id,$status_id,$kind_id,$created_at,\"$fecha_entrega\",$empresa_id,\"$name\")";
		//echo $sql;
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				$messages[] = "Tu ticket ha sido ingresado satisfactoriamente.";
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