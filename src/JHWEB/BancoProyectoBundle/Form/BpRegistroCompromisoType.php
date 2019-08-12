<?php

namespace JHWEB\BancoProyectoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BpRegistroCompromisoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('solicitudNumero')->add('solicitudFecha')->add('solicitudConsecutivo')->add('numero')->add('cuentaNumero')->add('cuentaTipo')->add('bancoNombre')->add('fechaRegistro')->add('fechaExpedicion')->add('contratoNumero')->add('contratoTipo')->add('estado')->add('cdp')->add('ciudadano')->add('empresa');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JHWEB\BancoProyectoBundle\Entity\BpRegistroCompromiso'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jhweb_bancoproyectobundle_bpregistrocompromiso';
    }


}
