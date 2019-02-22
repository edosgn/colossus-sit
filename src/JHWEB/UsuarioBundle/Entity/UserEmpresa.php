<?php

namespace JHWEB\UsuarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserEmpresa
 *
 * @ORM\Table(name="user_empresa")
 * @ORM\Entity(repositoryClass="JHWEB\UsuarioBundle\Repository\UserEmpresaRepository")
 */
class UserEmpresa
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

