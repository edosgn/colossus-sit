<?php

namespace AppBundle\services;

use Doctrine\ORM\EntityManager;

class GestionDocumental
{
  protected $em;

  function __construct(EntityManager $em) {
    $this->em = $em;
  }

  public function getDiasHabiles($fechaCreacion,$fechaVencimiento)
  {
    $fechaCreacion = new \Datetime($fechaCreacion);
    $fechaVencimiento = new \Datetime($fechaVencimiento);

    if ($fechaCreacion <= $fechaVencimiento) {
      $fechaInicial = $fechaCreacion;
      $fechaFinal = $fechaVencimiento;
      $estado = 'Vigente';
    }else{
      $fechaInicial = $fechaVencimiento;
      $fechaFinal = $fechaCreacion;
      $estado = 'Vencido';
    }

    $diasHabiles = 1;

    $em = $this->em;

    $festivos = $em->getRepository('AppBundle:Festivo')->findByActivo(true);

    if ($festivos) {
      foreach ($festivos as $key => $value) {
        $diasNoLaborales[] = $value->getFecha()->format('j-n');
      }

      while ($fechaInicial < $fechaFinal) {
        if ($fechaInicial->format('w') != 0 and $fechaInicial->format('w') != 6 and (in_array($fechaInicial->format('j-n'),$diasNoLaborales)) == FALSE) {
          $diasHabiles ++;
        }

        $fechaInicial->modify('+1 days');
      }
    }else{
      while ($fechaInicial < $fechaFinal) {
        if ($fechaInicial->format('w') != 0 and $fechaInicial->format('w') != 6) {
          $diasHabiles ++;
        }

        $fechaInicial->modify('+1 days');
      }
    }


    if ($estado == 'Vencido') {
      $diasHabiles = '-'.$diasHabiles;
    }

    return $diasHabiles; 
  }

  public function fechaVencimiento($fechaInicial, $diasSolicitados)
  {
    $em = $this->em;

    $festivos = $em->getRepository('JHWEBPqrsfBundle:CfgFestivo')->findByActivo(true);
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

  public function createTemplate($template, $trazabilidad)
  {
    setlocale(LC_ALL,"es_ES");
    $fechaActual = strftime("%d de %B del %Y");

    $comodines = array(
      '{ paciente.nombre }',
      '{ paciente.identificacion }',
      '{ acudiente.nombre }',
      '{ acudiente.identificacion }',
      '{ solicitud.tipo }',
      '{ solicitud.origen }',
      '{ solicitud.descripcion }',
      '{ solicitud.causa }',
      '{ solicitud.radicado }',
      '{ solicitud.fechaVencimiento }',
      '{ fechaActual }',
      '{ remitente.nombre }',
      '{ remitente.cargo }'
    );

    $replaces = array(
      $trazabilidad->getSolicitud()->getPaciente()->getNombres()." ".$trazabilidad->getSolicitud()->getPaciente()->getApellidos(),
      $trazabilidad->getSolicitud()->getPaciente()->getIdentificacion(),
      $trazabilidad->getSolicitud()->getAcudiente()->getNombres()." ".$trazabilidad->getSolicitud()->getAcudiente()->getApellidos(),
      $trazabilidad->getSolicitud()->getAcudiente()->getIdentificacion(),
      $trazabilidad->getSolicitud()->getTipo()->getNombre(),
      $trazabilidad->getSolicitud()->getOrigen()->getNombre(),
      $trazabilidad->getSolicitud()->getDescripcion(),
      $trazabilidad->getSolicitud()->getCausa()->getNombre(),
      $trazabilidad->getSolicitud()->getNumeroRadicado(),
      $trazabilidad->getSolicitud()->getFechaVencimientoCoordinador()->format('d/m/Y'),
      $fechaActual
    );

    if ($trazabilidad->getFuncionario()) {
      $remitenteNombre = $trazabilidad->getFuncionario()->getUsuario()->getNombres()." ".$trazabilidad->getFuncionario()->getUsuario()->getApellidos();
      array_push($replaces, $remitenteNombre);
      $remitenteCargo = $trazabilidad->getFuncionario()->getCargo()->getNombre();
      array_push($replaces, $remitenteCargo);
    }else{
      array_push($replaces, '');
      array_push($replaces, '');
    }

    foreach ($comodines as $comodinKey => $comodinValue) {
      $template = str_replace($comodinValue, $replaces[$comodinKey], $template);
    }

    return $template; 
  }
}
