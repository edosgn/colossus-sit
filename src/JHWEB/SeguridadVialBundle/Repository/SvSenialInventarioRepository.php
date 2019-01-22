<?php

namespace JHWEB\SeguridadVialBundle\Repository;

/**
 * SvSenialInventarioRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SvSenialInventarioRepository extends \Doctrine\ORM\EntityRepository
{

    //Obtiene el numero maximo de inventarios por año, tipo de señial y destino
    public function getMaximo($anio)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT MAX(si.consecutivo) AS maximo
            FROM JHWEBSeguridadVialBundle:SvSenialInventario si
            WHERE YEAR(si.fecha) = :ANIO";
        $consulta = $em->createQuery($dql);
        $consulta->setParameter('ANIO', $anio);
        return $consulta->getOneOrNullResult();
    }

	//Obtiene los inventarios por fechas y tipo de destino
    public function getByDateAndTipoDestino($fechaInicial, $fechaFinal, $idTipoSenial, $tipoDestino, $idMunicipio)
    {
        $em = $this->getEntityManager();

        if ($idMunicipio) {
	        $dql = "SELECT si
            FROM JHWEBSeguridadVialBundle:SvSenialInventario si,
            JHWEBSeguridadVialBundle:SvCfgSenialTipo st,
            AppBundle:Municipio m
            WHERE si.tipoDestino = :tipoDestino
            AND si.municipio = m.id
            AND si.municipio = :idMunicipio
            AND si.tipoSenial = st.id
            AND si.tipoSenial = :idTipoSenial
            AND si.fecha BETWEEN :fechaInicial AND :fechaFinal";

            $consulta = $em->createQuery($dql);

	        $consulta->setParameters(array(
	            'fechaInicial' => $fechaInicial,
	            'fechaFinal' => $fechaFinal,
	            'idTipoSenial' => $idTipoSenial,
	            'tipoDestino' => $tipoDestino,
	            'idMunicipio' => $idMunicipio,
	        ));
        }else{
        	$dql = "SELECT si
            FROM JHWEBSeguridadVialBundle:SvSenialInventario si,
            JHWEBSeguridadVialBundle:SvCfgSenialTipo st
            WHERE si.tipoDestino = :tipoDestino
            AND si.tipoSenial = st.id
            AND si.tipoSenial = :idTipoSenial
            AND si.fecha BETWEEN :fechaInicial AND :fechaFinal";

            $consulta = $em->createQuery($dql);

	        $consulta->setParameters(array(
	            'fechaInicial' => $fechaInicial,
	            'fechaFinal' => $fechaFinal,
	            'idTipoSenial' => $idTipoSenial,
	            'tipoDestino' => $tipoDestino,
	        ));
        }

        return $consulta->getResult();
    }

    //Obtiene las cantidades por senial y tipo de destino
    public function getCantidadBySenialAndTipoDestino($idTipoSenial, $tipoDestino, $idMunicipio)
    {
        $em = $this->getEntityManager();

        if ($idMunicipio) {
            $dql = "SELECT SUM(su.cantidad) AS cantidad, m.nombre, 
            s.id, s.nombre, s.codigo, st.id AS tipoSenial
            FROM JHWEBSeguridadVialBundle:SvSenialUbicacion su,
            JHWEBSeguridadVialBundle:SvCfgSenialTipo st,
            JHWEBSeguridadVialBundle:SvCfgSenial s,
            AppBundle:Municipio m
            WHERE su.municipio = m.id
            AND su.municipio = :idMunicipio
            AND s.tipoSenial = st.id
            AND s.tipoSenial = :idTipoSenial
            AND su.senial = s.id
            GROUP BY su.senial";

            $consulta = $em->createQuery($dql);

            $consulta->setParameters(array(
                'idTipoSenial' => $idTipoSenial,
                'idMunicipio' => $idMunicipio,
            ));
        }else{
            $dql = "SELECT SUM(sb.cantidad) AS cantidad, 
            s.id, s.nombre, s.codigo, st.id AS tipoSenial
            FROM JHWEBSeguridadVialBundle:SvSenialBodega sb,
            JHWEBSeguridadVialBundle:SvCfgSenialTipo st,
            JHWEBSeguridadVialBundle:SvCfgSenial s
            WHERE s.tipoSenial = st.id
            AND s.tipoSenial = :idTipoSenial
            AND sb.senial = s.id
            GROUP BY sb.senial";

            $consulta = $em->createQuery($dql);

            $consulta->setParameters(array(
                'idTipoSenial' => $idTipoSenial,
            ));
        }

        return $consulta->getResult();
    }
}
