<?php
namespace GestionBundle\Entity\personal;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="aplicacionconceptos")
 * @ORM\Entity
 */
class AplicacionConcepto
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="aplicacion", type="string")
     */
    private $concepto;
    


    public function getId()
    {
        return $this->id;
    }

    public function setConcepto($concepto)
    {
        $this->concepto = $concepto;

        return $this;
    }

    public function getConcepto()
    {
        return $this->concepto;
    }
}
