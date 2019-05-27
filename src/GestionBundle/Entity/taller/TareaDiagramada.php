<?php

namespace GestionBundle\Entity\taller;

use Doctrine\ORM\Mapping as ORM;

/**
 * TareaDiagramada
 *
 * @ORM\Table(name="norm_tareas_diagramadas")
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="integer")
 * @ORM\DiscriminatorMap({1:"TareaDiagramada", 2:"TareaProgramada", 3:"AnomaliaDiagramada"})
 */
abstract class TareaDiagramada
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
     * @var boolean
     *
     * @ORM\Column(name="realizada", type="boolean")
     */
    private $realizada = false;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;   

    /**
     * @var string
     *
     * @ORM\Column(name="descripcionTrabajo", type="text", nullable=true)
     */
    private $descripcionTrabajo;   

    /**
     * @ORM\ManyToOne(targetEntity="DiagramaTarea", inversedBy="tareasProgramadas")
     * @ORM\JoinColumn(name="id_diagrama_tareas", referencedColumnName="id")
     */    
    private $diagramaTarea;    

    /**
     * @ORM\ManyToOne(targetEntity="GestionBundle\Entity\Unidad")
     * @ORM\JoinColumn(name="id_unidad", referencedColumnName="id")
     */    
    private $unidad;   

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
     * Set realizada
     *
     * @param boolean $realizada
     *
     * @return TareaDiagramada
     */
    public function setRealizada($realizada)
    {
        $this->realizada = $realizada;

        return $this;
    }

    /**
     * Get realizada
     *
     * @return boolean
     */
    public function getRealizada()
    {
        return $this->realizada;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return TareaDiagramada
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set diagramaTarea
     *
     * @param \GestionBundle\Entity\taller\DiagramaTarea $diagramaTarea
     *
     * @return TareaDiagramada
     */
    public function setDiagramaTarea(\GestionBundle\Entity\taller\DiagramaTarea $diagramaTarea = null)
    {
        $this->diagramaTarea = $diagramaTarea;

        return $this;
    }

    /**
     * Get diagramaTarea
     *
     * @return \GestionBundle\Entity\taller\DiagramaTarea
     */
    public function getDiagramaTarea()
    {
        return $this->diagramaTarea;
    }

    /**
     * Set unidad
     *
     * @param \GestionBundle\Entity\Unidad $unidad
     *
     * @return TareaDiagramada
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

    public abstract function getAnomaliaDiagramada();

    /**
     * Set descripcionTrabajo
     *
     * @param string $descripcionTrabajo
     *
     * @return TareaDiagramada
     */
    public function setDescripcionTrabajo($descripcionTrabajo)
    {
        $this->descripcionTrabajo = $descripcionTrabajo;

        return $this;
    }

    /**
     * Get descripcionTrabajo
     *
     * @return string
     */
    public function getDescripcionTrabajo()
    {
        return $this->descripcionTrabajo;
    }

    public abstract function resultadoTarea();
}
