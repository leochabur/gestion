<?php

namespace GestionBundle\Form\taller;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use GestionBundle\Entity\UnidadRepository;

class TareaMantenimientoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tarea')
            ->add('tipo')
            ->add('controlaPorKm')
            ->add('periodicidad')                        
            ->add('unidades', 'entity', 
                    array('class' => 'GestionBundle:Unidad',
                           'multiple' => true,  
                          'query_builder' => function(UnidadRepository $er){
                                                                                return $er->createQueryBuilder('p')
                                                                                          ->where('p.activo = :activo')
                                                                                          ->setParameter('activo', true);                                                                                            
                                                                              })
                          )               
            ->add('save', 'submit', array('label'=>'Guardar Tarea'));               
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionBundle\Entity\taller\TareaMantenimiento'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gestionbundle_taller_tareamantenimiento';
    }
}
