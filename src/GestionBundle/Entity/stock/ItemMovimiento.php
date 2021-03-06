<?php

namespace GestionBundle\Entity\stock;

use Doctrine\ORM\Mapping as ORM;

/**
 * ItemMovimiento
 *
 * @ORM\Table(name="norm_items_movimientos")
 * @ORM\Entity
 */
class ItemMovimiento
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
     * @var float
     *
     * @ORM\Column(name="cantidad", type="float")
     */
    private $cantidad;

    /**
     * @var float
     *
     * @ORM\Column(name="unitario", type="float", nullable=true)
     */
    private $unitario;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float", nullable=true)
     */
    private $total;

    /**
     * @ORM\ManyToOne(targetEntity="GestionBundle\Entity\Articulo")
     * @ORM\JoinColumn(name="id_articulo", referencedColumnName="id")
     */  
    private $articulo;

    /**
     * @ORM\ManyToOne(targetEntity="MovimientoInventario", inversedBy="items")
     * @ORM\JoinColumn(name="id_movimiento", referencedColumnName="id")
     */    
    private $movimiento;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ingresadoAStock", type="boolean", nullable=false, options={"default":false})
     */
    private $ingresadoAStock = false;


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
     * Set cantidad
     *
     * @param float $cantidad
     *
     * @return ItemMovimiento
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
     * Set unitario
     *
     * @param float $unitario
     *
     * @return ItemMovimiento
     */
    public function setUnitario($unitario)
    {
        $this->unitario = $unitario;

        return $this;
    }

    /**
     * Get unitario
     *
     * @return float
     */
    public function getUnitario()
    {
        return $this->unitario;
    }

    /**
     * Set total
     *
     * @param float $total
     *
     * @return ItemMovimiento
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set articulo
     *
     * @param \GestionBundle\Entity\Articulo $articulo
     *
     * @return ItemMovimiento
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
     * Set movimiento
     *
     * @param \GestionBundle\Entity\stock\MovimientoInventario $movimiento
     *
     * @return ItemMovimiento
     */
    public function setMovimiento(\GestionBundle\Entity\stock\MovimientoInventario $movimiento = null)
    {
        $this->movimiento = $movimiento;

        return $this;
    }

    /**
     * Get movimiento
     *
     * @return \GestionBundle\Entity\stock\MovimientoInventario
     */
    public function getMovimiento()
    {
        return $this->movimiento;
    }

    /**
     * Set ingresadoAStock
     *
     * @param boolean $ingresadoAStock
     *
     * @return ItemMovimiento
     */
    public function setIngresadoAStock($ingresadoAStock)
    {
        $this->ingresadoAStock = $ingresadoAStock;

        return $this;
    }

    /**
     * Get ingresadoAStock
     *
     * @return boolean
     */
    public function getIngresadoAStock()
    {
        return $this->ingresadoAStock;
    }
}
