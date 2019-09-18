<?php

namespace JHWEB\UsuarioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserLicenciaConduccionRestriccionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fechaCancelacion')->add('fechaResolucion')->add('tipoActo')->add('numResolucion')->add('fechaInicio')->add('fechaFin')->add('tipo');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JHWEB\UsuarioBundle\Entity\UserLicenciaConduccionRestriccion'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jhweb_usuariobundle_userlicenciaconduccionrestriccion';
    }


}
