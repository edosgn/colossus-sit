<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PeticionarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombrePeticionario')
            ->add('identificacionPeticionario')
            ->add('direccionPeticionario')
            ->add('telefonoPeticionario')
            ->add('correoElectronico')
            ->add('numeroOficio')
            ->add('tipoPeticionario')
            ->add('registroDocumento')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Peticionario'
        ));
    }
}
