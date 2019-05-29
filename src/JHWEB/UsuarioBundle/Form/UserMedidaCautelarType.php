<?php

namespace JHWEB\UsuarioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserMedidaCautelarType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('numeroOficio')->add('numeroRadicado')->add('observaciones')->add('fechaRegistro')->add('fechaInicio')->add('fechaExpiracion')->add('activo')->add('ciudadano')->add('causal')->add('tipoProceso')->add('entidadJudicial')->add('municipio');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JHWEB\UsuarioBundle\Entity\UserMedidaCautelar'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jhweb_usuariobundle_usermedidacautelar';
    }


}
