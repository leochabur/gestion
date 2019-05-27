<?php

namespace GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * EntradaStock
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class EntradaStock extends MovimientoStock
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
    * @ORM\ManyToOne(targetEntity="Proveedor") 
    * @ORM\JoinColumn(name="id_proveedor", referencedColumnName="id")
    * @Assert\NotBlank()
    */      
    private $proveedor;  

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
}
