<!DOCTYPE html>
<html>
<head>
<title>Esfuerzo por semanas - Horas de preparación</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js" type="text/javascript"></script>

<script>
n = 0; //numero de semanas ingresadas
var grandPromedios = [];//arreglo para guardar los promedios de cada semana
var grandRangos = []; //arreglo para guardar los rangos de cada semana

function addRow(){
        n++;

        var div = document.createElement('div');
        div.setAttribute('class', 'form-inline');
            div.innerHTML = '<div style="clear:both"><input class="col-md-1" type="number" id="'+n+'1" value="'+n+'" readonly="readonly"><input class="col-md-1" type="number" min="0" id="'+n+'2" ><input class="col-md-1" type="number" min="0" id="'+n+'3" ><input class="col-md-1" type="number" min="0" id="'+n+'4" ><input class="col-md-1" type="number" min="0" id="'+n+'5" ><input class="col-md-1" type="number" min="0" id="'+n+'6" onchange="promedio('+n+');"><input type="checkbox" id="y'+n+'" checked><div class="col-md-2" id="promedio'+n+'"></div><div  class="col-md-2" id="rango'+n+'"></div>';
            document.getElementById('fila').appendChild(div);document.getElementById('fila').appendChild(div);
}

function cargar(){
  
        <?php 
            include("conexion.php");
            $query = "SELECT semana, lunes, martes, miercoles, jueves, viernes FROM esfuerzo_semanas ORDER BY semana ASC";
            $resultado = $conexion -> query($query);
            
            while($row = $resultado->fetch_assoc()){
            
                $semana = $row['semana'];
                $lunes = $row['lunes'];
                $martes = $row['martes'];
                $miercoles = $row['miercoles'];
                $jueves = $row['jueves'];
                $viernes = $row['viernes'];
               
         ?>

            n++;
            var semana = '<?php echo $semana;?>'
            var lunes = '<?php echo $lunes;?>'
            var martes = '<?php echo $martes;?>'
            var miercoles = '<?php echo $miercoles;?>'
            var jueves = '<?php echo $jueves;?>'
            var viernes = '<?php echo $viernes;?>'

            var div = document.createElement('div');
            div.setAttribute('class', 'form-inline');
            div.innerHTML = '<div style="clear:both"><input class="col-md-1" type="number" id="'+n+'1" value="'+semana+'" readonly="readonly"><input class="col-md-1" type="number" min="0" id="'+n+'2" value="'+lunes+'"><input class="col-md-1" type="number" min="0" id="'+n+'3" value="'+martes+'"><input class="col-md-1" type="number" min="0" id="'+n+'4" value="'+miercoles+'"><input class="col-md-1" type="number" min="0" id="'+n+'5" value="'+jueves+'"><input class="col-md-1" type="number" min="0" id="'+n+'6" value="'+viernes+'" onchange="promedio('+n+');"><input type="checkbox" id="y'+n+'" checked><div class="col-md-2" id="promedio'+n+'"></div><div  class="col-md-2" id="rango'+n+'"></div>';
            document.getElementById('fila').appendChild(div);document.getElementById('fila').appendChild(div);

            promedio(n);
            <?php 
            
            }
            ?>           

}

