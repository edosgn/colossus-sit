<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MparqEntradaSalidaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fechaIngreso')->add('fechaSalida')->add('horaSalida')->add('numeroSalida')->add('numeroInventario')->add('dias')->add('observaciones')->add('valorParqueadero')->add('salida')->add('activo')->add('grua')->add('comparendo')->add('costoTrayecto');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\MparqEntradaSalida'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_mparqentradasalida';
    }


}