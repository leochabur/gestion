<?php

namespace GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MovimientoPlanCuota
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class MovimientoPlanCuota extends MovimientoFinanciero
{

    /**
     * @var integer
     *
     * @ORM\Column(name="numeroCuota", type="integer")
     */
    private $numeroCuota;

    private $multiplicaPor;

    public function getMultiplicaPor()
    {
        return $this->multiplicaPor;
    }

    public function setMultiplicaPor($mult)
    {
        $this->multiplicaPor = $mult;
    }

    /**
     * Set numeroCuota
     *
     * @param integer $numeroCuota
     *
     * @return MovimientoPlanCuota
     */
    public function setNumeroCuota($numeroCuota)
    {
        $this->numeroCuota = $numeroCuota;

        return $this;
    }

    /**
     * Get numeroCuota
     *
     * @return integer
     */
    public function getNumeroCuota()
    {
        return $this->numeroCuota;
    }

    public function getDebito()
    {
        return $this->getImporte();
    }

    public function getCredito()
    {
        
    }    
}
