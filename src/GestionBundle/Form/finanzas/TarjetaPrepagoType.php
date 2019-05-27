<?php

namespace GestionBundle\Form\finanzas;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TarjetaPrepagoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('formaPago', new FormaPagoType(), array(
                'data_class' => 'GestionBundle\Entity\finanzas\TarjetaPrepago',
            ))         
            ->add('numComprobante')
            ->add('proveedorExterno')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionBundle\Entity\finanzas\TarjetaPrepago'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gestionbundle_finanzas_tarjetaprepago';
    }
}
