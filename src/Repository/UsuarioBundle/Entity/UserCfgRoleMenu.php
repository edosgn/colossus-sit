<?php

namespace Repository\UsuarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserCfgRoleMenu
 *
 * @ORM\Table(name="user_cfg_role_menu")
 * @ORM\Entity(repositoryClass="Repository\UsuarioBundle\Repository\UserCfgRoleMenuRepository")
 */
class UserCfgRoleMenu
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

    /** @ORM\ManyToOne(targetEntity="UserCfgMenu", inversedBy="roles") */
    private $menu;

    /** @ORM\ManyToOne(targetEntity="UserCfgRole", inversedBy="menus") */
    private $role;


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
     * @return UserCfgRoleMenu
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
     * Set menu
     *
     * @param \Repository\UsuarioBundle\Entity\UserCfgMenu $menu
     *
     * @return UserCfgRoleMenu
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
     * @return UserCfgRoleMenu
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
}
