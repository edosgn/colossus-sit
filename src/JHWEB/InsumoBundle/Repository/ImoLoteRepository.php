<?php

namespace JHWEB\InsumoBundle\Repository;

/**
 * ImoLoteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ImoLoteRepository extends \Doctrine\ORM\EntityRepository
{

    public function getMax($imoCfgTipo)
    { 
        $em = $this->getEntityManager();
        $dql = "SELECT MAX(l.rangoFin) AS maximo
        FROM JHWEBInsumoBundle:ImoLote l, JHWEBInsumoBundle:ImoCfgTipo t
        WHERE l.tipoInsumo = t.id
        AND l.tipoInsumo = :imoTipo";
        $consulta = $em->createQuery($dql);
        $consulta->setParameters(array(
            'imoTipo' => $imoCfgTipo,
        ));
        return $consulta->getOneOrNullResult();
    }

    public function getMaxActa()
    { 
        $em = $this->getEntityManager();

        $dql = "SELECT MAX(l.actaEntrega) AS maximo
        FROM JHWEBInsumoBundle:ImoInsumo l
        WHERE l.tipo = :tipo";
        $consulta = $em->createQuery($dql);
        $consulta->setParameters(array(
            'tipo' => 'SUSTRATO',
        ));
        return $consulta->getOneOrNullResult();
    }

    public function getTotalesTipo()
    { 
        $em = $this->getEntityManager();
        $dql = "SELECT SUM(il.cantidad) AS cantidad, it.nombre
                FROM JHWEBInsumoBundle:ImoLote il,
                JHWEBInsumoBundle:ImoCfgTipo it
                WHERE il.tipoInsumo = it.id
                AND il.tipo = :tipo
                GROUP BY il.tipoInsumo";
                $consulta = $em->createQuery($dql);
                $consulta->setParameters(array(
                    'tipo' => 'INSUMO',
                ));
                return $consulta->getResult();
    }

    public function getTotalTipo($estado,$tipoInsumo)
    {  
        $em = $this->getEntityManager();
        $dql = "SELECT SUM(il.cantidad) AS cantidad, it.nombre, il.id AS idLote, it.id AS idTipoInsumo
                FROM JHWEBInsumoBundle:ImoLote il,
                JHWEBInsumoBundle:ImoCfgTipo it
                WHERE il.tipoInsumo = :tipoInsumo
                AND il.tipoInsumo = it.id
                AND il.estado = :estado";
                $consulta = $em->createQuery($dql);
                $consulta->setParameters(array(
                    'estado' => $estado, 
                    'tipoInsumo' => $tipoInsumo,
                ));
                return $consulta->getOneOrNullResult();
    }


}
 