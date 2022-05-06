<?php

require_once 'clases/auth.class.php';
require_once 'clases/errores.class.php';

$_auth = new Auth;
//$_auth->getNewToken();
//$_auth->isSignIn();

$_errores = new Errores;

if($_SERVER['REQUEST_METHOD'] == "GET"){

    if(isset($_GET["signOut"])) {
        $_auth->signOut();
    }else if(isset($_GET["validate"])) {
        $response = $_auth->validateToken();

        if(isset($response->client_id)){
            header('Content-Type: application/json');
            echo json_encode($response);  
        }
    }else if(isset($_GET["validateArduino"])) {
        $response = $_auth->validateToken();

        if(isset($response->client_id)){
            header('Content-Type: application/json');
            echo json_encode("{true}");  
        }else {
            header('Content-Type: application/json');
            echo json_encode("{false}"); 
        }
    }

}else if($_SERVER['REQUEST_METHOD'] == "POST") {
    if(isset($_GET["function"])) {
        $funcion = $_GET["function"];
        if($funcion == "setToken"){
            if(isset($_GET["token"])){
                $newToken = $_GET["token"];
                $_auth->setToken($newToken);
            }
        }
    }
}
else{
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);  
}
?>
