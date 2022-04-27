<?php 

require_once 'clases/config/config.php';
require_once 'clases/auth.class.php';
require_once 'clases/user.class.php';
require_once 'errores.class.php';

class Stream extends config{
    
    public $id;
    public $user_id;
    public $user_login;
    public $user_name;
    public $game_id;
    public $game_name;
    public $type;
    public $title;
    public $viewer_count;
    public $started_at;
    public $language;
    public $thumbnail_url;
    public $tag_ids;
    public $is_mature;

    function __construct(){
        //$this->loadUserDataConfig();
    }

    public function getStreamData(){
        $_auth = new Auth;
        $_user = new User;
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.twitch.tv/helix/streams?user_id='.$_user->id,
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
            'Client-Id: '.$_auth->clientId,
        ),
        ));

        $response = json_decode(curl_exec($curl));
        $this->saveUserDataConfig($response);

        curl_close($curl);
        return $response;
    }

    public function getViewersCount(){
        // Obtenemos los datos
        $this->getStreamData();
        // Cargamos los datos en el objeto
        $this->loadUserDataConfig();
        
        return $this->viewer_count;
    }

    private function loadUserDataConfig(){
        $configData = file_get_contents(parent::getUrlStreamDataConfig());
        $jsonConfig = json_decode($configData);
        $_error = new Errores;

        if(isset($jsonConfig->id)){
            $this->id = $jsonConfig->id;
            $this->user_id = $jsonConfig->user_id;
            $this->user_login = $jsonConfig->user_login;
            $this->user_name = $jsonConfig->user_name;
            $this->game_id = $jsonConfig->game_id;
            $this->game_name = $jsonConfig->game_name;
            $this->type = $jsonConfig->type;
            $this->title = $jsonConfig->title;
            $this->viewer_count = $jsonConfig->viewer_count;
            $this->started_at = $jsonConfig->started_at;
            $this->language = $jsonConfig->language;
            $this->thumbnail_url = $jsonConfig->thumbnail_url;
            $this->tag_ids = $jsonConfig->tag_ids;
            $this->is_mature = $jsonConfig->is_mature;
        }else {
            // Como no entra en el IF tampoco va encontrar los demás valores
            return $_error->error_406("Config File Corrupt");
        }
    }

    private function saveUserDataConfig($tempConfig){
        if(isset($jsonConfig->id)){
            $json_Config = json_encode($tempConfig->data[0]);
            file_put_contents(parent::getUrlStreamDataConfig(),$json_Config);
        }else{
            $tempConfig = array(
                "id"=> "",
                "user_id"=> "",
                "user_login"=> "",
                "user_name" => "",
                "game_id" => "",
                "game_name" => "",
                "type" => "",
                "title" => "",
                "viewer_count" => 0,
                "started_at" => "",
                "language" => "",
                "thumbnail_url" => "",
                "tag_ids" => "",
                "is_mature" => ""
            );
            $json_Config = json_encode($tempConfig);
            file_put_contents(parent::getUrlStreamDataConfig(),$json_Config);
        }
        
    }
}

?>