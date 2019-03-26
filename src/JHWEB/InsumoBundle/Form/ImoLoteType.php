<?php

namespace JHWEB\InsumoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImoLoteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('estado')->add('numeroActa')->add('fecha')->add('rangoInicio')->add('rangoFin')->add('referencia')->add('tipo')->add('cantidad')->add('empresa')->add('sedeOperativa')->add('tipoInsumo');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JHWEB\InsumoBundle\Entity\ImoLote'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jhweb_insumobundle_imolote';
    }


}
