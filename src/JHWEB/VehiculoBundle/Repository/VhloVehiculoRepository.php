<?php

namespace JHWEB\VehiculoBundle\Repository;

/**
 * VhloVehiculoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VhloVehiculoRepository extends \Doctrine\ORM\EntityRepository
{
	//Obtiene un vehiculo según el filtro de búsqueda
    public function getByFilter($campo, $idModulo = null)
    {
        $em = $this->getEntityManager();
        if($idModulo) {
            $dql = "SELECT v
                FROM JHWEBVehiculoBundle:VhloVehiculo v, JHWEBVehiculoBundle:VhloCfgPlaca p,
                JHWEBVehiculoBundle:VhloCfgTipoVehiculo tv, JHWEBVehiculoBundle:VhloCfgClase c
                WHERE (v.placa = p.id  AND p.numero = :campo)
                OR (v.vin = :campo
                OR v.chasis = :campo
                OR v.serie = :campo
                OR v.motor = :campo)
                AND v.clase = c.id
                AND c.tipoVehiculo = tv.id
                AND tv.modulo = :idModulo";
            $consulta = $em->createQuery($dql);
    
            $consulta->setParameters(array(
                'campo' => $campo,
                'idModulo' => $idModulo,
            ));
        } else {
            $dql = "SELECT v
                FROM JHWEBVehiculoBundle:VhloVehiculo v, JHWEBVehiculoBundle:VhloCfgPlaca p
                WHERE (v.placa = p.id  AND p.numero = :campo)
                OR (v.vin = :campo
                OR v.chasis = :campo
                OR v.serie = :campo
                OR v.motor = :campo)";
            $consulta = $em->createQuery($dql);
    
            $consulta->setParameters(array(
                'campo' => $campo,
            ));
        }
        return $consulta->getResult();
        // return $consulta->getOneOrNullResult();
    }

    //Obtiene los vehículos según uno o varios parametros al tiempo
    public function getByParameters($params)
    {
        $condicion = null; 

        $em = $this->getEntityManager();
        
        /* UsuarioBundle:Usuario u */
        if (isset($params->propietario)) {
            $dql = "SELECT v
            FROM JHWEBVehiculoBundle:VhloVehiculo v, 
            JHWEBVehiculoBundle:VhloCfgPlaca p, 
            JHWEBVehiculoBundle:VhloPropietario vp, 
            JHWEBUsuarioBundle:UserCiudadano c
            WHERE v.placa = p.id";

            $condicion .= " AND vp.vehiculo = v.id AND vp.ciudadano = c.id AND c.identificacion ='" . $params->propietario . "'";
            /* $condicion .= " AND vp.vehiculo = v.id AND vp.ciudadano = c.id AND c.usuario = u.id AND c.identificacion ='" . $params->propietario . "'"; */
        /* }elseif (isset($params->numeroPlaca) && $params->numeroPlaca != 0) { */
        }elseif (isset($params->numeroPlaca)) {
            $dql = "SELECT v
            FROM JHWEBVehiculoBundle:VhloVehiculo v, 
            JHWEBVehiculoBundle:VhloCfgPlaca p
            WHERE v.placa = p.id";

            $condicion .= " AND p.numero = '" . $params->numeroPlaca . "'";
        }else{
            $dql = "SELECT v
            FROM JHWEBVehiculoBundle:VhloVehiculo v 
            WHERE (v.activo = true OR v.activo = false)";
        }

        if (isset($params->numeroVIN)) {
            $condicion .= " AND v.vin ='" . $params->numeroVIN . "'";
        }
        if (isset($params->numeroSerie)) {
            $condicion .= " AND v.serie ='" . $params->numeroSerie . "'";
        }
        if (isset($params->numeroMotor)) {
            $condicion .= " AND v.motor ='" . $params->numeroMotor . "'";
        }
        if (isset($params->numeroChasis)) {
            $condicion .= " AND v.chasis ='" . $params->numeroChasis . "'";
        }

        if ($condicion) {
            $dql .= $condicion;
        }

        $consulta = $em->createQuery($dql);

        return $consulta->getResult();
    }

    //Obtiene el vehículo según uno o varios parametros al tiempo
    public function getOneByParameters($parametros)
    {
        $condicion = null; 
        $em = $this->getEntityManager();

        $dql = "SELECT v
            FROM JHWEBVehiculoBundle:VhloVehiculo v, JHWEBVehiculoBundle:VhloCfgPlaca p
            WHERE v.placa = p.id";

        if ($parametros->numeroPlaca) {
            $condicion .= " AND p.numero = '" . $parametros->numeroPlaca . "'";

        }
        if ($parametros->numeroVIN) {
            $condicion .= " AND v.vin ='" . $parametros->numeroVIN . "'";

        }
        if ($parametros->numeroSerie) {
            $condicion .= " AND v.serie ='" . $parametros->numeroSerie . "'";

        }
        if ($parametros->numeroMotor) {
            $condicion .= " AND v.motor ='" . $parametros->numeroMotor . "'";

        }
        if ($parametros->numeroChasis) {
            $condicion .= " AND v.chasis ='" . $parametros->numeroChasis . "'";

        }
       
        if ($condicion) {
            $dql .= $condicion;
        }
        $consulta = $em->createQuery($dql);

        return $consulta->getResult();
    }

    //Busca todos los vehiculos que no sean ni maquinaria ni remolques
    public function getOneOnlyVehiculos()
    {
        $em = $this->getEntityManager();
        $dql = "SELECT v
                FROM JHWEBVehiculoBundle:VhloVehiculo v
                WHERE v.estado = true AND
                v.id NOT IN
                (SELECT IDENTITY(vm.vehiculo)
                FROM JHWEBVehiculoBundle:VhloMaquinaria vm
                WHERE vm.vehiculo = v.id) AND v.id NOT IN
                (SELECT IDENTITY(vr.vehiculo)
                FROM JHWEBVehiculoBundle:VhloRemolque vr
                WHERE vr.vehiculo = v.id)";

        $consulta = $em->createQuery($dql);
        return $consulta->getResult();
    }
 
    //Busca un solo vehiculo que no sean ni maquinaria ni remolques
    public function getOneOnlyVehiculo($id)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT v
                FROM JHWEBVehiculoBundle:VhloVehiculo v
                WHERE v.activo = true 
                AND v.id = :id
                AND 
                v.id NOT IN
                (SELECT IDENTITY(vm.vehiculo)
                FROM JHWEBVehiculoBundle:VhloMaquinaria vm
                WHERE vm.vehiculo = v.id) AND v.id NOT IN
                (SELECT IDENTITY(vr.vehiculo)
                FROM JHWEBVehiculoBundle:VhloRemolque vr
                WHERE vr.vehiculo = v.id)";

        $consulta = $em->createQuery($dql);
        $consulta->setParameters(array(
            'id' => $id,
        ));
        return $consulta->getOneOrNullResult();
    }

    //Obtiene el vehículo según un numero de placa
    public function getByPlaca($placa)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT v
            FROM JHWEBVehiculoBundle:VhloVehiculo v, JHWEBVehiculoBundle:VhloCfgPlaca p
            WHERE v.placa = p.id
            AND p.numero = :placa";
        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'placa' => $placa,
        ));

        return $consulta->getOneOrNullResult();
    }

    //Obtiene el vehículo según un numero de placa y módulo
    public function getByPlacaModulo($placa, $idModulo)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT v
            FROM JHWEBVehiculoBundle:VhloVehiculo v, JHWEBVehiculoBundle:VhloCfgPlaca p, JHWEBVehiculoBundle:VhloCfgClase c, JHWEBConfigBundle:CfgModulo m
            WHERE v.placa = p.id
            AND p.numero = :placa 
            AND v.clase = c.id
            AND c.modulo = m.id
            AND m.id = :idModulo";
        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'placa' => $placa,
            'idModulo' => $idModulo,
        ));

        return $consulta->getOneOrNullResult();
    }

    //Obtiene todos los vehiculos del módulo RNA entre fechas para creación de archivo plano
    public function getByFechasForFile($idOrganismoTransito, $idModulo, $fechaInicial, $fechaFinal)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT fts
            FROM JHWEBFinancieroBundle:FroTrteSolicitud fts,
            JHWEBFinancieroBundle:FroFacTramite ft,
            JHWEBFinancieroBundle:FroTrtePrecio tp,
            JHWEBVehiculoBundle:VhloVehiculo v,
            JHWEBVehiculoBundle:VhloCfgTipoVehiculo vctv,
            JHWEBVehiculoBundle:VhloCfgClase vcc,
            JHWEBVehiculoBundle:VhloPropietario vp
            WHERE fts.vehiculo = v.id
            AND fts.tramiteFactura = ft.id
            AND ft.precio = tp.id
            AND v.organismoTransito = :idOrganismoTransito
            AND (tp.tramite = 1 OR tp.tramite = 4)
            AND v.clase = vcc.id
            AND vcc.tipoVehiculo = vctv.id
            AND vctv.modulo = :idModulo
            AND v.activo = true
            AND vp.vehiculo = v.id
            AND vp.activo = true
            AND fts.fecha BETWEEN :fechaInicial AND :fechaFinal";
        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'idOrganismoTransito' => $idOrganismoTransito,
            'idModulo' => $idModulo,
            'fechaInicial' => $fechaInicial,
            'fechaFinal' => $fechaFinal
        ));
        
        return $consulta->getResult();
    }

    //Obtiene el vehículo según un numero de placa y módulo
    public function validateByModulo($idVehiculo, $idModulo)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT v
            FROM JHWEBVehiculoBundle:VhloVehiculo v, JHWEBVehiculoBundle:VhloCfgClase c, 
            JHWEBVehiculoBundle:VhloCfgTipoVehiculo tv, JHWEBConfigBundle:CfgModulo m
            WHERE v.id = :idVehiculo
            AND v.clase = c.id
            AND c.tipoVehiculo = tv.id
            AND tv.modulo = :idModulo";
        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'idVehiculo' => $idVehiculo,
            'idModulo' => $idModulo,
        ));

        return $consulta->getResult();
    }

    //Obtiene el vehículo según un numero de placa y módulo
    public function validateByModuloAndSede($idVehiculo, $idModulo, $idOrganismoTransito)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT v
            FROM JHWEBVehiculoBundle:VhloVehiculo v, JHWEBVehiculoBundle:VhloCfgClase c, 
            JHWEBVehiculoBundle:VhloCfgTipoVehiculo tv, JHWEBConfigBundle:CfgModulo m
            WHERE v.id = :idVehiculo
            AND v.clase = c.id
            AND c.tipoVehiculo = tv.id
            AND tv.modulo = :idModulo
            AND v.organismoTransito = :idOrganismoTransito";
        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'idVehiculo' => $idVehiculo,
            'idModulo' => $idModulo,
            'idOrganismoTransito' => $idOrganismoTransito,
        ));

        return $consulta->getResult();
    }
}
