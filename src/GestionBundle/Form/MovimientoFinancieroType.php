<?php

namespace GestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use GestionBundle\Entity\UnidadRepository;
use GestionBundle\Entity\Unidad;

class MovimientoFinancieroType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('movimiento', new MovimientoCuentaType(), array(
                'data_class' => 'GestionBundle\Entity\MovimientoFinanciero',
            ))                 
            ->add('unidad')
            ->add('concepto')              
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
       /* $resolver->setDefaults(array(
            'data_class' => 'GestionBundle\Entity\MovimientoFinanciero'
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
        return 'gestionbundle_movimientofinanciero';
    }
}
