<?php 

require_once 'clases/user.class.php';
require_once 'clases/errores.class.php';

$_user = new User;
$_errores = new Errores;

if($_SERVER['REQUEST_METHOD'] == "GET"){

    if(isset($_GET["getData"])) {
        $response = $_user->getUserData();

        if(isset($response)){
            header('Content-Type: application/json');
            echo json_encode($response);  
        }
    }

}

?>