<?php

namespace GestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use GestionBundle\Entity\ArticuloRepository;

class MovimientoStockType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha', 'date', array('widget' => 'single_text'))
            ->add('cantidad')
            ->add('numComprobante')            
            ->add('precioUnitario')
            ->add('articulo', 'entity', 
                    array('class' => 'GestionBundle:Articulo',
                          'query_builder' => function(ArticuloRepository $er){
                                                                                return $er->createQueryBuilder('p')
                                                                                          ->orderBy('p.descripcion');                                                                                            
                                                                              })
                          )  
            ->add('origenMovimiento')            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        /*$resolver->setDefaults(array(
            'data_class' => 'GestionBundle\Entity\MovimientoStock'
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
        return 'gestionbundle_movimientostock';
    }
}
