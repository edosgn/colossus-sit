<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehiculoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('placa')
            ->add('numeroFactura')
            ->add('fechaFactura', 'datetime')
            ->add('valor')
            ->add('numeroManifiesto')
            ->add('fechaManifiesto', 'datetime')
            ->add('cilindraje')
            ->add('modelo', 'date')
            ->add('motor')
            ->add('chasis')
            ->add('serie')
            ->add('vin')
            ->add('numeroPasajeros')
            ->add('estado')
            ->add('munucipio')
            ->add('linea')
            ->add('servicio')
            ->add('color')
            ->add('combustible')
            ->add('carroceria')
            ->add('organismoTransito')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Vehiculo'
        ));
    }
}