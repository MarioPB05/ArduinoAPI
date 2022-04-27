import { Notify } from "../js/notify.js";

// function isSignIn() {
//     var request = new XMLHttpRequest();
//     request.open('GET','http://localhost/ArduinoAPI/auth?function=isSignIn',true);
//     request.onload = function() {
//         const headerText = document.getElementById("headerText");
//         const userImage = document.getElementById("userImage");

//         if(request.response === "False"){
//             headerText.innerText = "Iniciar Sesión";
//             headerText.setAttribute('href','https://id.twitch.tv/oauth2/authorize?response_type=token&client_id=ohfa4jx2elff8xkzjaphoxkw70nwds&redirect_uri=http://localhost/ArduinoAPI/web/pages/auth-response.html&scope=user%3Aread%3Aemail');
//             headerText.setAttribute('target','_blank');

//             userImage.setAttribute('src','../assets/icons/userIcon.png');

//             // Mostramos una alerta al usuario para que lo sepa
//             const notificacion = new Notify("alert","../assets/icons/alertIcon.png","icon","Navegando como Invitado","","Actualmente está navegando como invitado, incie sesión para poder utilizar todas las funciones","warning");
            
//             var _toast = document.getElementById("alert");
//             var toast = new bootstrap.Toast(_toast);
            
//             toast.show();

//             // Evento que escucha cuando se oculta una notificación
//             /* _toast.addEventListener('hide.bs.toast', function () {
//                 console.log("Evento Oculto");
//             }); */

//         }else if(request.response === "True"){
//             headerText.innerText = "Cerrar Sesión";
//             headerText.setAttribute('onclick','signOut()');

//             userData = getUserData();

//             // Mostramos una alerta al usuario para que lo sepa
//             const notificacion = new Notify("info",userData.userImage,"userImage","Tu perfil ha sido cargado correctamente!","info");
//             var not = document.getElementById("info");
//             var toast = new bootstrap.Toast(not);
//             toast.show();
//         }
//     }
//     request.onerror = function() {
//         console.log("Error");
//     }
//     request.send();
// }

function signOut() {

    // Funcion que cierra la sesion actual

    fetch("http://localhost/ArduinoAPI/auth?signOut")
    .then(response => {
        return response;
    })

    location.reload();
}

function getUserData(){
    
    return fetch("http://localhost/ArduinoAPI/user?getData").then((response) => {
        return response.json();
    }).then((json) => {
        return json;
    }).catch(error => console.error(error));

}

function validateToken(){

    fetch("http://localhost/ArduinoAPI/auth?validate").then((response) => {
        return response.json();
    }).then((json) => {
        // Una vez que ya estan disponible los datos los leemos, para verificar al usuario

        let data = json;
        
        if(data.status) {
            // Enviamos una notificacion al usuario, para que sepa que el token
            // que habia guardado no esta verificado

            const notificacion = new Notify("alert","../assets/icons/alertIcon.png","icon","Navegando como Invitado","","Actualmente está navegando como invitado, incie sesión para poder utilizar todas las funciones","warning");
            
            var _toast = document.getElementById("alert");
            var toast = new bootstrap.Toast(_toast);
                        
            toast.show();

            // Actualizamos los elementos de la web
            const headerText = document.getElementById("headerText");
            const userImage = document.getElementById("userImage");

            headerText.innerText = "Iniciar Sesión";
            headerText.setAttribute('href','https://id.twitch.tv/oauth2/authorize?response_type=token&client_id=ohfa4jx2elff8xkzjaphoxkw70nwds&redirect_uri=http://localhost/ArduinoAPI/web/pages/auth-response.html&scope=user%3Aread%3Aemail');
            // El siguiente atributo decidira si se abre en una pestaña nueva
            //headerText.setAttribute('target','_blank');

            userImage.setAttribute('src','../assets/icons/userIcon.png');
        }else if(data.client_id) {
            // Se ha verificado el token correctamente
            // Recuperamos los datos del usuario

            Promise.resolve(getUserData()).then(userData => {

                if(window.location.pathname == "/ArduinoAPI/web/pages/control-panel"){
                    // Indicamos al usuario, que todo ha ido como deberia
                    const notificacion = new Notify("info",userData.profile_image_url,"userImage","Tu perfil ha sido cargado correctamente!","","Se han recuperado tus datos satisfactoriamente!","info");
                                                
                    var not = document.getElementById("info");
                    var toast = new bootstrap.Toast(not);

                    toast.show();
                }
                
                // Con los datos del usuario, actualizamos algunos elementos de la web con su informacion
                const userImage = document.getElementById("userImage");
                const headerText = document.getElementById("headerText");

                userImage.setAttribute("src",userData.profile_image_url);
                headerText.innerText = "Cerrar Sesión";
                headerText.addEventListener("click", signOut, false);

                if(window.location.pathname == "/ArduinoAPI/web/pages/control-panel"){
                    // Ahora actualizamos la información del token (Es decir, el apartado Token)
                    const tokenDescription = document.getElementById("token-desc");
                                    
                    tokenDescription.innerText = "";

                    Object.keys(data).forEach(e => {
                        tokenDescription.innerHTML += "<strong>"+e+"</strong>"+": "+data[e]+"<br>";
                    });
                }
            })
        }
    }).catch(error => console.error(error));

}

function getStream(token) {
    
    fetch("http://localhost/ArduinoAPI/stream?getData").then((response) => {
        return response.json();
    }).then((streamData) => {

        if(Object.keys(streamData["data"]).length > 0){
            if(window.location.pathname == "/ArduinoAPI/web/pages/control-panel"){
                // Ahora actualizamos la información del token (Es decir, el apartado Token)
                const streamDescription = document.getElementById("stream-desc");
                                
                streamDescription.innerText = "";

                Object.keys(streamData["data"][0]).forEach(e => {
                    streamDescription.innerHTML += "<strong>"+e+"</strong>"+": "+streamData["data"][0][e]+"<br>";
                });
            }
        }else{
            if(window.location.pathname == "/ArduinoAPI/web/pages/control-panel"){
                // Indicamos al usuario, que no tiene una retransmisión activa
                const notificacion = new Notify("warning","../assets/icons/streamIcon.png","userImage","No estás en Directo","","No se ha iniciado stream, prueba a iniciar una retransmisión","warning");
                                            
                var not = document.getElementById("warning");
                var toast = new bootstrap.Toast(not);

                toast.show();
            }
        }
        
    }).catch(error => console.error(error));

}

const btn = document.getElementById("btn");
btn.addEventListener("click", signOut, false);

Promise.resolve(validateToken());
Promise.resolve(getStream());