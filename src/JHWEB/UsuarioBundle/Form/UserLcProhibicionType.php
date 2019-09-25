<?php

namespace JHWEB\UsuarioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserLcProhibicionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('numResolucion')->add('numProceso')->add('fechaOrden')->add('fechaResolucion')->add('fechaInicio')->add('fechaFin')->add('fechaPlazo')->add('tipoOrden')->add('tipoNovedad')->add('motivo')->add('juzgado');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JHWEB\UsuarioBundle\Entity\UserLcProhibicion'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jhweb_usuariobundle_userlcprohibicion';
    }


}
