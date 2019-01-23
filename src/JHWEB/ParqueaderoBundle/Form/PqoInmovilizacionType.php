<?php

namespace JHWEB\ParqueaderoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PqoInmovilizacionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('numero_comparendo')->add('placa')->add('fechaIngreso')->add('horaIngreso')->add('fechaSalida')->add('horaSalida')->add('numeroSalida')->add('numeroInventario')->add('dias')->add('observaciones')->add('valor')->add('costoTrayecto')->add('estado')->add('salida')->add('activo')->add('linea')->add('color')->add('clase')->add('grua')->add('patio');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JHWEB\ParqueaderoBundle\Entity\PqoInmovilizacion'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jhweb_parqueaderobundle_pqoinmovilizacion';
    }


}
