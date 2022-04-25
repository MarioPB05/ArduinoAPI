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

function getToken() {

    // Funcion que consume nuestra API, que le devolvera el token que debe utilizar

    return fetch("../../clases/config/config.json")
    .then(response => {
        return response.json();
    })
    .then((jsondata) => {
        return jsondata.token;
    });
}

function getClientId() {

    // Funcion que consume nuestra API, que le devolvera el clientId que debe utilizar

    return fetch("../../clases/config/config.json")
    .then(response => {
        return response.json();
    })
    .then((jsondata) => {
        return jsondata.clientId;
    });
}

function getUserData(token) {

    // Funcion que obtiene todos los datos del usuario a partir del token

    // Establecemos el header de la peticion, que contendra el token (Ya que este es pedido por la documentacion de Twitch)
    const myHeaders = new Headers({
        'Authorization': 'Bearer '+token,
        'Client-Id': 'ohfa4jx2elff8xkzjaphoxkw70nwds'
    });

    return fetch("https://api.twitch.tv/helix/users", {
        headers: myHeaders
    })
    .then((response) => {
        // Obtenemos los resultados y los codificamos en un json, para trabajar mejor

        return response.json();    
    }).then((json) => {
        return json;
    }).catch(error => console.error(error));
}

function validateToken(token) {

    // Establecemos el header de la peticion, que contendra el token que verificaremos para saber
    // si el usuario esta o no logueado con nuestra API
    let data = {};
    const myHeaders = new Headers({
        'Authorization': 'OAuth '+token
    });

    fetch("https://id.twitch.tv/oauth2/validate", {
        headers: myHeaders
    })
    .then((response) => {
        // Obtenemos los resultados y los codificamos en un json, para trabajar mejor

        return response.json();    
    }).then((json) => {
        // Una vez que ya estan disponible los datos los leemos, para verificar al usuario

        data = json;
        
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

            Promise.resolve(getUserData(token)).then(userData => {

                // Indicamos al usuario, que todo ha ido como deberia
                const notificacion = new Notify("info",userData.data[0].profile_image_url,"userImage","Tu perfil ha sido cargado correctamente!","","Se han recuperado tus datos satisfactoriamente!","info");
                            
                var not = document.getElementById("info");
                var toast = new bootstrap.Toast(not);

                toast.show();

                // Con los datos del usuario, actualizamos algunos elementos de la web con su informacion
                const userImage = document.getElementById("userImage");
                const headerText = document.getElementById("headerText");

                userImage.setAttribute("src",userData.data[0].profile_image_url);
                headerText.innerText = "Cerrar Sesión";
                headerText.addEventListener("click", signOut, false);

                // Ahora actualizamos la información del token (Es decir, el apartado Token)
                const tokenDescription = document.getElementById("token-desc");
                
                tokenDescription.innerText = "";
                
                Object.keys(data).forEach(e => {
                    tokenDescription.innerHTML += "<strong>"+e+"</strong>"+": "+data[e]+"<br>";
                });
            })
        }
    }).catch(error => console.error(error));
}

function getStream(token) {

    Promise.resolve(getClientId().then(clientId => {
        const myHeaders = new Headers({
            'Authorization': 'Bearer '+token,
            'Client-Id': clientId
        });
        
        Promise.resolve(getUserData(token)).then(userData => {
            return fetch("https://api.twitch.tv/helix/streams?user_id="+userData["data"][0].id, {
                headers: myHeaders
            }).then(response => {return response.json()}).then(stream => {
                console.log(stream);
            });
        });
    }));
}

const btn = document.getElementById("btn");
btn.addEventListener("click", signOut, false);

Promise.resolve(getToken()).then(token => validateToken(token));
Promise.resolve(getToken()).then(token => getStream(token));