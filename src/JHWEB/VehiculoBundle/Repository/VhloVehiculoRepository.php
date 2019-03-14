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
    public function getByFilter($campo)
    {
        $em = $this->getEntityManager();
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
        
        return $consulta->getOneOrNullResult();
    }

    //Obtiene el vehículo según uno o varios parametros al tiempo
    public function getOneByParametros($parametros)
    {
        $condicion = null; 
        $em = $this->getEntityManager();

        $dql = "SELECT v
            FROM JHWEBVehiculoBundle:VhloVehiculo v, JHWEBVehiculoBundle:VhloCfgPlaca p, AppBundle:PropietarioVehiculo pv, JHWEBUsuarioBundle:UserCiudadano c, UsuarioBundle:Usuario u
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
        if ($parametros->propietario) {
            $condicion .= " AND pv.vehiculo = v.id AND pv.ciudadano = c.id AND c.usuario = u.id AND u.identificacion ='" . $parametros->propietario . "'";

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
}
