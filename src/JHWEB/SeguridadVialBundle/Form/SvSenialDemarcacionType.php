<?php

namespace JHWEB\SeguridadVialBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SvSenialDemarcacionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('cantidad')->add('metraje')->add('anchoLinea')->add('total')->add('tramoVial')->add('activo')->add('linea')->add('unidadMedida')->add('ubicacion');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JHWEB\SeguridadVialBundle\Entity\SvSenialDemarcacion'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jhweb_seguridadvialbundle_svsenialdemarcacion';
    }


}
