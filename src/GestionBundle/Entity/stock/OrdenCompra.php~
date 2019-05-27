<?php

namespace GestionBundle\Entity\stock;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OrdenCompra
 *
 * @ORM\Table(name="norm_orden_compra")
 * @ORM\Entity(repositoryClass="GestionBundle\Entity\stock\OrdenCompraRepository")
 */
class OrdenCompra extends MovimientoInventario
{

    /**
    * @ORM\ManyToOne(targetEntity="GestionBundle\Entity\Proveedor") 
    * @ORM\JoinColumn(name="id_proveedor", referencedColumnName="id")
    * @Assert\NotNull
    */      
    private $proveedor;  

    /**
     * @ORM\Column(type="boolean", name="autorizada", nullable=false, options={"default":false})
     */
    private $autorizada = false;

    /**
     * @ORM\Column(type="string", name="observacion", nullable=true)
     */
    private $observacion;

    /**
     * @ORM\Column(type="boolean", name="impresa", nullable=false, options={"default":false})
     */
    private $impresa = false;
    /**
     * Set proveedor
     *
     * @param \GestionBundle\Entity\Proveedor $proveedor
     *
     * @return EntradaStock
     */
    public function setProveedor(\GestionBundle\Entity\Proveedor $proveedor = null)
    {
        $this->proveedor = $proveedor;

        return $this;
    }

    /**
     * Get proveedor
     *
     * @return \GestionBundle\Entity\Proveedor
     */
    public function getProveedor()
    {
        return $this->proveedor;
    }

    public function getMovimiento()
    {
        return "Entrada";
    }

    public function getCoche()
    {
        return $this->getNumComprobante();
    }  

    public function getIngreso()
    {
        return $this->getCantidad();
    }

    public function getEgreso()
    {
        return 0;
    }

    public function getSaldo()
    {

    }

    public function updatePrecioArticulo() ///evalua si tiene que actualizar el precio de compra del producto
    {
        if ($this->getArticulo()->getUltimaActualizacionPrecio() < $this->getFecha())
        {
            $this->getArticulo()->setUltimaActualizacionPrecio($this->getFecha());
            $this->getArticulo()->setUltimoPrecio($this->getPrecioUnitario());
        }
    }

    /**
     * Set autorizada
     *
     * @param boolean $autorizada
     *
     * @return OrdenCompra
     */
    public function setAutorizada($autorizada)
    {
        $this->autorizada = $autorizada;

        return $this;
    }

    /**
     * Get autorizada
     *
     * @return boolean
     */
    public function getAutorizada()
    {
        return $this->autorizada;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     *
     * @return OrdenCompra
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Set impresa
     *
     * @param boolean $impresa
     *
     * @return OrdenCompra
     */
    public function setImpresa($impresa)
    {
        $this->impresa = $impresa;

        return $this;
    }

    /**
     * Get impresa
     *
     * @return boolean
     */
    public function getImpresa()
    {
        return $this->impresa;
    }
}
