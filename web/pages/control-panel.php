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
                <h1 class="h2">Panel de Control</h1>

                <!-- Utilidades Rápidas -->
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                    <span data-feather="calendar"></span>
                    This week
                    </button>
                </div>

                
            </div>

            <!-- Apartado sobre el Token -->
            <div class="accordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <img class="me-3" src="../assets/icons/alertIcon.png" width="24" alt="icon">
                            Estado del Token
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                      <div id="token-desc" class="accordion-body">
                        No se ha encontrado ningún token, o el token es inválido
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

    <script src="../js/control-panel.js" type="module"></script>
</body>
</html>