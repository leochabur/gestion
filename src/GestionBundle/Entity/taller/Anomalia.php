<?php

namespace GestionBundle\Entity\taller;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Anomalia
 *
 * @ORM\Table(name="norm_anomalias")
 * @ORM\Entity(repositoryClass="GestionBundle\Entity\taller\AnomaliaRepository")
 */
class Anomalia
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechacarga", type="datetime")
     */
    private $fechacarga;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="text")
     */
    private $observacion;

    /**
    * @ORM\ManyToOne(targetEntity="TipoDesperfecto") 
    * @ORM\JoinColumn(name="id_tipo_desperfecto", referencedColumnName="id")
    * @Assert\NotNull()  
    */      
    private $tipoDesperfecto;   

    /**
     * @var \integer
     *
     * @ORM\Column(name="numPlanilla", type="integer")
     */
    private $numPlanilla;    

    /**
    * @ORM\ManyToOne(targetEntity="GestionBundle\Entity\Unidad") 
    * @ORM\JoinColumn(name="id_unidad", referencedColumnName="id")
    * @Assert\NotNull() 
    */      
    private $unidad; 

    /**
    * @ORM\ManyToOne(targetEntity="GestionBundle\Entity\personal\Conductor") 
    * @ORM\JoinColumn(name="id_personaje", referencedColumnName="id", nullable=true)
    */      
    private $personaje;      

    /**
     * @var \boolean
     *
     * @ORM\Column(name="diagramada", type="boolean", options={"default":false})
     */
    private $diagramada = false; 

    /**
     * @var \boolean
     *
     * @ORM\Column(name="reparada", type="boolean", options={"default":false})
     */
    private $reparada = false;         



      public function __construct()
      {
        $this->fechacarga = new \DateTime();
      }    

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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Anomalia
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set fechacarga
     *
     * @param \DateTime $fechacarga
     *
     * @return Anomalia
     */
    public function setFechacarga($fechacarga)
    {
        $this->fechacarga = $fechacarga;

        return $this;
    }

    /**
     * Get fechacarga
     *
     * @return \DateTime
     */
    public function getFechacarga()
    {
        return $this->fechacarga;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     *
     * @return Anomalia
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Set tipoDesperfecto
     *
     * @param \GestionBundle\Entity\taller\TipoDesperfecto $tipoDesperfecto
     *
     * @return Anomalia
     */
    public function setTipoDesperfecto(\GestionBundle\Entity\taller\TipoDesperfecto $tipoDesperfecto = null)
    {
        $this->tipoDesperfecto = $tipoDesperfecto;

        return $this;
    }

    /**
     * Get tipoDesperfecto
     *
     * @return \GestionBundle\Entity\taller\TipoDesperfecto
     */
    public function getTipoDesperfecto()
    {
        return $this->tipoDesperfecto;
    }

    /**
     * Set unidad
     *
     * @param \GestionBundle\Entity\Unidad $unidad
     *
     * @return Anomalia
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
     * Set numPlanilla
     *
     * @param integer $numPlanilla
     *
     * @return Anomalia
     */
    public function setNumPlanilla($numPlanilla)
    {
        $this->numPlanilla = $numPlanilla;

        return $this;
    }

    /**
     * Get numPlanilla
     *
     * @return integer
     */
    public function getNumPlanilla()
    {
        return $this->numPlanilla;
    }



    /**
     * Set personaje
     *
     * @param \GestionBundle\Entity\personal\Conductor $personaje
     *
     * @return Anomalia
     */
    public function setPersonaje(\GestionBundle\Entity\personal\Conductor $personaje = null)
    {
        $this->personaje = $personaje;

        return $this;
    }

    /**
     * Get personaje
     *
     * @return \GestionBundle\Entity\personal\Conductor
     */
    public function getPersonaje()
    {
        return $this->personaje;
    }

    /**
     * Set diagramada
     *
     * @param boolean $diagramada
     *
     * @return Anomalia
     */
    public function setDiagramada($diagramada)
    {
        $this->diagramada = $diagramada;

        return $this;
    }

    /**
     * Get diagramada
     *
     * @return boolean
     */
    public function getDiagramada()
    {
        return $this->diagramada;
    }

    /**
     * Set reparada
     *
     * @param boolean $reparada
     *
     * @return Anomalia
     */
    public function setReparada($reparada)
    {
        $this->reparada = $reparada;

        return $this;
    }

    /**
     * Get reparada
     *
     * @return boolean
     */
    public function getReparada()
    {
        return $this->reparada;
    }
}
