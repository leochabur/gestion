<?php

namespace GestionBundle\Entity\finanzas;

use Doctrine\ORM\Mapping as ORM;

/**
 * ValoresTerceros
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ValoresTerceros extends FormaPago
{

    public function cargarCuentaExterna($credito)
    {

    }

    public function getProveedorExterno()
    {
        
    }

    public function __toString()
    {
        return "Valores de Terceros";
    }    

}
