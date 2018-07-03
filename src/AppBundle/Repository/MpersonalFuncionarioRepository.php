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
            FROM AppBundle:MpersonalFuncionario f
            WHERE f.cargo = :cargo";

	        $consulta = $em->createQuery($dql);
	        $consulta->setParameters(array(
	            'cargo' => $params->cargo,
	        ));
        }elseif(isset($params->tipoContratoId)){
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

    public function getSearchActivo($params){   
        $em = $this->getEntityManager(); 
        $dql = "SELECT f
            FROM AppBundle:MpersonalFuncionario f, UsuarioBundle:Usuario u, AppBundle:Ciudadano c
            WHERE u.id = c.usuario
            AND c.id = f.ciudadano
            AND u.identificacion = :identificacion
            AND f.activo = 1";

	        $consulta = $em->createQuery($dql);
	        $consulta->setParameters(array(
	            'identificacion' => $params->identificacion,
            ));
        return $consulta->getOneOrNullResult();    
    }

}
