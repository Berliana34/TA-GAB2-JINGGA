<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . "libraries/Server.php";

require APPPATH . 'libraries/JWT.php';
require APPPATH . 'libraries/ExpiredException.php';
require APPPATH . 'libraries/BeforeValidException.php';
require APPPATH . 'libraries/SignatureInvalidException.php';
require APPPATH . 'libraries/JWK.php';

use \Firebase\JWT\JWT;

class Token extends Server
{
    function configToken()
    {
        $config['exp'] = 3600; //detik
        $config['key'] = 'key-jwt';
        return $config;
    }

    public function authtoken(){        
        $authHeader = $this->input->request_headers()['Authorization'];  
        $arr = explode(" ", $authHeader); 
        $token = $arr[1];        
        if ($token){
            try{
                $decoded = JWT::decode($token, $this->configToken()['key'], array('HS256'));          
                if ($decoded){
                    return 1;
                }
            } catch (\Exception $e) {                
                return 0;
                
            }
        }       
    }


    //buat fungsi "POST"
    function service_post()
    {
        date_default_timezone_set("Asia/Jakarta");        
        $exp = $this->configToken()['exp']+time();
        $token = array(           
            "exp" => $exp,                          
        );

        $jwt = JWT::encode($token, $this->configToken()['key'],'HS256');        
        $data = array('token' => $jwt, 'exp' => date("d/m/Y H:i",$exp));
        $this->response($data, 200);
    }    
}
