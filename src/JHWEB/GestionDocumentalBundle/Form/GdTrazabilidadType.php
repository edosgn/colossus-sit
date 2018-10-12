<?php

namespace JHWEB\GestionDocumentalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GdTrazabilidadType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('estado')->add('fechaAsignacion')->add('fechaRespuesta')->add('url')->add('observaciones')->add('aceptada')->add('activo')->add('responsable')->add('documento');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JHWEB\GestionDocumentalBundle\Entity\GdTrazabilidad'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jhweb_gestiondocumentalbundle_gdtrazabilidad';
    }


}
