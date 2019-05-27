<?php

namespace GestionBundle\Entity\taller;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * TareaMantenimiento
 *
 * @ORM\Table(name="norm_tareasmantenimiento")
 * @ORM\Entity
 */
class TareaMantenimiento
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
     * @ORM\Column(name="tarea", type="string", length=255)
     * @Assert\NotNull() 
     */
    private $tarea;


    /**
     * @var boolean
     *
     * @ORM\Column(name="controlaPorKm", type="boolean")
     * @Assert\NotNull() 
     */
    private $controlaPorKm;

    /**
     * @var integer
     *
     * @ORM\Column(name="periodicidad", type="integer")
     * @Assert\NotNull() 
     */
    private $periodicidad;    

    /**
    * @ORM\ManyToOne(targetEntity="TipoDesperfecto") 
    * @ORM\JoinColumn(name="id_tipo", referencedColumnName="id")
    * @Assert\NotNull() 
    */      
    private $tipo;       

    /**
     * @ORM\ManyToOne(targetEntity="PlanMantenimiento", inversedBy="tareas")
     * @ORM\JoinColumn(name="id_plan_mantenimiento", referencedColumnName="id")
     */    
    private $planMantenimiento;

    /**
     * @ORM\ManyToMany(targetEntity="GestionBundle\Entity\Unidad")
     * @ORM\JoinTable(name="norm_unidades_por_tarea",
     *      joinColumns={@ORM\JoinColumn(name="id_tarea", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_unidad", referencedColumnName="id")}
     *      )
     */
    private $unidades;
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
     * Set tarea
     *
     * @param string $tarea
     *
     * @return TareaMantenimiento
     */
    public function setTarea($tarea)
    {
        $this->tarea = $tarea;

        return $this;
    }

    /**
     * Get tarea
     *
     * @return string
     */
    public function getTarea()
    {
        return $this->tarea;
    }

    /**
     * Set tipo
     *
     * @param \GestionBundle\Entity\taller\TipoDesperfecto $tipo
     *
     * @return TareaMantenimiento
     */
    public function setTipo(\GestionBundle\Entity\taller\TipoDesperfecto $tipo = null)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return \GestionBundle\Entity\taller\TipoDesperfecto
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set planMantenimiento
     *
     * @param \GestionBundle\Entity\taller\PlanMantenimiento $planMantenimiento
     *
     * @return TareaMantenimiento
     */
    public function setPlanMantenimiento(\GestionBundle\Entity\taller\PlanMantenimiento $planMantenimiento = null)
    {
        $this->planMantenimiento = $planMantenimiento;

        return $this;
    }

    /**
     * Get planMantenimiento
     *
     * @return \GestionBundle\Entity\taller\PlanMantenimiento
     */
    public function getPlanMantenimiento()
    {
        return $this->planMantenimiento;
    }

    public function __toString()
    {
        return $this->tarea;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->unidades = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add unidade
     *
     * @param \GestionBundle\Entity\Unidad $unidade
     *
     * @return TareaMantenimiento
     */
    public function addUnidade(\GestionBundle\Entity\Unidad $unidade)
    {
        $this->unidades[] = $unidade;

        return $this;
    }

    /**
     * Remove unidade
     *
     * @param \GestionBundle\Entity\Unidad $unidade
     */
    public function removeUnidade(\GestionBundle\Entity\Unidad $unidade)
    {
        $this->unidades->removeElement($unidade);
    }

    /**
     * Get unidades
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUnidades()
    {
        return $this->unidades;
    }

    /**
     * Set controlaPorKm
     *
     * @param boolean $controlaPorKm
     *
     * @return TareaMantenimiento
     */
    public function setControlaPorKm($controlaPorKm)
    {
        $this->controlaPorKm = $controlaPorKm;

        return $this;
    }

    /**
     * Get controlaPorKm
     *
     * @return boolean
     */
    public function getControlaPorKm()
    {
        return $this->controlaPorKm;
    }

    /**
     * Set periodicidad
     *
     * @param integer $periodicidad
     *
     * @return TareaMantenimiento
     */
    public function setPeriodicidad($periodicidad)
    {
        $this->periodicidad = $periodicidad;

        return $this;
    }

    /**
     * Get periodicidad
     *
     * @return integer
     */
    public function getPeriodicidad()
    {
        return $this->periodicidad;
    }
}
