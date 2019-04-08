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
            'tipo' => 'sustrato',
        ));
 
        return $consulta->getOneOrNullResult();
    }

    public function getByNumeroAndModulo($numero, $idModulo, $idOrganismoTransito)
    { 
        $em = $this->getEntityManager();

        $dql = "SELECT i.numero, t.nombre
            FROM JHWEBInsumoBundle:ImoInsumo i,
            JHWEBInsumoBundle:ImoCfgTipo t
            WHERE i.tipo = t.id
            AND i.organismoTransito = :idOrganismoTransito
            AND t.modulo = :idModulo
            AND i.estado = :estado
            AND i.tipo = :tipo
            AND i.numero = :numero
            GROUP BY i.numero";

        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'estado' => 'disponible',
            'tipo' => 'sustrato',
            'numero' => $numero,
            'idOrganismoTransito' => $idOrganismoTransito,
            'idModulo' => $idModulo,
        ));

        return $consulta->getOneOrNullResult();
    }
}
