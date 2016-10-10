<?php 

namespace AppBundle\services;

/**
* 
*/
class Helpers 
{
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

		$normalizer = new \Symfony\Component\Serializer\Normalizer\ObjectNormalizer();
		$normalizer->setCircularReferenceHandler(function ($object) {
		    return $object->getId();
		});
		$encoders =  new \Symfony\Component\Serializer\Encoder\JsonEncoder();
		
		$serializer = new \Symfony\Component\Serializer\Serializer(array($normalizer), array($encoders));
		$json = $serializer->serialize($data, 'json');
		
		$response = new \Symfony\Component\HttpFoundation\Response();
		$response->setContent($json);
		$response->headers->set("Content-Type", "application/json");
		
		return $response;
	}
}
