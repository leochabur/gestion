<?php

namespace GestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use GestionBundle\Entity\UnidadRepository;

class SalidaStockType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('movimiento', new MovimientoStockType(), array(
                'data_class' => 'GestionBundle\Entity\EntradaStock',
            ))        
            ->add('unidad', 'entity', 
                    array('class' => 'GestionBundle:Unidad',
                          'query_builder' => function(UnidadRepository $er){
                                                                                return $er->createQueryBuilder('p')
                                                                                          ->where('p.activo = :activo')
                                                                                          ->setParameter('activo', true);                                                                                            
                                                                              })
                          )   
            ->add('save', 'submit', array('label'=>'Registrar Salida'));
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionBundle\Entity\SalidaStock'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gestionbundle_salidastock';
    }    
}
