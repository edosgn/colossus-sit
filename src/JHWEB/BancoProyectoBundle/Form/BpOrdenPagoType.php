<?php

namespace JHWEB\BancoProyectoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BpOrdenPagoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fecha')->add('numero')->add('tipo')->add('concepto')->add('valor')->add('activo')->add('registroCompromiso')->add('autoriza');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JHWEB\BancoProyectoBundle\Entity\BpOrdenPago'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jhweb_bancoproyectobundle_bpordenpago';
    }


}
