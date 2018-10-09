<?php

namespace JHWEB\GestionDocumentalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GdDocumentoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fechaRegistro')->add('numeroRadicado')->add('consecutivo')->add('folios')->add('numeroOficio')->add('diasVigencia')->add('fechaVencimiento')->add('descripcion')->add('url')->add('correoCertificadoLlegada')->add('nombreTransportadoraLlegada')->add('fechaLlegada')->add('numeroGuiaLlegada')->add('correoCertificadoEnvio')->add('nombreTransportadoraEnvio')->add('fechaEnvio')->add('medioEnvio')->add('numeroGuia')->add('numeroCarpeta')->add('activo')->add('entidadNombre')->add('entidadCargo')->add('sedeOperativa')->add('peticionario')->add('tipoCorrespondencia')->add('remitente');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JHWEB\GestionDocumentalBundle\Entity\GdDocumento'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jhweb_gestiondocumentalbundle_gddocumento';
    }


}
