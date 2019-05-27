<?php

namespace GestionBundle\Entity\taller;

use Doctrine\ORM\Mapping as ORM;

/**
 * ResultadoNovedad
 *
 * @ORM\Table(name="norm_resultado_novedad")
 * @ORM\Entity
 */
class ResultadoNovedad
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
     * @ORM\Column(name="falla", type="boolean")
     */
    private $falla = false;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="string", length=255, nullable=true)
     */
    private $observacion;    

    /**
     * @ORM\ManyToOne(targetEntity="ItemNovedadPlanilla", inversedBy="novedades")
     * @ORM\JoinColumn(name="id_item_novedad_planilla", referencedColumnName="id")
     */
    private $itemNovedad;    

    /**
     * @ORM\ManyToOne(targetEntity="NovedadInterno", inversedBy="resultadosNovedad")
     * @ORM\JoinColumn(name="id_novedad_interno", referencedColumnName="id")
     */
    private $novedad;

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
     * Set falla
     *
     * @param boolean $falla
     *
     * @return ResultadoNovedad
     */
    public function setFalla($falla)
    {
        $this->falla = $falla;

        return $this;
    }

    /**
     * Get falla
     *
     * @return boolean
     */
    public function getFalla()
    {
        return $this->falla;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     *
     * @return ResultadoNovedad
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
     * Set itemNovedad
     *
     * @param \GestionBundle\Entity\taller\ItemNovedadPlanilla $itemNovedad
     *
     * @return ResultadoNovedad
     */
    public function setItemNovedad(\GestionBundle\Entity\taller\ItemNovedadPlanilla $itemNovedad = null)
    {
        $this->itemNovedad = $itemNovedad;

        return $this;
    }

    /**
     * Get itemNovedad
     *
     * @return \GestionBundle\Entity\taller\ItemNovedadPlanilla
     */
    public function getItemNovedad()
    {
        return $this->itemNovedad;
    }

    /**
     * Set novedad
     *
     * @param \GestionBundle\Entity\taller\NovedadInterno $novedad
     *
     * @return ResultadoNovedad
     */
    public function setNovedad(\GestionBundle\Entity\taller\NovedadInterno $novedad = null)
    {
        $this->novedad = $novedad;

        return $this;
    }

    /**
     * Get novedad
     *
     * @return \GestionBundle\Entity\taller\NovedadInterno
     */
    public function getNovedad()
    {
        return $this->novedad;
    }
}
