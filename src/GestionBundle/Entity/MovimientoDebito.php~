<?php

namespace GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MovimientoDebito
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class MovimientoDebito extends MovimientoCuenta
{
    /**
    * @ORM\ManyToOne(targetEntity="EntradaStock") 
    * @ORM\JoinColumn(name="id_entrada", referencedColumnName="id", nullable=true)
    */      
    private $movimiento;      

    /**
     * Set movimiento
     *
     * @param \GestionBundle\Entity\EntradaStock $movimiento
     *
     * @return MovimientoDebito
     */
    public function setMovimiento(\GestionBundle\Entity\EntradaStock $movimiento = null)
    {
        $this->movimiento = $movimiento;

        return $this;
    }

    /**
     * Get movimiento
     *
     * @return \GestionBundle\Entity\EntradaStock
     */
    public function getMovimiento()
    {
        return $this->movimiento;
    }

    public function getDebito()
    {
        if ($this->getCtaCte()->getMuestraXImporte())
            return $this->getImporte();
        else
            return $this->getCantidad();
    }

    public function getCredito()
    {
        return 0;
    }
}
