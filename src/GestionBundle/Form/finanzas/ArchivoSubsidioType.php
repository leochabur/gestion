<?php

namespace GestionBundle\Form\finanzas;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArchivoSubsidioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('periodo_mes', 'integer')
            ->add('periodo_anio', 'integer')
            ->add('numero_pago', 'integer')            
            ->add('archivo', 'file', array('label' => 'Archivo .csv'))
            ->add('load', 'submit', array('label'=>'Cargar Resumen'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionBundle\Entity\finanzas\ArchivoSubsidio'
        ));
         
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gestionbundle_finanzas_archivo_subsidio';
    }
}