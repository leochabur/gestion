<?php

namespace GestionBundle\Form\trafico;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NotificacionInspectorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('notificacion', new NotificacionType(), array(
                'data_class' => 'GestionBundle\Entity\trafico\NotificacionInspector',
            ))           
            ->add('personalAfectado')
            ->add('unidadAfectada')
            ->add('save', 'submit', array('label'=>'Registrar Notificacion'));                
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionBundle\Entity\trafico\NotificacionInspector'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gestionbundle_trafico_notificacioninspector';
    }
}
