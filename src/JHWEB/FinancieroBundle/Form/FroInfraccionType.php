<?php

namespace JHWEB\FinancieroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FroInfraccionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre')->add('codigo')->add('descripcion')->add('retiene')->add('inmoviliza')->add('dias')->add('activo')->add('categoria');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JHWEB\FinancieroBundle\Entity\FroInfraccion'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jhweb_financierobundle_froinfraccion';
    }


}
