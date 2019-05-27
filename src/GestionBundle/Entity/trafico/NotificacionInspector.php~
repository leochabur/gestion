<?php

namespace GestionBundle\Entity\trafico;

use Doctrine\ORM\Mapping as ORM;

/**
 * NotificacionInspector
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class NotificacionInspector extends Notificacion
{
    /**
    * @ORM\ManyToOne(targetEntity="GestionBundle\Entity\personal\Conductor") 
    * @ORM\JoinColumn(name="id_personal_afectado", referencedColumnName="id", nullable=true)
    */      
    private $personalAfectado;   

    /**
    * @ORM\ManyToOne(targetEntity="GestionBundle\Entity\Unidad") 
    * @ORM\JoinColumn(name="id_unidad_afectada", referencedColumnName="id", nullable=true)
    */      
    private $unidadAfectada;     

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaResolucion", type="date", nullable=true)
     */
    private $fechaResolucion;     

    /**
    * @ORM\ManyToOne(targetEntity="GestionBundle\Entity\personal\Conductor") 
    * @ORM\JoinColumn(name="id_responsable_resolucion", referencedColumnName="id", nullable=true)
    */      
    private $responsableResolucion;  

    /**
     * @var string
     *
     * @ORM\Column(name="descripcionResolucion", type="text", nullable=true)
     */
    private $detalleResolucion;          

    /**
     * Set personalAfectado
     *
     * @param \GestionBundle\Entity\personal\Conductor $personalAfectado
     *
     * @return NotificacionInspector
     */
    public function setPersonalAfectado(\GestionBundle\Entity\personal\Conductor $personalAfectado = null)
    {
        $this->personalAfectado = $personalAfectado;

        return $this;
    }

    /**
     * Get personalAfectado
     *
     * @return \GestionBundle\Entity\personal\Conductor
     */
    public function getPersonalAfectado()
    {
        return $this->personalAfectado;
    }

    /**
     * Set unidadAfectada
     *
     * @param \GestionBundle\Entity\Unidad $unidadAfectada
     *
     * @return NotificacionInspector
     */
    public function setUnidadAfectada(\GestionBundle\Entity\Unidad $unidadAfectada = null)
    {
        $this->unidadAfectada = $unidadAfectada;

        return $this;
    }

    /**
     * Get unidadAfectada
     *
     * @return \GestionBundle\Entity\Unidad
     */
    public function getUnidadAfectada()
    {
        return $this->unidadAfectada;
    }

    /**
     * Set fechaResolucion
     *
     * @param \DateTime $fechaResolucion
     *
     * @return NotificacionInspector
     */
    public function setFechaResolucion($fechaResolucion)
    {
        $this->fechaResolucion = $fechaResolucion;

        return $this;
    }

    /**
     * Get fechaResolucion
     *
     * @return \DateTime
     */
    public function getFechaResolucion()
    {
        return $this->fechaResolucion;
    }

    /**
     * Set detalleResolucion
     *
     * @param string $detalleResolucion
     *
     * @return NotificacionInspector
     */
    public function setDetalleResolucion($detalleResolucion)
    {
        $this->detalleResolucion = $detalleResolucion;

        return $this;
    }

    /**
     * Get detalleResolucion
     *
     * @return string
     */
    public function getDetalleResolucion()
    {
        return $this->detalleResolucion;
    }

    /**
     * Set responsableResolucion
     *
     * @param \GestionBundle\Entity\personale\Conductor $responsableResolucion
     *
     * @return NotificacionInspector
     */
    public function setResponsableResolucion(\GestionBundle\Entity\personale\Conductor $responsableResolucion = null)
    {
        $this->responsableResolucion = $responsableResolucion;

        return $this;
    }

    /**
     * Get responsableResolucion
     *
     * @return \GestionBundle\Entity\personale\Conductor
     */
    public function getResponsableResolucion()
    {
        return $this->responsableResolucion;
    }
}
