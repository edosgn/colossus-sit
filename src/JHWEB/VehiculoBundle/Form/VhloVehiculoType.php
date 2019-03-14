<?php

namespace JHWEB\VehiculoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VhloVehiculoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('numeroFactura')->add('fechaFactura')->add('valor')->add('numeroManifiesto')->add('fechaManifiesto')->add('cilindraje')->add('modelo')->add('motor')->add('chasis')->add('serie')->add('vin')->add('tipoMatricula')->add('numeroPasajeros')->add('capacidadCarga')->add('tipoBlindaje')->add('nivelBlindaje')->add('empresaBlindadora')->add('leasing')->add('pignorado')->add('cancelado')->add('activo')->add('linea')->add('servicio')->add('color')->add('combustible')->add('carroceria')->add('clase')->add('radioAccion')->add('modalidadTransporte')->add('nacionalidad')->add('placa')->add('pais')->add('municipio')->add('organismoTransito');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JHWEB\VehiculoBundle\Entity\VhloVehiculo'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jhweb_vehiculobundle_vhlovehiculo';
    }


}
