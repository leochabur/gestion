<?php

namespace GestionBundle\Entity\stock;


class OrdenCompraRepository extends \Doctrine\ORM\EntityRepository
{
    public function getOrdenesCompra()
    {
        $query = $this->getEntityManager()
                      ->createQuery('SELECT c 
                                     FROM GestionBundle:stock\OrdenCompra c
                                     WHERE c.eliminada = :eliminada')
                      ->setParameter('eliminada', false);
        return $query->getResult();            
    }
}
