<?php
$conexion = new mysqli("localhost", "root", "", "tdg");


	if($conexion){
		//echo "si";
	}
	else{
		echo "no";
	}

$query1 = "DELETE FROM esfuerzo_semanas";
$resultado1 = $conexion->query($query1);


if(isset($_POST["semana"]) && isset($_POST["lunes"]) && isset($_POST["martes"]) && isset($_POST["miercoles"]) && isset($_POST["jueves"]) && isset($_POST["viernes"])){
	
	$query = "INSERT INTO esfuerzo_semanas values (".$_POST["semana"].", ".$_POST["lunes"].", ".$_POST["martes"].", ".$_POST["miercoles"].", ".$_POST["jueves"].", ".$_POST["viernes"].")";
	
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