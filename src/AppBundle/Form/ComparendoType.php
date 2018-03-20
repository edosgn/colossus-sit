<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComparendoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('numeroOrden')->add('fechaDiligenciamiento')->add('lugarInfraccion')->add('barrioInfraccion')->add('observacionesAgente')->add('tipoInfractor')->add('tarjetaOperacionInfractor')->add('fuga')->add('accidente')->add('polca')->add('fechaNotificacion')->add('gradoAlchoholemia')->add('municipio')->add('vehiculo')->add('cuidadano')->add('agenteTransito')->add('seguimientoEntrega');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Comparendo'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_comparendo';
    }


}
