<?php

namespace AppBundle\Repository;

/**
 * MrfsvHu08Repository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MrfsvHu08Repository extends \Doctrine\ORM\EntityRepository
{
    //Obtiene la lista de inventario de se�ales
    public function getSearch($params){
        $em = $this->getEntityManager();

        if (isset($params->tipoDestino) && !isset($params->tipoDestinoSelected) && !isset($params->tipoSenalSelected)) {
            $dql = "SELECT Hu08
                FROM AppBundle:MrfsvHu08 Hu08, AppBundle:MrfsvHu09 Hu09, AppBundle:TipoSenal s, AppBundle:TipoDestino d
                WHERE Hu09.mrfsvHu08Id = Hu08.id
                AND s.id = Hu09.tipoSenal
                AND d.id = Hu09.tipoDestino
                AND Hu08.tipoDestino = :tipoDestino";

            $consulta = $em->createQuery($dql);
            $consulta->setParameters(array(
                'tipoDestino' => $params->tipoDestino,
            ));
        }elseif(isset($params->tipoDestinoSelected) && !isset($params->tipoDestino) && !isset($params->tipoSenalSelected)){
            $dql = "SELECT Hu08
                FROM AppBundle:MrfsvHu08 Hu08, AppBundle:MrfsvHu09 Hu09, AppBundle:TipoSenal s, AppBundle:TipoDestino d
                WHERE Hu09.mrfsvHu08Id = Hu08.id
                AND s.id = Hu09.tipoSenal
                AND d.id = Hu09.tipoDestino
                AND Hu08.xDestino = :tipoDestinoSelected";

            $consulta = $em->createQuery($dql);
            $consulta->setParameters(array(
                'tipoDestinoSelected' => $params->tipoDestinoSelected,
            ));
        }elseif(isset($params->tipoSenalSelected) && !isset($params->tipoDestino) && !isset($params->tipoDestinoSelected)){
            $dql = "SELECT Hu08
                FROM AppBundle:MrfsvHu08 Hu08, AppBundle:MrfsvHu09 Hu09, AppBundle:TipoSenal s, AppBundle:TipoDestino d
                WHERE Hu09.mrfsvHu08Id = Hu08.id
                AND s.id = Hu09.tipoSenal
                AND d.id = Hu09.tipoDestino
                AND Hu08.tipoSenal = :tipoSenalSelected";

            $consulta = $em->createQuery($dql);
            $consulta->setParameters(array(
                'tipoSenalSelected' => $params->tipoSenalSelected,
            ));
        }elseif(!isset($params->tipoDestino) && !isset($params->tipoDestinoSelected) && !isset($params->tipoSenalSelected)){
            $dql = "SELECT Hu08
                FROM AppBundle:MrfsvHu08 Hu08, AppBundle:MrfsvHu09 Hu09, AppBundle:TipoSenal s, AppBundle:TipoDestino d
                WHERE Hu09.mrfsvHu08Id = Hu08.id
                AND s.id = Hu09.tipoSenal
                AND d.id = Hu09.tipoDestino";

            $consulta = $em->createQuery($dql);
        }

        return $consulta->getResult();
    }

}
