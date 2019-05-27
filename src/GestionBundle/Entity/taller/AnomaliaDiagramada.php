<?php

namespace GestionBundle\Entity\taller;

use Doctrine\ORM\Mapping as ORM;

/**
 * AnomaliaDiagramada
 *
 * @ORM\Table(name="norm_anomalias_diagramadas")
 * @ORM\Entity
 */
class AnomaliaDiagramada extends TareaDiagramada
{

    /**
     * @ORM\ManyToOne(targetEntity="Anomalia")
     * @ORM\JoinColumn(name="id_tarea_mantenimiento", referencedColumnName="id")
     */    
    private $anomalia;	


    /**
     * Set anomalia
     *
     * @param \GestionBundle\Entity\taller\Anomalia $anomalia
     *
     * @return AnomaliaDiagramada
     */
    public function setAnomalia(\GestionBundle\Entity\taller\Anomalia $anomalia = null)
    {
        $this->anomalia = $anomalia;

        return $this;
    }

    /**
     * Get anomalia
     *
     * @return \GestionBundle\Entity\taller\Anomalia
     */
    public function getAnomalia()
    {
        return $this->anomalia;
    }

    public function getAnomaliaDiagramada()
    {
        return $this->anomalia;
    }

    public function resultadoTarea()
    {
        $this->anomalia->setReparada($this->getRealizada());
        $this->anomalia->setDiagramada($this->getRealizada());
    }
}
