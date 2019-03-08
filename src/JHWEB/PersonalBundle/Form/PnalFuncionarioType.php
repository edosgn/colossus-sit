<?php

namespace JHWEB\PersonalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PnalFuncionarioType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('actaPosesion')->add('resolucion')->add('numeroContrato')->add('fechaInicial')->add('fechaFinal')->add('numeroPlaca')->add('inhabilidad')->add('objetoContrato')->add('novedad')->add('modificatorio')->add('activo')->add('tipoNombramiento')->add('tipoContrato')->add('cargo')->add('ciudadano');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JHWEB\PersonalBundle\Entity\PnalFuncionario'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jhweb_personalbundle_pnalfuncionario';
    }


}
