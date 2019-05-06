<?php

namespace JHWEB\ParqueaderoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PqoCfgTarifaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('valorHora')->add('numeroActoAdministrativo')->add('fecha')->add('activo')->add('tipoVehiculo')->add('patio');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JHWEB\ParqueaderoBundle\Entity\PqoCfgTarifa'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jhweb_parqueaderobundle_pqocfgtarifa';
    }


}
