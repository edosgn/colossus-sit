<?php 

namespace AppBundle\services;

use Doctrine\ORM\EntityManager;
use JHWEB\ContravencionalBundle\Entity\CvCdoTrazabilidad;
use JHWEB\ConfigBundle\Entity\CfgAdmActoAdministrativo;

/**
* 
*/
class Helpers 
{
	public $jwt_auth;
	protected $em;
	protected $newDate = array('fecha' => null, 'hora' => null);
	
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
			$estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(
	            13
	        );
        }else{
			//Pendiente
			$estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(
	            1
	        );

			if (!$params->infractor->identificacion || !$params->comparendo->idInfraccion) {
				//Inhibitorio
	            $estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(
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
			$estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(
                7
            );
		}

		$fechaInicio = '2017-07-14 00:00:00';
        $fechaFin = date('Y-m-d h:i:s');
		$caducidad = $this->checkRangeDates($fechaInicio, $fechaFin, $fecha, 12);

		if ($caducidad) {
			//Caducidad
			$estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(
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
			$estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(
	            13
	        );
        }else{
        	//Valida que el comparendo este Pendiente
			if ($comparendo->getEstado()->getId() == 1) {
	        	if (!$comparendo->getAudiencia()) {
	        		
	        	}
			}

			//Pendiente
			$estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(
	            1
	        );

			if (!$comparendo->getInfractorIdentificacion() || !$comparendo->getInfraccion()) {
				//Inhibitorio
	            $estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(
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
			$estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(
                7
            );
		}

		$fechaInicio = '2017-07-14 00:00:00';
        $fechaFin = date('Y-m-d h:i:s');
		$caducidad = $this->checkRangeDates($fechaInicio, $fechaFin, $fecha, 12);

		if ($caducidad) {
			//Caducidad
			$estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(
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

	public function getDiasCalendario($fecha)
	{
		$fecha = $this->convertDateTime($fecha);
		$fechaActual = new \Datetime(date('Y-m-d'));
		
		$diasCalendario = 0;

		$em = $this->em;

		while ($fecha < $fechaActual) {
			$fecha->modify('+1 days');
			$diasCalendario ++;
		}
		
		return $diasCalendario; 
	}

	public function getDiasCalendarioInverse($fecha)
	{
		$fecha = $this->convertDateTime($fecha);
		$fechaActual = new \Datetime(date('Y-m-d'));
		
		$diasCalendario = 0;

		$em = $this->em;

		while ($fechaActual < $fecha) {
			$fechaActual->modify('+1 days');
			$diasCalendario ++;
		}
		
		return $diasCalendario; 
	}

	public function createTemplate($template, $replaces)
    {
        foreach ($replaces as $key => $comodin) {
          $template = str_replace($comodin->id, $comodin->value, $template);
        }

        return $template; 
    }

    public function getDateAudienciaAutomatica($fecha, $hora){
		$em = $this->em;

		$this->getFechaVencimiento($fecha, 31);

		$horario = $em->getRepository('JHWEBContravencionalBundle:CvAuCfgHorario')->findOneByActivo(true);

		$atenciones = $em->getRepository('JHWEBContravencionalBundle:CvAuCfgAtencion')->findByActivo(true);

		$diasAtencion = array();
		if ($atenciones) {
			foreach ($atenciones as $key => $atencion) {
				$diasAtencion[] = $atencion->getDia();
			}
		}
		
		$result = null;

		if ($horario) {
			$audienciaLast = $em->getRepository('JHWEBContravencionalBundle:CvAudiencia')->findOneBy(
				array(
					'activo' => true,
				),
				array(
					'fecha' => 'DESC',
				)
			);

			$horaManianaInicial = new \Datetime($horario->getHoraManianaInicial());

			$result = $this->validateAudienciaAutomatica(
				$fecha, 
				$horaManianaInicial, 
				$audienciaLast, 
				$horario,
				$diasAtencion
			);
		}

		return $result;
	}

	public function validateAudienciaAutomatica($fecha, $hora, $audienciaLast, $horario, $diasAtencion = null){
		if ($fecha->format('w') != 0 and $fecha->format('w') != 6 and (in_array($fecha->format('w'), $diasAtencion)) == FALSE) {
			if ($audienciaLast) {
				$horaManianaInicial = new \Datetime($horario->getHoraManianaInicial());
				if ($fecha >= $audienciaLast->getFecha() and $hora >= $horaManianaInicial){
					$horaTardeFinal = new \Datetime($horario->getHoraTardeFinal());

					if ($hora > $horaTardeFinal) {
						$fecha->modify('+1 days');
						$hora = $horaManianaInicial;
						$this->validateAudienciaAutomatica($fecha, $hora, $audienciaLast, $horario, $diasAtencion);
					}else{
						$horaManianaFinal = new \Datetime($horario->getHoraManianaFinal());
						$horaTardeInicial = new \Datetime($horario->getHoraTardeInicial());

						if(($hora >= $horaManianaInicial and $hora < $horaManianaFinal) or ($hora >= $horaTardeInicial and $hora < $horaTardeFinal)){
							$this->newDate['fecha'] = $fecha;
							$this->newDate['hora'] = $hora;
						}else{
							$hora->modify('+5 minutes');
							$this->validateAudienciaAutomatica($fecha, $hora, $audienciaLast, $horario, $diasAtencion);
						}
					}
				}else{
					if ($fecha >= $audienciaLast->getFecha()){
						$hora->modify('+5 minutes');
						$this->validateAudienciaAutomatica($fecha, $hora, $audienciaLast, $horario, $diasAtencion);
					}else{
						$fecha->modify('+1 days');
						$this->validateAudienciaAutomatica($fecha, $hora, $audienciaLast, $horario, $diasAtencion);
					}
				}
			}else{
				$horaTardeFinal = new \Datetime($horario->getHoraTardeFinal());
				$horaManianaInicial = new \Datetime($horario->getHoraManianaInicial());

				if ($hora > $horaTardeFinal) {
					$fecha->modify('+1 days');
					$hora = $horaManianaInicial;
					$this->validateAudienciaAutomatica($fecha, $hora, $audienciaLast, $horario, $diasAtencion);
				}else{
					$horaManianaFinal = new \Datetime($horario->getHoraManianaFinal());
					$horaTardeInicial = new \Datetime($horario->getHoraTardeInicial());

					if(($hora >= $horaManianaInicial && $hora < $horaManianaFinal) || ($hora >= $horaTardeInicial && $hora < $horaTardeFinal)){
						$this->newDate['fecha'] = $fecha;
						$this->newDate['hora'] = $hora;
					}else{
						$hora->modify('+5 minutes');
						$this->validateAudienciaAutomatica($fecha, $hora, $audienciaLast, $horario, $diasAtencion);
					}
				}
			}
		}else{
			$fecha->modify('+1 days');
			$this->validateAudienciaAutomatica($fecha, $hora, $audienciaLast, $horario, $diasAtencion);
		}
		
		return $this->newDate;
	}

	public function generateTrazabilidad($comparendo, $estado){
        $em = $this->em;

        if ($estado->getActualiza()) {
            $comparendo->setEstado($estado);
            $em->flush();
        }

        $trazabilidadesOld = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findBy(
            array(
                'comparendo' => $comparendo->getId(),
                'activo' => true
            )
        );

        if ($trazabilidadesOld) {
            foreach ($trazabilidadesOld as $key => $trazabilidadOld) {
                $trazabilidadOld->setActivo(false);
                $em->flush();
            }
        }

        $trazabilidad = new CvCdoTrazabilidad();

        $trazabilidad->setFecha(
            new \Datetime(date('Y-m-d'))
        );
        $trazabilidad->setHora(
            new \Datetime(date('h:i:s A'))
        );
        $trazabilidad->setActivo(true);
        $trazabilidad->setComparendo($comparendo);
        $trazabilidad->setEstado($estado);

        if ($estado->getFormato()) {
            $documento = new CfgAdmActoAdministrativo();

            $documento->setNumero(
                $comparendo->getEstado()->getSigla().'-'.$comparendo->getConsecutivo()->getConsecutivo()
            );
            $documento->setFecha(new \Datetime(date('Y-m-d')));
            $documento->setActivo(true);

            $documento->setFormato(
                $comparendo->getEstado()->getFormato()
            );

            $template = $this->generateTemplate($comparendo);
            $documento->setCuerpo($template);

            $em->persist($documento);
            $em->flush();

            $trazabilidad->setActoAdministrativo($documento);
        }

        $em->persist($trazabilidad);
        $em->flush();
    }

    public function generateTemplate($comparendo, $cuerpo){
        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        
        $replaces[] = (object)array('id' => 'NOM', 'value' => $comparendo->getInfractorNombres().' '.$comparendo->getInfractorApellidos()); 
        $replaces[] = (object)array('id' => 'ID', 'value' => $comparendo->getInfractorIdentificacion());
        $replaces[] = (object)array('id' => 'NOC', 'value' => $comparendo->getConsecutivo()->getConsecutivo()); 
        $replaces[] = (object)array('id' => 'FC1', 'value' => $fechaActual);

        if ($comparendo->getInfraccion()) {
            $replaces[] = (object)array('id' => 'DCI', 'value' => $comparendo->getInfraccion()->getDescripcion());
            $replaces[] = (object)array('id' => 'CIC', 'value' => $comparendo->getInfraccion()->getCodigo());
        }

        if ($comparendo->getPlaca()) {
            $replaces[] = (object)array('id' => 'PLACA', 'value' => $comparendo->getPlaca());
        }


        $template = $this->createTemplate(
          $cuerpo,
          $replaces
        );

        $template = str_replace("<br>", "<br/>", $template);

        return $template;
    }

    public function getFechaVencimiento($fechaInicial, $diasSolicitados){
		$em = $this->em;

		$festivos = $em->getRepository('AppBundle:CfgFestivo')->findByActivo(true);
		$diasHabiles = 0;

		if ($festivos) {
		  foreach ($festivos as $key => $value) {
		    $diasNoLaborales[] = $value->getFecha()->format('j-n');
		  }

		  while ($diasHabiles < $diasSolicitados) {
		    if ($fechaInicial->format('w') != 0 and $fechaInicial->format('w') != 6 and (in_array($fechaInicial->format('j-n'),$diasNoLaborales)) == false) {
		      $diasHabiles ++;
		    }

		    if ($diasHabiles < $diasSolicitados) {
		      $fechaInicial->modify('+1 days');
		    }
		  }
		}else{
		  while ($diasHabiles < $diasSolicitados) {
		    if ($fechaInicial->format('w') != 0 and $fechaInicial->format('w') != 6) {
		      $diasHabiles ++;
		    }

		    if ($diasHabiles < $diasSolicitados) {
		      $fechaInicial->modify('+1 days');
		    }
		  }
		}

		$fechaVencimiento = $fechaInicial;

		return $fechaVencimiento; 
	}
}
