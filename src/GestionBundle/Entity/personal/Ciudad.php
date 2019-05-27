<?php

namespace GestionBundle\Entity\personal;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ciudad
 *
 * @ORM\Table(name="ciudades")
 * @ORM\Entity
 */
class Ciudad
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="impresion", type="string", length=255, nullable=true)
     */
    private $impresion;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoServicio", type="string", length=255, nullable=true)
     */
    private $tipoServicio;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Ciudad
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set impresion
     *
     * @param string $impresion
     *
     * @return Ciudad
     */
    public function setImpresion($impresion)
    {
        $this->impresion = $impresion;

        return $this;
    }

    /**
     * Get impresion
     *
     * @return string
     */
    public function getImpresion()
    {
        return $this->impresion;
    }

    /**
     * Set tipoServicio
     *
     * @param string $tipoServicio
     *
     * @return Ciudad
     */
    public function setTipoServicio($tipoServicio)
    {
        $this->tipoServicio = $tipoServicio;

        return $this;
    }

    /**
     * Get tipoServicio
     *
     * @return string
     */
    public function getTipoServicio()
    {
        return $this->tipoServicio;
    }
}
