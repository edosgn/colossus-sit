<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MrfsvHu08Type extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('xDestino')->add('fecha')->add('unidad')->add('color')->add('latitud')->add('longitud')->add('direccion')->add('codigo')->add('logo')->add('nombre')->add('valor')->add('estado')->add('cantidad')->add('destino')->add('senal');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\MrfsvHu08'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_mrfsvhu08';
    }


}
