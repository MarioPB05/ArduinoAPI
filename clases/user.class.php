<?php 

require_once 'clases/config/config.php';
require_once 'clases/auth.class.php';
require_once 'errores.class.php';

class User extends config{

    public $id = "";
    public $login = "";
    public $display_name = "";
    public $type = "";
    public $brodcaster_type = "";
    public $description = "";
    public $profile_image_url = "";
    public $offline_image_url = "";
    public $view_count = "";
    public $email = "";
    public $created_at = ""; 

    function __construct(){
        $this->loadUserDataConfig();
    }

    public function getUserData(){
        $_auth = new Auth;
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.twitch.tv/helix/users',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$_auth->token,
            'Client-Id: '.$_auth->clientId
        ),
        ));

        $response = json_decode(curl_exec($curl));

        // Guardamos los datos del usuario
        $this->saveUserDataConfig($response->data[0]);

        curl_close($curl);
        return $response->data[0];
    }

    public function getLastFollower() {
        $_auth = new Auth;
        $_user = new User;
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.twitch.tv/helix/users/follows?to_id='.$_user->id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$_auth->token,
            'Client-Id: '.$_auth->clientId
        ),
        ));

        $response = json_decode(curl_exec($curl));

        curl_close($curl);
        return $response->data[0]->from_name;
    }

    public function getDisplayName() {
        return $this->getUserData()->display_name;
    }

    private function loadUserDataConfig(){
        $configData = file_get_contents(parent::getUrlUserDataConfig());
        $jsonConfig = json_decode($configData);
        $_error = new Errores;

        if(isset($jsonConfig->id)){
            $this->id = $jsonConfig->id;
            $this->login = $jsonConfig->login;
            $this->display_name = $jsonConfig->display_name;
            $this->broadcaster_type = $jsonConfig->broadcaster_type;
            $this->description = $jsonConfig->description;
            $this->profile_image_url = $jsonConfig->profile_image_url;
            $this->offline_image_url = $jsonConfig->offline_image_url;
            $this->view_count = $jsonConfig->view_count;
            $this->email = $jsonConfig->email;
            $this->created_at = $jsonConfig->created_at;
        }else {
            // Como no entra en el IF tampoco va encontrar los demás valores
            return $_error->error_406("Config File Corrupt");
        }
    }

    private function saveUserDataConfig($tempConfig){
        //$tempConfig = array("clientId"=> $this->clientId,"clientSecret"=> $this->clientSecret,"token"=> $this->token);
        $json_Config = json_encode($tempConfig);
        file_put_contents(parent::getUrlUserDataConfig(),$json_Config);
    }

    public function reloadData(){
        $this->getUserData();
    }
}

?>