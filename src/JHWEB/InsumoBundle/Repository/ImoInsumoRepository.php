<?php

namespace JHWEB\InsumoBundle\Repository;

/**
 * ImoInsumoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ImoInsumoRepository extends \Doctrine\ORM\EntityRepository
{

    //Obtiene el minimo insumo sustrato disponible
    public function getLastByFuncionario($idOrnganismoTransito)
    { 
        $em = $this->getEntityManager();

        $dql = "SELECT MAX(i.id) AS id, i.numero
            FROM JHWEBInsumoBundle:ImoInsumo i
            WHERE i.organismoTransito = :idOrnganismoTransito
            AND i.estado = :estado
            AND i.tipo = :tipo";
        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'idOrnganismoTransito' => $idOrnganismoTransito,
            'estado' => 'disponible',
            'tipo' => 'SUSTRATO',
        ));
 
        return $consulta->getOneOrNullResult();
    }

    public function getByNumeroAndModulo($numero, $idModulo, $idOrganismoTransito)
    { 
        $em = $this->getEntityManager();

        $dql = "SELECT i.id, i.numero, i.estado, t.nombre
            FROM JHWEBInsumoBundle:ImoInsumo i,
            JHWEBInsumoBundle:ImoCfgTipo t
            WHERE i.tipo = t.id
            AND i.organismoTransito = :idOrganismoTransito
            AND t.modulo = :idModulo
            AND i.numero = :numero
            AND i.estado = 'DISPONIBLE'
            GROUP BY i.numero";

        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'numero' => $numero,
            'idOrganismoTransito' => $idOrganismoTransito,
            'idModulo' => $idModulo,
        ));

        return $consulta->getOneOrNullResult();
    }

    public function getByNumeroActa($numeroActa)
    { 
        $em = $this->getEntityManager();

        $dql = "SELECT i
            FROM JHWEBInsumoBundle:ImoInsumo i,
            JHWEBInsumoBundle:ImoCfgTipo t
            WHERE i.tipo = t.id
            AND t.categoria = 'INSUMO'
            AND i.actaEntrega = :numeroActa";

        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'numeroActa' => $numeroActa,
        ));

        return $consulta->getResult();
    }

    public function getTotalesTipoActa($actaEntrega)
    { 
        $em = $this->getEntityManager();

        $dql = "SELECT COUNT(i.id) AS cantidad, it.nombre, ot.id AS idOrganismoTransito, 
                i.fecha AS fecha, il.rangoInicio AS rangoInicio, il.rangoFin AS rangoFin, i.actaEntrega AS actaEntrega
                FROM JHWEBInsumoBundle:ImoInsumo i, 
                JHWEBInsumoBundle:ImoCfgTipo it,
                JHWEBInsumoBundle:ImoLote il,
                JHWEBConfigBundle:CfgOrganismoTransito ot
                WHERE i.actaEntrega = :actaEntrega
                AND i.tipo = it.id
                AND i.organismoTransito = ot.id
                AND i.lote = il.id
                AND i.categoria = 'SUSTRATO'
                GROUP BY i.tipo";
                $consulta = $em->createQuery($dql);
                $consulta->setParameters(array(
                    'actaEntrega' => $actaEntrega,
                ));
                return $consulta->getResult();
    }

    public function getInsumoRango($fechaInicio, $fechaFin, $idOrganismoTransito)
    {
        $em = $this->getEntityManager();
        
        $dql = "SELECT i
        FROM JHWEBInsumoBundle:ImoInsumo i, 
        JHWEBConfigBundle:CfgOrganismoTransito ot,
        JHWEBInsumoBundle:ImoCfgTipo ict
        WHERE i.fecha BETWEEN :fechaInicio AND :fechaFin
        AND i.organismoTransito = ot.id
        AND i.tipo = ict.id
        AND i.organismoTransito = :idOrganismoTransito
        AND ict.categoria = 'SUSTRATO'"; 

        $consulta = $em->createQuery($dql);
        $consulta->setParameters(array(
            'idOrganismoTransito' => $idOrganismoTransito,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
        ));
        return $consulta->getResult();
    }


    public function getInsumoCantidad($idOrganismoTransito,$tipo,$cantidad)
    {
        $em = $this->getEntityManager();
        
        $dql = "SELECT i
        FROM JHWEBInsumoBundle:ImoInsumo i
        WHERE i.tipo = :tipo
        AND i.organismoTransito = :idOrganismoTransito
        AND i.estado = 'DISPONIBLE'
        ORDER BY i.id"; 

        $consulta = $em->createQuery($dql)->setMaxResults($cantidad);

        $consulta->setParameters(array(
            'idOrganismoTransito' => $idOrganismoTransito,
            'tipo' => $tipo,
        ));
        return $consulta->getResult();
    }

}
