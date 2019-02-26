<?php

namespace JHWEB\UsuarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserCfgEmpresaTipo
 *
 * @ORM\Table(name="user_cfg_empresa_tipo")
 * @ORM\Entity(repositoryClass="JHWEB\UsuarioBundle\Repository\UserCfgEmpresaTipoRepository")
 */
class UserCfgEmpresaTipo
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

