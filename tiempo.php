<!DOCTYPE html>
<html>
<head>
<title>Tiempo</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
     
</script>

<script>
n = 0; //numero de dias ingresadas
var grandPromedios = [];//arreglo para guardar los valores de cada dia
var grandRangos = [];
var promedio;
var sigma;


function addRow(){
        n++;

        var div = document.createElement('div');
        div.setAttribute('class', 'form-inline');
            div.innerHTML = '<div style="clear:both"><input class="col-md-1" type="number" id="number'+n+'" value="'+n+'" readonly="readonly"><input class="col-md-2" type="text" id="nombre'+n+'"><input class="col-md-3" type="datetime-local" min="2018-01-01T00:00" max="2019-12-31T00:00"  id="inicio'+n+'" ><input class="col-md-3" type="datetime-local" min="2018-01-01T00:00" max="2019-12-31T00:00"  id="fin'+n+'" onchange="horas('+n+');"><input type="checkbox" id="y'+n+'" checked><div class="col-md-2" id="dif'+n+'" readonly="readonly"></div>';
            document.getElementById('fila').appendChild(div);document.getElementById('fila').appendChild(div);
}   

function cargar(){
  
        <?php 
            include("conexion.php");
            $query = "SELECT proceso, nombre, inicio, fin FROM tiempo ORDER BY proceso ASC";
            $resultado = $conexion -> query($query);
            
            while($row = $resultado->fetch_assoc()){
            
                $proceso = $row['proceso'];
                $nombre = $row['nombre'];
                $inicio = $row['inicio'];
                $fin = $row['fin'];
                
               
         ?>

            n++;
            var proceso = '<?php echo $proceso;?>'
            var nombre = '<?php echo $nombre;?>'
            var inicio= '<?php echo $inicio;?>'
            var fin = '<?php echo $fin;?>'
            

           var div = document.createElement('div');
        div.setAttribute('class', 'form-inline');
            div.innerHTML = '<div style="clear:both"><input class="col-md-1" type="number" id="number'+n+'" value="'+proceso+'" readonly="readonly"><input class="col-md-2" type="text" id="nombre'+n+'" value="'+nombre+'"><input class="col-md-3" type="datetime-local" min="2018-01-01T00:00" max="2020-12-31T00:00"  id="inicio'+n+'" vale="'+inicio+'"><input class="col-md-3" type="datetime-local" min="2018-01-01T00:00" max="2020-12-31T00:00"  id="fin'+n+'" value="'+fin+'" onchange="horas('+n+');"><input type="checkbox" id="y'+n+'" checked><div class="col-md-2" id="dif'+n+'" readonly="readonly"></div>';
            document.getElementById('fila').appendChild(div);document.getElementById('fila').appendChild(div);

            horas(n);
            <?php 
            
            }
            ?>           

}

function volver(){
    window.location = "index.php";
}

function horas(n){

    
    var finicio = parseInt(new Date(document.getElementById("inicio"+n).value).getTime()/1000); 
    var ffin = parseInt(new Date(document.getElementById("fin"+n).value).getTime()/1000); 
    var difHoras = (ffin - finicio)/3600; 

    if(difHoras < 0){
        alert("La fecha fin debe ser mayor que la fecha inicio");
    }
    else{
        //sumatoria = sumatoria + difHoras;
        document.getElementById("dif"+n).innerHTML=difHoras; 
        //document.getElementById("sumatoria").innerHTML=sumatoria; 
        
    }
    

}




