<!DOCTYPE html>
<html>
<head>
<title>Cambios</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
   

</script>

<script>
n = 0; //numero modulos
var grandPromedios = [];//arreglo para guardar los valores de densidad a graficar
var arreglo = [];//arreglo para guardar cada valor del tamaño de modulo
var puntosUCL = []; //puntos de UCL a graficar
var puntosLCL = []; //puntos de LCL a graficar
var c;

var sumA = 0;//sumatoria de los numeros de defectos
var sumB = 0;//sumatoria del tamaño de los modulos

function addRow(){
        n++;

        var div = document.createElement('div');
        div.setAttribute('class', 'form-inline');
            div.innerHTML = '<div style="clear:both"><input class="col-md-1" type="number" id="number'+n+'" value="'+n+'" readonly="readonly"><input class="col-md-2" type="number" min="0" id="a'+n+'" ><input class="col-md-2" type="number" min="0" id="b'+n+'" onchange="densidad('+n+');"><input type="checkbox" id="y'+n+'" checked><div class="col-md-2" type="number" min="0" id="c'+n+'" placeholder="%"></div>';
            document.getElementById('fila').appendChild(div);document.getElementById('fila').appendChild(div);
}   

function cargar(){
  
        <?php 
            include("conexion.php");
            $query = "SELECT modulo, cambios, noResueltos FROM cambios ORDER BY modulo ASC";
            $resultado = $conexion -> query($query);
            
            while($row = $resultado->fetch_assoc()){
            
                $modulo = $row['modulo'];
                $cambios = $row['cambios'];
                $noResueltos = $row['noResueltos'];
                
               
         ?>

            n++;
            var modulo = '<?php echo $modulo;?>'
            var cambios = '<?php echo $cambios;?>'
            var noResueltos = '<?php echo $noResueltos;?>'
            

            var div = document.createElement('div');
            div.setAttribute('class', 'form-inline');
            div.innerHTML = '<div style="clear:both"><input class="col-md-1" type="number" id="number'+n+'" value="'+modulo+'" readonly="readonly"><input class="col-md-2" type="number" min="0" id="a'+n+'" value="'+cambios+'"><input class="col-md-2" type="number" min="0" id="b'+n+'" value="'+noResueltos+'" onchange="densidad('+n+');"><input type="checkbox" id="y'+n+'" checked><div class="col-md-2" type="number" min="0" id="c'+n+'" placeholder="%"></div>';
            document.getElementById('fila').appendChild(div);document.getElementById('fila').appendChild(div);

            densidad(n);
            <?php 
            
            }
            ?>           

}

function deleteRow(){
    n = 0;
    let node = document.getElementById("fila");
    if (node.parentNode) {
        node.parentNode.removeChild(node);
    }
    
}

function volver(){
    window.location = "index.php";
}



function densidad(n){
	
	var a = parseFloat(document.getElementById("a"+n).value);
	sumA = sumA + a;
	var b = parseFloat(document.getElementById("b"+n).value);
	//arreglo.push(a);
	sumB = sumB + b;
	c = parseFloat((b*100)/a);
    var cc = c.toFixed(2);
    

    
    if(c > 100){
        alert("El # de cambios no resueltos debe ser menor que el # de cambios");
    }
    else{
        //if(isChecked){  
         //grandPromedios[n] = c;
        //}
        document.getElementById("c"+n).innerHTML=cc;
        document.getElementById("sumA").innerHTML=sumA; 
        document.getElementById("sumB").innerHTML=sumB;
    }
	
    

}





function funcion(){

        var cl = ((sumB/sumA)*100);
        var cl2 = cl.toFixed(2);
        document.getElementById("CL").innerHTML=cl2;
        
        var e = 1;
        for (var i = 1; i <= n; i++) {
            var checkbox = document.getElementById("y"+i).checked;

            if(checkbox){

                ///////////////////////////////////////////////////////////////////////////
                var modulo=i;   
                var cambios=$("#a"+i).val();
                var noResueltos=$("#b"+i).val();
                

                $.post("cambios_db.php",{"modulo":modulo, "cambios":cambios, "noResueltos":noResueltos});
                ///////////////////////////////////////////////////////////////////////
            
                grandPromedios[e]=parseFloat(document.getElementById("c"+i).innerHTML);
                arreglo[e]= parseFloat(document.getElementById("b"+i).value);
                e++;
            }

        }
        

        //Calculo de UCL
        for (var i = 1; i < n; i++) {
        	var x = 3*(Math.sqrt(cl/(arreglo[i]/100)));
        	puntosUCL[i] = cl + x;
        	puntosLCL[i] = cl - x;
        }
        graficar();
    }  

    function funcion2(){
        
        var cl = ((sumB/sumA)*100);
        var cl2 = cl.toFixed(2);
        document.getElementById("CL").innerHTML=cl2;
        var e = 1;
        for (var i = 1; i <= n; i++) {
            var checkbox = document.getElementById("y"+i).checked;

            if(checkbox){
            
                grandPromedios[e]=parseFloat(document.getElementById("c"+i).innerHTML);
                arreglo[e]= parseFloat(document.getElementById("b"+i).value);
                var x = 3*(Math.sqrt(cl/(arreglo[i]/100)));
                puntosUCL[i] = cl + x;
                puntosLCL[i] = cl - x;

                e++;
            }

        }



        var ucl = parseFloat(document.getElementById("cambiar_ucl").value);
        var lcl = parseFloat(document.getElementById("cambiar_lcl").value);
        if(lcl >= ucl){
            alert("El limite de control superior UCL debe ser mayor que el limite de control inferior LCL");
        }
        else{
            graficar2();
        }
        
    }  

   

    
