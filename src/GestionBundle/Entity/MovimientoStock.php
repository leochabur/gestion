<?php

namespace GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * MovimientoStock
 *
 * @ORM\Table(name="movimiento_stock")
 * @ORM\Entity(repositoryClass="GestionBundle\Entity\MovimientoStockRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="integer")
 * @ORM\DiscriminatorMap({1:"MovimientoStock", 2:"EntradaStock", 3:"SalidaStock"})
 */
abstract class MovimientoStock
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     * @Assert\NotBlank()
     */     

    private $fecha;

    /**
     * @var float
     *
     * @ORM\Column(name="cantidad", type="float")
     * @Assert\NotBlank()     
     */
    private $cantidad;

    /**
     * @var integer
     *
     * @ORM\Column(name="numComprobante", type="integer", nullable=true)
     */
    private $numComprobante;

    /**
    * @ORM\ManyToOne(targetEntity="Articulo") 
    * @ORM\JoinColumn(name="id_articulo", referencedColumnName="id")
    * @Assert\NotBlank()    
    */      
    private $articulo;    

    /**
    * @ORM\ManyToOne(targetEntity="OrigenMovimiento") 
    * @ORM\JoinColumn(name="id_origen", referencedColumnName="id")
    * @Assert\NotBlank()    
    */      
    private $origenMovimiento;        

    /**
    * @ORM\ManyToOne(targetEntity="GestionBundle\Entity\stock\ItemMovimiento") 
    * @ORM\JoinColumn(name="id_item_orden_compra", referencedColumnName="id", nullable=true)
    */      
    private $itemOrdenCompra; 


    /**
     * @var float
     *
     * @ORM\Column(name="precioUnitario", type="float")
     */
    private $precioUnitario;    


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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return MovimientoStock
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

    /**
     * Set cantidad
     *
     * @param float $cantidad
     *
     * @return MovimientoStock
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
     * Set numComprobante
     *
     * @param integer $numComprobante
     *
     * @return MovimientoStock
     */
    public function setNumComprobante($numComprobante)
    {
        $this->numComprobante = $numComprobante;

        return $this;
    }

    /**
     * Get numComprobante
     *
     * @return integer
     */
    public function getNumComprobante()
    {
        return $this->numComprobante;
    }

    /**
     * Set articulo
     *
     * @param \GestionBundle\Entity\Articulo $articulo
     *
     * @return MovimientoStock
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

    public abstract function getMovimiento();
    public abstract function getCoche();    
    public abstract function getIngreso();
    public abstract function getEgreso();
    public abstract function getSaldo();
    public abstract function updatePrecioArticulo();

    /**
     * Set precioUnitario
     *
     * @param float $precioUnitario
     *
     * @return MovimientoStock
     */
    public function setPrecioUnitario($precioUnitario)
    {
        $this->precioUnitario = $precioUnitario;

        return $this;
    }

    /**
     * Get precioUnitario
     *
     * @return float
     */
    public function getPrecioUnitario()
    {
        return $this->precioUnitario;
    }

    /**
     * Set origenMovimiento
     *
     * @param \GestionBundle\Entity\OrigenMovimiento $origenMovimiento
     *
     * @return MovimientoStock
     */
    public function setOrigenMovimiento(\GestionBundle\Entity\OrigenMovimiento $origenMovimiento = null)
    {
        $this->origenMovimiento = $origenMovimiento;

        return $this;
    }

    /**
     * Get origenMovimiento
     *
     * @return \GestionBundle\Entity\OrigenMovimiento
     */
    public function getOrigenMovimiento()
    {
        return $this->origenMovimiento;
    }

    public function getMontoTotal()
    {
        return ($this->cantidad*$this->precioUnitario);
    }

    /**
     * Set itemOrdenCompra
     *
     * @param \GestionBundle\Entity\stock\ItemMovimiento $itemOrdenCompra
     *
     * @return MovimientoStock
     */
    public function setItemOrdenCompra(\GestionBundle\Entity\stock\ItemMovimiento $itemOrdenCompra = null)
    {
        $this->itemOrdenCompra = $itemOrdenCompra;

        return $this;
    }

    /**
     * Get itemOrdenCompra
     *
     * @return \GestionBundle\Entity\stock\ItemMovimiento
     */
    public function getItemOrdenCompra()
    {
        return $this->itemOrdenCompra;
    }
}
