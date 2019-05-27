<?php

namespace GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MovimientoCredito
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class MovimientoCredito extends MovimientoCuenta
{

    /**
    * @ORM\ManyToOne(targetEntity="GestionBundle\Entity\finanzas\FormaPago") 
    * @ORM\JoinColumn(name="id_forma_pago", referencedColumnName="id", nullable=false)
    */      
    private $formaPago;        


    public function getDebito()
    {
        return 0;
    }

    public function getCredito()
    {
        if ($this->getCtaCte()->getMuestraXImporte())
            return $this->getImporte();     
        else
        {
            return $this->getCantidad();
        }   
    }    

    /**
     * Set formaPago
     *
     * @param \GestionBundle\Entity\finanzas\FormaPago $formaPago
     *
     * @return MovimientoCredito
     */
    public function setFormaPago(\GestionBundle\Entity\finanzas\FormaPago $formaPago = null)
    {
        $this->formaPago = $formaPago;

        return $this;
    }

    /**
     * Get formaPago
     *
     * @return \GestionBundle\Entity\finanzas\FormaPago
     */
    public function getFormaPago()
    {
        return $this->formaPago;
    }
}
