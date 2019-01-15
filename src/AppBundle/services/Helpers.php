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

	public function comparendoState($params){
		$em = $this->em;

		//Valida si el comparendo esta en proceso de anulación
        if ($params->comparendo->anulado) {
            //En proceso de anulación
			$estado = $em->getRepository('AppBundle:CfgComparendoEstado')->find(
	            13
	        );
        }else{
			//Pendiente
			$estado = $em->getRepository('AppBundle:CfgComparendoEstado')->find(
	            1
	        );

			if (!$params->infractor->identificacion || !$params->comparendo->idInfraccion) {
				//Inhibitorio
	            $estado = $em->getRepository('AppBundle:CfgComparendoEstado')->find(
	                6
	            );
	        }
        }


        /*$fecha = $params->comparendo->fecha." ".$params->comparendo->horas.':'.$params->comparendo->minutos.':00';

        $fechaInicio = '2002-01-01 00:00:00';
        $fechaFin = '2017-07-13 23:59:00';
		$caducidad = $this->checkRangeDates($fechaInicio, $fechaFin, $fecha, 6);

		if ($caducidad) {
			//Caducidad
			$estado = $em->getRepository('AppBundle:CfgComparendoEstado')->find(
                7
            );
		}

		$fechaInicio = '2017-07-14 00:00:00';
        $fechaFin = date('Y-m-d h:i:s');
		$caducidad = $this->checkRangeDates($fechaInicio, $fechaFin, $fecha, 12);

		if ($caducidad) {
			//Caducidad
			$estado = $em->getRepository('AppBundle:CfgComparendoEstado')->find(
                7
            );
		}*/
	   
	    return $estado;
	}

	protected function checkRangeDates($fechaInicio, $fechaFin, $fecha, $meses){
		$fechaInicio = strtotime($fechaInicio);
		$fechaFin = strtotime($fechaFin);
		$fecha = strtotime($fecha);

		if(($fecha >= $fechaInicio) && ($fecha <= $fechaFin)) {
			$fechaComparendo = new DateTime($fecha);
			$fechaActual = new DateTime(date('Y-m-d h:i:s'));
			$interval = $fechaComparendo->diff($fechaActual);

			if ($interval->format('m') > $meses) {
				return true;
			}else {
				return false;
			}
		}else {
			return false;
		}
	}
}
