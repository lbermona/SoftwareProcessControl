<?php
$conexion = new mysqli("localhost", "root", "", "tdg");


	if($conexion){
		//echo "si";
	}
	else{
		echo "no";
	}

$query1 = "DELETE FROM esfuerzo_dias WHERE horas<>0";
$resultado1 = $conexion->query($query1);


if(isset($_POST["dia"]) && isset($_POST["horas"])){
	
	$query = "INSERT INTO esfuerzo_dias values (".$_POST["dia"].", ".$_POST["horas"].")";
	
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