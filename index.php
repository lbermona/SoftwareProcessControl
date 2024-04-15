<!DOCTYPE html>
<html>
<head>
	<title>Inicio</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script type="text/javascript">
		function esfuerzo(){
			window.location = "ventana_esfuerzo.php";
		}
		
        function problemas(){
            window.location = "problemas.php";
        }
        function tamañoudt(){
            window.location = "unidades_trabajo.php";
        }
        function tiempo(){
            window.location = "tiempo.php";
        }
        function dinero(){
            window.location = "dinero.php";
        }
        function requerimientos(){
            window.location = "requerimientos.php";
        }
        function cambios(){
            window.location = "cambios.php";
        }
        function pruebas(){
            window.location = "pruebas.php";
        }
        function defectos(){
            window.location = "errores_codigo.php";
        }
	</script>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
     <link rel="stylesheet" href="tresColumnas.css" type="text/css" media="all">
</head>
<body>
	<div class = "container">
		<center>
			<h1>Atributos Medibles en un Proceso de Software</h1>
			<hr>
        <table>
            <tr>
                <td class="first">
                    <u><b>Entidades recibidas o usadas </b></u>
                    <hr>
                    <input type="button" class="btn btn-success" id="add_row()" onClick="cambios()" value="Cambios" />
                    <hr>
                    <input type="button" class="btn btn-success" id="add_row()" onClick="requerimientos()" value="Requerimientos" />
                    
                    <hr>
                    <input type="button" class="btn btn-success" id="add_row()" onClick="problemas()" value="Problemas reportados" />
                </td>
                <td class="second">
                    <u><b>Entidades consumidas</b></u>
                    <hr>
                    <input type="button" class="btn btn-success" id="add_row()" onClick="esfuerzo()" value="Esfuerzo" />                  
                    <hr>
                    <input type="button" class="btn btn-success" id="add_row()" onClick="tiempo()" value="Tiempo" />
                    <hr>
                    <input type="button" class="btn btn-success" id="add_row()" onClick="dinero()" value="Costo" />
                </td>
                <td class="third">
                	<u><b>Entidades producidas</b></u>
                	<hr>
                    <input type="button" class="btn btn-success" id="add_row()" onClick="tamañoudt()" value="Tamaño Unidades de trabajo" />
                	<hr>
                	<input type="button" class="btn btn-success" id="add_row()" onClick="pruebas()" value="Resultados de pruebas" />
                    <hr>
                    <input type="button" class="btn btn-success" id="add_row()" onClick="defectos()" value="Problemas y defectos" />
                	
                </td>
            </tr>
            <tr><td class="first"></td><td class="second"></td><td class="third"></td></tr>
            
        </table>
		</center>		
	</div>

</body>
</html>