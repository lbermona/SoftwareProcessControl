<?php
$conexion = new mysqli("localhost", "root", "", "tdg");


	if($conexion){
		//echo "si";
	}
	else{
		echo "no";
	}

$query1 = "DELETE FROM unidades_trabajo_db";
$resultado1 = $conexion->query($query1);


if(isset($_POST["modulo"]) && isset($_POST["sloc"]) ){
	
	$query = "INSERT INTO unidades_trabajo_db values (".$_POST["modulo"].", ".$_POST["sloc"].")";
	
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