<?php

namespace GestionBundle\Entity;

/**
 * CtaCteProveedorRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */

class CtaCteProveedorRepository extends \Doctrine\ORM\EntityRepository
{

	public function getCtaCteProveedor($proveedor)
	{
        $query = $this->getEntityManager()
                      ->createQuery('SELECT c 
                                     FROM GestionBundle:CtaCteProveedor c 
                                     LEFT JOIN c.movimientos m
                                     WHERE c.proveedor = :proveedor')
                      ->setParameter('proveedor', $proveedor);
        return $query->getOneOrNullResult();			
	}

    public function getCtaCteProveedorArticulo($proveedor, $articulo)
    {
        $query = $this->getEntityManager()
                      ->createQuery('SELECT mc as mov, cta.muestraXImporte as muestra
                                     FROM GestionBundle:MovimientoCuenta mc 
                                     JOIN mc.ctacte cta
                                     WHERE cta.proveedor = :proveedor AND mc.articulo = :articulo
                                     ORDER BY mc.fecha, mc.id')
                      ->setParameter('proveedor', $proveedor)
                      ->setParameter('articulo', $articulo);
        return $query->getResult();            
    }    

	public function getVencimientosPeriodo($desde, $hasta)
	{
        return $this->getEntityManager()
                    ->createQuery('SELECT c 
                    			   FROM GestionBundle:MovimientoPlanCuota c 
                    			   WHERE c.fecha between :desde and :hasta')
                    ->setParameter('desde', $desde)
                    ->setParameter('hasta', $hasta)                                        
                    ->getResult();			
	}

}
