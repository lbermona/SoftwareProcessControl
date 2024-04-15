<!DOCTYPE html>
<html>
<head>
<title>Problemas detectados</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js" type="text/javascript"></script>

<script>
var n1 = 0; 
var n2 = 0;
var grandPromedios = [];//arreglo para guardar los valores de cada dia
var grandRangos = [];
var promedio;
var sigma;

function addRow1(){
        n1++;

        var div = document.createElement('div');
        div.setAttribute('class', 'form-inline');
            div.innerHTML = '<div style="clear:both"><input class="col-md-offset col-md-2" type="number" id="number'+n1+'" value="'+n1+'" readonly="readonly"><input class="col-md-3" type="number" min="0" id="'+n1+'" ><input type="checkbox" id="y'+n1+'" checked></div>';
            document.getElementById('col1').appendChild(div);document.getElementById('col1').appendChild(div);
} 
function addRow2(){
        n2++;
        n1++;

        var div = document.createElement('div');
        div.setAttribute('class', 'form-inline');
            div.innerHTML = '<div style="clear:both"><input class="col-md-offset col-md-2" type="number" id="numbe'+n1+'" value="'+n1+'" readonly="readonly"><input class="col-md-3" type="number" min="0" id="'+n1+'" ><input type="checkbox" id="y'+n1+'" checked></div>';
            document.getElementById('col2').appendChild(div);document.getElementById('col2').appendChild(div);
}  



function volver(){
    window.location = "index.php";
}     

function funcion(){
        var suma = 0;
        var sumaR = 0;

        for (var i = 1; i <= (n1-n2); i++) {
            var valor = parseFloat(document.getElementById(i).value);
            suma = suma + valor;
            
        }
        var t = 0;
        for (var e = 1; e <= n1; e++) {
            var checkbox = document.getElementById("y"+e).checked;
            var valor = parseFloat(document.getElementById(e).value);
            if(checkbox){
                grandPromedios[t]=valor;
                
                t++;
            }
            //grandPromedios.push(valor);//Guardo cada valor
           
            
        }
        for (var i = 1; i < (n1-n2); i++) {
            var y = i + 1;
            var a = parseFloat(document.getElementById(y).value);
            var b = parseFloat(document.getElementById(i).value);
            var mr = Math.abs(a - b);
            
            sumaR = sumaR + mr;
        }
        for (var i = 1; i < n1; i++) {
            var y = i + 1;
            var a = parseFloat(document.getElementById(y).value);
            var b = parseFloat(document.getElementById(i).value);
            var mr = Math.abs(a - b);
            grandRangos.push(mr);
            
        }
        
        var d = n1 - n2;
        promedio = suma/d;//CL
        var rango = (1/(d-1))*sumaR;//CLR
        var ucl = promedio + 2.660*rango;
        var lcl = promedio - 2.660*rango;
        var uclr = 3.268*rango;
        sigma = rango/1.128;

        var promedio2 = promedio.toFixed(2);
        var rango2 = rango.toFixed(2);
        var ucl2 = ucl.toFixed(2);
        var lcl2 = lcl.toFixed(2);
        var uclr2 = uclr.toFixed(2);
        var sigma2 = sigma.toFixed(2);


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
        var suma = 0;
        var sumaR = 0;

        for (var i = 1; i <= (n1-n2); i++) {
            var valor = parseFloat(document.getElementById(i).value);
            suma = suma + valor;
            
        }
        var t = 0;
        for (var e = 1; e <= n1; e++) {
            var checkbox = document.getElementById("y"+e).checked;
            var valor = parseFloat(document.getElementById(e).value);
            if(checkbox){
                grandPromedios[t]=valor;
                
                t++;
            }
            //grandPromedios.push(valor);//Guardo cada valor
           
            
        }
        for (var i = 1; i < (n1-n2); i++) {
            var y = i + 1;
            var a = parseFloat(document.getElementById(y).value);
            var b = parseFloat(document.getElementById(i).value);
            var mr = Math.abs(a - b);
            
            sumaR = sumaR + mr;
        }
        for (var i = 1; i < n1; i++) {
            var y = i + 1;
            var a = parseFloat(document.getElementById(y).value);
            var b = parseFloat(document.getElementById(i).value);
            var mr = Math.abs(a - b);
            grandRangos.push(mr);
            
        }
        
        var d = n1 - n2;
        promedio = suma/d;//CL
        var rango = (1/(d-1))*sumaR;//CLR
        var ucl = parseFloat(document.getElementById("cambiar_ucl").value);
        var lcl = parseFloat(document.getElementById("cambiar_lcl").value);
        var uclr = 3.268*rango;
        sigma = rango/1.128;

        var promedio2 = promedio.toFixed(2);
        var rango2 = rango.toFixed(2);
        var ucl2 = ucl.toFixed(2);
        var lcl2 = lcl.toFixed(2);
        var uclr2 = uclr.toFixed(2);
        var sigma2 = sigma.toFixed(2);


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
        
        for (var i = 0; i < n1-2; i++) {

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
        for (var i = 0; i < n1-4; i++) {

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
        for (var i = 0; i < n1-7; i++){
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
        text: "Grafica # problemas no resueltos"
    },
    axisX: {
      title: "Semana"
    },
    axisY: {
        title: "problemas no resueltos",
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
                
                    {x: 1, y: grandPromedios[0]},
                    {x: 2, y: grandPromedios[1]},
                    {x: 3, y: grandPromedios[2]},
                    {x: 4, y: grandPromedios[3]},
                    {x: 5, y: grandPromedios[4]},
                    {x: 6, y: grandPromedios[5]},
                    {x: 7, y: grandPromedios[6]},
                    {x: 8, y: grandPromedios[7]},
                    {x: 9, y: grandPromedios[8]},
                    {x: 10, y: grandPromedios[9]},
                    {x: 11, y: grandPromedios[10]},
                    {x: 12, y: grandPromedios[11]},
                    {x: 13, y: grandPromedios[12]},
                    {x: 14, y: grandPromedios[13]},
                    {x: 15, y: grandPromedios[14]},
                    {x: 16, y: grandPromedios[15]},
                    {x: 17, y: grandPromedios[16]},
                    {x: 18, y: grandPromedios[17]},
                    {x: 19, y: grandPromedios[18]},
                    {x: 20, y: grandPromedios[19]},
                    {x: 21, y: grandPromedios[20]},
                    {x: 22, y: grandPromedios[21]},
                    {x: 23, y: grandPromedios[22]},
                    {x: 24, y: grandPromedios[23]},
                    {x: 25, y: grandPromedios[24]},
                    {x: 26, y: grandPromedios[25]},
                    {x: 27, y: grandPromedios[26]},
                    {x: 28, y: grandPromedios[27]},
                    {x: 29, y: grandPromedios[28]},
                    {x: 30, y: grandPromedios[29]},
                    {x: 31, y: grandPromedios[30]}
                
            
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
      title: "Semana"
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
                    {x: 16, y: grandRangos[15]},
                    {x: 17, y: grandRangos[16]},
                    {x: 18, y: grandRangos[17]},
                    {x: 19, y: grandRangos[18]},
                    {x: 20, y: grandRangos[19]},
                    {x: 21, y: grandRangos[20]},
                    {x: 22, y: grandRangos[21]},
                    {x: 23, y: grandRangos[22]},
                    {x: 24, y: grandRangos[23]},
                    {x: 25, y: grandRangos[24]},
                    {x: 26, y: grandRangos[25]},
                    {x: 27, y: grandRangos[26]},
                    {x: 28, y: grandRangos[27]},
                    {x: 29, y: grandRangos[28]},
                    {x: 30, y: grandRangos[29]},
                    {x: 31, y: grandRangos[30]}
                
            
        ]
    }]
});
chart2.render();

}

