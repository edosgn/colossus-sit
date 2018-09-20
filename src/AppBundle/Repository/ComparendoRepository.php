<?php

namespace AppBundle\Repository;

/**
 * ComparendoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ComparendoRepository extends \Doctrine\ORM\EntityRepository
{

    public function findByParametros($params){
        
        $fechaDesde = new \DateTime($params->fechaDesde);
        $fechaHasta = new \DateTime($params->fechaHasta);
        $comparendosId = $params->comparendosId;
        $condicion = null;


    $em = $this->getEntityManager();

    $dql = "SELECT c from AppBundle:Comparendo c, AppBundle:MpersonalFuncionario m
                WHERE c.agenteTransito = m.id
                AND m.id = :agenteId
                AND c.fechaNotificacion BETWEEN :fechaDesde AND :fechaHasta";
        $i=0;

        foreach ($comparendosId as $keyComparendo => $comparendo) {
            if($keyComparendo==0){
                $condicion .= " AND c.estado = '" . $comparendo . "'";
            }
            else {
                $condicion .= " OR c.estado = '" . $comparendo . "'";
                }
            }

        $dql .= $condicion;
        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'agenteId' => $params->agenteId,
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,
        ));

        return $consulta->getResult();
    }

    //Obtiene el comparendo según ciudadano
    public function getByCiudadanoInfractor($ciudadanoId)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT co
            FROM AppBundle:Comparendo co
            WHERE co.ciudadanoInfractor = :ciudadanoId
            AND co.estado = 1";
        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'ciudadanoId' => $ciudadanoId,
        ));

        return $consulta->getResult();
    }

}