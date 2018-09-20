<?php 

namespace AppBundle\services;

use Doctrine\ORM\EntityManager;

/**
* 
*/
class Helpers 
{
	public $jwt_auth;
	protected $em;
	
	public function __construct($jwt_auth, EntityManager $em) {
		$this->jwt_auth = $jwt_auth;
		$this->em = $em;
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

	public function calculateAge($fechaNacimiento){
		$fechaNacimiento = new \DateTime($fechaNacimiento);
	    $fechaActual = new \DateTime();
	    $edad = $fechaActual->diff($fechaNacimiento);

	    return $edad->y;
	}

	public function comparendoState($params,$comparendo){
 
		$em = $this->em;

		if ($params->comparendo->ciudadanoId) {
            $infractor = $em->getRepository('AppBundle:Ciudadano')->find(
                $params->comparendo->ciudadanoId
            );
            $comparendo->setCiudadanoInfractor($infractor);

            $estado = $em->getRepository('AppBundle:CfgComparendoEstado')->findOneByNombre(
                'Inhibitorio'
            );
        }

        $fecha = $params->comparendo->fecha." ".$params->comparendo->hora;

        $fechaInicio = '2002-01-01 00:00:00';
        $fechaFin = '2017-07-13 23:59:00';
		$caducidad = $this->checkRangeDates($fechaInicio, $fechaFin, $fecha);

		if ($caducidad) {
			$estado = $em->getRepository('AppBundle:CfgComparendoEstado')->findOneByNombre(
                'Caducidad'
            );
		}

		$fechaInicio = '2017-07-14 00:00:00';
        $fechaFin = date('Y-m-d h:i:s');
		$caducidad = $this->checkRangeDates($fechaInicio, $fechaFin, $fecha);

		if ($caducidad) {
			$estado = $em->getRepository('AppBundle:CfgComparendoEstado')->findOneByNombre(
                'Caducidad'
            );
		}
	   
	    return $estado;
	}

	protected function checkRangeDates($fechaInicio, $fechaFin, $fecha){
		$fechaInicio = strtotime($fechaInicio);
		$fechaFin = strtotime($fechaFin);
		$fecha = strtotime($fecha);

		if(($fecha >= $fechaInicio) && ($fecha <= $fechaFin)) {
			return true;
		}else {
			return false;
		}
	}
}
