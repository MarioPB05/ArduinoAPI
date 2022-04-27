<?php 

require_once 'clases/stream.class.php';
require_once 'clases/errores.class.php';

$_stream = new Stream;
$_errores = new Errores;

if($_SERVER['REQUEST_METHOD'] == "GET"){

    if(isset($_GET["getData"])) {
        $response = $_stream->getStreamData();

        if(isset($response)){
            header('Content-Type: application/json');
            echo json_encode($response);  
        }
    }else if(isset($_GET["viewers"])) {
        $response = $_stream->getViewersCount();

        if(isset($response)){
            header('Content-Type: application/json');
            echo json_encode($response);  
        }
    }

}

?>