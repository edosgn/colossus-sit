<?php

namespace JHWEB\ContravencionalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CvCdoComparendoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fecha')->add('hora')->add('expediente')->add('direccion')->add('localidad')->add('placa')->add('infractorIdentificacion')->add('infractorNumeroLicenciaConduccion')->add('categoria')->add('fechaExpedicion')->add('fechaVencimiento')->add('infractorNombres')->add('infractorApellidos')->add('infractorDireccion')->add('infractorFechaNacimiento')->add('infractorTelefono')->add('infractorMunicipioResidencia')->add('infractorEmail')->add('numeroLicenciaTransito')->add('propietarioIdentificacion')->add('propietarioNombre')->add('propietarioApellidos')->add('empresaNit')->add('empresaNombre')->add('tarjetaOperacion')->add('observacionesAgente')->add('observacionesDigitador')->add('testigoNombres')->add('testigoApellidos')->add('testigoIdentificacion')->add('testigoDireccion')->add('testigoTelefono')->add('fuga')->add('accidente')->add('retencionLicencia')->add('valorInfraccion')->add('interesMora')->add('valorPagar')->add('urlDocumento')->add('polca')->add('audiencia')->add('recurso')->add('notificado')->add('pagado')->add('curso')->add('porcentajeDescuento')->add('activo')->add('servicio')->add('clase')->add('radioAccion')->add('modalidadTransporte')->add('transportePasajero')->add('transporteEspecial')->add('infractorTipoIdentificacion')->add('organismoTransitoLicencia')->add('propietarioTipoIdentificacion')->add('municipio')->add('infraccion')->add('organismoTransitoMatriculado')->add('tipoInfractor')->add('organismoTransito')->add('agenteTransito')->add('consecutivo')->add('acuerdoPago')->add('estado');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JHWEB\ContravencionalBundle\Entity\CvCdoComparendo'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jhweb_contravencionalbundle_cvcdocomparendo';
    }


}
