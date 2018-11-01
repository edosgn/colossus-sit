<?php

namespace JHWEB\ContravencionalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CvMedidaCautelarType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fechaRegistro')->add('fechaInico')->add('fechaExpiracion')->add('fechaLevantamiento')->add('numeroOficioInscripcion')->add('numeroOficioLevantamiento')->add('numeroRadicado')->add('observacionesInscripcion')->add('observacionesLevantamiento')->add('municipioInscripcion')->add('municipioLevantamiento')->add('entidadJudicialInscripcion')->add('entidadJudicialLevantamiento')->add('tipoMedidaCautelar');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JHWEB\ContravencionalBundle\Entity\CvMedidaCautelar'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jhweb_contravencionalbundle_cvmedidacautelar';
    }


}
