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
    //Obtiene todos los comparendos por tramitar
    public function getForProcessing(){
        $em = $this->getEntityManager();

        $dql = "SELECT c from AppBundle:Comparendo c
        WHERE c.estado != 6
        AND c.estado != 8
        AND c.estado != 9
        AND c.estado != 10
        AND c.estado != 11
        AND c.estado != 12";

        $consulta = $em->createQuery($dql);
        return $consulta->getResult();
    }

    public function findByParametros($params){
        
        $fechaDesde = new \DateTime($params->fechaDesde);
        $fechaHasta = new \DateTime($params->fechaHasta);
        $comparendosId = $params->comparendosId;
        $condicion = null;


        $em = $this->getEntityManager();

        $dql = "SELECT c from AppBundle:Comparendo c, AppBundle:MpersonalFuncionario m
        WHERE c.agenteTransito = m.id
        AND m.id = :agenteId
        AND c.fecha BETWEEN :fechaDesde AND :fechaHasta";
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

    public function getByFilter($params){
        $em = $this->getEntityManager();

        switch ($params->tipoFiltro) {
            case 1:
                $dql = "SELECT c
                FROM AppBundle:Comparendo c
                WHERE c.infractorNombres LIKE :nombres
                OR c.infractorApellidos LIKE :apellidos";

                $consulta = $em->createQuery($dql);
                $consulta->setParameters(array(
                    'nombres' => '%'.$params->filtro.'%',
                    'apellidos' => '%'.$params->filtro.'%',
                ));
                break;

            case 2:
                $dql = "SELECT c
                FROM AppBundle:Comparendo c
                WHERE c.infractorIdentificacion = :identificacion";

                $consulta = $em->createQuery($dql);
                $consulta->setParameters(array(
                    'identificacion' => $params->filtro,
                ));
                break;

            case 3:
                $dql = "SELECT c
                FROM AppBundle:Comparendo c
                WHERE c.placa LIKE :placa";

                $consulta = $em->createQuery($dql);
                $consulta->setParameters(array(
                    'placa' => '%'.$params->filtro.'%',
                ));
                break;

            case 4:
                $dql = "SELECT c
                FROM AppBundle:Comparendo c, AppBundle:MpersonalComparendo pc
                WHERE pc.consecutivo = :consecutivo
                AND c.consecutivo = pc.id";

                $consulta = $em->createQuery($dql);
                $consulta->setParameters(array(
                    'consecutivo' => $params->filtro,
                ));
                break;
        }

        return $consulta->getResult();
    }

    public function getByFilterForFactura($params){
        $em = $this->getEntityManager();

        switch ($params->tipoFiltro) {
            case 1:
                $dql = "SELECT c
                FROM AppBundle:Comparendo c
                WHERE (c.infractorNombres LIKE :nombres
                OR c.infractorApellidos LIKE :apellidos)
                AND (c.estado = 2 OR c.estado = 3)";

                $consulta = $em->createQuery($dql);
                $consulta->setParameters(array(
                    'nombres' => '%'.$params->filtro.'%',
                    'apellidos' => '%'.$params->filtro.'%',
                ));
                break;

            case 2:
                $dql = "SELECT c
                FROM AppBundle:Comparendo c
                WHERE c.infractorIdentificacion = :identificacion
                AND (c.estado = 2 OR c.estado = 3)";

                $consulta = $em->createQuery($dql);
                $consulta->setParameters(array(
                    'identificacion' => $params->filtro,
                ));
                break;

            case 3:
                $dql = "SELECT c
                FROM AppBundle:Comparendo c
                WHERE c.placa LIKE :placa
                AND (c.estado = 2 OR c.estado = 3)";

                $consulta = $em->createQuery($dql);
                $consulta->setParameters(array(
                    'placa' => '%'.$params->filtro.'%',
                ));
                break;

            case 4:
                $dql = "SELECT c
                FROM AppBundle:Comparendo c, AppBundle:MpersonalComparendo pc
                WHERE pc.consecutivo = :consecutivo
                AND c.consecutivo = pc.id
                AND (c.estado = 2 OR c.estado = 3)";

                $consulta = $em->createQuery($dql);
                $consulta->setParameters(array(
                    'consecutivo' => $params->filtro,
                ));
                break;
        }

        return $consulta->getResult();
    }

    public function getByNumber($numero){
        $em = $this->getEntityManager();

        $dql = "SELECT c
        FROM AppBundle:Comparendo c, AppBundle:MpersonalComparendo pc
        WHERE pc.consecutivo = :consecutivo
        AND c.consecutivo = pc.id";

        $consulta = $em->createQuery($dql);
        $consulta->setParameters(array(
            'consecutivo' => $numero,
        ));

        return $consulta->getOneOrNullResult();
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

    //Obtiene el comparendo mas viejo vigente segun el ciudadano
    public function getLastDateByCiudadano($ciudadanoId)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT MIN(co.fecha), co.id
            FROM AppBundle:Comparendo co
            WHERE co.ciudadanoInfractor = :ciudadanoId
            AND co.estado = 2";
        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'ciudadanoId' => $ciudadanoId,
        ));

        return $consulta->getOneOrNullResult();
    }

    public function getByAgente($params){
        $em = $this->getEntityManager();

        $fechaDesdeDatetime = new \Datetime($params->fechaDesde);
        $fechaHastaDatetime = new \Datetime($params->fechaHasta);

        if($params->agenteId){
            $idAgente = $em->getRepository('AppBundle:MpersonalFuncionario')->find($params->agenteId);
        }

        if($params->sedeOperativaId){
            $idSedeOperativa = $em->getRepository('AppBundle:SedeOperativa')->find($params->sedeOperativaId);
        }

        $dql = "SELECT co
        FROM AppBundle:Comparendo co
        WHERE co.fecha BETWEEN :fechaDesdeDatetime AND :fechaHastaDatetime
        AND co.agenteTransito = :idAgente
        AND co.sedeOperativa = :idSedeOperativa";

        $consulta = $em->createQuery($dql);
        $consulta->setParameters(array(
            'fechaDesdeDatetime' => $fechaDesdeDatetime,
            'fechaHastaDatetime' => $fechaHastaDatetime,
            'idAgente' => $idAgente,
            'idSedeOperativa' => $idSedeOperativa,
        ));

        return $consulta->getOneOrNullResult();
    }

    public function findByFecha($params){
        $em = $this->getEntityManager();

        $dql = "SELECT c
        FROM AppBundle:Comparendo c, AppBundle:MpersonalComparendo pc
        WHERE c.fecha = :fechaDesde BETWEEN :fechaHasta
        AND c.consecutivo = pc.id";

        $consulta = $em->createQuery($dql);
        $consulta->setParameters(array(
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,
        ));

        return $consulta->getOneOrNullResult();
    }
}