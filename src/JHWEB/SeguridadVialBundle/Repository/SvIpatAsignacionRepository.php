<?php

namespace JHWEB\SeguridadVialBundle\Repository;

/**
 * SvIpatAsignacionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SvIpatAsignacionRepository extends \Doctrine\ORM\EntityRepository
{
    //Obtiene el numero maximo de facturas por año
    public function getMaximo($anio)
    {
        $em = $this->getEntityManager();
        
        $dql = "SELECT COUNT(a.id) AS maximo
            FROM JHWEBSeguridadVialBundle:SvIpatAsignacion a
            WHERE YEAR(a.fecha) = :ANIO";

        $consulta = $em->createQuery($dql);
        $consulta->setParameter('ANIO', $anio);

        return $consulta->getOneOrNullResult();
    }

    //Obtiene la lista de documentos por peticionario
    public function getFuncionariosByTipoContrato($params, $cargo){   
        $em = $this->getEntityManager();

    	$dql = "SELECT f
        FROM JHWEBPersonalBundle:PnalFuncionario f, JHWEBUsuarioBundle:UserCiudadano c
        WHERE c.id = f.ciudadano
        AND (c.primerNombre = :parametro OR c.segundoNombre = :parametro OR c.primerApellido = :parametro OR c.segundoApellido = :parametro OR f.numeroPlaca = :parametro)
        AND f.cargo = :cargo";

        $consulta = $em->createQuery($dql);
        $consulta->setParameters(array(
            'parametro' => $params->parametro,
            'cargo' => $cargo,
        ));


        return $consulta->getResult();
    }
}
