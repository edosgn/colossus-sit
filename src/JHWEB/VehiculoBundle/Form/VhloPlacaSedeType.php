<?php

namespace JHWEB\VehiculoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VhloPlacaSedeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('letrasPlaca')->add('numeroInicial')->add('numeroFinal')->add('activo')->add('sedeOperativa')->add('tipoVehiculo');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JHWEB\VehiculoBundle\Entity\VhloPlacaSede'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jhweb_vehiculobundle_vhloplacasede';
    }


}
