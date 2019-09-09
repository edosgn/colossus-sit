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
    //Obtiene trámites solicitud con facturas finalizadas según el filtro de búsqueda
    public function findTramitesFinalizados($tipoArchivoTramite, $fechaInicio, $fechaFin, $arrayOrganismosTransito) {
        $em = $this->getEntityManager();

        $condicion = null; 
        
        if($tipoArchivoTramite == 'GENERAL') {
            $dql = "SELECT COUNT(fts.id) as cantidad, ft.codigo, ft.nombre, ftp.valor, COUNT(fts.id) * ftp.valor as total
                FROM JHWEBFinancieroBundle:FroTrteSolicitud fts,
                JHWEBFinancieroBundle:FroFactura ff,
                JHWEBFinancieroBundle:FroFacTramite fft, 
                JHWEBFinancieroBundle:FroTramite ft, 
                JHWEBFinancieroBundle:FroTrtePrecio ftp
                WHERE fts.tramiteFactura = fft.id
                AND fft.factura = ff.id
                AND ff.fechaPago BETWEEN :fechaInicio AND :fechaFin
                AND ff.estado = 'FINALIZADA'
                AND fft.precio = ftp.id
                AND ftp.tramite = ft.id";
        }
        else if($tipoArchivoTramite == 'DETALLADO') {
            $dql = "SELECT ff.numero, ff.fechaPago, vcp.numero as placa, ii.numero as numeroSustrato, m.abreviatura, ff.numeroRunt, ft.nombre as nombreTramite, fts.fecha as fechaTramite, ftp.valor as valorPagado
                FROM JHWEBFinancieroBundle:FroTrteSolicitud fts,
                JHWEBFinancieroBundle:FroFactura ff,
                JHWEBFinancieroBundle:FroFacTramite fft, 
                JHWEBFinancieroBundle:FroTramite ft, 
                JHWEBFinancieroBundle:FroTrtePrecio ftp,
                JHWEBVehiculoBundle:VhloVehiculo vv,
                JHWEBVehiculoBundle:VhloCfgPlaca vcp,
                JHWEBFinancieroBundle:FroFacInsumo ffi,
                JHWEBInsumoBundle:ImoInsumo ii,
                JHWEBInsumoBundle:ImoCfgTipo ict,
                JHWEBConfigBundle:CfgModulo m
                WHERE fts.tramiteFactura = fft.id
                AND fts.vehiculo = vv.id
                AND vv.placa = vcp.id
                AND fft.factura = ff.id
                AND ff.fechaPago BETWEEN :fechaInicio AND :fechaFin
                AND ff.estado = 'FINALIZADA'
                AND ff.id = ffi.factura
                AND ffi.insumo = ii.id
                AND ii.tipo = ict.id
                AND ict.modulo = m.id
                AND ict.categoria = 'SUSTRATO'
                AND fft.precio = ftp.id
                AND ftp.tramite = ft.id";
        }


        if ($arrayOrganismosTransito) {
            if(count($arrayOrganismosTransito) > 0) {
                foreach ($arrayOrganismosTransito as $keyOrganismoTransito => $idOrganismoTransito) {
                    if($keyOrganismoTransito == 0) {
                        $condicion .= " fts.organismoTransito = '" . $idOrganismoTransito. "'";
                    } else {
                        $condicion .= " OR fts.organismoTransito = '" . $idOrganismoTransito. "'";
                    }
                }
            } else {
                $condicion .= " fts.organismoTransito = '" . $idOrganismoTransito. "'";
            }
        }

        if ($condicion) {
            $dql .=  ' AND (' . $condicion . ')';
        }
        
        if($tipoArchivoTramite == 'GENERAL'){ 
            $dql .= " GROUP BY ftp.tramite";
        }

        /* var_dump($dql);
        die(); */

        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
        ));

        return $consulta->getResult();
    }
    //Obtiene trámites solicitud con facturas devolucionadas según el filtro de búsqueda
    public function findFacturasDevolucionadas($fechaInicio, $fechaFin, $arrayOrganismosTransito) {
        $em = $this->getEntityManager();

        $condicion = null; 
        
        $dql = "SELECT COUNT(fts.id) as cantidad, ft.nombre, ftp.valor, COUNT(fts.id) * ftp.valor as total
            FROM JHWEBFinancieroBundle:FroTrteSolicitud fts,
            JHWEBFinancieroBundle:FroFactura ff,
            JHWEBFinancieroBundle:FroFacTramite fft, 
            JHWEBFinancieroBundle:FroTramite ft, 
            JHWEBFinancieroBundle:FroTrtePrecio ftp
            WHERE fts.tramiteFactura = fft.id
            AND fft.factura = ff.id
            AND ff.fechaPago BETWEEN :fechaInicio AND :fechaFin
            AND ff.estado = 'DEVOLUCION'
            AND fft.precio = ftp.id
            AND ftp.tramite = ft.id";

        if ($arrayOrganismosTransito) {
            foreach ($arrayOrganismosTransito as $keyOrganismoTransito => $idOrganismoTransito) {
                if($keyOrganismoTransito == 0) {
                    $condicion .= " AND fts.organismoTransito = '" . $idOrganismoTransito . "'";
                } else {
                    $condicion .= " OR fts.organismoTransito = '" . $idOrganismoTransito . "'";
                }
            }
        }

        $condicion .=  " GROUP BY ftp.tramite";

        if ($condicion) {
            $dql .= $condicion;
        }

        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
        ));

        return $consulta->getResult();
    }
    //Obtiene trámites solicitud con facturas pagadas según el filtro de búsqueda
    public function findFacturasPagadas($fechaInicio, $fechaFin, $arrayOrganismosTransito) {
        $em = $this->getEntityManager();

        $condicion = null; 
        
        $dql = "SELECT COUNT(ff.id) as cantidad
            FROM JHWEBFinancieroBundle:FroFactura ff
            WHERE ff.estado = 'PAGADA'
            AND ff.fechaPago BETWEEN :fechaInicio AND :fechaFin";

        if ($arrayOrganismosTransito) {
            foreach ($arrayOrganismosTransito as $keyOrganismoTransito => $idOrganismoTransito) {
                if($keyOrganismoTransito == 0) {
                    $condicion .= " AND ff.organismoTransito = '" . $idOrganismoTransito . "'";
                } else {
                    $condicion .= " OR ff.organismoTransito = '" . $idOrganismoTransito . "'";
                }
            }
        }

        if ($condicion) {
            $dql .= $condicion;
        }

        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
        ));

        return $consulta->getResult();
    }
    //Obtiene trámites solicitud con facturas de traspaso según el filtro de búsqueda
    public function findFacturasRetefuente($fechaInicio, $fechaFin, $arrayOrganismosTransito) {
        $em = $this->getEntityManager();

        $condicion = null; 
        
        $dql = "SELECT COUNT(ff.id) as cantidad
            FROM JHWEBFinancieroBundle:FroTrteSolicitud fts,
            JHWEBFinancieroBundle:FroFactura ff,
            JHWEBFinancieroBundle:FroFacTramite fft, 
            JHWEBFinancieroBundle:FroTramite ft, 
            JHWEBFinancieroBundle:FroTrtePrecio ftp
            WHERE fts.tramiteFactura = fft.id
            AND fft.factura = ff.id
            AND ff.estado = 'FINALIZADA'
            AND ff.fechaPago BETWEEN :fechaInicio AND :fechaFin
            AND fft.precio = ftp.id
            AND ftp.tramite = ft.id
            AND ft.codigo = 2";

        if ($arrayOrganismosTransito) {
            foreach ($arrayOrganismosTransito as $keyOrganismoTransito => $idOrganismoTransito) {
                if($keyOrganismoTransito == 0) {
                    $condicion .= " AND ff.organismoTransito = '" . $idOrganismoTransito . "'";
                } else {
                    $condicion .= " OR ff.organismoTransito = '" . $idOrganismoTransito . "'";
                }
            }
        }

        if ($condicion) {
            $dql .= $condicion;
        }

        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
        ));

        return $consulta->getResult();
    }
    //Obtiene trámites solicitud con facturas vencidas según el filtro de búsqueda
    public function findFacturasVencidas($fechaInicio, $fechaFin, $arrayOrganismosTransito) {
        $em = $this->getEntityManager();

        $condicion = null; 
        
        $dql = "SELECT COUNT(ff.id) as cantidad
            FROM JHWEBFinancieroBundle:FroTrteSolicitud fts,
            JHWEBFinancieroBundle:FroFactura ff,
            JHWEBFinancieroBundle:FroFacTramite fft, 
            JHWEBFinancieroBundle:FroTramite ft, 
            JHWEBFinancieroBundle:FroTrtePrecio ftp
            WHERE fts.tramiteFactura = fft.id
            AND fft.factura = ff.id
            AND ff.fechaPago BETWEEN :fechaInicio AND :fechaFin
            AND ff.estado = 'VENCIDA'
            AND fft.precio = ftp.id
            AND ftp.tramite = ft.id";

        if ($arrayOrganismosTransito) {
            foreach ($arrayOrganismosTransito as $keyOrganismoTransito => $idOrganismoTransito) {
                if($keyOrganismoTransito == 0) {
                    $condicion .= " AND ff.organismoTransito = '" . $idOrganismoTransito . "'";
                } else {
                    $condicion .= " OR ff.organismoTransito = '" . $idOrganismoTransito . "'";
                }
            }
        }

        if ($condicion) {
            $dql .= $condicion;
        }

        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
        ));

        return $consulta->getResult();
    }

    //obtiene sustratos de acuerdo al numero de factura
    public function getSustratos($fechaInicio, $fechaFin) {
        $em = $this->getEntityManager();

        $dql = "SELECT COUNT(fi.id) AS cantidad, ict.id, ict.nombre, icv.valor, COUNT(fi.id) * icv.valor AS total
            FROM JHWEBFinancieroBundle:FroFacInsumo fi, 
            JHWEBFinancieroBundle:FroFactura ff,
            JHWEBInsumoBundle:ImoInsumo ii,
            JHWEBInsumoBundle:ImoCfgTipo ict,
            JHWEBInsumoBundle:ImoCfgValor icv
            WHERE fi.factura = ff.id
            AND ff.estado = 'FINALIZADA'
            AND ff.fechaPago BETWEEN :fechaInicio AND :fechaFin
            AND fi.insumo = ii.id
            AND ii.tipo = ict.id
            AND ict.categoria = 'SUSTRATO'
            AND icv.tipo = ict.id
            GROUP BY ict.nombre";

        $consulta = $em->createQuery($dql);
        
        $consulta->setParameters(array(
            'fechaInicio' => $fechaInicio, 
            'fechaFin' => $fechaFin
        ));

        return $consulta->getResult();
    }

    //obtiene los conceptos en un rango de fechas especifico
    public function getConceptos($fechaInicio, $fechaFin) {
        $em = $this->getEntityManager();
        
        $dql = "SELECT COUNT(ftcc.id) AS cantidad ,ftcc.id, ftcc.nombre, ftcc.valor, COUNT(ftcc.id) * ftcc.valor AS total
        FROM JHWEBFinancieroBundle:FroTrteConcepto ftc,
            JHWEBFinancieroBundle:FroTrtePrecio ftp, 
            JHWEBFinancieroBundle:FroFacTramite ft,
            JHWEBFinancieroBundle:FroTrteSolicitud fts, 
            JHWEBFinancieroBundle:FroTrteCfgConcepto ftcc,
            JHWEBFinancieroBundle:FroFactura f

            WHERE ftp.id = ft.precio 
            AND ftp.id = ftc.precio 
            AND ftc.concepto != 2
            AND fts.tramiteFactura = ft.id
            AND ftcc.id = ftc.concepto
            AND ft.factura = f.id
            AND ft.precio = ftp.id
            AND f.fechaPago BETWEEN :fechaInicio AND :fechaFin
            AND f.estado = 'FINALIZADA'
            AND ftc.activo = 1 
            GROUP BY ftcc.id";
        
        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
        ));

        return $consulta->getResult();
    }

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