function volver(){
    window.location = "ventana_esfuerzo.php";
}




        var sumaPromedios = 0; //Varaible que acumula los promedios de cada fila
        var sumaRangos = 0;   
    function promedio(n)
    {
        var v1 = parseFloat(document.getElementById(n+"2").value);
        var v2 = parseFloat(document.getElementById(n+"3").value);
        var v3 = parseFloat(document.getElementById(n+"4").value);
        var v4 = parseFloat(document.getElementById(n+"5").value);
        var v5 = parseFloat(document.getElementById(n+"6").value);
        

        

        var promedio = (v1+v2+v3+v4+v5)/5;
        //grandPromedios.push(promedio);//Guardo cada promedio de cada semana en el array
        

        sumaPromedios = sumaPromedios + promedio;

        var array = [v1,v2,v3,v4,v5];
        var rango = Math.max.apply(null,array) - Math.min.apply(null,array);
        //grandRangos.push(rango);
        

        sumaRangos = sumaRangos + rango; 

        promedio = promedio.toFixed(2);
        rango = rango.toFixed(2);
        //sumaPromedios = sumaPromedios.toFixed(2);
        //sumaRangos = sumaRangos.toFixed(2);
        

        document.getElementById("promedio"+n).innerHTML=promedio; 
        document.getElementById("sumaPromedios").innerHTML=sumaPromedios;
        document.getElementById("rango"+n).innerHTML=rango;
        document.getElementById("sumaRangos").innerHTML=sumaRangos;       
        
    } 

    function funcion(){

        var e = 1;
        for (var i = 1; i <= n; i++) {
            var checkbox = document.getElementById("y"+i).checked;

            if(checkbox){

                ///////////////////////////////////////////////////////////////////////////
                var semana=$("#"+i+"1").val();   
                var lunes=$("#"+i+"2").val();
                var martes=$("#"+i+"3").val();
                var miercoles=$("#"+i+"4").val();
                var jueves=$("#"+i+"5").val();
                var viernes=$("#"+i+"6").val();

                $.post("esfuerzo_semanas_db.php",{"semana":semana, "lunes":lunes, "martes":martes, "miercoles":miercoles, "jueves":jueves, "viernes":viernes});
                ///////////////////////////////////////////////////////////////////////
            
                grandPromedios[e]=parseFloat(document.getElementById("promedio"+i).innerHTML);
                grandRangos[e]=parseFloat(document.getElementById("rango"+i).innerHTML);
                e++;
            }

        }
        
        var cl = sumaPromedios/n;//CL
        var clr = sumaRangos/n;//CLR
        var ucl = cl + 0.577*clr;
        var lcl = cl - 0.577*clr;
        var uclr = 2.114*clr;
        var sigma = (0.577*clr)/3;

        var cl2 = cl.toFixed(2);
        var clr2 = clr.toFixed(2);
        var ucl2 = ucl.toFixed(2);
        var lcl2 = lcl.toFixed(2);
        var uclr2 = uclr.toFixed(2);
        var sigma2 = sigma.toFixed(2);

        document.getElementById("cl").innerHTML=cl2; 
        document.getElementById("clr").innerHTML=clr2;
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

    function funcion2(){

        var e = 1;
        for (var i = 1; i <= n; i++) {
            var checkbox = document.getElementById("y"+i).checked;

            if(checkbox){
            
                grandPromedios[e]=parseFloat(document.getElementById("promedio"+i).innerHTML);
                grandRangos[e]=parseFloat(document.getElementById("rango"+i).innerHTML);
                e++;
            }

        }
        var cl = sumaPromedios/n;//CL
        var clr = sumaRangos/n;//CLR
        var ucl = parseFloat(document.getElementById("cambiar_ucl").value);
        var lcl = parseFloat(document.getElementById("cambiar_lcl").value);
        var uclr = 2.114*clr;
        var sigma = (0.577*clr)/3;

        var cl2 = cl.toFixed(2);
        var clr2 = clr.toFixed(2);
        var ucl2 = ucl.toFixed(2);
        var lcl2 = lcl.toFixed(2);
        var uclr2 = uclr.toFixed(2);
        var sigma2 = sigma.toFixed(2);

        document.getElementById("cl").innerHTML=cl2; 
        document.getElementById("clr").innerHTML=clr2;
        document.getElementById("ucl").innerHTML=ucl2;
        document.getElementById("lcl").innerHTML=lcl2;
        document.getElementById("uclr").innerHTML=uclr2;
        document.getElementById("sigma").innerHTML=sigma2;

        graficar();
        //graficar2();

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
                                break;
                                var div = document.createElement('div');
div.setAttribute('class', 'form-inline');
div.innerHTML = '<div><input type="checkbox" id="t3" checked> TEST 3: Al menos cuatro de los cinco valores consecutivos caen del mismo lado y más de una unidad sigma lejos de la línea central.</div><br>';
document.getElementById('test3').appendChild(div);document.getElementById('test3').appendChild(div);
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
                                            var div = document.createElement('div');
div.setAttribute('class', 'form-inline');
div.innerHTML = '<div><input type="checkbox" id="t4" checked> TEST 4: Al menos ocho valores consecutivos caen del mismo lado de la línea central.</div><br>';
document.getElementById('test4').appendChild(div);document.getElementById('test4').appendChild(div);
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
                                            var div = document.createElement('div');
div.setAttribute('class', 'form-inline');
div.innerHTML = '<div><input type="checkbox" id="t4" checked> TEST 4: Al menos ocho valores consecutivos caen del mismo lado de la línea central.</div><br>';
document.getElementById('test4').appendChild(div);document.getElementById('test4').appendChild(div);
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
        text: "Gráfica de promedios"
    },
    axisX: {
      title: "Semanas"
    },
    axisY: {
        title: "Promedio de horas diarias",
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
  //grandPromedios = [];
  
}

function graficar2() {

var chart2 = new CanvasJS.Chart("chartContainer2", {
    animationEnabled: true,  
    title:{
        text: "Gráfica de rangos"
    },
    axisX: {
      title: "Semanas"
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

}

</script>

</head>
<div style="float:right"><b>Entidad:</b> Cosas consumidas - <b>Atributo:</b> Esfuerzo</div>
<input type="button" style="float:left;" class="btn btn-success" id="Volver" value="Volver Atrás" onclick="volver();">

<body>
<div class="container">
    <h1>Esfuerzo por semanas - Horas de preparación</h1><hr>
    <h4>Este formulario permite visualizar el comportamiento de las horas de preparación utilizadas en un proceso de software
     cada SEMANA.  </h4>
    <h4><b>1.</b> Utilicé el botón <b>+</b> para ingresar cada semana.</h4>
    <h4><b>2.</b> Ingrese el número de horas de preparación utilizadas en cada día.</h4>
    <h4><b>3.</b> Utilicé el botón <b>Calcular límites y graficar</b> para calcular las variables necesarias para el gráfico.</h4><hr>
    
    <form action="formulario2.html" id="formulario" method="get">
    
    <div class="row">
        <div class="col-md-offset col-md-1"><label>Semana</label></div>
        <div class="col-md-1"><label>Lunes</label></div>
        <div class="col-md-1"><label>Martes</label></div>
        <div class="col-md-1"><label>Miercoles</label></div>
        <div class="col-md-1"><label>Jueves</label></div>
        <div class="col-md-1"><label>Viernes</label></div>
        <div class="col-md-2"><label>Promedio</label></div>
        <div class="col-md-2"><label>Rango</label></div>
        <div class="col-md-0"><input type="button" class="btn btn-success" id="add_row()" onClick="addRow()" value="+" /></div>
    </div>
 
    <div class="row" id="fila"></div>
    <br><hr>
    <div class="col-md-offset-5 col-md-1"><label>Sumatoria</label></div>
    <div class="col-md-2" id= "sumaPromedios"> </div><div class="col-md-2" id= "sumaRangos"> </div>
<br>
    <input type="button" class="btn btn-success" id="Promedio" value="Calcular límites y graficar" onclick="funcion();">
<input type="button" name="aceptar" value="Cargar" onclick="cargar();" class="btn btn-success">
    <div class="row" id="fila"></div>
    
    
    
    <div title="Límite superior de control" class="col-md-offset-5 col-md-2"><label>UCL</label></div>
    <div class="col-md-1" id= "ucl"> </div>
    <div title="Promedio" class="col-md-offset-5 col-md-2"><label>CL</label></div>
    <div class="col-md-1" id= "cl"> </div>
    <div title="Límite inferior de control" class="col-md-offset-5 col-md-2"><label>LCL</label></div>
    <div class="col-md-1" id= "lcl"> </div>
    <div title="Límite superior de control de rangos" class="col-md-offset-5 col-md-2"><label>UCLR</label></div>
    <div class="col-md-1" id= "uclr"> </div>
    <div title="Promedio de los rangos" class="col-md-offset-5 col-md-2"><label>CLR</label></div>
    <div class="col-md-1" id= "clr"> </div>
    
    
    
    
    <div class="col-md-offset-5 col-md-2"><label>SIGMA </label></div>
    <div class="col-md-1" id= "sigma"> </div>

<hr>

    <div id="test1"></div>
    <div id="test2"></div>
    <div id="test3"></div>
    <div id="test4"></div>
    </form>
    <br>
    <input type="number" name="ucl" id="cambiar_ucl" placeholder="ucl">
    <input type="number" name="lcl" id="cambiar_lcl" placeholder="lcl">
    <input type="button" class="btn btn-success" id="cambiar" value="Cambiar límites" onclick="funcion2();">
    
</div>
<hr>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<hr>

<div id="chartContainer2" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

</body>
</html>


