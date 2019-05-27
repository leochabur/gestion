<?php

namespace GestionBundle\Form\taller;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use GestionBundle\Entity\UnidadRepository;

class AnomaliaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha', 'date', array('widget' => 'single_text'))
            ->add('observacion')
            ->add('tipoDesperfecto')
            ->add('unidad', 'entity', 
                    array('class' => 'GestionBundle:Unidad',
                          'query_builder' => function(UnidadRepository $er){
                                                                                return $er->createQueryBuilder('p')
                                                                                          ->where('p.activo = :activo')
                                                                                          ->setParameter('activo', true);                                                                                            
                                                                              })
                          )   
            ->add('numPlanilla')            
            ->add('save', 'submit', array('label'=>'Registrar Anomalia'));                
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionBundle\Entity\taller\Anomalia'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gestionbundle_taller_anomalia';
    }
}
