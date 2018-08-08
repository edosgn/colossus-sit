<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MgdDocumentoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fechaRegistro')->add('numeroRadicado')->add('folios')->add('numeroOficio')->add('fechaVencimiento')->add('descripcion')->add('url')->add('correoCertificadoLlegada')->add('nombreTransportadoraLlegada')->add('fechaLlegada')->add('numeroGuiaLlegada')->add('correoCertificadoEnvio')->add('nombreTransportadoraEnvio')->add('fechaEnvio')->add('numeroGuia')->add('fechaSalida')->add('activo')->add('asignado')->add('tipoCorrespondencia')->add('sedeOperativa')->add('usuario');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\MgdDocumento'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_mgddocumento';
    }


}
