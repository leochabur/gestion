<?php

namespace GestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EntradaStockType extends AbstractType
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
            ->add('proveedor')
            ->add('save', 'submit', array('label'=>'Registrar Ingreso'));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionBundle\Entity\EntradaStock'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gestionbundle_entradastock';
    }
}
