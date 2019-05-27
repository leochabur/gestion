<?php

namespace GestionBundle\Form\finanzas;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PagoSubsidioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('periodoMes')
            ->add('periodoAnio')
            ->add('numeroPago')
            ->add('concepto')
            ->add('monto')
            ->add('save', 'submit', array('label'=>'Cargar Pago'))                 

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionBundle\Entity\finanzas\PagoSubsidio'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gestionbundle_finanzas_pagosubsidio';
    }
}
