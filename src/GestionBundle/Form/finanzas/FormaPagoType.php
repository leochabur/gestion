<?php

namespace GestionBundle\Form\finanzas;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FormaPagoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('detalle')
            ->add('importe')
            ->add('cantidad')
            ->add('fecha', 'date', array('widget' => 'single_text'))
            ->add('ctacte')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        /*$resolver->setDefaults(array(
            'data_class' => 'GestionBundle\Entity\finanzas\FormaPago'
        ));*/
        $resolver->setDefaults(array(
            'virtual' => true,
        ));            
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gestionbundle_finanzas_formapago';
    }
}
