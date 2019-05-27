<?php

namespace GestionBundle\Entity\taller;

use Doctrine\ORM\Mapping as ORM;

/**
 * TareaProgramada
 *
 * @ORM\Table(name="norm_tareas_programadas")
 * @ORM\Entity
 */
class TareaProgramada extends TareaDiagramada
{
    /**
     * @ORM\ManyToOne(targetEntity="TareaMantenimiento")
     * @ORM\JoinColumn(name="id_tarea_mantenimiento", referencedColumnName="id")
     */    
    private $tarea;

    /**
     * Set tarea
     *
     * @param \GestionBundle\Entity\taller\TareaMantenimiento $tarea
     *
     * @return TareaProgramada
     */
    public function setTarea(\GestionBundle\Entity\taller\TareaMantenimiento $tarea = null)
    {
        $this->tarea = $tarea;

        return $this;
    }

    /**
     * Get tarea
     *
     * @return \GestionBundle\Entity\taller\TareaMantenimiento
     */
    public function getTarea()
    {
        return $this->tarea;
    }

    public function getAnomaliaDiagramada()
    {
        return null;
    }

    public function resultadoTarea()
    {

    }    
}
