<?php 

class Errores{

    public $response = [
        'status' => "ok",
        "result" => array()
    ];

    public function error_405() {
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "405",
            "error_msg" => "Método no válido"
        );
        return $this->response;
    }

    public function error_406($datos = "Datos no encontrados después de la negociación") {
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "406",
            "error_msg" => $datos
        );
        return $this->response;
    }

    public function error_200($valor = "Datos incorrectos") {
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "200",
            "error_msg" => $valor
        );
        return $this->response;
    }

    public function error_204($valor = "La peticion ha sido aceptada, pero no tiene contenido") {
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "204",
            "error_msg" => $valor
        );
        return $this->response;
    }

    public function error_400() {
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "400",
            "error_msg" => "Datos enviados incompletos o con formato incorrecto"
        );
        return $this->response;
    }

    public function error_401($value ="No autorizado, Token Invalido") {
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "500",
            "error_msg" => $value
        );
        return $this->response;
    }

    public function error_500($value ="Error Interno del servidor") {
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "401",
            "error_msg" => $value
        );
        return $this->response;
    }

}

?>