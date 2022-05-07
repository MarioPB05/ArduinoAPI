<?php
    switch ($_SERVER['REQUEST_URI']) {
        case '/ArduinoAPI/web/pages/docs.php':
            echo 'hola';
            break;
        
        default:
            # code...
            break;
    }
    
?>

<div class="d-flex flex-column flex-shrink-0 bg-light" style="width: 4.5rem;">
    <ul class="nav nav-pills nav-flush flex-column mb-auto text-center mt-2">
        <li class="nav-item">
            <?php 
                if($_SERVER['REQUEST_URI'] == '/ArduinoAPI/web/pages/control-panel'){
                    echo '
                    <a href="control-panel" class="nav-link active py-3 border-bottom" aria-current="page" title="Inicio" data-bs-toggle="tooltip" data-bs-placement="right">
                        <img src="../assets/icons/homeIcon.png" alt="Incio" class="bi" role="img" aria-label="Incio" width="24">
                    </a>
                    ';
                }else{
                    echo '
                    <a href="control-panel" class="nav-link py-3 border-bottom" aria-current="page" title="Inicio" data-bs-toggle="tooltip" data-bs-placement="right">
                        <img src="../assets/icons/homeIcon.png" alt="Incio" class="bi" role="img" aria-label="Incio" width="24">
                    </a>
                    ';
                }
            ?>
        </li>

        <li>
            <?php 
                if($_SERVER['REQUEST_URI'] == '/ArduinoAPI/web/pages/docs'){
                    echo '
                    <a href="docs" class="nav-link active py-3 border-bottom" title="Documentación" data-bs-toggle="tooltip" data-bs-placement="right">
                        <img src="../assets/icons/bookIcon.png" alt="Incio" class="bi" role="img" aria-label="Documentación" width="24">
                    </a>
                    ';
                }else{
                    echo '
                    <a href="docs" class="nav-link py-3 border-bottom" title="Documentación" data-bs-toggle="tooltip" data-bs-placement="right">
                        <img src="../assets/icons/bookIcon.png" alt="Incio" class="bi" role="img" aria-label="Documentación" width="24">
                    </a>
                    ';
                }
            ?>
        </li>

        <li>
            <?php 
                if($_SERVER['REQUEST_URI'] == '/ArduinoAPI/web/pages/settings'){
                    echo '
                    <a href="#" class="nav-link active py-3 border-bottom" title="Ajustes" data-bs-toggle="tooltip" data-bs-placement="right">
                        <img src="../assets/icons/settingsIcon.png" alt="Incio" class="bi" role="img" aria-label="Ajustes" width="24">
                    </a>
                    ';
                }else{
                    echo '
                    <a href="#" class="nav-link py-3 border-bottom" title="Ajustes" data-bs-toggle="tooltip" data-bs-placement="right">
                        <img src="../assets/icons/settingsIcon.png" alt="Incio" class="bi" role="img" aria-label="Ajustes" width="24">
                    </a>
                    ';
                }
            ?>
        </li>

        <li>
            <?php 
                if($_SERVER['REQUEST_URI'] == '/ArduinoAPI/web/pages/help'){
                    echo '
                    <a href="help" class="nav-link active py-3 border-bottom" title="Perfil" data-bs-toggle="tooltip" data-bs-placement="right">
                        <img src="../assets/icons/helpIcon.png" alt="Incio" class="bi" role="img" aria-label="Perfil" width="24">
                    </a>
                    ';
                }else{
                    echo '
                    <a href="help" class="nav-link py-3 border-bottom" title="Perfil" data-bs-toggle="tooltip" data-bs-placement="right">
                        <img src="../assets/icons/helpIcon.png" alt="Incio" class="bi" role="img" aria-label="Perfil" width="24">
                    </a>
                    ';
                }
            ?>
            
        </li>
    </ul>

    <!-- Imagen del usuario que al hacer click contiene más acciones rápidas -->
    <div class="dropdown border-top">
        <a href="#" class="d-flex align-items-center justify-content-center p-3 link-dark text-decoration-none dropdown-toggle" id="dropdownUser3" data-bs-toggle="dropdown" aria-expanded="false">
        <img id="userImage" src="https://github.com/mdo.png" alt="mdo" width="24" height="24" class="rounded-circle">
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser3">
            <li><a class="dropdown-item" href="#">Perfil</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a id="btn" class="dropdown-item" style="cursor: pointer;">Cerrar Sesión</a></li>
        </ul>
    </div>
</div>