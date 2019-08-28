<?php

namespace JHWEB\FinancieroBundle\Repository;

/**
 * FroFacturaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FroFacturaRepository extends \Doctrine\ORM\EntityRepository
{
    //Obtiene el numero maximo de facturas por año
    public function getMaximo($anio)
    {
        $em = $this->getEntityManager();
        
        $dql = "SELECT MAX(f.consecutivo) AS maximo
            FROM JHWEBFinancieroBundle:FroFactura f
            WHERE YEAR(f.fechaCreacion) = :ANIO";

        $consulta = $em->createQuery($dql);
        $consulta->setParameter('ANIO', $anio);

        return $consulta->getOneOrNullResult();
    }

    //=======================================para reportes de ingresos=======================================//
    ////Obtiene trámites solicitud según el filtro de búsqueda diario
    /* public function findTramitesGeneral($fecha, $idOrganismoTransito) {
        $em = $this->getEntityManager();

        $dql = "SELECT fts
            FROM JHWEBFinancieroBundle:FroTrteSolicitud fts,
            JHWEBFinancieroBundle:FroFactura ff,
            JHWEBFinancieroBundle:FroFacTramite fft
            WHERE fts.organismoTransito = :idOrganismoTransito 
            AND fts.tramiteFactura = fft.id
            AND fft.factura = ff.id
            AND ff.fechaPago = :fecha";

        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'idOrganismoTransito' => $idOrganismoTransito, 
            'fecha' => $fecha,
        ));
        
        return $consulta->getResult();
    } */
    
    //Obtiene trámites solicitud según el filtro de búsqueda mensual
    public function findTramites($fechaInicioDatetime, $fechaFinDatetime, $idOrganismoTransito) {
        $em = $this->getEntityManager();
        
        $dql = "SELECT fts
            FROM JHWEBFinancieroBundle:FroTrteSolicitud fts,
            JHWEBFinancieroBundle:FroFactura ff,
            JHWEBFinancieroBundle:FroFacTramite fft, 
            JHWEBFinancieroBundle:FroTrtePrecio ftp
            WHERE fts.organismoTransito = :idOrganismoTransito 
            AND fts.tramiteFactura = fft.id
            AND fft.factura = ff.id
            AND ff.fechaPago BETWEEN :fechaInicio AND :fechaFin
            AND fft.precio = ftp.id
            GROUP BY ftp.tramite";

        /* if ($params->arrayOragnismosTransito) {
            foreach ($params->arrayOragnismosTransito as $keyOrganismoTransito => $idOrganismoTransito) {
                # code...
                $edadInicio = intval($idOrganismoTransito);
                $edadFin = $edadInicio + 4;

                if($keyOrganismoTransito == 0) {
                    $condicion .= " AND fts.organismoTransito = '" . $idOrganismoTransito . "'";
                } else {
                    $condicion .= " OR fts.organismoTransito = '" . $idOrganismoTransito . "'";
                }
            }
        } */

        $consulta = $em->createQuery($dql);
        
        $consulta->setParameters(array(
            'idOrganismoTransito' => $idOrganismoTransito, 
            'fechaInicio' => $fechaInicioDatetime,
            'fechaFin' => $fechaFinDatetime,
        ));

        return $consulta->getResult();
    }

    public function getConceptosByPrecio($idPrecio) {
        $em = $this->getEntityManager();
        
        $dql = "SELECT ftc
            FROM JHWEBFinancieroBundle:FroTrteConcepto ftc,
            JHWEBFinancieroBundle:FroTrtePrecio ftp, 
            JHWEBFinancieroBundle:FroTrteCfgConcepto ftcc 
            WHERE ftp.id = :idPrecio
            AND ftc.precio = ftp.id
            AND NOT ftc.concepto = 2
            AND ftc.activo = 1
            AND ftc.concepto = ftcc.id";

        $consulta = $em->createQuery($dql);
        
        $consulta->setParameters(array(
            'idPrecio' => $idPrecio, 
        ));

        return $consulta->getResult();
    }

    public function getTotalConceptosByPrecio($idPrecio) {
        $em = $this->getEntityManager();

        $dql = "SELECT COUNT(ftc.id)
            FROM JHWEBFinancieroBundle:FroTrteConcepto ftc
            WHERE ftc.precio = :idPrecio";

        $consulta = $em->createQuery($dql);
        
        $consulta->setParameters(array(
            'idPrecio' => $idPrecio, 
        ));

        return $consulta->getOneOrNullResult();
    }
    
    /* public function getTotalConceptosByPrecio($idConcepto, $idPrecio) {
        $em = $this->getEntityManager();

        $dql = "SELECT COUNT(ftc.id)
            FROM JHWEBFinancieroBundle:FroTrteConcepto ftc
            WHERE ftc.concepto = :idConcepto
            AND ftc.precio = :idPrecio";

        $consulta = $em->createQuery($dql);
        
        $consulta->setParameters(array(
            'idConcepto' => $idConcepto, 
            'idPrecio' => $idPrecio, 
        ));

        return $consulta->getOneOrNullResult();
    } */

    public function getTramiteByName($idTramite) {
        $em = $this->getEntityManager();

        $dql = "SELECT COUNT(ftp.id)
            FROM JHWEBFinancieroBundle:FroTrtePrecio ftp
            WHERE ftp.tramite = :idTramite";

        $consulta = $em->createQuery($dql);
        
        $consulta->setParameters(array(
            'idTramite' => $idTramite, 
        ));

        return $consulta->getOneOrNullResult();
    }
    
    public function getSustratoByFactura($idFactura) {
        $em = $this->getEntityManager();

        $dql = "SELECT COUNT(fi.id) AS total, iv.valor, t.nombre, iv.valor AS valorUnitario
            FROM JHWEBFinancieroBundle:FroFacInsumo fi,
            JHWEBInsumoBundle:ImoInsumo i,
            JHWEBInsumoBundle:ImoCfgTipo t,
            JHWEBInsumoBundle:ImoCfgValor iv
            WHERE fi.factura = :idFactura
            AND fi.insumo = i.id
            AND i.tipo = t.id
            AND t.categoria = 'SUSTRATO'
            AND iv.tipo = t.id";

        $consulta = $em->createQuery($dql);
        
        $consulta->setParameters(array(
            'idFactura' => $idFactura, 
        ));

        return $consulta->getResult();
    }

    /* $dql = "SELECT COUNT (ftc.id) AS cantConceptos, ftcc.valor, ftcc.id, ftcc.nombre, ftcc.valor AS valorUnitarioConcepto */ 
    /* GROUP BY ftcc.id"; */
    /* public function getConceptosByPrecio($idPrecio) {
        $em = $this->getEntityManager();
        
        $dql = "SELECT ftc
            FROM JHWEBFinancieroBundle:FroTrteConcepto ftc,
            JHWEBFinancieroBundle:FroTrtePrecio ftp, 
            JHWEBFinancieroBundle:FroTrteCfgConcepto ftcc 
            WHERE ftp.id = :idPrecio
            AND ftc.precio = ftp.id
            AND NOT ftc.concepto = 2
            AND ftc.activo = 1
            AND ftc.concepto = ftcc.id";

        $consulta = $em->createQuery($dql);
        
        $consulta->setParameters(array(
            'idPrecio' => $idPrecio, 
        ));

        return $consulta->getResult();
    } */
    /*  =============== para infracciones ================= */

    public function getInfraccionesByFecha($fechaInicioDatetime, $fechaFinDatetime, $idOrganismoTransito) {
        $em = $this->getEntityManager();

        $dql = "SELECT ccc
            FROM JHWEBContravencionalBundle:CvCdoComparendo ccc
            WHERE ccc.organismoTransito = :idOrganismoTransito 
            AND ccc.fecha BETWEEN :fechaInicio AND :fechaFin";

        $consulta = $em->createQuery($dql);
        
        $consulta->setParameters(array(
            'idOrganismoTransito' => $idOrganismoTransito, 
            'fechaInicio' => $fechaInicioDatetime,
            'fechaFin' => $fechaFinDatetime,
        ));

        return $consulta->getResult();
    }

    /*  =============== para acuerdos de pago ================= */

    public function getAcuerdosPagoByFecha($fechaInicioDatetime, $fechaFinDatetime, $idOrganismoTransito) {
        $em = $this->getEntityManager();

        $dql = "SELECT fa
            FROM JHWEBFinancieroBundle:FroAmortizacion fa, JHWEBContravencionalBundle:CvCdoComparendo ccc,
            JHWEBFinancieroBundle:FroAcuerdoPago fap
            WHERE ccc.organismoTransito = :idOrganismoTransito 
            AND ccc.acuerdoPago = fap.id
            AND fa.acuerdoPago = fap.id
            AND fap.fecha BETWEEN :fechaInicio AND :fechaFin";

        $consulta = $em->createQuery($dql);
        
        $consulta->setParameters(array(
            'idOrganismoTransito' => $idOrganismoTransito, 
            'fechaInicio' => $fechaInicioDatetime,
            'fechaFin' => $fechaFinDatetime,
        ));

        return $consulta->getResult();
    }

    /*  =============== para parqueadero ================= */

    public function getInmovilizacionesByFecha($fechaInicioDatetime, $fechaFinDatetime, $idOrganismoTransito) {
        $em = $this->getEntityManager();

        $dql = "SELECT ffp
            FROM JHWEBParqueaderoBundle:PqoInmovilizacion pqi, JHWEBContravencionalBundle:CvCdoComparendo ccc, 
            JHWEBFinancieroBundle:FroFactura ff, JHWEBFinancieroBundle:FroFacParqueadero ffp
            WHERE  ffp.factura = ff.id
            AND ff.organismoTransito = :idOrganismoTransito 
            AND ffp.inmovilizacion = pqi.id
            AND pqi.fechaSalida BETWEEN :fechaInicio AND :fechaFin";

        $consulta = $em->createQuery($dql);
        
        $consulta->setParameters(array(
            'idOrganismoTransito' => $idOrganismoTransito, 
            'fechaInicio' => $fechaInicioDatetime,
            'fechaFin' => $fechaFinDatetime,
        ));

        return $consulta->getResult();
    }

    /*  =============== para retefuente ================= */

    public function getRetefuentesByFecha($fechaInicioDatetime, $fechaFinDatetime, $idOrganismoTransito) {
        $em = $this->getEntityManager();

        $dql = "SELECT ffr
            FROM JHWEBFinancieroBundle:FroFacRetefuente ffr, JHWEBFinancieroBundle:FroFactura ff 
            WHERE  ffr.factura = ff.id
            AND ff.organismoTransito = :idOrganismoTransito 
            AND ffr.fecha BETWEEN :fechaInicio AND :fechaFin";

        $consulta = $em->createQuery($dql);
        
        $consulta->setParameters(array(
            'idOrganismoTransito' => $idOrganismoTransito, 
            'fechaInicio' => $fechaInicioDatetime,
            'fechaFin' => $fechaFinDatetime,
        ));

        return $consulta->getResult();
    }

    public function getByFilters($params){
        $em = $this->getEntityManager();

        switch ($params->tipoFiltro) {
            case 1:
                $dql = "SELECT f
                FROM JHWEBFinancieroBundle:FroFactura f
                WHERE f.numero = :filtro";

                $consulta = $em->createQuery($dql);
                $consulta->setParameters(array(
                    'filtro' => $params->filtro,
                ));
                break;

            case 2:
                $dql = "SELECT f
                FROM JHWEBFinancieroBundle:FroFactura f,
                JHWEBConfigBundle:CfgOrganismoTransito o
                WHERE f.organismoTransito = o.id
                AND o.id = :filtro
                AND f.fechaCreacion BETWEEN :fechaInicial AND :fechaFinal";

                $consulta = $em->createQuery($dql);
                $consulta->setParameters(array(
                    'filtro' => $params->filtro,
                    'fechaInicial' => $params->fechaInicial,
                    'fechaFinal' => $params->fechaFinal,
                ));
                break;

            case 3:
                $dql = "SELECT f
                FROM JHWEBFinancieroBundle:FroFactura f
                WHERE f.valorNeto = :filtro
                AND f.fechaCreacion BETWEEN :fechaInicial AND :fechaFinal";

                $consulta = $em->createQuery($dql);
                $consulta->setParameters(array(
                    'filtro' => $params->filtro,
                    'fechaInicial' => $params->fechaInicial,
                    'fechaFinal' => $params->fechaFinal,
                ));
                break;
        }

        return $consulta->getResult();
    }
}
