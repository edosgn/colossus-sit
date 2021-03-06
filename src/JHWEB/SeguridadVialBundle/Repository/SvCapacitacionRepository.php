<?php

namespace JHWEB\SeguridadVialBundle\Repository;

/**
 * SvCapacitacionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SvCapacitacionRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByParametros($params) {

        $em = $this->getEntityManager();

        $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(array('identificacion' => $params->identificacion));

        $dql = "SELECT c
            FROM JHWEBSeguridadVialBundle:SvCapacitacion c
            WHERE c.ciudadano = :ciudadano
            AND c.activo = 1
            GROUP BY c.fechaActividad, c.municipio, c.funcion, c.funcionCriterio, c.temaCapacitacion, c.descripcionActividad";


        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'ciudadano' => $ciudadano,
        ));

        return $consulta->getResult();
    }

    public function findCapacitacionesByParametros($params) {

        $em = $this->getEntityManager();

        $condicion = null; 

        /* $fechaInicio = $params->fechaInicio;
        $fechaFin = $params->fechaFin; */
        
        $dql = "SELECT c
            FROM JHWEBSeguridadVialBundle:SvCapacitacion c, JHWEBConfigBundle:CfgMunicipio m, JHWEBSeguridadVialBundle:SvCfgFuncion scf,
             JHWEBSeguridadVialBundle:SvCfgFuncionCriterio scfc,  JHWEBSeguridadVialBundle:SvCfgClaseActorVia sccav
            WHERE c.activo = 1";

        if($params->arrayMunicipios) {
            foreach ($params->arrayMunicipios as $keyMunicipio => $idMunicipio) {
                if($keyMunicipio == 0) {
                    $condicion .= " AND c.municipio = '" . $idMunicipio . "'";
                } else {
                    $condicion .= " OR c.municipio = '" . $idMunicipio . "'";
                }
            }
        }

        if($params->fechaInicio && $params->fechaFin){
            $condicion .= " AND c.fechaActividad BETWEEN " . $params->fechaInicio . " AND $params->fechaFin";
        }

        if($params->arrayFunciones) {
            foreach ($params->arrayFunciones as $keyFuncion => $idFuncion) {
                if($keyFuncion == 0) {
                    $condicion .= " AND c.funcion = '" . $idFuncion . "'";
                } else {
                    $condicion .= " OR c.funcion = '" . $idFuncion . "'";
                }
            } 
        }

        if($params->arrayFuncionesCriterio) {
            foreach ($params->arrayFuncionesCriterio as $keyFuncionCriterio => $idFuncionCriterio) {
                if($keyFuncionCriterio == 0) {
                    $condicion .= " AND c.funcionCriterio = '" . $idFuncionCriterio . "'";
                } else {
                    $condicion .= " OR c.funcionCriterio = '" . $idFuncionCriterio . "'";
                }
            } 
        }

        if($params->arrayClasesActorVia) {
            foreach ($params->arrayClasesActorVia as $keyClaseActorVia => $idClaseActorVia) {
                if($keyClaseActorVia == 0) {
                    $condicion .= " AND c.claseActorVial = '" . $idClaseActorVia . "'";
                } else {
                    $condicion .= " OR c.claseActorVial = '" . $idFuncionCriterio . "'";
                }
            } 
        }

        //=====================
        if ($condicion) {
            $dql .= $condicion;
        }

        $consulta = $em->createQuery($dql);

        return $consulta->getResult();
    }
}
