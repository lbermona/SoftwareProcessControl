<?php
$conexion = new mysqli("localhost", "root", "", "tdg");


	if($conexion){
		//echo "si";
	}
	else{
		echo "no";
	}

$query1 = "DELETE FROM pruebas";
$resultado1 = $conexion->query($query1);


if(isset($_POST["modulo"]) && isset($_POST["pruebas"]) && isset($_POST["noAprobadas"])){
	
	$query = "INSERT INTO pruebas values (".$_POST["modulo"].", ".$_POST["pruebas"].", ".$_POST["noAprobadas"].")";
	
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