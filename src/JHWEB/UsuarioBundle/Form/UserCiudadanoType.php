<?php

namespace JHWEB\UsuarioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserCiudadanoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('direccion')->add('fechaExpedicionDocumento')->add('direccionTrabajo')->add('enrolado')->add('activo')->add('municipioNacimiento')->add('municipioResidencia')->add('genero')->add('grupoSanguineo')->add('usuario');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JHWEB\UsuarioBundle\Entity\UserCiudadano'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jhweb_usuariobundle_userciudadano';
    }


}
