<?php

namespace GestionBundle\Entity\taller;

use Doctrine\ORM\Mapping as ORM;

/**
 * ItemNovedadPlanilla
 *
 * @ORM\Table(name="norm_items_novedad_planilla")
 * @ORM\Entity
 */
class ItemNovedadPlanilla
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\ManyToMany(targetEntity="ListaNovedadPlanilla", mappedBy="itemsNovedad")
     */
    private $listasNovedades;

    /**
     * @ORM\ManyToOne(targetEntity="TipoDesperfecto")
     * @ORM\JoinColumn(name="ir_tipo_desperfecto", referencedColumnName="id")
     */
    private $tipoDesperfecto;       

   /**
     * @ORM\OneToMany(targetEntity="ResultadoNovedad", mappedBy="itemNovedad", cascade={"persist", "remove"})
    */
    private $novedades;   

    public function __toString()
    {
        return $this->nombre;
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return ItemNovedadPlanilla
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Add listasNovedade
     *
     * @param \GestionBundle\Entity\taller\ListaNovedadPlanilla $listasNovedade
     *
     * @return ItemNovedadPlanilla
     */
    public function addListasNovedade(\GestionBundle\Entity\taller\ListaNovedadPlanilla $listasNovedade)
    {
        $this->listasNovedades[] = $listasNovedade;

        return $this;
    }

    /**
     * Remove listasNovedade
     *
     * @param \GestionBundle\Entity\taller\ListaNovedadPlanilla $listasNovedade
     */
    public function removeListasNovedade(\GestionBundle\Entity\taller\ListaNovedadPlanilla $listasNovedade)
    {
        $this->listasNovedades->removeElement($listasNovedade);
    }

    /**
     * Get listasNovedades
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getListasNovedades()
    {
        return $this->listasNovedades;
    }

    /**
     * Set tipoDesperfecto
     *
     * @param \GestionBundle\Entity\taller\TipoDesperfecto $tipoDesperfecto
     *
     * @return ItemNovedadPlanilla
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
     * Add novedade
     *
     * @param \GestionBundle\Entity\taller\ResultadoNovedad $novedade
     *
     * @return ItemNovedadPlanilla
     */
    public function addNovedade(\GestionBundle\Entity\taller\ResultadoNovedad $novedade)
    {
        $this->novedades[] = $novedade;

        return $this;
    }

    /**
     * Remove novedade
     *
     * @param \GestionBundle\Entity\taller\ResultadoNovedad $novedade
     */
    public function removeNovedade(\GestionBundle\Entity\taller\ResultadoNovedad $novedade)
    {
        $this->novedades->removeElement($novedade);
    }

    /**
     * Get novedades
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNovedades()
    {
        return $this->novedades;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->listasNovedades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->novedades = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
