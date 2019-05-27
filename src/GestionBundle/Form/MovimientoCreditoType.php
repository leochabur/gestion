<?php

namespace GestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MovimientoCreditoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('movimiento', new MovimientoCuentaType(), array(
                'data_class' => 'GestionBundle\Entity\MovimientoCredito',
            ))         
            ->add('articulo')            
            ->add('formaPago')
            ->add('save', 'submit', array('label'=>'Registrar Ingreso'));              
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionBundle\Entity\MovimientoCredito'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gestionbundle_movimientocredito';
    }
}
