<?php

namespace JHWEB\ParqueaderoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PqoGruaCiudadanoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fechaInicial')->add('fechaFinal')->add('observaciones')->add('tipo')->add('activo')->add('ciudadano')->add('grua');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JHWEB\ParqueaderoBundle\Entity\PqoGruaCiudadano'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jhweb_parqueaderobundle_pqogruaciudadano';
    }


}
