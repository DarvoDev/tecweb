
function getDatos()
{
    var nombre = prompt("Nombre: ", "");

    var edad = prompt("Edad: ", 0);

    var div1 = document.getElementById('nombre');
    div1.innerHTML = '<h3> Nombre: '+nombre+'</h3>';

    var div2 = document.getElementById('edad');
    div2.innerHTML = '<h3> Edad: '+edad+'</h3>';
}

//ejemplo 1
function imprimirHolaMundo(){
    document.write('<h3>Hola mundo</h3>');
}  

//ejemplo 2
function ejecutarEj2(){
    var nombre = 'David'
    var edad = 21;
    var altura = 1.72;
    var casado = false;
    document.write(nombre);
    document.write('<br>');
    document.write(edad);
    document.write('<br>');
    document.write(altura);
    document.write('<br>');
    document.write(casado);
}

//ejemplo 3
function ejecutarEj3(){
    var nombre;
    var edad;
    nombre = prompt('Ingresa tu nombre:', '');
    edad = prompt('Ingresa tu edad: ', '');
    document.write('Hola ');
    document.write(nombre);
    document.write(' asi que tienes ');
    document.write(edad);
    document.write(' años');
}

//ejemplo 4
function calcular(){
    var valor1;
    var valor2;

    valor1 = prompt('Introduce el primer numero:', '');
    valor2 = prompt('Introduce el segundo numero:', '');

    var suma = parseInt(valor1)+parseInt(valor2);
    var producto = parseInt(valor1) * parseInt(valor2);

    document.write('La suma es ');
    document.write(suma);
    document.write('<br>');
    document.write('El producto es ');
    document.write(producto);
}

//ejemplo 5
function calificar(){
    var nombre;
    var nota;
    nombre = prompt('Ingresa tu nombre:', 's');
    nota = prompt('Ingresa tu nota:', '');
    if(nota>=4){
        document.write(nombre + ' esta aprobado con un '+nota);
    }
}

//ejemplo 6
function determinarMayor(){
    var num1, num2;
    num1 = prompt('Ingresa el primer numero:','');
    num2 = prompt('Ingresa el segundo numero:','');
    num1 = parseInt(num1);
    num2 = parseInt(num2);
    if (num1>num2){
        document.write('el mayor es '+num1);
    }else{
        document.write('el mayor es '+num2);
    }
}

//ejemplo 7
function calificar2(){
    var nota1, nota2, nota3;

    nota1 = prompt('Ingresa la 1ra. nota:','');
    nota2 = prompt('Ingresa la 2da. nota:','');
    nota3 = prompt('Ingresa la 3ra. nota:','');

    //Convertimos los 3 string en enteros
    nota1 = parseInt(nota1);
    nota2 = parseInt(nota2);
    nota3 = parseInt(nota3);

    var pro;
    pro = (nota1 + nota2 + nota3) / 3;

    if(pro>=7){
        document.write('aprobado');
    }
    else{
        if(pro>=4){
            document.write('regular');
        }
        else{
            document.write('reprobado');
        }
    }
}

//ejemplo 8
function convertirAPalabra(){
    var valor;
    valor = prompt('Ingresa un valor comprendido entre 1 y 5', '');
    //Convertimos a entero
    valor = parseInt(valor);

    switch(valor){
        case 1: document.write('uno');
        break;
        
        case 2: document.write('dos');
        break;

        case 3: document.write('tres');
        break;

        case 4: document.write('cuatro');
        break;

        case 5: document.write('cinco');
        break;

        default:
            document.write('Debe ingresar un valor comprendido entre 1 y 5.');
    }
}

//ejemplo 9
function pintarFondo(){
    var col;
    col = prompt('Ingresa el color con que quiera pintar el fondo de la ventana (rojo, verde, azul)', '');

    switch(col){
        case 'rojo': document.bgColor='#ff0000';
        break;

        case 'verde': document.bgColor = '#00ff00';
        break;

        case 'azul': document.bgColor = '#0000ff'
        break;        
    }
}

//ejemplo 10
function ejecutarEj10(){
    var x;
    x=1;

    while(x<=100){
        document.write(x);
        document.write('<br>');
        x=x+1;
    }
}

//ejemplo 11
function acumular(){
    var x = 1;
    var suma = 0;
    var valor;

    while(x<=5){
        valor = prompt('Ingresa el valor:', '');
        valor = parseInt(valor);    
        x = x+1;
    }
    document.write("La suma de los valores es " + suma + "<br>");
}

//ejemplo 12
function ejecutarEj12(){
    var valor;
    do{
        valor = prompt('Ingresa un valor entre 0 y 990:', '');
        valor = parseInt(valor);
        document.write('El valor '+valor+' tiene ');
        if(valor<10){
            document.write('Tiene 1 digitos');
        }else{
            if(valor<100){
                document.write('Tiene 2 digitos');
            }
            else{
                document.write('Tiene 3 digitos');
            }
            document.write('<br>');
        }
    }while(valor != 0);
}

//ejemplo 13
function mostrarNumeros(){
    var f;
    for(f = 1; f<=10; f++){
        document.write(f+" ");
    }
}

//ejemplo 14
function ejecutarEj14(){
   document.write("Cuidado<br>");
   document.write("Ingresa tu documento correctamente<br>");
   document.write("Cuidado<br>");
   document.write("Ingresa tu documento correctamente<br>");
   document.write("Cuidado<br>");
   document.write("Ingresa tu documento correctamente<br>");
}

//ejemplo 15
function mostrarMensaje(){
    document.write("Cuidado<br>");
    document.write("Ingresa tu documento correctamente<br>");
}

function ejecutarEj15(){
    mostrarMensaje();
    mostrarMensaje();
    mostrarMensaje();
}

//ejemplo 16
function mostrarRango(x1, x2){
    var inicio;
    for(inicio = x1; inicio<=x2; inicio++){
        document.write(inicio+' ');
    }
}

function ejecutarEj16(){
    var valor1, valor2;
    valor1 = prompt('Ingresa el valor inferior:', '');
    valor1 = parent(valor1);
    valor2 = prompt('Ingresa el valor superior:', '');
    valor2 = parseInt(valor2);
    mostrarRango(valor1, valor2);
}

//ejemplo 17
function convertirCastellano(x){
    if(x==1){
        return "uno";
    }else{
        if(x==2){
            return "dos";
        }else{
            if(x==3){
                return "tres";
            }else{
                if(x==4){
                    return "cuatro";
                }else{
                    if(x==5){
                        return "cinco";
                    }else{
                        return "valor incorrecto";
                    }
                }
            }    
        }
    }
}

function ejecutarEj17(){
    var valor = prompt("Ingresa un valor entre 1 y 5", '');
    valor = parseInt(valor);
    var r = convertirCastellano(valor);
    document.write(r);
}

//ejemplo 18
function convertirCastellano2(x){
    switch(x){
        case 1: return "uno";
        case 2: return "dos";
        case 3: return "tres";
        case 4: return "cuatro";
        case 5: return "cinco";
        default: return "valor incorrecto";
    }
}

function ejecutarEj18(){
    var valor = prompt("Ingresa un valor entre 1 y 5", '');
    valor = parseInt(valor);
    var r = convertirCastellano2(valor);
    document.write(r);
}