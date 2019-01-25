<?php

namespace JHWEB\FinancieroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FroFacturaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fechaCreacion')->add('fechaVencimiento')->add('hora')->add('valor')->add('numero')->add('consecutivo')->add('estado')->add('activo')->add('sedeOperativa')->add('tipoRecaudo');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JHWEB\FinancieroBundle\Entity\FroFactura'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jhweb_financierobundle_frofactura';
    }


}
