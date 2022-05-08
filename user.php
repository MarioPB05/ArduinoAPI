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
    }else if(isset($_GET["getName"])) {
        $response = $_user->getDisplayName();

        if(isset($response)){
            header('Content-Type: application/json');
            echo json_encode("{".$response."}");  
        }
    }else if(isset($_GET["getLastFollower"])) {
        $response = $_user->getLastFollower();

        if(isset($response)){
            header('Content-Type: application/json');
            echo json_encode("{".$response."}");  
        }
    }else if(isset($_GET["getFollowerCount"])) {
        $response = $_user->getFollowerCount();

        if(isset($response)){
            header('Content-Type: application/json');
            echo json_encode("{".$response."}");  
        }
    }else if(isset($_GET["getLastSubscriber"])) {
        $response = $_user->getLastSubscriber();

        if(isset($response)){
            header('Content-Type: application/json');
            echo json_encode("{".$response."}");  
        }
    }else if(isset($_GET["getSubscriberCount"])) {
        $response = $_user->getSubscriberCount();

        if(isset($response)){
            header('Content-Type: application/json');
            echo json_encode("{".$response."}");  
        }
    }

}

?>