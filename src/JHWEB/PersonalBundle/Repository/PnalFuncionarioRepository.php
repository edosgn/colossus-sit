<?php

namespace JHWEB\PersonalBundle\Repository;

/**
 * PnalFuncionarioRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PnalFuncionarioRepository extends \Doctrine\ORM\EntityRepository
{
    //Obtiene la lista de documentos por peticionario
    public function getSearch($params){ 
        $em = $this->getEntityManager();
        if (isset($params->nombre)) { 
        	$dql = "SELECT f
            FROM JHWEBPersonalBundle:PnalFuncionario f, JHWEBUsuarioBundle:UserCiudadano c
            WHERE c.id = f.ciudadano 
            AND (c.primerNombre = :nombre OR c.segundoNombre = :nombre OR c.primerApellido = :nombre OR c.segundoApellido = :nombre)";

	        $consulta = $em->createQuery($dql);
	        $consulta->setParameters(array(
	            'nombre' => $params->nombre,
	        ));
        }elseif(isset($params->identificacion)){ 
        	$dql = "SELECT f
            FROM JHWEBPersonalBundle:PnalFuncionario f, JHWEBUsuarioBundle:UserCiudadano c
            WHERE c.id = f.ciudadano 
            AND c.identificacion = :identificacion";

	        $consulta = $em->createQuery($dql);
	        $consulta->setParameters(array(
	            'identificacion' => $params->identificacion,
	        )); 
        }elseif(isset($params->cargo)){
			
        	$dql = "SELECT f
            FROM JHWEBPersonalBundle:PnalFuncionario f, JHWEBPersonalBundle:PnalCfgCargo c
            WHERE f.cargo = c.id
            AND c.id = :cargo";

	        $consulta = $em->createQuery($dql);
	        $consulta->setParameters(array(
	            'cargo' => $params->cargo,
	        ));
        }elseif(isset($params->numeroContrato)){
        	$dql = "SELECT f
            FROM JHWEBPersonalBundle:PnalFuncionario f
            WHERE f.numeroContrato = :numeroContrato";
	        $consulta = $em->createQuery($dql);
	        $consulta->setParameters(array(
	            'numeroContrato' => $params->numeroContrato,
	        ));
        }elseif(isset($params->idTipoNombramiento)){
        	$dql = "SELECT f
            FROM JHWEBPersonalBundle:PnalFuncionario f
            WHERE f.tipoNombramiento = :nombramiento";
	        $consulta = $em->createQuery($dql);
	        $consulta->setParameters(array(
	            'nombramiento' => $params->idTipoNombramiento,
	        ));
        }elseif(isset($params->fechaInicio) && isset($params->fechaFin)){
           
        	$dql = "SELECT f
            FROM JHWEBPersonalBundle:PnalFuncionario f
            WHERE (f.fechaInicio BETWEEN :fechaInicio AND :fechaFin)
            OR (f.fechaFin BETWEEN :fechaInicio AND :fechaFin)";
	        $consulta = $em->createQuery($dql);
	        $consulta->setParameters(array(
	            'fechaInicio' => $params->fechaInicio,
	            'fechaFin' => $params->fechaFin,
	        ));
		} 
        elseif(isset($params->idOrganismoTransito)){
        	$dql = "SELECT f
            FROM JHWEBPersonalBundle:PnalFuncionario f, JHWEBConfigBundle:CfgOrganismoTransito ot
            WHERE ot.id = f.organismoTransito
            AND ot.id = :organismoTransito";

	        $consulta = $em->createQuery($dql);
	        $consulta->setParameters(array(
	            'organismoTransito' => $params->idOrganismoTransito,
	        ));
        }
		
        return $consulta->getResult();
	}
	
	//Obtiene la lista de funcionarios asignados por cargo
    public function getAgentesByParams($params, $cargo){   
        $em = $this->getEntityManager();

    	$dql = "SELECT f
        FROM JHWEBPersonalBundle:PnalFuncionario f, 
        JHWEBUsuarioBundle:UserCiudadano c,
        UsuarioBundle:Usuario u
        WHERE u.id = c.usuario
        AND c.id = f.ciudadano
        AND (c.primerNombre = :parametro 
        OR c.segundoNombre = :parametro 
        OR c.primerApellido = :parametro 
        OR c.segundoApellido = :parametro 
        OR f.numeroPlaca = :parametro)
        AND f.cargo = :cargo";

        $consulta = $em->createQuery($dql);
        $consulta->setParameters(array(
            'parametro' => $params->parametro,
            'cargo' => $cargo,
        ));


        return $consulta->getResult();
    }
}
