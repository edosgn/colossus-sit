<?php

namespace JHWEB\GestionDocumentalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GdRemitenteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('primerNombre')->add('segundoNombre')->add('primerApellido')->add('segundoApellido')->add('direccion')->add('telefono')->add('identificacion')->add('correoElectronico')->add('activo')->add('tipoIdentificacion');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JHWEB\GestionDocumentalBundle\Entity\GdRemitente'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jhweb_gestiondocumentalbundle_gdremitente';
    }


}
