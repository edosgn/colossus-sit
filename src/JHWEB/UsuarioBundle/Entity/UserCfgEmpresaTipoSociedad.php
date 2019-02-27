<?php

namespace JHWEB\UsuarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserCfgEmpresaTipoSociedad
 *
 * @ORM\Table(name="user_cfg_empresa_tipo_sociedad")
 * @ORM\Entity(repositoryClass="JHWEB\UsuarioBundle\Repository\UserCfgEmpresaTipoSociedadRepository")
 */
class UserCfgEmpresaTipoSociedad
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