</script>

</head>
<div style="float:right"><b>Entidad:</b> Cosas recibidas o usadas - <b>Atributo:</b> Problemas reportados</div>
<input type="button" style="float:left;" class="btn btn-success" id="Volver" value="Volver Atrás" onclick="volver();">

<body>
<div class="container">
    <h1>Problemas no resueltos</h1><hr>
    <h4>Este formulario permite visualizar el comportamiento de los problemas no resueltos en un proceso de software
     cada SEMANA, para esto se utiliza el total de problemas no resueltos por semana durante un tiempo determinado, en el cual existe un tiempo o numero de semanas en donde el comportamiento se considera estable y otro grupo de semanas en las cuales se desea determinar si el comportamiento ha sido estable o no de acuerdo a los datos considerados como estables.  </h4><hr>
     <h4>Para utilizar este formulario siga los siguientes pasos: </h4>
    <h4><b>1.</b> Utilicé el botón <b>+</b> para ingresar cada semana, dependiendo de la cantidad que necesite en cada caso</h4>
    <h4><b>2.</b> Ingrese el número de problemas no resueltos en cada semana.</h4>
    <h4><b>3.</b> Utilicé el botón <b>Calcular límites y graficar</b> para calcular las variables necesarias para el gráfico.</h4>
    
    <form action="formulario2.html" id="formulario" method="get">
    <table style="width: 100%">
        <tr>
            <th>DATOS CONSIDERADOS ESTABLES</th>
            <th>DATOS A EXAMINAR</th>
        </tr>
        <tr>
        <th><div class="row">
        <div class="col-md-offset col-md-2"><label>Semana</label></div>
        <div class="col-md-3"><label># de problemas no resueltos</label></div>
        
        <div class="col-md-0"><input type="button" class="btn btn-success" id="add_row1()" onClick="addRow1()" value="+" /></div>

    </div></th>
    <th><div class="row">
        <div class="col-md-offset col-md-2"><label>Semana</label></div>
        <div class="col-md-3"><label># de problemas no resueltos</label></div>
        
        <div class="col-md-0"><input type="button" class="btn btn-success" id="add_row2()" onClick="addRow2()" value="+" /></div>
    </div></th>
    </tr>
    <tr>
        <th><div class="row" id="col1"></div></th>
        <th><div class="row" id="col2"></div></th>
    </tr>
    </table>
    
    <hr>
    
    <br>
    <div><label>Promedio</label></div>
    <div  id= "cl"> : </div><br>
    <div><label>Rango</label></div>
    <div  id= "clr"> : </div>
    <div><label>UCL</label></div>
    <div  id= "ucl"> : </div>
    <div><label>LCL</label></div>
    <div  id= "lcl"> : </div>
    <div><label>UCLR</label></div>
    <div  id= "uclr"> : </div>
    <div><label>SIGMA</label></div>
    <div  id= "sigma"> : </div>

    <input type="button" class="btn btn-success" id="Promedio" value="Calcular límites y graficar" onclick="funcion();"><br>
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