</script> 

<script>
function graficar() {

var chart = new CanvasJS.Chart("chartContainer", {
    animationEnabled: true,  
    title:{
        text: "% de cambios no resueltos por modulos"
    },
    axisX: {
      title: "Numero de modulo"
    },
    axisY: {
        title: "% de cambios no resueltos",
        includeZero: true,
        valueFormatString: "",
        suffix: "",
        stripLines: [   
        {
            value: document.getElementById("CL").innerHTML,
            label: "CL"
        }
        ],
    },
    data: [{
        yValueFormatString: "",
        xValueFormatString: "",
        type: "spline",
        dataPoints: [
                
                    {x: 1, y: grandPromedios[1]}, 
                    {x: 2, y: grandPromedios[2]},
                    {x: 3, y: grandPromedios[3]},
                    {x: 4, y: grandPromedios[4]},
                    {x: 5, y: grandPromedios[5]},
                    {x: 6, y: grandPromedios[6]},
                    {x: 7, y: grandPromedios[7]},
                    {x: 8, y: grandPromedios[8]},
                    {x: 9, y: grandPromedios[9]},
                    {x: 10, y: grandPromedios[10]},
                    {x: 11, y: grandPromedios[11]},
                    {x: 12, y: grandPromedios[12]},
                    {x: 13, y: grandPromedios[13]},
                    {x: 14, y: grandPromedios[14]},
                    {x: 15, y: grandPromedios[15]},
                    {x: 16, y: grandPromedios[16]},
                    {x: 17, y: grandPromedios[17]},
                    {x: 18, y: grandPromedios[18]},
                    {x: 19, y: grandPromedios[19]},
                    {x: 20, y: grandPromedios[20]},
                    {x: 21, y: grandPromedios[21]},
                    {x: 22, y: grandPromedios[22]},
                    {x: 23, y: grandPromedios[23]},
                    {x: 24, y: grandPromedios[24]},
                    {x: 25, y: grandPromedios[25]},
                    {x: 26, y: grandPromedios[26]}
                
            
        ]
    },

    {
		type: "stepLine",  
		//axisYType: "secondary",
		connectNullData: true,
		xValueFormatString: "",
		label: "UCL",
		markerSize: 2,
		dataPoints: [
					{x: 1, y: puntosUCL[1], indexLabel: "UCL"},
                    {x: 2, y: puntosUCL[2]},
                    {x: 3, y: puntosUCL[3]},
                    {x: 4, y: puntosUCL[4]},
                    {x: 5, y: puntosUCL[5]},
                    {x: 6, y: puntosUCL[6]},
                    {x: 7, y: puntosUCL[7]},
                    {x: 8, y: puntosUCL[8]},
                    {x: 9, y: puntosUCL[9]},
                    {x: 10, y: puntosUCL[10]},
                    {x: 11, y: puntosUCL[11]},
                    {x: 12, y: puntosUCL[12]},
                    {x: 13, y: puntosUCL[13]},
                    {x: 14, y: puntosUCL[14]},
                    {x: 15, y: puntosUCL[15]},
                    {x: 16, y: puntosUCL[16]},
                    {x: 17, y: puntosUCL[17]},
                    {x: 18, y: puntosUCL[18]},
                    {x: 19, y: puntosUCL[19]},
                    {x: 20, y: puntosUCL[20]},
                    {x: 21, y: puntosUCL[21]},
                    {x: 22, y: puntosUCL[22]},
                    {x: 23, y: puntosUCL[23]},
                    {x: 24, y: puntosUCL[24]},
                    {x: 25, y: puntosUCL[25]},
                    {x: 26, y: puntosUCL[26]}
		]
	}

    ]
});
chart.render();
  
  //grandPromedios = [];
}

