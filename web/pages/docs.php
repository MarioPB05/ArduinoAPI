<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arduino API</title>
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

                <h1 class="h2">Documentación</h1>
                
            </div>

            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        /auth
                    </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" aria-expanded="false" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="list-group">
                            <div class="list-group-item" aria-current="true">
                                <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1 fw-bold">?validate</h6>
                                <small class="text-muted">GET</small>
                                </div>
                                <p class="mb-1">Valida si hay un token, en el caso de que el token sea válido, retorna la información de ese token</p>
                            </div>

                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1 fw-bold">?validateArduino</h6>
                                <small class="text-muted">GET</small>
                                </div>
                                <p class="mb-1">Retorna "true" si el token que dispone la API es válido para utilizarse, si no lo es, retorna "false"</p>
                            </div>

                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1 fw-bold">?signOut</h6>
                                <small class="text-muted">GET</small>
                                </div>
                                <p class="mb-1">Cierra la sesión del usuario</p>
                            </div>

                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                  <h6 class="mb-1 fw-bold">?function=setToken&token=""</h6>
                                  <small class="text-muted">POST</small>
                                </div>
                                <p class="mb-1">Establece el token que utilizará la API</p>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        /user
                    </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="list-group">
                            <div class="list-group-item" aria-current="true">
                                <div class="d-flex w-100 justify-content-between">
                                  <h6 class="mb-1 fw-bold">?getData</h6>
                                  <small class="text-muted">GET</small>
                                </div>
                                <p class="mb-1">Retorna toda la información del usuario logueado en la API</p>
                            </div>

                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1 fw-bold">?getName</h6>
                                    <small class="text-muted">GET</small>
                                </div>
                                <p class="mb-1">Retorna el nombre del usuario logueado en la API</p>
                            </div>

                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1 fw-bold">?getLastFollower</h6>
                                    <small class="text-muted">GET</small>
                                </div>
                                <p class="mb-1">Retorna el nombre del último seguidor del usuario logueado en la API</p>
                            </div>

                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1 fw-bold">?getFollowerCount</h6>
                                    <small class="text-muted">GET</small>
                                </div>
                                <p class="mb-1">Retorna la cantidad de seguidores del usuario logueado en la API</p>
                            </div>

                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1 fw-bold">?getLastSubscriber</h6>
                                    <small class="text-muted">GET</small>
                                </div>
                                <p class="mb-1">Retorna el nombre del último suscriptor del usuario logueado en la API</p>
                            </div>

                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1 fw-bold">?getSubscriberCount</h6>
                                    <small class="text-muted">GET</small>
                                </div>
                                <p class="mb-1">Retorna la cantidad de suscriptores del usuario logueado en la API</p>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        /stream
                    </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="list-group">
                            <div class="list-group-item" aria-current="true">
                                <div class="d-flex w-100 justify-content-between">
                                  <h6 class="mb-1 fw-bold">?getData</h6>
                                  <small class="text-muted">GET</small>
                                </div>
                                <p class="mb-1">Retorna toda la información sobre la retransmisión del usuario</p>
                            </div>

                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1 fw-bold">?viewers</h6>
                                    <small class="text-muted">GET</small>
                                </div>
                                <p class="mb-1">Retorna el número de espectadores actuales de la retransmisión del usuario</p>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            
            <div id="toastContainer" class="toast-container position-absolute bottom-0 end-0 m-2">
            
                <!-- Plantilla para Notificaciones -->
                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <img src="../assets/icons/bookIcon.png" class="rounded me-2" alt="...">
                        <strong class="me-auto">Bootstrap</strong>
                        <small class="text-muted">just now</small>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        See? Just like this.
                    </div>
                </div>

                <!-- A partir de esta línea se van agregando las demás notificaciones -->
            
            </div>
            

        </div>
    </div>

</body>
</html>