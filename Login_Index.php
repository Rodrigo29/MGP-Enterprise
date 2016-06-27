<?php 
session_start();
if(!isset($_SESSION['estaLoggeadoUsuario']) || isset($_SESSION['estaLoggeadoUsuario']) && $_SESSION['estaLoggeadoUsuario'] == false){
	die("Ud. no tiene acceso para visitar esta secci&oacute;n.");
}
include("Conectar.php");
?>
<!DOCTYPE html> 
<head>
	<title> CouchInn </title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel ="stylesheet" type ="text/css" href ="Estilos_Login_Index.css"/>
	<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="JavaScript_index.js"></script>
	<script src="Jquery.js" type="text/javascript"></script>
</head>
<body>
	<?php
		include("Login_Cabeza.php");
	?>
	<div id="cuerpo">
		<?php
			include("Login_Menu.php");
		?>
		<div id="buscar">
			<div id= "titulo">
				<p> Busca tu destino </p>
			</div>
			<div id= "SubBus">
				<form action="Login_Buscar_VerCouch.php" method="post" name="buscar">
					<div class= "select" id= "formulario">
						Titulo:
						<input type="text" name="titulo" value="" PLACEHOLDER="Ingrese un titulo"/>
					</div>
					<div class= "select" id= "formulario">
						Tipo:
						<select name="tipo" style="width:16em">
							<option value="">Seleccione un tipo</option>
							<?php
								$query = "SELECT * FROM tipo WHERE tipo.Eliminado=0"; 
								$q = mysql_query($query, $link);
								while($result=mysql_fetch_array($q)) {	
									echo"<option value=".$result["idTipo"].">".$result["Tipo"]."</option>";
								}
							?>
						</select>
					</div>
					<div class= "select" id= "formulario">
						Capacidad:
						<select name="capacidad" style="width: 16em">
							<option value="">Seleccione la capacidad</option>
							<option value="1"> 1 </option>
							<option value="2"> 2 </option>
							<option value="3"> 3 </option>
							<option value="4"> 4 </option>
							<option value="5"> 5 </option>
							<option value="6"> Mas... </option>
						</select>
					</div>
					<div class= "select" id= "formulario">
						Localidad:
						<select name="loc" id="localidades" style="width: 16em"> 
							<option value="">Seleccione una localidad</option>
							<?php
								$query = "SELECT * FROM localidades"; 
								$q = mysql_query($query, $link);
								while($result=mysql_fetch_array($q)) {	
									echo"<option value=".$result["idLocalidades"].">".$result["Localidad"]."</option>";
								}
							?>
						</select>
					</div>
					<div class= "select" id= "formulario">
						Puntaje:
						<select name="puntaje" style="width: 16em">
							<option value="">Seleccione el puntaje</option>
							<option value="1"> 1 </option>
							<option value="2"> 2 </option>
							<option value="3"> 3 </option>
							<option value="4"> 4 </option>
							<option value="5"> 5 </option>
						</select>
					</div>
					<div class= "select" id= "formulario1">
						Descripcion:
						<textarea rows="4" cols="40" name="descripcion" value="" MAXLENGTH="140" PLACEHOLDER="Ingrese una descripcion"></textarea>	
					</div>
					<div id="boton">
						<input type="submit" name="buscar" value="Buscar" onclick="buscar"/>
					</div>
				</form>
			</div>
		</div>
		<div id="lista">
			<div id= "subLis">
				<div id= "titulo2">
					<p> Hospedajes </p>
				</div>
				<?php

					$query = "SELECT * FROM couch ORDER BY idCouch DESC";   //CONSULTA A LA TABLA COUCH
					$q = mysql_query($query, $link);
					$num=mysql_num_rows ($q);
					
					if ($num<>0) {	
						if ($num > 5) {
							$num= 5;
						}	
						for ($i=0; $i<$num; $i++) {

							$resCouch=mysql_fetch_array($q);

							if ($resCouch['Publicado'] == 0) {

								echo '<div id= "fila">';

									$query = "SELECT * FROM imagenes WHERE idCouch='".$resCouch['idCouch']."'";   //CONSULTA A LA TABLA IMAGENES CHOCANDO IDCOUCH
									$qe = mysql_query($query, $link);
									$resImg=mysql_fetch_array($qe);

									echo '<a href="Login_Ver_Couchs_Detalles.php?couch='.$resCouch['idCouch'].'">';

									echo '<div id= "imag">';
										$query = "SELECT * FROM ucomun WHERE idUComun='".$resCouch['idUComun']."'";   //CONSULTA A LA TABLA USUARIO CHOCANDO IDUCOMUN
										$qe = mysql_query($query, $link);
										$resUser=mysql_fetch_array($qe);
										if ($resUser['Premium'] and $resImg['Imagen']) {   //SI PREMIUM ES TRUE Y SI SUBIO UNA IMAGEN
											$dir = $resImg['Imagen'];
											//echo $dir; PARA VER SI ANDA 
											echo'<img class="redondo" src="'.$dir.'" width="74" height="74"/>';
										}
										else {
											echo'<img class="redondo" src="Imagen/sillon.png" width="74" height="74"/>';
										}
									echo '</div>';

									echo '<div id= "titu">';
										echo '<b> '.$resCouch['Titulo'].' </b>';
									echo '</div>';

									echo '<div id= "des">';
										echo '<p> '.$resCouch['Descripcion'].' </p>';
									echo '</div>';

									echo '</a>';

								echo '</div>';
							}
							else {
								$i= $i-1;  //PARA QUE HAGA LOS 5 COUCH DEL FOR, SINO QUEDA UNO MENO PORQUE NO ENTRA AL IF
							}
						}
					}
					else {
						echo '<div id="noCouch">';
							echo 'No disponemos de hospedajes por el momento.';
						echo '</div>';
					}
				?>		
			</div>
			<div id="boton2">
				<input type="button" name="buscar" value="Ver más" OnClick="location.href='Login_Ver_Couchs.php'"/>
			</div>
			</div>

		</div>		
	</div>
	<?php
		include("Pie.php");
	?>
</body>
</html>