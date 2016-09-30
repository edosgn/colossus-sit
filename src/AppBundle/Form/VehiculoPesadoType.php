<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehiculoPesadoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tonelaje')
            ->add('numeroEjes')
            ->add('numeroMt')
            ->add('fichaTecnicaHomologacionCarroceria')
            ->add('fichaTecnicaHomologacionChasis')
            ->add('vehiculo')
            ->add('modalidad')
            ->add('empresa')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\VehiculoPesado'
        ));
    }
}
