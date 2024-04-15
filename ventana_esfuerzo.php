<!DOCTYPE html>
<html>
<head>
	<title>Esfuerzo</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script type="text/javascript">
		function esfuerzo_dias1(){
			window.location = "esfuerzo_dias1.php";
		}
        function esfuerzo_dias2(){
            window.location = "esfuerzo_dias2.php";
        }
        function esfuerzo_dias3(){
            window.location = "esfuerzo_dias3.php";
        }
        function esfuerzo_dias4(){
            window.location = "esfuerzo_dias4.php";
        }
        function esfuerzo_dias5(){
            window.location = "esfuerzo_dias5.php";
        }
		function esfuerzo_semanas1(){
			window.location = "esfuerzo_semanas1.php";
		}
        function esfuerzo_semanas2(){
            window.location = "esfuerzo_semanas2.php";
        }
        function esfuerzo_semanas3(){
            window.location = "esfuerzo_semanas3.php";
        }
        function esfuerzo_semanas4(){
            window.location = "esfuerzo_semanas4.php";
        }
        function esfuerzo_semanas5(){
            window.location = "esfuerzo_semanas5.php";
        }
        function volver(){
    window.location = "index.php";
}
	</script>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
     <link rel="stylesheet" href="dosColumnas.css" type="text/css" media="all">
</head>
<input type="button" style="float:left;" class="btn btn-success" id="Volver" value="Volver Atrás" onclick="volver();">
<body>
	<div class = "container">
		<center>
			<h1>Esfuerzo</h1>
			<hr>
        <table>
            <tr>
                <td class="first">
                    <u><b>Esfuerzo por días</b></u>
                    <br><br>Utilice estas opciones si los datos de esfuerzo se tienen por cada día
                    <hr>
                    <input type="button" class="btn btn-success" id="add_row()" onClick="esfuerzo_dias1()" value="Horas de desarrollo" />
                    <hr>
                    <input type="button" class="btn btn-success" id="add_row()" onClick="esfuerzo_dias2()" value="Horas de re-trabajo" />
                    <hr>
                    <input type="button" class="btn btn-success" id="add_row()" onClick="esfuerzo_dias3()" value="Horas de soporte" />
                    <hr>
                    <input type="button" class="btn btn-success" id="add_row()" onClick="esfuerzo_dias4()" value="Horas de preparación" />
                    <hr>
                    <input type="button" class="btn btn-success" id="add_row()" onClick="esfuerzo_dias5()" value="Horas de reunión" />
                </td>
                <td class="">
                    <u><b>Esfuerzo por semanas</b></u>
                    <br><br>Utilice estas opciones si los datos de esfuerzo se tienen por cada día pero desean agruparse por cada semana
                    <hr>
                    <input type="button" class="btn btn-success" id="add_row()" onClick="esfuerzo_semanas1()" value="Horas de desarrollo" />
                    <hr>
                    <input type="button" class="btn btn-success" id="add_row()" onClick="esfuerzo_semanas2()" value="Horas de re-trabajo" />
                    <hr>
                    <input type="button" class="btn btn-success" id="add_row()" onClick="esfuerzo_semanas3()" value="Horas de soporte" />
                    <hr>
                    <input type="button" class="btn btn-success" id="add_row()" onClick="esfuerzo_semanas4()" value="Horas de preparación" />
                    <hr>
                    <input type="button" class="btn btn-success" id="add_row()" onClick="esfuerzo_semanas5()" value="Horas de reunión" />
                </td>
                
            </tr>
            
            
        </table>
		</center>		
	</div>

</body>
</html>