<?php

namespace GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MovimientoCuenta
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="integer")
 * @ORM\DiscriminatorMap({1:"MovimientoCuenta", 2:"MovimientoDebito", 3:"MovimientoCredito", 4:"MovimientoFinanciero", 5:"MovimientoPlanCuota"}) 
 */
abstract class MovimientoCuenta
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
     * @ORM\Column(name="detalle", type="string", length=255)
     */
    private $detalle;

    /**
     * @var float
     *
     * @ORM\Column(name="importe", type="float")
     */
    private $importe;

    /**
     * @var float
     *
     * @ORM\Column(name="cantidad", type="float", nullable=true)
     */
    private $cantidad;    

    /**
    * @ORM\ManyToOne(targetEntity="CtaCteProveedor", inversedBy="movimientos") 
    * @ORM\JoinColumn(name="id_cta", referencedColumnName="id", nullable=false)
    */      
    private $ctacte;      

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */     

    private $fecha;

    /**
    * @ORM\ManyToOne(targetEntity="Articulo") 
    * @ORM\JoinColumn(name="id_articulo", referencedColumnName="id", nullable=true)
    */      
    private $articulo;       

    /**
     * @var float
     *
     * @ORM\Column(name="orden_aparicion", type="float", nullable=true, options={"default"=100000})
     */
    private $orden;

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
     * Set detalle
     *
     * @param string $detalle
     *
     * @return MovimientoCuenta
     */
    public function setDetalle($detalle)
    {
        $this->detalle = $detalle;

        return $this;
    }

    /**
     * Get detalle
     *
     * @return string
     */
    public function getDetalle()
    {
        return $this->detalle;
    }

    /**
     * Set importe
     *
     * @param float $importe
     *
     * @return MovimientoCuenta
     */
    public function setImporte($importe)
    {
        $this->importe = $importe;

        return $this;
    }

    /**
     * Get importe
     *
     * @return float
     */
    public function getImporte()
    {
        return $this->importe;
    }

    /**
     * Set cantidad
     *
     * @param float $cantidad
     *
     * @return MovimientoCuenta
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return float
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set ctacte
     *
     * @param \GestionBundle\Entity\CtaCteProveedor $ctacte
     *
     * @return MovimientoCuenta
     */
    public function setCtacte(\GestionBundle\Entity\CtaCteProveedor $ctacte = null)
    {
        $this->ctacte = $ctacte;

        return $this;
    }

    /**
     * Get ctacte
     *
     * @return \GestionBundle\Entity\CtaCteProveedor
     */
    public function getCtacte()
    {
        return $this->ctacte;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return MovimientoCuenta
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
        return $this->fecha;
    }

    public abstract function getDebito();
    public abstract function getCredito();

    /**
     * Set articulo
     *
     * @param \GestionBundle\Entity\Articulo $articulo
     *
     * @return MovimientoCuenta
     */
    public function setArticulo(\GestionBundle\Entity\Articulo $articulo = null)
    {
        $this->articulo = $articulo;

        return $this;
    }

    /**
     * Get articulo
     *
     * @return \GestionBundle\Entity\Articulo
     */
    public function getArticulo()
    {
        return $this->articulo;
    }

    /**
     * Set orden
     *
     * @param float $orden
     *
     * @return MovimientoCuenta
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return float
     */
    public function getOrden()
    {
        return $this->orden;
    }
}
