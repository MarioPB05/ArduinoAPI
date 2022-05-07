<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayuda</title>
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
    <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../assets/icons/icon.ico" type="image/x-icon">
</head>
<body style="height: 100vh;">
    <!-- Barra Superior (Header) -->
    <?php include 'components/navbar.php' ?>
    
    <!-- Contenedor Principal de la Web -->
    <div class="container-fluid">
        <!-- 96.01vh  -->
        <div class="row" style="height: 92vh;">

            <!-- Barra lateral de Acciones Rápidas -->
            <?php include 'components/fastActions.php' ?>

            <main class="col-md- ms-sm-auto col">
            
            <!-- Contenedor que tendrá todo el contenido de la página -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

                <h1 class="h2">Ayuda</h1>

                <!-- Utilidades Rápidas -->
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#depuracionModal">
                        Modo Depuración
                    </button>
                </div>

                <!-- Modal Modo Depuración -->
                <div class="modal fade" id="depuracionModal" tabindex="-1" aria-labelledby="depuracionModal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modo Depuración</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Si quieres ver lo que está realizando en todo momento Arduino, puedes conectarlo através de su USB, y en el monitor serial encontrarás toda la información de las acciones que está realizando Arduino en ese momento. En el monitor serial encontrarás principalmente cuatro tipos de mensajes:</p>
                                <ol class="list-group list-group-numbered">
                                    <li class="list-group-item list-group-item-primary"><strong>Info</strong>: Este tipo de mensajes nos avisan de la ejecución de una tarea de manera exitosa</li>
                                    <li class="list-group-item list-group-item-warning"><strong>Warning</strong>: Este tipo de mensajes nos avisan de tareas que tienen varios avisos (Tareas que no se han podido ejecutar, pero no influyen en el rendimiento normal del programa)</li>
                                    <li class="list-group-item list-group-item-danger"><strong>Error</strong>: Este tipo de mensajes nos avisan de tareas que no se han podido ejecutar, y son críticas para el funcionamiento normal del programa</li>
                                    <li class="list-group-item list-group-item-success"><strong>Mensajes del módulo Wifi</strong>: Estos mensajes los envía el propio módulo Wifi, son variados y cambian según la tarea que se esté realizando</li>
                                </ol>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-row bd-highlight justify-content-center align-items-center mb-3">
                <div class="card" style="width: 18rem;">
                    <img src="../assets/images/error001Card.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Error 001</h5>
                        <p class="card-text">No hay ninguna sesión inciada, o valida, en la API</p>
                        <a href="https://id.twitch.tv/oauth2/authorize?response_type=token&client_id=ohfa4jx2elff8xkzjaphoxkw70nwds&redirect_uri=http://localhost/ArduinoAPI/web/pages/auth-response.html&scope=user%3Aread%3Aemail" class="btn btn-primary">Iniciar Sesión</a>
                    </div>
                </div>
                
                <div class="card ms-4" style="width: 18rem;">
                    <img src="../assets/images/error002Card.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Error 002</h5>
                        <p class="card-text">El módulo no se ha podido conectar al servidor</p>
                        <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#error002Modal">Ver Causas</a>
                    </div>
                </div>

                <!-- Modal Error 002 -->
                <div class="modal fade" id="error002Modal" tabindex="-1" aria-labelledby="error002Modal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Posibles Causas del Error 002</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <ol class="list-group list-group-numbered">
                                    <li class="list-group-item">El servidor web de la API no está en funcionamiento</li>
                                    <li class="list-group-item">El modulo wifi se configuró de manera errónea</li>
                                    <li class="list-group-item">El firewall está bloqueando la conexión de arduino con la API, tenga abierto el puerto 80</li>
                                </ol>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card ms-4" style="width: 18rem;">
                    <img src="../assets/images/error003Card.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Error 003</h5>
                        <p class="card-text">El módulo wifi conectado a Arduino no está operativo</p>
                        <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#error003Modal">Mostrar Detalles</a>
                    </div>
                </div>
                
                <!-- Modal Error 003 -->
                <div class="modal fade" id="error003Modal" tabindex="-1" aria-labelledby="error003Modal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Error 003</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h6>Posibles Causas:</h6>
                                <ol class="list-group list-group-numbered">
                                    <li class="list-group-item">El módulo no está bien conectado a arduino</li>
                                    <li class="list-group-item">No le llega la corriente, o la suficiente</li>
                                </ol>
                                <h6 class="mt-4">Posibles Soluciones:</h6>
                                <p>Desconecta el pin <strong>GND</strong> del módulo wifi, espera unos segundos y vuelve a conectarlo.</p>
                                <p>Revisa el <strong><a href="../assets/images/esquemaConexionWifi.png" target="_blank">esquema</a></strong> de conexión del módulo wifi</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="../js/control-panel.js" type="module"></script>
</body>
</html>