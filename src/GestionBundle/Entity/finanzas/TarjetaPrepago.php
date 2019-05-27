<?php

namespace GestionBundle\Entity\finanzas;
use GestionBundle\Entity\MovimientoDebito;

use Doctrine\ORM\Mapping as ORM;

/**
 * TarjetaPrepago
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class TarjetaPrepago extends FormaPago
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
    * @ORM\ManyToOne(targetEntity="GestionBundle\Entity\Proveedor") 
    * @ORM\JoinColumn(name="id_proveedor_externo", referencedColumnName="id")
    */      
    private $proveedorExterno;          



    /**
     * Set proveedorExterno
     *
     * @param \GestionBundle\Entity\Proveedor $proveedorExterno
     *
     * @return TarjetaPrepago
     */
    public function setProveedorExterno(\GestionBundle\Entity\Proveedor $proveedorExterno = null)
    {
        $this->proveedorExterno = $proveedorExterno;

        return $this;
    }

    /**
     * Get proveedorExterno
     *
     * @return \GestionBundle\Entity\Proveedor
     */
    public function getProveedorExterno()
    {
        return $this->proveedorExterno;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return "Tarjeta Prepago ".$this->proveedorExterno;
    }

    public function cargarCuentaExterna($credito)
    {
        if ($this->proveedorExterno)
        {        
            $debito = new MovimientoDebito();
            $debito->setFecha($credito->getFecha());
            $debito->setDetalle('Extraccion con Tarjeta');
            $debito->setCantidad($credito->getCantidad());
            $debito->setImporte($credito->getImporte());
            $debito->setArticulo($credito->getArticulo());
            return $debito;
        }
        return null;
    }

}
