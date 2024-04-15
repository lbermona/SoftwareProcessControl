<?php
$conexion = new mysqli("localhost", "root", "", "tdg");


	if($conexion){
		//echo "si";
	}
	else{
		echo "no";
	}

$query1 = "DELETE FROM requerimientos";
$resultado1 = $conexion->query($query1);


if(isset($_POST["modulo"]) && isset($_POST["requerimientos"]) && isset($_POST["noResueltos"])){
	
	$query = "INSERT INTO requerimientos values (".$_POST["modulo"].", ".$_POST["requerimientos"].", ".$_POST["noResueltos"].")";
	
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