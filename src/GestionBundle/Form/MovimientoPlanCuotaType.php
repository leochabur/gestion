<?php

namespace GestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MovimientoPlanCuotaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('movimiento', new MovimientoFinancieroType(), array(
                'data_class' => 'GestionBundle\Entity\MovimientoPlanCuota',
            ))              
            ->add('numeroCuota')
            ->add('multiplicaPor', 'number', array('data' => '1'))
            ->add('save', 'submit', array('label'=>'Registrar Ingreso'));               
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionBundle\Entity\MovimientoPlanCuota'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gestionbundle_movimientoplancuota';
    }
}
