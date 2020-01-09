<?php

namespace JHWEB\FinancieroBundle\Repository;

/**
 * FroFacTramiteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FroFacTramiteRepository extends \Doctrine\ORM\EntityRepository
{
	public function getByFacturaAndTramite($idFactura, $idTramite)
    {
        $em = $this->getEntityManager();
        
        $dql = "SELECT ft
            FROM JHWEBFinancieroBundle:FroFacTramite ft, JHWEBFinancieroBundle:FroFactura f, JHWEBFinancieroBundle:FroTramite t, JHWEBFinancieroBundle:FroTrtePrecio tp
            WHERE ft.factura = f.id
            AND ft.precio = tp.id
            AND tp.tramite = t.id
            AND t.id = :idTramite
            AND f.id = :idFactura"; 
        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'idFactura' => $idFactura,
            'idTramite' => $idTramite,
        ));

        return $consulta->getOneOrNullResult();
    }
    
    public function validateByFactura($idFactura)
    {
        $em = $this->getEntityManager();
        
        $dql = "SELECT ft
            FROM JHWEBFinancieroBundle:FroFacTramite ft, JHWEBFinancieroBundle:FroFactura f, 
            JHWEBFinancieroBundle:FroTramite t, JHWEBFinancieroBundle:FroTrtePrecio tp
            WHERE ft.factura = f.id
            AND f.id = :idFactura
            AND ft.precio = tp.id
            AND (tp.tramite = 1 OR tp.tramite = 4 OR tp.tramite = 22)";
            
        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'idFactura' => $idFactura,
        ));

        return $consulta->getOneOrNullResult();
    }

}
