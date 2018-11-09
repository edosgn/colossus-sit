<?php

namespace AppBundle\Repository;

/**
 * MsvTConsecutivoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MsvTConsecutivoRepository extends \Doctrine\ORM\EntityRepository
{
        //Obtiene el vehículo según un numero de placa y módulo
     public function getLastBySede($idSedeOperativa)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT MAX(msc.consecutivo) AS consecutivo, msc.estado, msc.id
            FROM AppBundle:MsvTConsecutivo msc, UsuarioBundle:Usuario u, AppBundle:MpersonalFuncionario mpf
            WHERE u.ciudadano = mpf.ciudadano
            AND mpf.sedeOperativa = msc.sedeOperativa
            AND msc.sedeOperativa = :idSedeOperativa
            AND (msc.estado = 'DISPONIBLE'
            OR msc.estado = 'EN TRAMITE'";
        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'idSedeOperativa' => $idSedeOperativa
        ));

        return $consulta->getOneOrNullResult();
    }
     public function getBySede($identificacionUsuario)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT msc
            FROM AppBundle:MsvTConsecutivo msc, UsuarioBundle:Usuario u, AppBundle:MpersonalFuncionario mpf
            WHERE u.identificacion = :identificacionUsuario
            AND u.ciudadano = mpf.ciudadano
            AND mpf.sedeOperativa = msc.sedeOperativa
            AND msc.activo = true";
        $consulta = $em->createQuery($dql);

        $consulta->setParameters(array(
            'identificacionUsuario' => $identificacionUsuario,
        ));

        return $consulta->getResult();
    }
}
/*

SELECT consecutivo FROM msv_t_consecutivo, usuario, mpersonal_funcionario 
WHERE usuario.identificacion=2222 
AND usuario.ciudadano_id = mpersonal_funcionario.ciudadano_id 
AND mpersonal_funcionario.sede_operativa_id = msv_t_consecutivo.sede_operativa_id 
AND msv_t_consecutivo.consecutivo = 12312300000000000000

*/