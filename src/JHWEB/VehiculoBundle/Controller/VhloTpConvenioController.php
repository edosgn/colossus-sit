<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloTpConvenio;
use JHWEB\VehiculoBundle\Entity\VhloTpConvenioEmpresa;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlotpconvenio controller.
 *
 * @Route("vhlotpconvenio")
 */
class VhloTpConvenioController extends Controller
{
   /**
     * datos para select 2 por departamento
     *
     * @Route("/{id}/convenios/por/empresa", name="vhlotpconvenio_convenios_por_empresa")
     * @Method({"GET", "POST"})
     */
    public function getConveniosPorEmpresaAction($id)
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $convenios = $em->getRepository('JHWEBVehiculoBundle:VhloTpConvenio')->findBy(
            array(
                'alcaldia' => $id,
                'activo' => 1
            )
        );

        if ($convenios != null) {
            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Registros encontrados con exito", 
                'data'=> $convenios,
            );
        } else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "No se han encontrado convenios para la empresa en la base de datos", 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Creates a new vhloTpConvenio entity.
     *
     * @Route("/new", name="vhlotpconvenio_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {        
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        
        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();

            $fechaConvenio = new \DateTime($params->fechaConvenio);
            $fechaActaInicio = new \DateTime($params->fechaActaInicio);
            $fechaActaFin = new \DateTime($params->fechaActaFin);
            $alcaldia = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->find($params->empresa);
            
            $convenio = $em->getRepository('JHWEBVehiculoBundle:VhloTpConvenio')->findOneBy(
                array (
                    'numeroConvenio' => $params->numeroConvenio,
                    'activo' => true
                )
            );

            if($convenio) {
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El número de convenio ya fue asignado", 
                );
            }
            else {
                if($fechaActaFin < $fechaActaInicio){
                    $response = array(
                        'title' => 'Error!',
                        'status' => 'error',
                        'code' => 400,
                        'message' => "La fecha de fin debe ser mayor a la fecha de inicio del acta.", 
                    );
                } else {
                    $vhloTpConvenio = new VhloTpConvenio();
                    
                    $vhloTpConvenio->setNumeroConvenio($params->numeroConvenio);
                    $vhloTpConvenio->setFechaConvenio($fechaConvenio);
                    $vhloTpConvenio->setFechaActaInicio($fechaActaInicio);
                    $vhloTpConvenio->setFechaActaFin($fechaActaFin);
                    $vhloTpConvenio->setAlcaldia($alcaldia);
                    $vhloTpConvenio->setObservacion($params->observacion);
                    $vhloTpConvenio->setActivo(true);

                    $em->persist($vhloTpConvenio);

                    foreach ($params->empresas as $key => $empresa) {
                        $empresaConvenio = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->find($empresa);
                        
                        $vhloTpConvenioEmpresa = new VhloTpConvenioEmpresa();
                        
                        $vhloTpConvenioEmpresa->setEmpresa($empresaConvenio);
                        $vhloTpConvenioEmpresa->setVhloTpConvenio($vhloTpConvenio);
                        $vhloTpConvenioEmpresa->setActivo(true);

                        $em->persist($vhloTpConvenioEmpresa);
                        $em->flush();
                    }
                    
                    $response = [];

                    $response = array(
                        'title' => 'Perfecto!',
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Registro creado con éxito",
                    );
                }
            }
        } else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }    
        return $helpers->json($response);
    }

    /**
     * Finds and displays a vhloTpConvenio entity.
     *
     * @Route("/{id}", name="vhlotpconvenio_show")
     * @Method("GET")
     */
    public function showAction(VhloTpConvenio $vhloTpConvenio)
    {
        $deleteForm = $this->createDeleteForm($vhloTpConvenio);

        return $this->render('vhlotpconvenio/show.html.twig', array(
            'vhloTpConvenio' => $vhloTpConvenio,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vhloTpConvenio entity.
     *
     * @Route("/edit", name="vhlotpconvenio_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        
        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();

            $fechaConvenio = new \DateTime($params->fechaConvenio);
            $fechaActaInicio = new \DateTime($params->fechaActaInicio);
            $fechaActaFin = new \DateTime($params->fechaActaFin);
            
            $convenio = $em->getRepository('JHWEBVehiculoBundle:VhloTpConvenio')->find($params->id);

            if($convenio) {
                if($fechaActaFin < $fechaActaInicio){
                    $response = array(
                        'title' => 'Error!',
                        'status' => 'error',
                        'code' => 400,
                        'message' => "La fecha de fin debe ser mayor a la fecha de inicio del acta.", 
                    );
                } else {
                    $convenio->setNumeroConvenio($params->numeroConvenio);
                    $convenio->setFechaConvenio($fechaConvenio);
                    $convenio->setFechaActaInicio($fechaActaInicio);
                    $convenio->setFechaActaFin($fechaActaFin);
                    $convenio->setObservacion($params->observacion);

                    $em->persist($convenio);

                    $empresasAnteriores = $em->getRepository('JHWEBVehiculoBundle:VhloTpConvenioEmpresa')->findBy(
                        array(
                            'vhloTpConvenio' => $convenio->getId(),
                            'activo' => true
                        )
                    );

                    foreach ($empresasAnteriores as $key => $empresaAnterior) {
                        $empresaAnterior->setActivo(false);
                        $em->persist($empresaAnterior);
                    }

                    foreach ($params->empresas as $key => $empresaNueva) {
                        $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->find($empresaNueva);
                        
                        $convenioEmpresa = new VhloTpConvenioEmpresa();
                        
                        $convenioEmpresa->setEmpresa($empresa);
                        $convenioEmpresa->setVhloTpConvenio($convenio);
                        $convenioEmpresa->setActivo(true);

                        $em->persist($convenioEmpresa);
                        $em->flush();
                    }
                    
                    $response = [];

                    $response = array(
                        'title' => 'Perfecto!',
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Registro creado con éxito",
                    );
                }
            } else {
                $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "No se encontró el convenio para editar", 
            );
            }
        } else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }    
        return $helpers->json($response);
    }

    /**
     * Deletes a vhloTpConvenio entity.
     *
     * @Route("/delete", name="vhlotpconvenio_delete")
     * @Method({"GET","POST"})
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", true);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("data", null);
            $params = json_decode($json);

            $convenio = $em->getRepository('JHWEBVehiculoBundle:VhloTpConvenio')->find($params->id);
            $convenio->setActivo(false);

            $empresas = $em->getRepository('JHWEBVehiculoBundle:VhloTpConvenioEmpresa')->findBy(
                array(
                    'vhloTpConvenio' => $convenio->getId(),
                    'activo' => true
                )
            );

            foreach ($empresas as $key => $empresa) {
                $empresa->setActivo(false);
                $em->persist($empresa);
            }

            $em->persist($convenio);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con éxito.",
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a vhloTpConvenio entity.
     *
     * @param VhloTpConvenio $vhloTpConvenio The vhloTpConvenio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloTpConvenio $vhloTpConvenio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlotpconvenio_delete', array('id' => $vhloTpConvenio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Busca empresas de transporte público por convenio
     *
     * @Route("/search/empresastransportepublico/convenio", name="vhlotpconvenio_empresas_transporte_publico_by_convenio")
     * @Method({"GET", "POST"})
     */
    public function searchEmpresasTransportePublicoByconvenioAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        
        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();

            $empresasTransportePublico = $em->getRepository('JHWEBVehiculoBundle:VhloTpConvenioEmpresa')->findBy(
                array(
                    'vhloTpConvenio' => $params->idConvenio, 
                    'activo' => true
                )
            );

            foreach ($empresasTransportePublico as $key => $empresaTransportePublico) {
                $arrayEmpresasTransportePublico[] = $empresaTransportePublico->getEmpresa()->getId();
            }

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Empresas encontradas.", 
                'data' => $arrayEmpresasTransportePublico
            );
        } else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización válida.", 
            );
        }
        
        return $helpers->json($response);
    }
}
