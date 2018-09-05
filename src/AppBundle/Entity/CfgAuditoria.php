<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CfgAuditoria
 *
 * @ORM\Table(name="cfg_auditoria")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CfgAuditoriaRepository")
 */
class CfgAuditoria
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
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="text")
     */
    private $token;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var array
     *
     * @ORM\Column(name="datos", type="array")
     */
    private $datos;

    /**
     * @var string
     *
     * @ORM\Column(name="accion", type="string", length=100)
     */
    private $accion;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=255)
     */
    private $ip;


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
     * Set url
     *
     * @param string $url
     *
     * @return CfgAuditoria
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return CfgAuditoria
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return CfgAuditoria
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha->format('Y-m-d h:i:s A');
    }

    /**
     * Set datos
     *
     * @param array $datos
     *
     * @return CfgAuditoria
     */
    public function setDatos($datos)
    {
        $this->datos = $datos;

        return $this;
    }

    /**
     * Get datos
     *
     * @return array
     */
    public function getDatos()
    {
        return $this->datos;
    }

    /**
     * Set accion
     *
     * @param string $accion
     *
     * @return CfgAuditoria
     */
    public function setAccion($accion)
    {
        $this->accion = $accion;

        return $this;
    }

    /**
     * Get accion
     *
     * @return string
     */
    public function getAccion()
    {
        return $this->accion;
    }

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return CfgAuditoria
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }
}