function funcion(){
    
        var sumaR = 0;
        var suma = 0;
        //console.log((document.getElementById("dif1").innerHTML));
        var e = 1;
        for (var i = 1; i <= n; i++) {
            var checkbox = document.getElementById("y"+i).checked;
            if(checkbox){

                ///////////////////////////////////////////////////////////////////////////
                var proceso=i;   
                console.log(proceso);
                var nombre=$("#nombre"+i).val();
                console.log(nombre);
                var inicio=$("#inicio"+i).val();
                console.log(inicio);
                var fin=$("#fin"+i).val();
                console.log(fin);
                

                $.post("tiempo_db.php",{"proceso":proceso, "nombre":nombre, "inicio":inicio, "fin":fin});
                ///////////////////////////////////////////////////////////////////////
                var valor = parseFloat(document.getElementById("dif"+i).innerHTML);          
                grandPromedios[e] = valor;
                e++;
            }
            
            suma = suma + valor;
            
        }
        
        for (var i = 0; i < n - 1; i++) {
            var y = i + 1;
            var a = grandPromedios[y];
            var b = grandPromedios[i];
            var mr = Math.abs(a - b);
            grandRangos.push(mr);
            sumaR = sumaR + mr;
        }

        promedio = suma/n;//CL
        
        var rango = (1/(n-1))*sumaR;//CLR
        var ucl = promedio + 2.660*rango;
        var lcl = promedio - 2.660*rango;
        var uclr = 3.268*rango;
        sigma = rango/1.128;

        var suma2 = suma.toFixed(2);
        var promedio2 = promedio.toFixed(2);
        var rango2 = rango.toFixed(2);
        var ucl2 = ucl.toFixed(2);
        var lcl2 = lcl.toFixed(2);
        var uclr2 = uclr.toFixed(2);
        var sigma2 = sigma.toFixed(2);

        document.getElementById("sumatoria").innerHTML=suma2; 
        document.getElementById("cl").innerHTML=promedio2; 
        document.getElementById("clr").innerHTML=rango2; 
        document.getElementById("ucl").innerHTML=ucl2; 
        document.getElementById("lcl").innerHTML=lcl2;
        document.getElementById("uclr").innerHTML=uclr2;
        document.getElementById("sigma").innerHTML=sigma2;
       
      graficar();
      graficar2();
        

    } 

    function funcion2(){
    
        var sumaR = 0;
        var suma = 0;
        //console.log((document.getElementById("dif1").innerHTML));
        var e = 1;
        for (var i = 1; i <= n; i++) {
            var checkbox = document.getElementById("y"+i).checked;
            if(checkbox){
                var valor = parseFloat(document.getElementById("dif"+i).innerHTML);          
                grandPromedios[e] = valor;
                e++;
            }
            
            suma = suma + valor;
            
        }
        
        for (var i = 0; i < n - 1; i++) {
            var y = i + 1;
            var a = grandPromedios[y];
            var b = grandPromedios[i];
            var mr = Math.abs(a - b);
            grandRangos.push(mr);
            sumaR = sumaR + mr;
        }

        promedio = suma/n;//CL
        
        var rango = (1/(n-1))*sumaR;//CLR
        var ucl = parseFloat(document.getElementById("cambiar_ucl").value);
        var lcl = parseFloat(document.getElementById("cambiar_lcl").value);
        var uclr = 3.268*rango;
        sigma = rango/1.128;

        var suma2 = suma.toFixed(2);
        var promedio2 = promedio.toFixed(2);
        var rango2 = rango.toFixed(2);
        var ucl2 = ucl.toFixed(2);
        var lcl2 = lcl.toFixed(2);
        var uclr2 = uclr.toFixed(2);
        var sigma2 = sigma.toFixed(2);

        document.getElementById("sumatoria").innerHTML=suma2; 
        document.getElementById("cl").innerHTML=promedio2; 
        document.getElementById("clr").innerHTML=rango2; 
        document.getElementById("ucl").innerHTML=ucl2; 
        document.getElementById("lcl").innerHTML=lcl2;
        document.getElementById("uclr").innerHTML=uclr2;
        document.getElementById("sigma").innerHTML=sigma2;
       
      if(lcl >= ucl){
            alert("El limite de control superior UCL debe ser mayor que el limite de control inferior LCL");
        }
        else{
            graficar();
            graficar2();
        }
        

    } 

    function test2(){
        
        for (var i = 0; i < n-2; i++) {

                //Caso en el que el primer valor esta por encima de sigma+2, el segundo esta por encima de CL y el tercer valor esta por encima de +2
                
                if(grandPromedios[i] > (promedio + 2*sigma)){
                    if(grandPromedios[i+1] > promedio & grandPromedios[i+1] < (promedio + 2*sigma)){
                        if(grandPromedios[i+2] > (promedio + 2*sigma)){
                                alert("Test2: Al menos dos de los tres valores consecutivos caen del mismo lado y más de dos unidades sigma lejos de la línea central");
                                
                                break;
                            }

                    }
                }

                //Caso en el que los tres valores estan por encima de sigma-2
                if(grandPromedios[i] > (promedio + 2*sigma)){
                    if(grandPromedios[i+1] > (promedio + 2*sigma)){
                        if(grandPromedios[i+2] > (promedio + 2*sigma)){
                            alert("Test2: Al menos dos de los tres valores consecutivos caen del mismo lado y más de dos unidades sigma lejos de la línea central");
                            break;
                        }
                    }
                }
                //Caso en el que el primer valor esta por debajo de sigma-2, el segundo esta por debajo de CL y el tercero esta por encima de sigma-2
                
                if(grandPromedios[i] < (promedio - 2*sigma)){
                    if(grandPromedios[i+1] < promedio & grandPromedios[i+1] > (promedio - 2*sigma)){
                        if(grandPromedios[i+2] < (promedio - 2*sigma)){
                                alert("Test2: Al menos dos de los tres valores consecutivos caen del mismo lado y más de dos unidades sigma lejos de la línea central");
                                break;
                            }
                    }
                }

                //Caso en el que los tres valores estan por debajo de sigma-2
                if(grandPromedios[i] < (promedio - 2*sigma)){
                    if(grandPromedios[i+1] < (promedio - 2*sigma)){
                        if(grandPromedios[i+2] < (promedio - 2*sigma)){
                            alert("Test2: Al menos dos de los tres valores consecutivos caen del mismo lado y más de dos unidades sigma lejos de la línea central");
                            break;
                        }
                    }
                }

                //Caso en el que el primer valor esta por encima de CL y los dos siguientes estan por encima de sigma+2
                if(grandPromedios[i] > promedio){
                        if(grandPromedios[i+1] > (promedio + 2*sigma)){
                            if(grandPromedios[i+2] > (promedio + 2*sigma)){
                               alert("Test2: Al menos dos de los tres valores consecutivos caen del mismo lado y más de dos unidades sigma lejos de la línea central");
                                break;
                            }
                            
                        }
                    
                }

                //Caso en el que el primer valor esta por debajo de Cl y los dos siguientes estan por debajo de sigma-2
                if(grandPromedios[i] < promedio){
                    if(grandPromedios[i+1] < (promedio - 2*sigma)){
                            if(grandPromedios[i+2] < (promedio - 2*sigma)){
                               alert("Test2: Al menos dos de los tres valores consecutivos caen del mismo lado y más de dos unidades sigma lejos de la línea central");
                                break;
                            }
                            
                        
                    }
                }

                //Caso en el que los dos primeros valores estan por encima de sigma+2 y el tercero por encima de CL
                if(grandPromedios[i] > (promedio + 2*sigma)){
                        if(grandPromedios[i+1] > (promedio + 2*sigma)){
                            if(grandPromedios[i+2] > promedio){
                                alert("Test2: Al menos dos de los tres valores consecutivos caen del mismo lado y más de dos unidades sigma lejos de la línea central");
                                break;
                            }
                            
                        }
                    
                }

                //Caso en el que los dos primeros valores estan por debajo de sigma-2 y el tercero por debajo de CL
                if(grandPromedios[i] < (promedio - 2*sigma)){
                        if(grandPromedios[i+1] < (promedio - 2*sigma)){
                            if(grandPromedios[i+2] < promedio){
                                alert("Test2: Al menos dos de los tres valores consecutivos caen del mismo lado y más de dos unidades sigma lejos de la línea central");
                                break;
                            }
                            
                        }
                    
                }

        }
    }

    function test3(){
        for (var i = 0; i < n-4; i++) {

            if(grandPromedios[i] > (promedio + sigma)){
                if(grandPromedios[i+1] > (promedio + sigma)){
                    if(grandPromedios[i+2] > (promedio + sigma)){
                        if(grandPromedios[i+3] > (promedio + sigma)){
                            if(grandPromedios[i+4] > (promedio + sigma)){
                                alert("Test3: Al menos cuatro de los cinco valores consecutivos caen del mismo lado y más de una unidad sigma lejos de la línea central ");
                                break;
                            }
                            if(grandPromedios[i+4] > promedio){
                                alert("Test3: Al menos cuatro de los cinco valores consecutivos caen del mismo lado y más de una unidad sigma lejos de la línea central ");
                                break;
                            }
                        }
                        if(grandPromedios[i+3] > promedio){
                            if(grandPromedios[i+4] > (promedio + sigma)){
                               alert("Test3: Al menos cuatro de los cinco valores consecutivos caen del mismo lado y más de una unidad sigma lejos de la línea central ");
                                break;
                            }
                        }
                    }
                    if(grandPromedios[i+2] > promedio){
                        if(grandPromedios[i+3] > (promedio + sigma)){
                            if(grandPromedios[i+4] > (promedio + sigma)){
                                alert("Test3: Al menos cuatro de los cinco valores consecutivos caen del mismo lado y más de una unidad sigma lejos de la línea central ");
                                break;
                            }
                        }
                    }
                }
                if(grandPromedios[i+1] > promedio){
                    if(grandPromedios[i+2] > (promedio + sigma)){
                        if(grandPromedios[i+3] > (promedio + sigma)){
                            if(grandPromedios[i+4] > (promedio + sigma)){
                                alert("Test3: Al menos cuatro de los cinco valores consecutivos caen del mismo lado y más de una unidad sigma lejos de la línea central ");
                                break;
                            }
                        }
                    }
                }
            }
            if(grandPromedios[i] > promedio){
                if(grandPromedios[i+1] > (promedio + sigma)){
                    if(grandPromedios[i+2] > (promedio + sigma)){
                        if(grandPromedios[i+3] > (promedio + sigma)){
                            if(grandPromedios[i+4] > (promedio + sigma)){
                                alert("Test3: Al menos cuatro de los cinco valores consecutivos caen del mismo lado y más de una unidad sigma lejos de la línea central ");
                                break;
                            }
                        }
                    }

                }
            }


            ////////////////////////////////////////////////////////////////////////Por debajo de CL
            if(grandPromedios[i] < (promedio - sigma)){
                if(grandPromedios[i+1] < (promedio - sigma)){
                    if(grandPromedios[i+2] < (promedio - sigma)){
                        if(grandPromedios[i+3] < (promedio - sigma)){
                            if(grandPromedios[i+4] < (promedio - sigma)){
                                alert("Test3: Al menos cuatro de los cinco valores consecutivos caen del mismo lado y más de una unidad sigma lejos de la línea central ");
                                break;
                            }
                            if(grandPromedios[i+4] < promedio){
                                alert("Test3: Al menos cuatro de los cinco valores consecutivos caen del mismo lado y más de una unidad sigma lejos de la línea central ");
                                break;
                            }
                        }
                        if(grandPromedios[i+3] < promedio){
                            if(grandPromedios[i+4] < (promedio - sigma)){
                                alert("Test3: Al menos cuatro de los cinco valores consecutivos caen del mismo lado y más de una unidad sigma lejos de la línea central ");
                                break;
                            }
                        }
                    }
                    if(grandPromedios[i+2] < promedio){
                        if(grandPromedios[i+3] < (promedio - sigma)){
                            if(grandPromedios[i+4] < (promedio - sigma)){
                                alert("Test3: Al menos cuatro de los cinco valores consecutivos caen del mismo lado y más de una unidad sigma lejos de la línea central ");
                                break;
                            }
                        }
                    }
                }
                if(grandPromedios[i+1] < promedio){
                    if(grandPromedios[i+2] < (promedio - sigma)){
                        if(grandPromedios[i+3] < (promedio - sigma)){
                            if(grandPromedios[i+4] < (promedio - sigma)){
                                alert("Test3: Al menos cuatro de los cinco valores consecutivos caen del mismo lado y más de una unidad sigma lejos de la línea central ");
                                break;
                            }
                        }
                    }
                }
            }
            if(grandPromedios[i] < promedio){
                if(grandPromedios[i+1] < (promedio - sigma)){
                    if(grandPromedios[i+2] < (promedio - sigma)){
                        if(grandPromedios[i+3] < (promedio - sigma)){
                            if(grandPromedios[i+4] < (promedio - sigma)){
                                alert("Test3: Al menos cuatro de los cinco valores consecutivos caen del mismo lado y más de una unidad sigma lejos de la línea central ");
                                break;
                            }
                        }
                    }

                }
            }

        }
    } 


    function test4(){
        for (var i = 0; i < n-7; i++){
            if(grandPromedios[i] > promedio){
                if(grandPromedios[i+1] > promedio){
                    if(grandPromedios[i+2] > promedio){
                        if(grandPromedios[i+3] > promedio){
                            if(grandPromedios[i+4] > promedio){
                                if(grandPromedios[i+5] > promedio){
                                    if(grandPromedios[i+6] > promedio){
                                        if(grandPromedios[i+7] > promedio){
                                            alert("Test4: Al menos ocho valores consecutivos caen del mismo lado de la línea central");
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }


            if(grandPromedios[i] < promedio){
                if(grandPromedios[i+1] < promedio){
                    if(grandPromedios[i+2] < promedio){
                        if(grandPromedios[i+3] < promedio){
                            if(grandPromedios[i+4] < promedio){
                                if(grandPromedios[i+5] < promedio){
                                    if(grandPromedios[i+6] < promedio){
                                        if(grandPromedios[i+7] < promedio){
                                            alert("Test4: Al menos ocho valores consecutivos caen del mismo lado de la línea central");
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }    

    
</script> 

<script>
function graficar() {

var chart = new CanvasJS.Chart("chartContainer", {
    animationEnabled: true,  
    title:{
        text: "Grafico de duración por cada proceso"
    },
    axisX: {
      title: "procesos"
    },
    axisY: {
        title: "Horas",
        includeZero: false,
        valueFormatString: "",
        suffix: "",
        stripLines: [
        {
            value: document.getElementById("ucl").innerHTML,
            label: "UCL",
            color: "red",
            labelFontColor: "red"
        },
        {
            value: document.getElementById("cl").innerHTML,
            label: "CL"
        },
        {
            value: document.getElementById("lcl").innerHTML,
            label: "LCL",
            color: "red",
            labelFontColor: "red"
        },
        {
            value: document.getElementById("cl").innerHTML - document.getElementById("sigma").innerHTML,
            label: "-S1",
            color: "green",
            labelFontColor: "green"
        },
        {
            value: document.getElementById("cl").innerHTML - 2*document.getElementById("sigma").innerHTML,
            label: "-S2",
            color: "#E7EE00 ",
            labelFontColor: "#E7EE00 "
        },
        {
            value: document.getElementById("ucl").innerHTML - document.getElementById("sigma").innerHTML,
            label: "S2",
            color: "#E7EE00 ",
            labelFontColor: "#E7EE00 "
        }
        ,
        {
            value: document.getElementById("ucl").innerHTML - 2*document.getElementById("sigma").innerHTML,
            label: "S1",
            color: "green",
            labelFontColor: "green"
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
                    {x: 16, y: grandPromedios[16]}
                
            
        ]
    }]
});
chart.render();
  test2();
  test3();
  test4();
  grandPromedios = [];
}

function graficar2() {

var chart2 = new CanvasJS.Chart("chartContainer2", {
    animationEnabled: true,  
    title:{
        text: "Grafica de rangos"
    },
    axisX: {
      title: "Procesos"
    },
    axisY: {
        title: "Rango",
        includeZero: false,
        valueFormatString: "",
        suffix: "",
        stripLines: [
        {
            value: document.getElementById("uclr").innerHTML,
            label: "UCLR"
        },
        {
            value: document.getElementById("clr").innerHTML,
            label: "CLR"
        }
        ],
    },
    data: [{
        yValueFormatString: "",
        xValueFormatString: "",
        type: "spline",
        dataPoints: [
                
                    {x: 1, y: grandRangos[0]},
                    {x: 2, y: grandRangos[1]},
                    {x: 3, y: grandRangos[2]},
                    {x: 4, y: grandRangos[3]},
                    {x: 5, y: grandRangos[4]},
                    {x: 6, y: grandRangos[5]},
                    {x: 7, y: grandRangos[6]},
                    {x: 8, y: grandRangos[7]},
                    {x: 9, y: grandRangos[8]},
                    {x: 10, y: grandRangos[9]},
                    {x: 11, y: grandRangos[10]},
                    {x: 12, y: grandRangos[11]},
                    {x: 13, y: grandRangos[12]},
                    {x: 14, y: grandRangos[13]},
                    {x: 15, y: grandRangos[14]},
                    {x: 16, y: grandRangos[15]}
                
            
        ]
    }]
});
chart2.render();
grandRangos = [];
}

</script>

</head>
<div style="float:right"><b>Entidad:</b> Cosas consumidas - <B>Atributo:</B> Tiempo</div>
<input type="button" style="float:left;" class="btn btn-success" id="Volver" value="Volver Atrás" onclick="volver();">

<body>
<div class="container">
    <h1>Duración de un proceso o tarea</h1><hr>
    <h4>Este formulario permite visualizar el comportamiento de la duración en horas de un proceso o tarea.  </h4>
    <h4><b>1.</b> Utilicé el botón <b>+</b> para ingresar cada proceso o tarea.</h4>
    <h4><b>2.</b> Ingrese la fecha de inicio y la fecha de fin del proceso o tarea.</h4>
    <h4><b>3.</b> Utilicé el botón <b>Calcular límites y graficar</b> para calcular las variables necesarias para los gráficos.</h4><hr>
    
    <form action="formulario2.html" id="formulario" method="get">
    
    <div class="row">
        <div class="col-md-offset col-md-1"><label>Procesos</label></div>
        <div class="col-md-2"><label>Nombre</label></div>
        <div class="col-md-3"><label>Fecha inicio</label></div>
        <div class="col-md-3"><label>Fecha fin</label></div>
        <div class="col-md-2"><label>Horas</label></div>
        
        <div class="col-md-0"><input type="button" class="btn btn-success" id="add_row()" onClick="addRow()" value="+" />
            </div>
        
    </div>

    <div class="row" id="fila"></div>
    
  
    <div class="row" id="fila"></div>
    <br><hr>
    <div title="sumatoria"><label>Sumatoria</label></div>
    <div  id= "sumatoria"> : </div><br>
    <div title="Promedio"><label>CL</label></div>
    <div  id= "cl"> : </div><br>
    <div title="Promedio de los rangos"><label>CLR</label></div>
    <div  id= "clr"> : </div>
    <div title="Límite superior de control"><label>UCL</label></div>
    <div  id= "ucl"> : </div>
    <div title="Límite inferior de control"><label>LCL</label></div>
    <div  id= "lcl"> : </div>
    <div title="Límite superior de control de rangos"><label>UCLR</label></div>
    <div  id= "uclr"> : </div>
    <div><label>SIGMA</label></div>
    <div  id= "sigma"> : </div>

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

<hr>
<div id="chartContainer2" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

</body>
</html>


