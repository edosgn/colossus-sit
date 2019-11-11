<?php

namespace JHWEB\ContravencionalBundle\Repository;

/**
 * CvCdoComparendoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CvCdoComparendoRepository extends \Doctrine\ORM\EntityRepository
{
    //Obtiene el numero maximo de documentos por año
    public function getMaximo($anio)
    {
        $em = $this->getEntityManager();
        
        $dql = "SELECT MAX(c.expedienteConsecutivo) AS maximo
        FROM JHWEBContravencionalBundle:CvCdoComparendo c
        WHERE YEAR(c.fecha) = :ANIO";

        $consulta = $em->createQuery($dql);
        $consulta->setParameter('ANIO', $anio);
        
        return $consulta->getOneOrNullResult();
    }

	//Obtiene todos los comparendos por tramitar
    public function getForProcessing(){
        $em = $this->getEntityManager();

        $dql = "SELECT c from JHWEBContravencionalBundle:CvCdoComparendo c
        WHERE c.estado != 6
        AND c.estado != 8
        AND c.estado != 9
        AND c.estado != 10
        AND c.estado != 11
        AND c.estado != 12";

        $consulta = $em->createQuery($dql);
        return $consulta->getResult();
    }

    public function getByParametros($params){
        $fechaDesde = new \DateTime($params->fechaDesde);
        $fechaHasta = new \DateTime($params->fechaHasta);
        $comparendos = $params->comparendos;
        $condicion = null;


        $em = $this->getEntityManager();

        $dql = "SELECT c from JHWEBContravencionalBundle:CvCdoComparendo c, JHWEBPersonalBundle:PnalFuncionario f
        WHERE c.agenteTransito = f.id
        AND f.id = :idFuncionario
        AND c.fecha BETWEEN :fechaDesde AND :fechaHasta";

        $i=0;

        foreach ($comparendos as $keyComparendo => $comparendo) {
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
            'idFuncionario' => $params->idFuncionario,
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
                FROM JHWEBContravencionalBundle:CvCdoComparendo c
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
                FROM JHWEBContravencionalBundle:CvCdoComparendo c
                WHERE c.infractorIdentificacion = :identificacion";

                $consulta = $em->createQuery($dql);
                $consulta->setParameters(array(
                    'identificacion' => $params->filtro,
                ));
                break;

            case 3:
                $dql = "SELECT c
                FROM JHWEBContravencionalBundle:CvCdoComparendo c
                WHERE c.placa LIKE :placa";

                $consulta = $em->createQuery($dql);
                $consulta->setParameters(array(
                    'placa' => '%'.$params->filtro.'%',
                ));
                break;

            case 4:
                $dql = "SELECT c
                FROM JHWEBContravencionalBundle:CvCdoComparendo c, JHWEBPersonalBundle:PnalCfgCdoConsecutivo pc
                WHERE pc.numero = :numero
                AND c.consecutivo = pc.id";

                $consulta = $em->createQuery($dql);
                $consulta->setParameters(array(
                    'numero' => $params->filtro,
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
                FROM JHWEBContravencionalBundle:CvCdoComparendo c
                WHERE (c.infractorNombres LIKE :nombres
                OR c.infractorApellidos LIKE :apellidos)
                AND (c.estado = 1 OR c.estado = 2 OR c.estado = 3)";

                $consulta = $em->createQuery($dql);
                $consulta->setParameters(array(
                    'nombres' => '%'.$params->filtro.'%',
                    'apellidos' => '%'.$params->filtro.'%',
                ));
                break;

            case 2:
                $dql = "SELECT c
                FROM JHWEBContravencionalBundle:CvCdoComparendo c
                WHERE c.infractorIdentificacion = :identificacion
                AND (c.estado = 1 OR c.estado = 2 OR c.estado = 3)";

                $consulta = $em->createQuery($dql);
                $consulta->setParameters(array(
                    'identificacion' => $params->filtro,
                ));
                break;

            case 3:
                $dql = "SELECT c
                FROM JHWEBContravencionalBundle:CvCdoComparendo c
                WHERE c.placa LIKE :placa
                AND (c.estado = 1 OR c.estado = 2 OR c.estado = 3)";

                $consulta = $em->createQuery($dql);
                $consulta->setParameters(array(
                    'placa' => '%'.$params->filtro.'%',
                ));
                break;

            case 4:
                $dql = "SELECT c
                FROM JHWEBContravencionalBundle:CvCdoComparendo c, 
                JHWEBPersonalBundle:PnalCfgCdoConsecutivo pc
                WHERE pc.numero = :numero
                AND c.consecutivo = pc.id
                AND (c.estado = 1 OR c.estado = 2 OR c.estado = 3)";

                $consulta = $em->createQuery($dql);
                $consulta->setParameters(array(
                    'numero' => $params->filtro,
                ));
                break;
        }

        return $consulta->getResult();
    }

    public function getByNumber($numero){
        $em = $this->getEntityManager();

        $dql = "SELECT c
        FROM JHWEBContravencionalBundle:CvCdoComparendo c, JHWEBPersonalBundle:PnalCfgCdoConsecutivo pc
        WHERE pc.numero = :numero
        AND c.consecutivo = pc.id
        GROUP BY pc.numero";

        $consulta = $em->createQuery($dql);
        $consulta->setParameters(array(
            'numero' => $numero,
        ));

        return $consulta->getOneOrNullResult();
    }

    //Obtiene el comparendo según ciudadano
    public function getByCiudadanoInfractor($idCiudadano)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT co
            FROM JHWEBContravencionalBundle:CvCdoComparendo co
            WHERE co.ciudadanoInfractor = :idCiudadano
            AND co.estado = 1";
        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'idCiudadano' => $idCiudadano,
        ));

        return $consulta->getResult();
    }

    //Obtiene el comparendo mas viejo vigente segun el ciudadano
    public function getLastDateByCiudadano($idCiudadano)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT MIN(co.fecha), co.id
            FROM JHWEBContravencionalBundle:CvCdoComparendo co
            WHERE co.ciudadanoInfractor = :idCiudadano
            AND co.estado = 2";
        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'idCiudadano' => $idCiudadano,
        ));

        return $consulta->getOneOrNullResult();
    }

    public function getByAgente($params){
        $em = $this->getEntityManager();

        $fechaDesdeDatetime = new \Datetime($params->fechaDesde);
        $fechaHastaDatetime = new \Datetime($params->fechaHasta);

        if($params->idFuncionario){
            $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->find($params->idFuncionario);
        }

        if($params->idOrganismoTransito){
            $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find(
            	$params->idOrganismoTransito
            );
        }

        $dql = "SELECT co
        FROM JHWEBContravencionalBundle:CvCdoComparendo co
        WHERE co.fecha BETWEEN :fechaDesdeDatetime AND :fechaHastaDatetime
        AND co.agenteTransito = :idFuncionario
        AND co.organismoTransito = :idOrganismoTransito";

        $consulta = $em->createQuery($dql);
        $consulta->setParameters(array(
            'fechaDesdeDatetime' => $fechaDesdeDatetime,
            'fechaHastaDatetime' => $fechaHastaDatetime,
            'idFuncionario' => $funcionario->getId(),
            'idOrganismoTransito' => $organismoTransito->getId(),
        ));

        return $consulta->getOneOrNullResult();
    }

    public function getByFecha($params){
        $em = $this->getEntityManager();

        $dql = "SELECT c
        FROM JHWEBContravencionalBundle:CvCdoComparendo c, JHWEBPersonalBundle:PnalCfgCdoConsecutivo pc
        WHERE c.fecha = :fechaDesde BETWEEN :fechaHasta
        AND c.consecutivo = pc.id";

        $consulta = $em->createQuery($dql);
        $consulta->setParameters(array(
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,
        ));

        return $consulta->getOneOrNullResult();
    }

    //Obtiene todos los vehiculos del módulo RNA entre fechas para creación de archivo plano
    public function getByFechasForFile($idOrganismoTransito, $fechaInicial, $fechaFinal)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT c
            FROM JHWEBContravencionalBundle:CvCdoComparendo c

            WHERE c.organismoTransito = :idOrganismoTransito
            AND c.fecha BETWEEN :fechaInicial AND :fechaFinal
            AND c.activo = true";
        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'idOrganismoTransito' => $idOrganismoTransito,
            'fechaInicial' => $fechaInicial,
            'fechaFinal' => $fechaFinal
        ));
        
        return $consulta->getResult();
    }

    //Obtiene todos los vehiculos del módulo RNA entre fechas para creación de archivo plano
    public function getResolucionesByFechasForFile($idOrganismoTransito, $fechaInicial, $fechaFinal)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT ct
            FROM JHWEBContravencionalBundle:CvCdoTrazabilidad ct,
            JHWEBContravencionalBundle:CvCdoComparendo c,
            JHWEBContravencionalBundle:CvCdoCfgEstado ce,
            JHWEBConfigBundle:CfgAdmActoAdministrativo aa,
            JHWEBConfigBundle:CfgAdmFormato af

            WHERE ct.comparendo = c.id
            AND c.organismoTransito = :idOrganismoTransito
            AND c.fecha BETWEEN :fechaInicial AND :fechaFinal
            AND c.activo = true
            AND ct.actoAdministrativo = aa.id
            AND aa.formato = af.id
            AND ce.activo = true
            AND ct.estado = ce.id
            AND ce.simit = true
            AND ct.activo = true";

        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'idOrganismoTransito' => $idOrganismoTransito,
            'fechaInicial' => $fechaInicial,
            'fechaFinal' => $fechaFinal
        ));
        
        return $consulta->getResult();
    }

    //Obtiene todos los vehiculos del módulo RNA entre fechas para creación de archivo plano
    public function getRecaudosByFechasForFile($idOrganismoTransito, $fechaInicial, $fechaFinal)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT fc
            FROM JHWEBFinancieroBundle:FroFacComparendo fc,
            JHWEBFinancieroBundle:FroFactura f,
            JHWEBContravencionalBundle:CvCdoComparendo c

            WHERE fc.factura = f.id
            AND f.organismoTransito = :idOrganismoTransito
            AND f.fechaPago BETWEEN :fechaInicial AND :fechaFinal
            AND fc.comparendo = c.id";

        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'idOrganismoTransito' => $idOrganismoTransito,
            'fechaInicial' => $fechaInicial,
            'fechaFinal' => $fechaFinal
        ));
        
        return $consulta->getResult();
    }

    public function getReincidenciasByMonths($identificacion, $fechaFinal, $meses){
        $fechaInicial = new \DateTime(date("Y-m-d",strtotime($fechaFinal->format('Y-m-d')."- ".$meses." month"))); 

        $em = $this->getEntityManager();

        $dql = "SELECT c
        from JHWEBContravencionalBundle:CvCdoComparendo c
        WHERE c.infractorIdentificacion = :identificacion
        AND c.fecha BETWEEN :fechaInicial AND :fechaFinal";

        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'identificacion' => $identificacion,
            'fechaInicial' => $fechaInicial,
            'fechaFinal' => $fechaFinal,
        ));

        return $consulta->getResult();
    }

    public function getTopByInfraccion($idOrganismoTransito, $fechaInicial, $fechaFinal)
    {
        $em = $this->getEntityManager();

        $dql = "SELECT count(c.infraccion) as cant, fi.nombre as nombre
            FROM JHWEBContravencionalBundle:CvCdoComparendo c,
            JHWEBFinancieroBundle:FroInfraccion fi
            
            WHERE c.infraccion = fi.id
            AND c.organismoTransito = :idOrganismoTransito
            AND c.fecha BETWEEN :fechaInicial AND :fechaFinal
            ORDER BY cant DESC";

        $consulta = $em->createQuery($dql)->setMaxResults(10);

        $consulta->setParameters(array(
            'idOrganismoTransito' => $idOrganismoTransito,
            'fechaInicial' => $fechaInicial,
            'fechaFinal' => $fechaFinal,
        ));

        return $consulta->getResult();
    }
    
    public function getTopByEdad($idOrganismoTransito, $fechaInicial, $fechaFinal)
    {
        $em = $this->getEntityManager();
    
        $dql = "SELECT count(c.infractorEdad) as cant, fi.nombre, c.infractorEdad as edad
            FROM JHWEBContravencionalBundle:CvCdoComparendo c,
            JHWEBFinancieroBundle:FroInfraccion fi
            
            WHERE c.infraccion = fi.id
            AND c.organismoTransito = :idOrganismoTransito
            AND c.fecha BETWEEN :fechaInicial AND :fechaFinal
            ORDER BY cant DESC";

        $consulta = $em->createQuery($dql)->setMaxResults(10);

        $consulta->setParameters(array(
            'idOrganismoTransito' => $idOrganismoTransito,
            'fechaInicial' => $fechaInicial,
            'fechaFinal' => $fechaFinal,
        ));
    
        return $consulta->getResult();
    }
}
