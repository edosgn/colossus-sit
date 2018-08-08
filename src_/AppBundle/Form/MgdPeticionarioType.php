<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MgdPeticionarioType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('primerNombre')->add('segundoNombre')->add('primerApellido')->add('segundoApellido')->add('identificacion')->add('entidadNombre')->add('entidadCargo')->add('direccion')->add('telefono')->add('correoElectronico')->add('estado')->add('tipoIdentificacion');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\MgdPeticionario'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_mgdpeticionario';
    }


}
