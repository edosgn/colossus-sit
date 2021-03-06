<?php

namespace JHWEB\UsuarioBundle\Repository;

/**
 * UserUsuarioMenuRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserUsuarioMenuRepository extends \Doctrine\ORM\EntityRepository
{
	//Obtiene la lista de MENUS disponibles para asignar a un USUARIO
    public function getAssignedByUsuario($idUsuario)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT um
            FROM JHWEBUsuarioBundle:UserCfgMenu m,
            JHWEBUsuarioBundle:UserUsuarioMenu um
            WHERE um.menu = m.id
            AND m.activo = true
            AND um.activo = true
            AND um.usuario = :idUsuario
            AND m.parent IS NOT NULL
            ORDER BY m.parent, m.titulo ASC";

        $consulta = $em->createQuery($dql);
        $consulta->setParameters(array(
	        'idUsuario' => $idUsuario,
	    ));

        return $consulta->getResult();
    }
}
