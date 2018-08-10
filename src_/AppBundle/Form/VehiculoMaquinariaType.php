<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehiculoMaquinariaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('claseMaquinaria')->add('tipoMmaClase')->add('tipoMaquinaria')->add('pesoBrutoVehicular')->add('cargarUtilMaxima')->add('rodaje')->add('numeroEjes')->add('numeroLlantas')->add('tipoCabina')->add('altoTotal')->add('anchoTotal')->add('largoTotal')->add('origenVehiculo')->add('subpartidaArancelaria');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\VehiculoMaquinaria'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_vehiculomaquinaria';
    }


}
