<?php

require_once 'clases/config/config.php';
require_once 'errores.class.php';

class Auth extends config{

    private $clientId = "";
    private $clientSecret = "";
    private $token = "";
    private $listScopes = "";
    private $csrf = "421aa90e079fa326b6494f812ad13e79";

    function __construct(){
        $this->loadConfiguration();
    }

    private function loadConfiguration(){
        $configData = file_get_contents("clases/config/config.json");
        $jsonConfig = json_decode($configData);
        $_error = new Errores;

        //print_r($jsonConfig->clientId);

        if(isset($jsonConfig->clientId)){
            $this->clientId = $jsonConfig->clientId;
            if(isset($jsonConfig->clientSecret)){
                $this->clientSecret = $jsonConfig->clientSecret;
                if(isset($jsonConfig->token)){
                    $this->token = $jsonConfig->token;
                }else {
                    return $_error->error_406("No se encontró el token en la configuración");
                }
            }else {
                return $_error->error_406("No se encontró el clientSecret en la configuración");
            }
        }else {
            // Como no entra en el IF tampoco va encontrar los demás valores
            return $_error->error_406("No se encontró el clientId en la configuración (Configuración incorrecta)");
        }
    }
    
    private function saveConfiguration(){
        $tempConfig = array("clientId"=> $this->clientId,"clientSecret"=> $this->clientSecret,"token"=> $this->token);
        $json_Config = json_encode($tempConfig);
        file_put_contents(parent::getUrlConfig(),$json_Config);
    }

    public function loadScopes(){
        $configData = file_get_contents("clases/config/scopes.json");
        $jsonScopes = json_decode($configData);

        foreach ($jsonScopes as $scope) {
            $this->listScopes .= $scope;
        }
    }

    public function setToken($newToken){
        $this->token = $newToken;
        $this->saveConfiguration();
    }

    public function getToken(){
        return $this->token;
    }
    
    public function signOut(){
        $this->token = "";
        $this->saveConfiguration();
    }

    // Codigo remplazado

    /* public function getNewToken(){

        $ch = curl_init("https://id.twitch.tv/oauth2/authorize");
        # Setup request to send json via POST.
        $payload = json_encode(array("client_id"=> $this->clientId, "client_secret"=> $this->clientSecret, "grant_type"=> "client_credentials"));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        # Setup a insecure connection (Localhost dosen't have SSL)
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'response_type: token',
            'client_id: '.$this->clientId,
            'redirect_uri: http://localhost/ArduinoAPI/auth-response.php',
            'scope: '.$this->listScopes
        ));
        # Return response instead of printing.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        # Send request.
        $result = json_decode(curl_exec($ch));
        print_r(curl_exec($ch));

        if(!isset($result->status)){
            $this->token = $result->acess_token;
            $this->saveConfiguration();
        }
        

        $error = curl_error($ch);
        print_r($error);
        curl_close($ch);
    } */

    // public function verifyToken(){
    //     // abrimos la sesión cURL
    //     $ch = curl_init();
    //     // definimos la URL a la que hacemos la petición
    //     curl_setopt($ch, CURLOPT_URL,"https://id.twitch.tv/oauth2/validate");
    //     // definimos cada uno de los parámetros
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    //         'Authorization: OAuth '.$this->token
    //     ));
    
    //     // recibimos la respuesta y la guardamos en una variable
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_HEADER, true);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    //     $response = json_decode(curl_exec($ch),true);
    //     $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    //     $header = substr($response, 0, $header_size);
    //     $body = substr($response, $header_size);
        
    //     print_r($header);
    //     print_r($body);

    //     // Vemos si tenemos errores
    //     $error = json_decode(curl_error($ch));
    //     print_r($error);

    //     // cerramos la sesión cURL
    //     curl_close ($ch);
        
    //     if(isset($error)){
    //         if(isset($error->status)){
    //             if($error->status == 401){
    //                 return $error->message;
    //             }
    //         }
    //     }else{
    //         return $response;
    //     }
    // }

    // public function isSignIn(){
    //     //$result = $this->verifyToken();
    //     if(isset($result->login)){
    //         return "True";
    //     }else{
    //         print_r( $this->verifyToken());
    //         //return "False";
    //     }
    // }
}

?>