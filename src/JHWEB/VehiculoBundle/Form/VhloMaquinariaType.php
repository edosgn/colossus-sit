<?php

namespace JHWEB\VehiculoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VhloMaquinariaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fechaIngreso')->add('peso')->add('cargarUtilMaxima')->add('numeroLlantas')->add('numeroEjes')->add('alto')->add('largo')->add('ancho')->add('tipoDispositivo')->add('numeroImportacion')->add('numeroActivacionGps')->add('vehiculo')->add('subpartidaArancelaria')->add('tipoRodaje')->add('tipoCabina')->add('claseMaquinaria')->add('condicionIngreso')->add('origenRegistro')->add('empresaGps');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JHWEB\VehiculoBundle\Entity\VhloMaquinaria'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jhweb_vehiculobundle_vhlomaquinaria';
    }


}
