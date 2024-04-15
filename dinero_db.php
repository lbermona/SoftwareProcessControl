<?php
$conexion = new mysqli("localhost", "root", "", "tdg");


	if($conexion){
		//echo "si";
	}
	else{
		echo "no";
	}

$query1 = "DELETE FROM costo";
$resultado1 = $conexion->query($query1);


if(isset($_POST["proceso"]) && isset($_POST["esfuerzo"]) && isset($_POST["costo"])){
	
	$query = "INSERT INTO costo values (".$_POST["proceso"].", ".$_POST["esfuerzo"].", ".$_POST["costo"].")";
	
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