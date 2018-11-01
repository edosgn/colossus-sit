<?php
namespace Repository\UsuarioBundle\services;

class Helpers {
	public $jwt_auth;
	
	public function __construct($jwt_auth) {
		$this->jwt_auth = $jwt_auth;
	}

	public function authCheck($hash, $getIdentity = null){
		$jwt_auth = $this->jwt_auth;
		$auth=false;
		if ($hash!=null) {
			if ($getIdentity == false) {
				$check_Token = $jwt_auth->checkToken($hash);
				if ($check_Token == true) {
					$auth = true;
				}
			}else{
				$check_Token = $jwt_auth->checkToken($hash , true);
				if (is_object($check_Token)) {
					$auth = $check_Token;
				}
			}
		}

		return $auth;
	}

	public function json($data){
        $normalizers = array(new \Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer());
        $encoders = array("json" => new \Symfony\Component\Serializer\Encoder\JsonEncoder());
        
        $serializer = new \Symfony\Component\Serializer\Serializer($normalizers, $encoders);
        $json = $serializer->serialize($data, 'json');
        
        $response = new \Symfony\Component\HttpFoundation\Response();
        $response->setContent($json);
        $response->headers->set("Content-Type", "application/json");
        
        return $response;
    }	
}