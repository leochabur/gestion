<?php

namespace GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Articulo
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="GestionBundle\Entity\ArticuloRepository")
 */
class Articulo
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
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $descripcion;

    /**
     * @var float
     *
     * @ORM\Column(name="ultimoPrecio", type="float", nullable=true)
     */
    private $ultimoPrecio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ultimaActualizacionPrecio", type="date", nullable=true)
     */     

    private $ultimaActualizacionPrecio;    

    /**
     * @var float
     *
     * @ORM\Column(name="stock", type="float", nullable=true)
     */
    private $stock;    

    /**
     * @var string
     *
     * @ORM\Column(name="codBarras", type="string", length=255, nullable=true)
     */   
    private $codigoBarras;


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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Articulo
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set ultimoPrecio
     *
     * @param float $ultimoPrecio
     *
     * @return Articulo
     */
    public function setUltimoPrecio($ultimoPrecio)
    {
        $this->ultimoPrecio = $ultimoPrecio;

        return $this;
    }

    /**
     * Get ultimoPrecio
     *
     * @return float
     */
    public function getUltimoPrecio()
    {
        return $this->ultimoPrecio;
    }

    /**
     * Set stock
     *
     * @param float $stock
     *
     * @return Articulo
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return float
     */
    public function getStock()
    {
        return $this->stock;
    }

    public function __toString()
    {
        return strtoupper($this->descripcion);
    }

    /**
     * Set ultimaActualizacionPrecio
     *
     * @param \DateTime $ultimaActualizacionPrecio
     *
     * @return Articulo
     */
    public function setUltimaActualizacionPrecio($ultimaActualizacionPrecio)
    {
        $this->ultimaActualizacionPrecio = $ultimaActualizacionPrecio;

        return $this;
    }

    /**
     * Get ultimaActualizacionPrecio
     *
     * @return \DateTime
     */
    public function getUltimaActualizacionPrecio()
    {
        return $this->ultimaActualizacionPrecio;
    }

    /**
     * Set codigoBarras
     *
     * @param string $codigoBarras
     *
     * @return Articulo
     */
    public function setCodigoBarras($codigoBarras)
    {
        $this->codigoBarras = $codigoBarras;

        return $this;
    }

    /**
     * Get codigoBarras
     *
     * @return string
     */
    public function getCodigoBarras()
    {
        return $this->codigoBarras;
    }
}
