<?php

namespace GestionBundle\Entity\taller;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlanillaRecepcionAnomalia
 *
 * @ORM\Table(name="norm_planilla_recepcion_anomalias")
 * @ORM\Entity(repositoryClass="GestionBundle\Entity\taller\PlanillaRecepcionAnomaliaRepository")
 */
class PlanillaRecepcionAnomalia
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
     * @var integer
     *
     * @ORM\Column(name="numeroF0015", type="integer")
     */
    private $numeroF0015;

    /**
     * @ORM\ManyToOne(targetEntity="GestionBundle\Entity\personal\Conductor")
     * @ORM\JoinColumn(name="id_conductor", referencedColumnName="id")
     */
    private $conductor;     

    /**
     * @ORM\ManyToOne(targetEntity="GestionUsuariosBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="id_user_alta", referencedColumnName="id")
     */
    private $userAlta;     

    /**
     * @ORM\OneToMany(targetEntity="NovedadInterno", mappedBy="planillaRecepcion", cascade={"persist", "remove"})
     */
    private $novedad;   

    /**
     *
     * @ORM\Column(name="cerrada", type="boolean", options={"default":false})
     */
    private $cerrada = false;  

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
     * @return PlanillaRecepcionAnomalia
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
     * Set numeroF0015
     *
     * @param integer $numeroF0015
     *
     * @return PlanillaRecepcionAnomalia
     */
    public function setNumeroF0015($numeroF0015)
    {
        $this->numeroF0015 = $numeroF0015;

        return $this;
    }

    /**
     * Get numeroF0015
     *
     * @return integer
     */
    public function getNumeroF0015()
    {
        return $this->numeroF0015;
    }

    /**
     * Set conductor
     *
     * @param \GestionBundle\Entity\personal\Conductor $conductor
     *
     * @return PlanillaRecepcionAnomalia
     */
    public function setConductor(\GestionBundle\Entity\personal\Conductor $conductor = null)
    {
        $this->conductor = $conductor;

        return $this;
    }

    /**
     * Get conductor
     *
     * @return \GestionBundle\Entity\personal\Conductor
     */
    public function getConductor()
    {
        return $this->conductor;
    }

    /**
     * Set userAlta
     *
     * @param \GestionUsuariosBundle\Entity\Usuario $userAlta
     *
     * @return PlanillaRecepcionAnomalia
     */
    public function setUserAlta(\GestionUsuariosBundle\Entity\Usuario $userAlta = null)
    {
        $this->userAlta = $userAlta;

        return $this;
    }

    /**
     * Get userAlta
     *
     * @return \GestionUsuariosBundle\Entity\Usuario
     */
    public function getUserAlta()
    {
        return $this->userAlta;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->novedad = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add novedad
     *
     * @param \GestionBundle\Entity\taller\NovedadInterno $novedad
     *
     * @return PlanillaRecepcionAnomalia
     */
    public function addNovedad(\GestionBundle\Entity\taller\NovedadInterno $novedad)
    {
        $this->novedad[] = $novedad;
        $novedad->setPlanillaRecepcion($this);
        return $this;
    }

    /**
     * Remove novedad
     *
     * @param \GestionBundle\Entity\taller\NovedadInterno $novedad
     */
    public function removeNovedad(\GestionBundle\Entity\taller\NovedadInterno $novedad)
    {
        $this->novedad->removeElement($novedad);
    }

    /**
     * Get novedad
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNovedad()
    {
        return $this->novedad;
    }

    /**
     * Set cerrada
     *
     * @param boolean $cerrada
     *
     * @return PlanillaRecepcionAnomalia
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
}
