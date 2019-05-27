<?php

namespace GestionBundle\Entity\taller;

use Doctrine\ORM\Mapping as ORM;

/**
 * NovedadInterno
 *
 * @ORM\Table(name="norm_novedad_interno")
 * @ORM\Entity
 */
class NovedadInterno
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
     * @ORM\ManyToOne(targetEntity="GestionBundle\Entity\Unidad")
     * @ORM\JoinColumn(name="id_unidad", referencedColumnName="id")
     */
    private $unidad;     

    /**
     * @ORM\OneToMany(targetEntity="ResultadoNovedad", mappedBy="novedad", cascade={"persist", "remove"})
     */
    private $resultadosNovedad; 

    /**
     * @ORM\ManyToOne(targetEntity="PlanillaRecepcionAnomalia", inversedBy="novedades")
     * @ORM\JoinColumn(name="id_planilla_recepcion", referencedColumnName="id")
     */
    private $planillaRecepcion;          


    public function __toString()
    {
        return count($this->resultadosNovedad)."";
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
     * Set unidad
     *
     * @param \GestionBundle\Entity\Unidad $unidad
     *
     * @return NovedadInterno
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
     * Constructor
     */
    public function __construct()
    {
        $this->resultadosNovedad = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add resultadosNovedad
     *
     * @param \GestionBundle\Entity\taller\ResultadoNovedad $resultadosNovedad
     *
     * @return NovedadInterno
     */
    public function addResultadosNovedad(\GestionBundle\Entity\taller\ResultadoNovedad $resultadosNovedad)
    {
        $this->resultadosNovedad[] = $resultadosNovedad;
        $resultadosNovedad->setNovedad($this);

        return $this;
    }

    /**
     * Remove resultadosNovedad
     *
     * @param \GestionBundle\Entity\taller\ResultadoNovedad $resultadosNovedad
     */
    public function removeResultadosNovedad(\GestionBundle\Entity\taller\ResultadoNovedad $resultadosNovedad)
    {
        $this->resultadosNovedad->removeElement($resultadosNovedad);
    }

    /**
     * Get resultadosNovedad
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResultadosNovedad()
    {
        return $this->resultadosNovedad;
    }

    /**
     * Set planillaRecepcion
     *
     * @param \GestionBundle\Entity\taller\PlanillaRecepcionAnomalia $planillaRecepcion
     *
     * @return NovedadInterno
     */
    public function setPlanillaRecepcion(\GestionBundle\Entity\taller\PlanillaRecepcionAnomalia $planillaRecepcion = null)
    {
        $this->planillaRecepcion = $planillaRecepcion;

        return $this;
    }

    /**
     * Get planillaRecepcion
     *
     * @return \GestionBundle\Entity\taller\PlanillaRecepcionAnomalia
     */
    public function getPlanillaRecepcion()
    {
        return $this->planillaRecepcion;
    }
}
