<?php

namespace Repository\UsuarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserCfgPermiso
 *
 * @ORM\Table(name="user_cfg_permiso")
 * @ORM\Entity(repositoryClass="Repository\UsuarioBundle\Repository\UserCfgPermisoRepository")
 */
class UserCfgPermiso
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
     * @ORM\Column(name="create", type="boolean")
     */
    private $create = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="update", type="boolean")
     */
    private $update = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="delete", type="boolean")
     */
    private $delete = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /** @ORM\ManyToOne(targetEntity="UserCfgMenu", inversedBy="permisos") */
    private $menu;

    /** @ORM\ManyToOne(targetEntity="UserCfgRole", inversedBy="permisos") */
    private $role;

    /** @ORM\ManyToOne(targetEntity="Usuario", inversedBy="permisos") */
    private $usuario;



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
     * Set create
     *
     * @param boolean $create
     *
     * @return UserCfgPermiso
     */
    public function setCreate($create)
    {
        $this->create = $create;

        return $this;
    }

    /**
     * Get create
     *
     * @return boolean
     */
    public function getCreate()
    {
        return $this->create;
    }

    /**
     * Set update
     *
     * @param boolean $update
     *
     * @return UserCfgPermiso
     */
    public function setUpdate($update)
    {
        $this->update = $update;

        return $this;
    }

    /**
     * Get update
     *
     * @return boolean
     */
    public function getUpdate()
    {
        return $this->update;
    }

    /**
     * Set delete
     *
     * @param boolean $delete
     *
     * @return UserCfgPermiso
     */
    public function setDelete($delete)
    {
        $this->delete = $delete;

        return $this;
    }

    /**
     * Get delete
     *
     * @return boolean
     */
    public function getDelete()
    {
        return $this->delete;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return UserCfgPermiso
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set menu
     *
     * @param \Repository\UsuarioBundle\Entity\UserCfgMenu $menu
     *
     * @return UserCfgPermiso
     */
    public function setMenu(\Repository\UsuarioBundle\Entity\UserCfgMenu $menu = null)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return \Repository\UsuarioBundle\Entity\UserCfgMenu
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Set role
     *
     * @param \Repository\UsuarioBundle\Entity\UserCfgRole $role
     *
     * @return UserCfgPermiso
     */
    public function setRole(\Repository\UsuarioBundle\Entity\UserCfgRole $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \Repository\UsuarioBundle\Entity\UserCfgRole
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set usuario
     *
     * @param \Repository\UsuarioBundle\Entity\Usuario $usuario
     *
     * @return UserCfgPermiso
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
}
