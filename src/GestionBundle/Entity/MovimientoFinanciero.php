<?php

namespace GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MovimientoFinanciero
 *
 * @ORM\Table()
 * @ORM\Entity
 */
abstract class MovimientoFinanciero extends MovimientoCuenta
{


    /**
    * @ORM\ManyToOne(targetEntity="Unidad") 
    * @ORM\JoinColumn(name="id_unidad", referencedColumnName="id", nullable=true)
    */      
    private $unidad;       

    /**
    * @ORM\ManyToOne(targetEntity="ConceptoMovimientoFinanza") 
    * @ORM\JoinColumn(name="id_concepto", referencedColumnName="id", nullable=false)
    */      
    private $concepto;           

    /**
     * Set unidad
     *
     * @param \GestionBundle\Entity\Unidad $unidad
     *
     * @return MovimientoFinanciero
     */
    public function setUnidad(\GestionBundle\Entity\Unidad $unidad = null)
    {
        $this->unidad = $unidad;

        return $this;
    }

    /**
     * Get unidad
     *
     * @return \GestionBundle\Entity\Unidad
     */
    public function getUnidad()
    {
        return $this->unidad;
    }

    /**
     * Set concepto
     *
     * @param \GestionBundle\Entity\ConceptoMovimientoFinanza $concepto
     *
     * @return MovimientoFinanciero
     */
    public function setConcepto(\GestionBundle\Entity\ConceptoMovimientoFinanza $concepto = null)
    {
        $this->concepto = $concepto;

        return $this;
    }

    /**
     * Get concepto
     *
     * @return \GestionBundle\Entity\ConceptoMovimientoFinanza
     */
    public function getConcepto()
    {
        return $this->concepto;
    }
}
