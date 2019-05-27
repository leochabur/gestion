<?php

namespace GestionBundle\Entity\taller;

use Doctrine\ORM\Mapping as ORM;

/**
 * DiagramaTarea
 *
 * @ORM\Table(name="norm_diagramas_tareas")
* @ORM\Entity(repositoryClass="GestionBundle\Entity\taller\DiagramaTareaRepository")
 */
class DiagramaTarea
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
     * @ORM\ManyToOne(targetEntity="GestionBundle\Entity\personal\Conductor")
     * @ORM\JoinColumn(name="id_responsable", referencedColumnName="id")
     */    
    private $responsable;   

    /**
     * @ORM\OneToMany(targetEntity="TareaDiagramada", mappedBy="diagramaTarea", cascade={"persist", "remove"})
     */
    private $tareasProgramadas;    

    /**
     * @var \boolean
     *
     * @ORM\Column(name="procesada", type="boolean", nullable=false, options={"default":false})
     */
    private $procesada = false;    

    /**
     * @var \boolean
     *
     * @ORM\Column(name="cerrada", type="boolean", nullable=false, options={"default":false})
     */
    private $cerrada = false;        

    /**
     * @var \boolean
     *
     * @ORM\Column(name="eliminada", type="boolean", nullable=false, options={"default":false})
     */
    private $eliminada = false;       

    /**
    * @ORM\ManyToOne(targetEntity="GestionUsuariosBundle\Entity\Usuario") 
    * @ORM\JoinColumn(name="id_usuario_carga", referencedColumnName="id")
    */    
    private $usuarioCarga;    

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaProcesado", type="datetime", nullable=true)
     */
    private $fechaProcesado;

    /**
    * @ORM\ManyToOne(targetEntity="GestionUsuariosBundle\Entity\Usuario") 
    * @ORM\JoinColumn(name="id_usuario_proceso", referencedColumnName="id")
    */    
    private $usuarioProcesado;        

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
     * @return DiagramaTarea
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
     * Constructor
     */
    public function __construct()
    {
        $this->tareasProgramadas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set responsable
     *
     * @param \GestionBundle\Entity\personal\Conductor $responsable
     *
     * @return DiagramaTarea
     */
    public function setResponsable(\GestionBundle\Entity\personal\Conductor $responsable = null)
    {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * Get responsable
     *
     * @return \GestionBundle\Entity\personal\Conductor
     */
    public function getResponsable()
    {
        return $this->responsable;
    }



    /**
     * Set procesada
     *
     * @param boolean $procesada
     *
     * @return DiagramaTarea
     */
    public function setProcesada($procesada)
    {
        $this->procesada = $procesada;

        return $this;
    }

    /**
     * Get procesada
     *
     * @return boolean
     */
    public function getProcesada()
    {
        return $this->procesada;
    }

    /**
     * Set usuarioCarga
     *
     * @param \GestionUsuariosBundle\Entity\Usuario $usuarioCarga
     *
     * @return DiagramaTarea
     */
    public function setUsuarioCarga(\GestionUsuariosBundle\Entity\Usuario $usuarioCarga = null)
    {
        $this->usuarioCarga = $usuarioCarga;

        return $this;
    }

    /**
     * Get usuarioCarga
     *
     * @return \GestionUsuariosBundle\Entity\Usuario
     */
    public function getUsuarioCarga()
    {
        return $this->usuarioCarga;
    }

    /**
     * Set cerrada
     *
     * @param boolean $cerrada
     *
     * @return DiagramaTarea
     */
    public function setCerrada($cerrada)
    {
        $this->cerrada = $cerrada;

        return $this;
    }

    /**
     * Get cerrada
     *
     * @return boolean
     */
    public function getCerrada()
    {
        return $this->cerrada;
    }

    /**
     * Set eliminada
     *
     * @param boolean $eliminada
     *
     * @return DiagramaTarea
     */
    public function setEliminada($eliminada)
    {
        $this->eliminada = $eliminada;

        return $this;
    }

    /**
     * Get eliminada
     *
     * @return boolean
     */
    public function getEliminada()
    {
        return $this->eliminada;
    }

    /**
     * Add tareasProgramada
     *
     * @param \GestionBundle\Entity\taller\TareaDiagramada $tareasProgramada
     *
     * @return DiagramaTarea
     */
    public function addTareasProgramada(\GestionBundle\Entity\taller\TareaDiagramada $tareasProgramada)
    {
        $this->tareasProgramadas[] = $tareasProgramada;

        return $this;
    }

    /**
     * Remove tareasProgramada
     *
     * @param \GestionBundle\Entity\taller\TareaDiagramada $tareasProgramada
     */
    public function removeTareasProgramada(\GestionBundle\Entity\taller\TareaDiagramada $tareasProgramada)
    {
        $this->tareasProgramadas->removeElement($tareasProgramada);
    }

    /**
     * Get tareasProgramadas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTareasProgramadas()
    {
        return $this->tareasProgramadas;
    }

    /**
     * Set fechaProcesado
     *
     * @param \DateTime $fechaProcesado
     *
     * @return DiagramaTarea
     */
    public function setFechaProcesado($fechaProcesado)
    {
        $this->fechaProcesado = $fechaProcesado;

        return $this;
    }

    /**
     * Get fechaProcesado
     *
     * @return \DateTime
     */
    public function getFechaProcesado()
    {
        return $this->fechaProcesado;
    }

    /**
     * Set usuarioProcesado
     *
     * @param \GestionUsuariosBundle\Entity\Usuario $usuarioProcesado
     *
     * @return DiagramaTarea
     */
    public function setUsuarioProcesado(\GestionUsuariosBundle\Entity\Usuario $usuarioProcesado = null)
    {
        $this->usuarioProcesado = $usuarioProcesado;

        return $this;
    }

    /**
     * Get usuarioProcesado
     *
     * @return \GestionUsuariosBundle\Entity\Usuario
     */
    public function getUsuarioProcesado()
    {
        return $this->usuarioProcesado;
    }
}
