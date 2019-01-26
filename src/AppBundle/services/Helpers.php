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

	public function convertDateTime($fecha){
        $fechaArray = explode("/", $fecha);
        
        $fecha = (new \DateTime($fechaArray[2].'-'.$fechaArray[1].'-'.$fechaArray[0]));

        return $fecha; 
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

	public function comparendoStateAutomatic($comparendo){
		$em = $this->em;

		$diasHabiles = $this->getDiasHabiles($comparendo->getFecha());

		//Valida si el comparendo esta en proceso de anulación
        if ($comparendo->getEstado()->getId() == 13) {
            //En proceso de anulación
			$estado = $em->getRepository('AppBundle:CfgComparendoEstado')->find(
	            13
	        );
        }else{
        	//Valida que el comparendo este Pendiente
			if ($comparendo->getEstado()->getId() == 1) {
	        	if (!$comparendo->getAudiencia()) {
	        		
	        	}
			}

			//Pendiente
			$estado = $em->getRepository('AppBundle:CfgComparendoEstado')->find(
	            1
	        );

			if (!$comparendo->getInfractorIdentificacion() || !$comparendo->getInfraccion()) {
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
	   
	    return array(
	    	'estado' => $estado, 
	    	'diasHabiles' => $diasHabiles, 
	    	'comparendo' => $comparendo
	    );
	}

	public function checkRangeDates($fechaComparendo){
		$fechaComparendo = $this->convertDateTime($fechaComparendo);

		$fechaInicio = new \Datetime('2002-01-01');
        $fechaFin = new \Datetime('2017-07-13');

        if ($fechaComparendo > $fechaInicio && $fechaComparendo < $fechaFin) {
        	$diasHabiles = $this->getDiasHabiles($fechaComparendo->format('d/m/Y'));

        	if ($diasHabiles > 180) {
        		return true;
        	}
        }else{
			$fechaInicio = new \Datetime('2017-07-14');
	        $fechaFin = new \Datetime(date('Y-m-d'));

	        if ($fechaComparendo > $fechaInicio && $fechaComparendo < $fechaFin) {
	        	$diasHabiles = $this->getDiasHabiles($fechaComparendo->format('d/m/Y'));

	        	if ($diasHabiles > 365) {
	        		return true;
	        	}
	        }else{
	        	return false;
	        }
        }
	}

	public function getDiasHabiles($fechaComparendo)
	{
		$fechaComparendo = $this->convertDateTime($fechaComparendo);
		$fechaActual = new \Datetime(date('Y-m-d'));

		$diasHabiles = 1;

		$em = $this->em;

		$festivos = $em->getRepository('AppBundle:CfgFestivo')->findByActivo(true);

		if ($festivos) {
			foreach ($festivos as $key => $value) {
				$diasNoLaborales[] = $value->getFecha()->format('j-n');
			}

			while ($fechaComparendo < $fechaActual) {
				if ($fechaComparendo->format('w') != 0 and $fechaComparendo->format('w') != 6 and (in_array($fechaComparendo->format('j-n'),$diasNoLaborales)) == FALSE) {
					$diasHabiles ++;
				}

				$fechaComparendo->modify('+1 days');
			}
		}else{
			while ($fechaComparendo < $fechaActual) {
				if ($fechaComparendo->format('w') != 0 and $fechaComparendo->format('w') != 6) {
					$diasHabiles ++;
				}

				$fechaComparendo->modify('+1 days');
			}
		}

		return $diasHabiles; 
	}

	public function createTemplate($template, $replaces)
    {
        foreach ($replaces as $key => $comodin) {
          $template = str_replace($comodin->id, $comodin->value, $template);
        }

        return $template; 
    }
}
