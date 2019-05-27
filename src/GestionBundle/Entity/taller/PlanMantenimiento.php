<?php

namespace GestionBundle\Entity\taller;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlanMantenimiento
 *
 * @ORM\Table(name="norm_planesmantenimiento")
 * @ORM\Entity
 */
class PlanMantenimiento
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
     * @var string
     *
     * @ORM\Column(name="nombrePlan", type="string", length=255)
     */
    private $nombrePlan;

    /**
     * @ORM\OneToMany(targetEntity="TareaMantenimiento", mappedBy="planMantenimiento")
     */
    private $tareas;

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
     * Set nombrePlan
     *
     * @param string $nombrePlan
     *
     * @return PlanMantenimiento
     */
    public function setNombrePlan($nombrePlan)
    {
        $this->nombrePlan = $nombrePlan;

        return $this;
    }

    /**
     * Get nombrePlan
     *
     * @return string
     */
    public function getNombrePlan()
    {
        return $this->nombrePlan;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tareas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tarea
     *
     * @param \GestionBundle\Entity\taller\TareaMantenimiento $tarea
     *
     * @return PlanMantenimiento
     */
    public function addTarea(\GestionBundle\Entity\taller\TareaMantenimiento $tarea)
    {
        $this->tareas[] = $tarea;

        return $this;
    }

    /**
     * Remove tarea
     *
     * @param \GestionBundle\Entity\taller\TareaMantenimiento $tarea
     */
    public function removeTarea(\GestionBundle\Entity\taller\TareaMantenimiento $tarea)
    {
        $this->tareas->removeElement($tarea);
    }

    /**
     * Get tareas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTareas()
    {
        return $this->tareas;
    }

    public function __toString()
    {
        return $this->nombrePlan;
    }    
}
