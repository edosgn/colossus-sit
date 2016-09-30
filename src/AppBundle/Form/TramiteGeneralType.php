<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TramiteGeneralType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numeroQpl')
            ->add('fechaInicial', 'date')
            ->add('fechaFinal', 'date')
            ->add('estado')
            ->add('valor')
            ->add('numeroLicencia')
            ->add('numeroSustrato')
            ->add('vehiculo')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\TramiteGeneral'
        ));
    }
}