function graficar2() {

var chart = new CanvasJS.Chart("chartContainer", {
    animationEnabled: true,  
    title:{
        text: "% de cambios no resueltos por modulos"
    },
    axisX: {
      title: "Numero de modulo"
    },
    axisY: {
        title: "% de cambios no resueltos",
        includeZero: true,
        valueFormatString: "",
        suffix: "",
        stripLines: [  
        {
            value: document.getElementById("cambiar_ucl").value,
            label: "UCL",
            color: "red",
            labelFontColor: "red"
        }, 
        {
            value: document.getElementById("CL").innerHTML,
            label: "CL"
        },
        {
            value: document.getElementById("cambiar_lcl").value,
            label: "LCL",
            color: "red",
            labelFontColor: "red"
        }
        ],
    },
    data: [{
        yValueFormatString: "",
        xValueFormatString: "",
        type: "spline",
        dataPoints: [
                
                    {x: 1, y: grandPromedios[1]}, 
                    {x: 2, y: grandPromedios[2]},
                    {x: 3, y: grandPromedios[3]},
                    {x: 4, y: grandPromedios[4]},
                    {x: 5, y: grandPromedios[5]},
                    {x: 6, y: grandPromedios[6]},
                    {x: 7, y: grandPromedios[7]},
                    {x: 8, y: grandPromedios[8]},
                    {x: 9, y: grandPromedios[9]},
                    {x: 10, y: grandPromedios[10]},
                    {x: 11, y: grandPromedios[11]},
                    {x: 12, y: grandPromedios[12]},
                    {x: 13, y: grandPromedios[13]},
                    {x: 14, y: grandPromedios[14]},
                    {x: 15, y: grandPromedios[15]},
                    {x: 16, y: grandPromedios[16]},
                    {x: 17, y: grandPromedios[17]},
                    {x: 18, y: grandPromedios[18]},
                    {x: 19, y: grandPromedios[19]},
                    {x: 20, y: grandPromedios[20]},
                    {x: 21, y: grandPromedios[21]},
                    {x: 22, y: grandPromedios[22]},
                    {x: 23, y: grandPromedios[23]},
                    {x: 24, y: grandPromedios[24]},
                    {x: 25, y: grandPromedios[25]},
                    {x: 26, y: grandPromedios[26]}
                
            
        ]
    }

    ]
});
chart.render();
  
  //grandPromedios = [];
}



</script>

</head>
<div style="float:right"><b>Entidad:</b> Cosas Recibidas o usadas - <b>Atributo:</b> Cambios </div>
<input type="button" style="float:left;" class="btn btn-success" id="Volver" value="Volver Atrás" onclick="volver();">

<body>
<div class="container">
    <h1>Cambios no resueltos</h1><hr>
    <h4>Este formulario permite visualizar el comportamiento del porcentaje de cambios no resueltos en cada módulo o unidad de trabajo.  </h4>
    <h4><b>1.</b> Utilicé el botón <b>+</b> para ingresar cada modulo.</h4>
    <h4><b>2.</b> Ingrese el número de cambios totales por módulo.</h4>
    <h4><b>3.</b> Ingrese el número de cambios no resueltos en dicho módulo.</h4>
    <h4><b>5.</b> El campo CL se calcula dividiendo el total de # de cambios no resueltos entre el total de # de cambios.</h4>
    <h4><b>6.</b> Utilicé el botón <b>Calcular límites y graficar </b> para calcular CL y observar la gráfica de control.</h4>
   <hr>
    <form action="formulario2.html" id="formulario" method="get">
    
    <div class="row">
        <div class="col-md-offset col-md-1"><label># de modulo</label></div>
        <div class="col-md-2"><label># de cambios</label></div>
        <div class="col-md-2"><label># de cambios no resueltos</label></div>
        <div class="col-md-2"><label>% de cambios no resueltos</label></div>
        
        <div class="col-md-0"><input type="button" class="btn btn-success" id="add_row()" onClick="addRow();" value="+" />
            </div>
        
    </div>

    

    <div class="row" id="fila"></div>
    <br><hr>
    <div><label>Total de # de cambios</label></div>
    <div  id= "sumA"> : </div><br>
    <div><label>Total de # de cambios no resueltos</label></div>
    <div  id= "sumB"> : </div>
    <div><label>CL</label></div>
    <div  id= "CL"> : </div>
    

    <input type="button" class="btn btn-success" id="Promedio" value="Calcular límites y graficar" onclick="funcion();">
    
    <input type="button" name="aceptar" value="Cargar" onclick="cargar();" class="btn btn-success">
    <br>

    <input type="number" name="ucl" id="cambiar_ucl" placeholder="ucl">
    <input type="number" name="lcl" id="cambiar_lcl" placeholder="lcl">
    <input type="button" class="btn btn-success" id="cambiar" value="Cambiar límites" onclick="funcion2();">
    </form>
    
</div>
<hr>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>


<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

</body>
</html>


