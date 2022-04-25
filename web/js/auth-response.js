import { Notify } from "../js/notify.js";

// Obtenemos los elementos necesarios de nuestro archivo html
const progress = document.getElementById("progressBar");
const btn = document.getElementById("btn");

// Ocultamos el boton, ya que todavia no sabemos si el usuario se ha verificado
btn.setAttribute('style','display: none;');

// Establecemos el valor de inicio de la barra de progreso
let progressValue = 10;

function frame() {

    // Funcion que anima la barra de progreso

    if (progressValue >= 100) {
        clearInterval(id);
    } else {
        progressValue++;
        progress.setAttribute("style","width:"+ progressValue +"%;");
        progress.innerText = progressValue + "%";
    }
    if (progressValue === 100) {
        // Una vez que la barra de progreso llega al 100%, se muestra el boton al usuario
        btn.setAttribute('style','');
    }
}

function conexion(validateConnect) {

    // Funcion, que mediante el parametro que le pasemos, indicaremos si el usuario ha podido conectarse o no

    if (validateConnect) {
        
        // Creamos una notificacion para indicarle al usuario de que se ha verificado correctamente
        const notificacion = new Notify("info","../assets/icons/alertIcon.png","icon","Autenticación Correcta","","Se ha verificado la cuenta, y se ha obtenido el token de acceso. Será redirigido al inicio, espere porfavor","info");
            
        var _toast = document.getElementById("info");
        var toast = new bootstrap.Toast(_toast);

        toast.show();
    }else {
        // Creamos una notificacion para indicarle al usuario de que no se ha podido verificar,
        // lo que no tenemos acceso a su token
        const notificacion = new Notify("danger","../assets/icons/alertIcon.png","icon","Autenticación Incorrecta","","No se ha permitido el acceso a su cuenta, reinténtelo","danger");
            
        var _toast = document.getElementById("danger");
        var toast = new bootstrap.Toast(_toast);

        toast.show();
    }
}

// Para darle más vistosidad, agregamos una barra de progreso que se actualiza cada 40 frames
var id = setInterval(frame, 40);

function getTokenByTwitch() {

    // Si twitch nos hace una peticion que empieze por #, sabemos que nos va a devolver un token
    // Esto lo podemos encontrar en la propia documentacion:
    // https://dev.twitch.tv/docs/authentication/getting-tokens-oauth#implicit-grant-flow 
    
    // El parametro document/location/hash nos devuelve todos los query que se han
    // añadido a nuestra url
    var hash = document.location.hash;

    if(containsChar(hash,"#")) {
        // Se ha autenticado el usuario
        var token = "";
        var foundToken = false;
        var scope = "";
        var foundScope = true;
        var token_type = "";
    
        hash.split("").map(function(char,index) {
            if(foundToken === false){
                if(char != "&"){
                    if(index > 13){
                        token += char;
                    }
                }else if(char === "&"){
                    foundToken = true;
                }
            }
        })
        
        if(token != ""){
            conexion(true);
    
            var request = new XMLHttpRequest();
    
            request.open('POST','http://localhost/ArduinoAPI/auth?function=setToken&token='+token,true);
            
            request.onload = function() {
                console.log(request.response);
            }
    
            request.onerror = function() {
                console.log("Error");
            }
    
            request.send();
        }
        console.log(token);
    }else {
        // No se ha podido autenticar el usuario
        conexion(false);
    }
}

function containsChar(s,search) {
    if (s.length == 0)
        return false;
    else
        return s.charAt(0) == search || containsChar(s.substring(1), search);
}

getTokenByTwitch();