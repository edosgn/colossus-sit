<?php

namespace JHWEB\UsuarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserUsuarioMenu
 *
 * @ORM\Table(name="user_usuario_menu")
 * @ORM\Entity(repositoryClass="JHWEB\UsuarioBundle\Repository\UserUsuarioMenuRepository")
 */
class UserUsuarioMenu
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
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /** @ORM\ManyToOne(targetEntity="UsuarioBundle\Entity\Usuario", inversedBy="menus") */
    private $usuario;

    /** @ORM\ManyToOne(targetEntity="UserCfgMenu", inversedBy="usuarios") */
    private $menu;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return UserUsuarioMenu
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return bool
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set usuario
     *
     * @param \Repository\UsuarioBundle\Entity\Usuario $usuario
     *
     * @return UserUsuarioMenu
     */
    public function setUsuario(\Repository\UsuarioBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \Repository\UsuarioBundle\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set menu
     *
     * @param \JHWEB\UsuarioBundle\Entity\UserCfgMenu $menu
     *
     * @return UserUsuarioMenu
     */
    public function setMenu(\JHWEB\UsuarioBundle\Entity\UserCfgMenu $menu = null)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return \JHWEB\UsuarioBundle\Entity\UserCfgMenu
     */
    public function getMenu()
    {
        return $this->menu;
    }
}
