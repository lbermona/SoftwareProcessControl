<?php
$conexion = new mysqli("localhost", "root", "", "tdg");


	if($conexion){
		//echo "si";
	}
	else{
		echo "no";
	}

$query1 = "DELETE FROM errores";
$resultado1 = $conexion->query($query1);


if(isset($_POST["modulo"]) && isset($_POST["defectos"]) && isset($_POST["tamano"])){
	
	$query = "INSERT INTO errores values (".$_POST["modulo"].", ".$_POST["defectos"].", ".$_POST["tamano"].")";
	
	$resultado = $conexion->query($query);
	if($resultado){
		//echo '<script>alert("siBD")</script>';
	}
	else{
		echo '<script>alert("noBD")</script>';
		
	}
	

}

$conexion->close();


?>