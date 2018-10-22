<?php

namespace AppBundle\Repository;

/**
 * MpersonalFuncionarioRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MpersonalFuncionarioRepository extends \Doctrine\ORM\EntityRepository
{
	//Obtiene la lista de documentos por peticionario
    public function getSearch($params){   
        $em = $this->getEntityManager();
        if (isset($params->nombre)) { 
        	$dql = "SELECT f
            FROM AppBundle:MpersonalFuncionario f, UsuarioBundle:Usuario u, AppBundle:Ciudadano c
            WHERE u.id = c.usuario
            AND c.id = f.ciudadano
            AND (u.primerNombre = :nombre OR u.segundoNombre = :nombre OR u.primerApellido = :nombre OR u.segundoApellido = :nombre)";

	        $consulta = $em->createQuery($dql);
	        $consulta->setParameters(array(
	            'nombre' => $params->nombre,
	        ));
        }elseif(isset($params->identificacion)){
        	$dql = "SELECT f
            FROM AppBundle:MpersonalFuncionario f, UsuarioBundle:Usuario u, AppBundle:Ciudadano c
            WHERE u.id = c.usuario
            AND c.id = f.ciudadano
            AND u.identificacion = :identificacion";

	        $consulta = $em->createQuery($dql);
	        $consulta->setParameters(array(
	            'identificacion' => $params->identificacion,
	        )); 
        }elseif(isset($params->cargo)){
        	$dql = "SELECT f
            FROM AppBundle:MpersonalFuncionario f, AppBundle:CfgCargo c
            WHERE f.cargo = c.id
            AND c.id = :cargo";

	        $consulta = $em->createQuery($dql);
	        $consulta->setParameters(array(
	            'cargo' => $params->cargo,
	        ));
        }elseif(isset($params->numeroContrato)){
        	$dql = "SELECT f
            FROM AppBundle:MpersonalFuncionario f
            WHERE f.numeroContrato = :numeroContrato";
	        $consulta = $em->createQuery($dql);
	        $consulta->setParameters(array(
	            'numeroContrato' => $params->numeroContrato,
	        ));
        }elseif(isset($params->nombramiento)){
        	$dql = "SELECT f
            FROM AppBundle:MpersonalFuncionario f
            WHERE f.tipoNombramiento = :nombramiento";
	        $consulta = $em->createQuery($dql);
	        $consulta->setParameters(array(
	            'nombramiento' => $params->nombramiento,
	        ));
        }elseif(isset($params->fechaInicio) && isset($params->fechaFin)){
           
        	$dql = "SELECT f
            FROM AppBundle:MpersonalFuncionario f
            WHERE (f.fechaInicio BETWEEN :fechaInicio AND :fechaFin)
            OR (f.fechaFin BETWEEN :fechaInicio AND :fechaFin)";
	        $consulta = $em->createQuery($dql);
	        $consulta->setParameters(array(
	            'fechaInicio' => $params->fechaInicio,
	            'fechaFin' => $params->fechaFin,
	        ));
        } 
        elseif(isset($params->tipoContratoId)){
        	$dql = "SELECT f
            FROM AppBundle:MpersonalFuncionario f, AppBundle:MpersonalTipoContrato tc
            WHERE tc.id = f.tipoContrato
            AND tc.id = :tipoContrato";

	        $consulta = $em->createQuery($dql);
	        $consulta->setParameters(array(
	            'tipoContrato' => $params->tipoContratoId,
	        ));
        }elseif(isset($params->sedeOperativaId)){
        	$dql = "SELECT f
            FROM AppBundle:MpersonalFuncionario f, AppBundle:SedeOperativa s
            WHERE s.id = f.sedeOperativa
            AND s.id = :sedeOperativa";

	        $consulta = $em->createQuery($dql);
	        $consulta->setParameters(array(
	            'sedeOperativa' => $params->sedeOperativaId,
	        ));
        }

        return $consulta->getResult();
    }
}
