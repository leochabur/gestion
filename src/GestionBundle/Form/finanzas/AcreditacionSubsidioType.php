<?php

namespace GestionBundle\Form\finanzas;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AcreditacionSubsidioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha', 'date', array('widget' => 'single_text'))
            ->add('importe', 'number')
            ->add('save', 'submit', array('label'=>'Cargar Acreditacion'))            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionBundle\Entity\finanzas\AcreditacionSubsidio'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gestionbundle_finanzas_acreditacionsubsidio';
    }
}
