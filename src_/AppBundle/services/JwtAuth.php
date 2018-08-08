<?php 
namespace AppBundle\services;
use Firebase\JWT\JWT;

/**
* 
*/
class JwtAuth 
{
	public $manager;
	public $key = "clave-secreta";
	
	function __construct($manager)
	{
		$this->manager = $manager;
	}

	public function singUp($email , $password , $getHash = null)
	{
		$key = $this->key;

		$user = $this->manager->getRepository('UsuarioBundle:Usuario')->findOneBy(

			array(
					"correo" => $email,
					"password" => $password

				)

			);
		$singup = false;
		if (is_object($user)) {
			$singup = true;
		}

		if ($singup==true) {

			$token = array(
				"sub" => $user->getId(),
				"correo" => $user->getCorreo(),
				"primerNombre" => $user->getPrimerNombre(),
				"segundoNombre" => $user->getSegundoNombre(),
				"primerApellido" => $user->getPrimerApellido(),
				"segundoApellido" => $user->getSegundoApellido(),
				"identificacion" => $user->getIdentificacion(),
				"ciudadano" => $user->getCiudadano(),
				"foto" => $user->getFoto(),
				"telefono" => $user->getTelefono(),
				"fechanacimiento" => $user->getFechaNacimiento(),
				"estado" => $user->getEstado(),
				"fechanacimiento" => $user->getFechaNacimiento(),
				"role" => $user->getRole(),
				"created" => $user->getCreatedAt(),
				"updated" => $user->getUpdatedAt(),
				"iat" => time(),
				"exp" => time() + (7*24*60*60)
			);
		$jwt=JWT::encode($token , $key , 'HS256');
		$decoded = JWT::decode($jwt, $key, array('HS256'));

		if ($getHash!=null ) {
			return $jwt;
		}else{
			return $decoded;
		}

			
		}else{
			return array("status" => "error" , "data" =>"Login incorrecto");
		}



	}

	public function checkToken($jwt, $getIdentity = false){
		$key = $this->key;
		$auth = false;
		
		try{
			$decoded = JWT::decode($jwt, $key, array('HS256'));
			
		}catch(\UnexpectedValueException $e){
			$auth = false;
		}catch(\DomainException $e){
			$auth = false;
		}
		
		if(isset($decoded->sub)){
			$auth = true;
		}else{
			$auth = false;
		}
		
		if($getIdentity == true){
			return $decoded;
		}else{
			return $auth;
		}
	}
}