<?php
namespace GestionBundle\Entity\personal;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="conceptos_liquidacion")
 * @ORM\Entity
 */
class ConceptoPago
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="concepto", type="string", precision=0, scale=0, nullable=false, unique=false)
     */
    private $concepto;
    
    /**
     * @ORM\Column(name="valor", type="float", nullable=true)
     */
    private $valor;
    
    /**
     * @ORM\Column(name="suma_resta", type="integer")
     */
    private $suma;

    /**
     * @ORM\Column(name="calculaCS", type="boolean")
     */
    private $calculaCS;
    
    /**
     * @ORM\Column(name="calculaSueldo", type="boolean")
     */
    private $calculaSueldo;

    /**
     * @ORM\Column(name="sueldoBolsillo", type="boolean")
     */
    private $sueldoBolsillo;    
    
    
    public function setCalculaSueldo($calc)
    {
        $this->calculaSueldo = $calc;
    }

    public function getCalculaSueldo()
    {
        return $this->calculaSueldo;
    }

    public function getCalculaCS()
    {
        return $this->calculaCS;
    }

    public function setCalculaCS($cs)
    {
        $this->calculaCS = $cs;

        return $this;
    }    


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
    
    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    public function getValor()
    {
        return $this->valor;
    }
    
    public function setSuma($suma)
    {
        $this->suma = $suma;
    }

    public function getSuma()
    {
        return $this->suma;
    }

	public function __toString()
	{
		return $this->concepto;
	}

    /**
     * Set sueldoBolsillo
     *
     * @param boolean $sueldoBolsillo
     *
     * @return ConceptoPago
     */
    public function setSueldoBolsillo($sueldoBolsillo)
    {
        $this->sueldoBolsillo = $sueldoBolsillo;

        return $this;
    }

    /**
     * Get sueldoBolsillo
     *
     * @return boolean
     */
    public function getSueldoBolsillo()
    {
        return $this->sueldoBolsillo;
    }
}
