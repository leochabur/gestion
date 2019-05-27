<?php

namespace GestionBundle\Form\stock;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrdenCompraType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('movimiento', new MovimientoInventarioType(), array(
                'data_class' => 'GestionBundle\Entity\stock\OrdenCompra',
            ))            
            ->add('proveedor')
            ->add('observacion')            
            ->add('save', 'submit', array('label'=>'Siguiente >>'));               
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionBundle\Entity\stock\OrdenCompra'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gestionbundle_stock_ordencompra';
    }
}
