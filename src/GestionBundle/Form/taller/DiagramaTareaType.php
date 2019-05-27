<?php

namespace GestionBundle\Form\taller;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use GestionBundle\Entity\personal\ConductorRepository;

class DiagramaTareaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha', 'date', array('widget' => 'single_text'))
            ->add('responsable', 'entity', 
                    array('class' => 'GestionBundle:personal\Conductor',
                          'query_builder' => function(ConductorRepository $er){
                                                                                return $er->createQueryBuilder('p')
                                                                                          ->where('p.activo = :activo')
                                                                                          ->orderBy('p.apellido')
                                                                                          ->setParameter('activo', true);                                                                                            
                                                                              })
                          )      
            ->add('save', 'submit', array('label' => 'Generar Diagrama'))            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionBundle\Entity\taller\DiagramaTarea'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gestionbundle_taller_diagramatarea';
    }
}
