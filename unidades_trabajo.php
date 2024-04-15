<!DOCTYPE html>
<html>
<head>
<title>Tamaño unidades de trabajo</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
   

</script>

<script> 
n = 0; //numero modulos
var grandPromedios = [];//arreglo para guardar los valores de densidad a graficar
var grandRangos = [];
var arreglo = [];//arreglo para guardar cada valor del tamaño de modulo
var puntosUCL = []; //puntos de UCL a graficar
var puntosLCL = []; //puntos de LCL a graficar


var sumA = 0;//sumatoria de los numeros de defectos
var sumB = 0;//sumatoria del tamaño de los modulos

function addRow(){
        n++;

        var div = document.createElement('div');
        div.setAttribute('class', 'form-inline');
            div.innerHTML = '<div style="clear:both"><input class="col-md-1" type="number" id="number" value="'+n+'" readonly="readonly"><input class="col-md-2" type="number" min="0" id="b'+n+'" step="1000" onchange="densidad('+n+');"><input type="checkbox" id="y'+n+'" checked><div class="col-md-2" type="number" min="0" id="c'+n+'" ></div>';
            document.getElementById('fila').appendChild(div);document.getElementById('fila').appendChild(div);
}   

function cargar(){
  
        <?php 
            include("conexion.php");
            $query = "SELECT modulo, sloc FROM unidades_trabajo_db ORDER BY modulo ASC";
            $resultado = $conexion -> query($query);
            
            while($row = $resultado->fetch_assoc()){
            
                $modulo = $row['modulo'];
                $sloc = $row['sloc'];
                
                
               
         ?>

            n++;
            var modulo = '<?php echo $modulo;?>'
            var sloc = '<?php echo $sloc;?>'
           
            

            var div = document.createElement('div');
        div.setAttribute('class', 'form-inline');
            div.innerHTML = '<div style="clear:both"><input class="col-md-1" type="number" id="number" value="'+modulo+'" readonly="readonly"><input class="col-md-2" type="number" min="0" id="b'+n+'" value="'+sloc+'" step="1000" onchange="densidad('+n+');"><input type="checkbox" id="y'+n+'" checked><div class="col-md-2" type="number" min="0" id="c'+n+'" ></div>';
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

function decimalAdjust(type, value, exp) {
    // If the exp is undefined or zero...
    if (typeof exp === 'undefined' || +exp === 0) {
      return Math[type](value);
    }
    value = +value;
    exp = +exp;
    // If the value is not a number or the exp is not an integer...
    if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
      return NaN;
    }
    // Shift
    value = value.toString().split('e');
    value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
    // Shift back
    value = value.toString().split('e');
    return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
  }

  if (!Math.ceil10) {
    Math.ceil10 = function(value, exp) {
      return decimalAdjust('ceil', value, exp);
    };
  }

function densidad(n){
	
	
	var b = parseFloat(document.getElementById("b"+n).value);
	arreglo.push(b);
	var c = Math.ceil10(b/1000);
    var cc = c.toFixed(2);
    
	document.getElementById("c"+n).innerHTML=cc;
	

}
function funcion(){
        var suma = 0;
        var sumaR = 0;

        var e = 1;
        for (var i = 1; i <= n; i++) {
            var checkbox = document.getElementById("y"+i).checked;

            if(checkbox){
                var valor = parseFloat(document.getElementById("c"+i).innerHTML);

                ///////////////////////////////////////////////////////////////////////////
                var modulo=i;   
                var sloc=$("#b"+i).val();
               
                

                $.post("unidades_trabajo_db.php",{"modulo":modulo, "sloc":sloc});
                ///////////////////////////////////////////////////////////////////////
                grandPromedios[e]=valor;
                suma = suma + valor;
                e++;
            }

        }


        for (var i = 1; i < n; i++) {
            var y = i + 1;
            var a = parseFloat(document.getElementById("c"+y).innerHTML);
            var b = parseFloat(document.getElementById("c"+i).innerHTML);
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

        var promedio2 = promedio.toFixed(2);
        var rango2 = rango.toFixed(2);
        var UCL2 = ucl.toFixed(2);
        var LCL2 = lcl.toFixed(2);
        var UCLR2 = uclr.toFixed(2);
        var sigma2 = sigma.toFixed(2);

        document.getElementById("cl").innerHTML=promedio2; 
        document.getElementById("clr").innerHTML=rango2; 
        document.getElementById("ucl").innerHTML=UCL2; 
        document.getElementById("lcl").innerHTML=LCL2;
        document.getElementById("uclr").innerHTML=UCLR2;
        document.getElementById("sigma").innerHTML=sigma2;
       
      graficar();
      graficar2();
        

    } 
    function funcion2(){
        var suma = 0;
        var sumaR = 0;
        console.log("entro");
        var e = 1;
        for (var i = 1; i <= n; i++) {
            var checkbox = document.getElementById("y"+i).checked;
            console.log(checkbox);
            if(checkbox){
                var valor = parseFloat(document.getElementById("c"+i).innerHTML);
                console.log(valor);
                grandPromedios[e]=valor;
                suma = suma + valor;
                e++;
            }

        }
        for (var i = 1; i < n; i++) {
            var y = i + 1;
            var a = parseFloat(document.getElementById("c"+y).innerHTML);
            var b = parseFloat(document.getElementById("c"+i).innerHTML);
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

        var promedio2 = promedio.toFixed(2);
        var rango2 = rango.toFixed(2);
        var UCL2 = ucl.toFixed(2);
        var LCL2 = lcl.toFixed(2);
        var UCLR2 = uclr.toFixed(2);
        var sigma2 = sigma.toFixed(2);

        document.getElementById("cl").innerHTML=promedio2; 
        document.getElementById("clr").innerHTML=rango2; 
        document.getElementById("ucl").innerHTML=UCL2; 
        document.getElementById("lcl").innerHTML=LCL2;
        document.getElementById("uclr").innerHTML=UCLR2;
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
                                var div = document.createElement('div');
div.setAttribute('class', 'form-inline');
div.innerHTML = '<div><input type="checkbox" id="t2" checked> TEST 2: Al menos dos de los tres valores consecutivos caen del mismo lado y más de dos unidades sigma lejos de la línea central.</div><br>';
document.getElementById('test2').appendChild(div);document.getElementById('test2').appendChild(div);
                                
                                break;
                            }

                    }
                }

                //Caso en el que los tres valores estan por encima de sigma-2
                if(grandPromedios[i] > (promedio + 2*sigma)){
                    if(grandPromedios[i+1] > (promedio + 2*sigma)){
                        if(grandPromedios[i+2] > (promedio + 2*sigma)){
                            alert("Test2: Al menos dos de los tres valores consecutivos caen del mismo lado y más de dos unidades sigma lejos de la línea central");
                            var div = document.createElement('div');
div.setAttribute('class', 'form-inline');
div.innerHTML = '<div><input type="checkbox" id="t2" checked> TEST 2: Al menos dos de los tres valores consecutivos caen del mismo lado y más de dos unidades sigma lejos de la línea central.</div><br>';
document.getElementById('test2').appendChild(div);document.getElementById('test2').appendChild(div);
                            break;
                        }
                    }
                }
                //Caso en el que el primer valor esta por debajo de sigma-2, el segundo esta por debajo de CL y el tercero esta por encima de sigma-2
                
                if(grandPromedios[i] < (promedio - 2*sigma)){
                    if(grandPromedios[i+1] < promedio & grandPromedios[i+1] > (promedio - 2*sigma)){
                        if(grandPromedios[i+2] < (promedio - 2*sigma)){
                                alert("Test2: Al menos dos de los tres valores consecutivos caen del mismo lado y más de dos unidades sigma lejos de la línea central");
                                var div = document.createElement('div');
div.setAttribute('class', 'form-inline');
div.innerHTML = '<div><input type="checkbox" id="t2" checked> TEST 2: Al menos dos de los tres valores consecutivos caen del mismo lado y más de dos unidades sigma lejos de la línea central.</div><br>';
document.getElementById('test2').appendChild(div);document.getElementById('test2').appendChild(div);
                                break;
                            }
                    }
                }

                //Caso en el que los tres valores estan por debajo de sigma-2
                if(grandPromedios[i] < (promedio - 2*sigma)){
                    if(grandPromedios[i+1] < (promedio - 2*sigma)){
                        if(grandPromedios[i+2] < (promedio - 2*sigma)){
                            alert("Test2: Al menos dos de los tres valores consecutivos caen del mismo lado y más de dos unidades sigma lejos de la línea central");
                            var div = document.createElement('div');
div.setAttribute('class', 'form-inline');
div.innerHTML = '<div><input type="checkbox" id="t2" checked> TEST 2: Al menos dos de los tres valores consecutivos caen del mismo lado y más de dos unidades sigma lejos de la línea central.</div><br>';
document.getElementById('test2').appendChild(div);document.getElementById('test2').appendChild(div);
                            break;
                        }
                    }
                }

                //Caso en el que el primer valor esta por encima de CL y los dos siguientes estan por encima de sigma+2
                if(grandPromedios[i] > promedio){
                        if(grandPromedios[i+1] > (promedio + 2*sigma)){
                            if(grandPromedios[i+2] > (promedio + 2*sigma)){
                               alert("Test2: Al menos dos de los tres valores consecutivos caen del mismo lado y más de dos unidades sigma lejos de la línea central");
                               var div = document.createElement('div');
div.setAttribute('class', 'form-inline');
div.innerHTML = '<div><input type="checkbox" id="t2" checked> TEST 2: Al menos dos de los tres valores consecutivos caen del mismo lado y más de dos unidades sigma lejos de la línea central.</div><br>';
document.getElementById('test2').appendChild(div);document.getElementById('test2').appendChild(div);
                                break;
                            }
                            
                        }
                    
                }

                //Caso en el que el primer valor esta por debajo de Cl y los dos siguientes estan por debajo de sigma-2
                if(grandPromedios[i] < promedio){
                    if(grandPromedios[i+1] < (promedio - 2*sigma)){
                            if(grandPromedios[i+2] < (promedio - 2*sigma)){
                               alert("Test2: Al menos dos de los tres valores consecutivos caen del mismo lado y más de dos unidades sigma lejos de la línea central");
                               var div = document.createElement('div');
div.setAttribute('class', 'form-inline');
div.innerHTML = '<div><input type="checkbox" id="t2" checked> TEST 2: Al menos dos de los tres valores consecutivos caen del mismo lado y más de dos unidades sigma lejos de la línea central.</div><br>';
document.getElementById('test2').appendChild(div);document.getElementById('test2').appendChild(div);
                                break;
                            }
                            
                        
                    }
                }

                //Caso en el que los dos primeros valores estan por encima de sigma+2 y el tercero por encima de CL
                if(grandPromedios[i] > (promedio + 2*sigma)){
                        if(grandPromedios[i+1] > (promedio + 2*sigma)){
                            if(grandPromedios[i+2] > promedio){
                                alert("Test2: Al menos dos de los tres valores consecutivos caen del mismo lado y más de dos unidades sigma lejos de la línea central");
                                var div = document.createElement('div');
div.setAttribute('class', 'form-inline');
div.innerHTML = '<div><input type="checkbox" id="t2" checked> TEST 2: Al menos dos de los tres valores consecutivos caen del mismo lado y más de dos unidades sigma lejos de la línea central.</div><br>';
document.getElementById('test2').appendChild(div);document.getElementById('test2').appendChild(div);
                                break;
                            }
                            
                        }
                    
                }

                //Caso en el que los dos primeros valores estan por debajo de sigma-2 y el tercero por debajo de CL
                if(grandPromedios[i] < (promedio - 2*sigma)){
                        if(grandPromedios[i+1] < (promedio - 2*sigma)){
                            if(grandPromedios[i+2] < promedio){
                                alert("Test2: Al menos dos de los tres valores consecutivos caen del mismo lado y más de dos unidades sigma lejos de la línea central");
                                var div = document.createElement('div');
div.setAttribute('class', 'form-inline');
div.innerHTML = '<div><input type="checkbox" id="t2" checked> TEST 2: Al menos dos de los tres valores consecutivos caen del mismo lado y más de dos unidades sigma lejos de la línea central.</div><br>';
document.getElementById('test2').appendChild(div);document.getElementById('test2').appendChild(div);
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
                                var div = document.createElement('div');
div.setAttribute('class', 'form-inline');
div.innerHTML = '<div><input type="checkbox" id="t3" checked> TEST 3: Al menos cuatro de los cinco valores consecutivos caen del mismo lado y más de una unidad sigma lejos de la línea central.</div><br>';
document.getElementById('test3').appendChild(div);document.getElementById('test3').appendChild(div);
                                break;
                            }
                            if(grandPromedios[i+4] > promedio){
                                alert("Test3: Al menos cuatro de los cinco valores consecutivos caen del mismo lado y más de una unidad sigma lejos de la línea central ");
                                var div = document.createElement('div');
div.setAttribute('class', 'form-inline');
div.innerHTML = '<div><input type="checkbox" id="t3" checked> TEST 3: Al menos cuatro de los cinco valores consecutivos caen del mismo lado y más de una unidad sigma lejos de la línea central.</div><br>';
document.getElementById('test3').appendChild(div);document.getElementById('test3').appendChild(div);
                                break;
                            }
                        }
                        if(grandPromedios[i+3] > promedio){
                            if(grandPromedios[i+4] > (promedio + sigma)){
                               alert("Test3: Al menos cuatro de los cinco valores consecutivos caen del mismo lado y más de una unidad sigma lejos de la línea central ");
                               var div = document.createElement('div');
div.setAttribute('class', 'form-inline');
div.innerHTML = '<div><input type="checkbox" id="t3" checked> TEST 3: Al menos cuatro de los cinco valores consecutivos caen del mismo lado y más de una unidad sigma lejos de la línea central.</div><br>';
document.getElementById('test3').appendChild(div);document.getElementById('test3').appendChild(div);
                                break;
                            }
                        }
                    }
                    if(grandPromedios[i+2] > promedio){
                        if(grandPromedios[i+3] > (promedio + sigma)){
                            if(grandPromedios[i+4] > (promedio + sigma)){
                                alert("Test3: Al menos cuatro de los cinco valores consecutivos caen del mismo lado y más de una unidad sigma lejos de la línea central ");
                                var div = document.createElement('div');
div.setAttribute('class', 'form-inline');
div.innerHTML = '<div><input type="checkbox" id="t3" checked> TEST 3: Al menos cuatro de los cinco valores consecutivos caen del mismo lado y más de una unidad sigma lejos de la línea central.</div><br>';
document.getElementById('test3').appendChild(div);document.getElementById('test3').appendChild(div);
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
                                var div = document.createElement('div');
div.setAttribute('class', 'form-inline');
div.innerHTML = '<div><input type="checkbox" id="t3" checked> TEST 3: Al menos cuatro de los cinco valores consecutivos caen del mismo lado y más de una unidad sigma lejos de la línea central.</div><br>';
document.getElementById('test3').appendChild(div);document.getElementById('test3').appendChild(div);
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
                                var div = document.createElement('div');
div.setAttribute('class', 'form-inline');
div.innerHTML = '<div><input type="checkbox" id="t3" checked> TEST 3: Al menos cuatro de los cinco valores consecutivos caen del mismo lado y más de una unidad sigma lejos de la línea central.</div><br>';
document.getElementById('test3').appendChild(div);document.getElementById('test3').appendChild(div);
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
                                var div = document.createElement('div');
div.setAttribute('class', 'form-inline');
div.innerHTML = '<div><input type="checkbox" id="t3" checked> TEST 3: Al menos cuatro de los cinco valores consecutivos caen del mismo lado y más de una unidad sigma lejos de la línea central.</div><br>';
document.getElementById('test3').appendChild(div);document.getElementById('test3').appendChild(div);
                                break;
                            }
                            if(grandPromedios[i+4] < promedio){
                                alert("Test3: Al menos cuatro de los cinco valores consecutivos caen del mismo lado y más de una unidad sigma lejos de la línea central ");
                                var div = document.createElement('div');
div.setAttribute('class', 'form-inline');
div.innerHTML = '<div><input type="checkbox" id="t3" checked> TEST 3: Al menos cuatro de los cinco valores consecutivos caen del mismo lado y más de una unidad sigma lejos de la línea central.</div><br>';
document.getElementById('test3').appendChild(div);document.getElementById('test3').appendChild(div);
                                break;
                            }
                        }
                        if(grandPromedios[i+3] < promedio){
                            if(grandPromedios[i+4] < (promedio - sigma)){
                                alert("Test3: Al menos cuatro de los cinco valores consecutivos caen del mismo lado y más de una unidad sigma lejos de la línea central ");
                                var div = document.createElement('div');
div.setAttribute('class', 'form-inline');
div.innerHTML = '<div><input type="checkbox" id="t3" checked> TEST 3: Al menos cuatro de los cinco valores consecutivos caen del mismo lado y más de una unidad sigma lejos de la línea central.</div><br>';
document.getElementById('test3').appendChild(div);document.getElementById('test3').appendChild(div);
                                break;
                            }
                        }
                    }
                    if(grandPromedios[i+2] < promedio){
                        if(grandPromedios[i+3] < (promedio - sigma)){
                            if(grandPromedios[i+4] < (promedio - sigma)){
                                alert("Test3: Al menos cuatro de los cinco valores consecutivos caen del mismo lado y más de una unidad sigma lejos de la línea central ");
                                var div = document.createElement('div');
div.setAttribute('class', 'form-inline');
div.innerHTML = '<div><input type="checkbox" id="t3" checked> TEST 3: Al menos cuatro de los cinco valores consecutivos caen del mismo lado y más de una unidad sigma lejos de la línea central.</div><br>';
document.getElementById('test3').appendChild(div);document.getElementById('test3').appendChild(div);
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
                                var div = document.createElement('div');
div.setAttribute('class', 'form-inline');
div.innerHTML = '<div><input type="checkbox" id="t3" checked> TEST 3: Al menos cuatro de los cinco valores consecutivos caen del mismo lado y más de una unidad sigma lejos de la línea central.</div><br>';
document.getElementById('test3').appendChild(div);document.getElementById('test3').appendChild(div);
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
                                var div = document.createElement('div');
div.setAttribute('class', 'form-inline');
div.innerHTML = '<div><input type="checkbox" id="t3" checked> TEST 3: Al menos cuatro de los cinco valores consecutivos caen del mismo lado y más de una unidad sigma lejos de la línea central.</div><br>';
document.getElementById('test3').appendChild(div);document.getElementById('test3').appendChild(div);
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
                                            var div = document.createElement('div');
div.setAttribute('class', 'form-inline');
div.innerHTML = '<div><input type="checkbox" id="t4" checked> TEST 4: Al menos ocho valores consecutivos caen del mismo lado de la línea central.</div><br>';
document.getElementById('test4').appendChild(div);document.getElementById('test4').appendChild(div);
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
                                            var div = document.createElement('div');
div.setAttribute('class', 'form-inline');
div.innerHTML = '<div><input type="checkbox" id="t4" checked> TEST 4: Al menos ocho valores consecutivos caen del mismo lado de la línea central.</div><br>';
document.getElementById('test4').appendChild(div);document.getElementById('test4').appendChild(div);
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

    

/*
function funcion(){
        var e = 0;
        for (var i = 1; i <= n; i++) {
            var checkbox = document.getElementById("y"+i).checked;

            if(checkbox){
                grandPromedios[e]=parseFloat(document.getElementById("c"+i).innerHTML);
                e++;
            }

        }
        var cl = ((sumA/sumB)*1000);
        var cl2 = cl.toFixed(2);
        document.getElementById("CL").innerHTML=cl2;

        //Calculo de UCL
        for (var i = 0; i < n; i++) {
        	var x = 3*(Math.sqrt(cl/(arreglo[i]/1000)));
        	puntosUCL[i] = cl + x;
        	puntosLCL[i] = cl - x;
        }
        graficar();
    }  */

/*
    function funcion2(){

        var e = 0;
        for (var i = 1; i <= n; i++) {
            var checkbox = document.getElementById("y"+i).checked;

            if(checkbox){
                grandPromedios[e]=parseFloat(document.getElementById("c"+i).innerHTML);
                e++;
            }

        }
        
        var cl = ((sumA/sumB)*1000);
        var cl2 = cl.toFixed(2);
        document.getElementById("CL").innerHTML=cl2;

        var ucl = parseFloat(document.getElementById("cambiar_ucl").value);
        var lcl = parseFloat(document.getElementById("cambiar_lcl").value);
        if(lcl >= ucl){
            alert("El limite de control superior UCL debe ser mayor que el limite de control inferior LCL");
        }
        else{
            
            graficar2();
        }
    }  

   */

    
</script> 

<script>

    function graficar() {

var chart = new CanvasJS.Chart("chartContainer", {
    animationEnabled: true,  
    title:{
        text: "Gráfica de tamaño de las unidades de trabajo por módulo"
    },
    axisX: {
      title: "Modulos"
    },
    axisY: {
        title: "Tamaño del módulo (KSLOC)",
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
        text: "Gráfica de rangos"
    },
    axisX: {
      title: "Modulos"
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
<div style="float:right"><b>Entidad:</b> Cosas Producidas - <b>Atributo:</b> Tamaño de las unidades de trabajo</div>
<input type="button" style="float:left;" class="btn btn-success" id="Volver" value="Volver Atrás" onclick="volver();">

<body>
<div class="container">
    <h1>Tamaño de las unidades de trabajo por módulo</h1><hr>
    <h4>Este formulario permite visualizar el comportamiento del tamaño de las unidades de trabajo expresado por la cantidad de líneas de código en cada módulo o unidad de trabajo.  </h4>
    <h4><b>1.</b> Utilicé el botón <b>+</b> para ingresar cada módulo.</h4>
    <h4><b>2.</b> Ingrese el tamaño del módulo en líneas de código (SLOC).</h4>
    <h4><b>3.</b> La columna tamaño del módulo se calcula por cada 1000 líneas de código automáticamente (KSLOC).</h4>
    <h4><b>4.</b> Utilicé el botón <b>Calcular límites y graficar </b> para calcular CL y observar la gráfica de control.</h4>
   <hr>
    <form action="formulario2.html" id="formulario" method="get">
    
    <div class="row">
        <div class="col-md-offset col-md-1"><label># de modulo</label></div>
        <div class="col-md-2"><label>Tamaño del módulo (SLOC)</label></div>
        <div class="col-md-2"><label>Tamaño del módulo (KSLOC)</label></div>
        
        <div class="col-md-0"><input type="button" class="btn btn-success" id="add_row()" onClick="addRow();" value="+" />
            </div>
        
    </div>

    <div class="row" id="fila"></div>
    

    <div class="row" id="fila"></div>
    <br><hr>
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

    <hr>

    <div id="test1"></div>
    <div id="test2"></div>
    <div id="test3"></div>
    <div id="test4"></div>
    

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


<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

</body>
</html>


