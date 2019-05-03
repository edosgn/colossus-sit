<?php

namespace JHWEB\PersonalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PnalCfgCdoConsecutivoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('numero')->add('fechaAsignacion')->add('estado')->add('activo')->add('organismoTransito')->add('funcionario')->add('talonario');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JHWEB\PersonalBundle\Entity\PnalCfgCdoConsecutivo'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jhweb_personalbundle_pnalcfgcdoconsecutivo';
    }


}
