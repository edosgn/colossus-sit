<?php

namespace JHWEB\UsuarioBundle\Repository;

/**
 * UserCfgMenuRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserCfgMenuRepository extends \Doctrine\ORM\EntityRepository
{
	//Obtiene la lista de MENUS disponibles para asignar a un USUARIO
    public function getAvailablesByUsuario($idParent, $idUsuario)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT m
            FROM JHWEBUsuarioBundle:UserCfgMenu m
            WHERE m.activo = true
            AND m.parent = :idParent
            AND m.id NOT IN
            (SELECT IDENTITY(um.menu)
            FROM JHWEBUsuarioBundle:UserUsuarioMenu um
            JOIN um.usuario u
            WHERE um.activo = true 
            AND u.id = :idUsuario)";

        $consulta = $em->createQuery($dql);
        $consulta->setParameters(array(
	        'idParent' => $idParent,
	        'idUsuario' => $idUsuario,
	    ));

        return $consulta->getResult();
    }
}