<?php

namespace GestionBundle\Entity\taller;

use Doctrine\ORM\Mapping as ORM;

/**
 * ListaNovedadPlanilla
 *
 * @ORM\Table(name="norm_listas_novedad_planilla")
 * @ORM\Entity
 */
class ListaNovedadPlanilla
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
     * @var string
     *
     * @ORM\Column(name="activa", type="boolean")
     */
    private $activa = true;

    /**
     * @ORM\ManyToMany(targetEntity="ItemNovedadPlanilla", inversedBy="listasNovedades")
     * @ORM\JoinTable(name="norm_items_novedad_por_lista")
     */
    private $itemsNovedad;    

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
     * @return ListaNovedadPlanilla
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
     * Constructor
     */
    public function __construct()
    {
        $this->itemsNovedad = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set activa
     *
     * @param boolean $activa
     *
     * @return ListaNovedadPlanilla
     */
    public function setActiva($activa)
    {
        $this->activa = $activa;

        return $this;
    }

    /**
     * Get activa
     *
     * @return boolean
     */
    public function getActiva()
    {
        return $this->activa;
    }

    /**
     * Add itemsNovedad
     *
     * @param \GestionBundle\Entity\taller\ItemNovedadPlanilla $itemsNovedad
     *
     * @return ListaNovedadPlanilla
     */
    public function addItemsNovedad(\GestionBundle\Entity\taller\ItemNovedadPlanilla $itemsNovedad)
    {
        $this->itemsNovedad[] = $itemsNovedad;

        return $this;
    }

    /**
     * Remove itemsNovedad
     *
     * @param \GestionBundle\Entity\taller\ItemNovedadPlanilla $itemsNovedad
     */
    public function removeItemsNovedad(\GestionBundle\Entity\taller\ItemNovedadPlanilla $itemsNovedad)
    {
        $this->itemsNovedad->removeElement($itemsNovedad);
    }

    /**
     * Get itemsNovedad
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItemsNovedad()
    {
        return $this->itemsNovedad;
    }
}
