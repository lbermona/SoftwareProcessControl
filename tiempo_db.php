<?php
$conexion = new mysqli("localhost", "root", "", "tdg");


	if($conexion){
		//echo "si";
	}
	else{
		echo "no";
	}

$query1 = "DELETE FROM tiempo";
$resultado1 = $conexion->query($query1);


if(isset($_POST["proceso"]) && isset($_POST["nombre"]) && isset($_POST["inicio"]) && isset($_POST["fin"])){
	
	$query = "INSERT INTO tiempo values (convert(datetime,".$_POST["proceso"].", ".$_POST["nombre"].", ".$_POST["inicio"].", ".$_POST["fin"]."))";
	
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