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

            $em = $this->getEntityManager();

            $dql = "SELECT c from AppBundle:Comparendo c, AppBundle:MpersonalFuncionario m
                    WHERE c.agenteTransito = m.id
                    AND m.id = :agenteId
                    AND c.fecha BETWEEN :fechaDesde AND :fechaHasta";

            $consulta = $em->createQuery($dql);

            $consulta->setParameters(array(
                'agenteId' => $params->agenteId,
                'fechaDesde' => $fechaDesde,
                'fechaHasta' => $fechaHasta,
            ));

            return $consulta->getResult();
        }

}
