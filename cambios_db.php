<?php
$conexion = new mysqli("localhost", "root", "", "tdg");


	if($conexion){
		//echo "si";
	}
	else{
		echo "no";
	}

$query1 = "DELETE FROM cambios";
$resultado1 = $conexion->query($query1);


if(isset($_POST["modulo"]) && isset($_POST["cambios"]) && isset($_POST["noResueltos"])){
	
	$query = "INSERT INTO cambios values (".$_POST["modulo"].", ".$_POST["cambios"].", ".$_POST["noResueltos"].")";
	
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