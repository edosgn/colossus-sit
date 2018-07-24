<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LimitacionDatosType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fechaRadicacion')->add('nOrdenJudicial')->add('fechaExpedicion')->add('observaciones')->add('datos')->add('estado')->add('departamento')->add('municipio')->add('ciudadanoDemandado')->add('ciudadanoDemandante')->add('limitacion')->add('tipoProceso')->add('entidadJudicial');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\LimitacionDatos'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_limitaciondatos';
    }


}
