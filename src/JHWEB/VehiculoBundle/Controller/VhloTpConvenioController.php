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
            $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->find($params->empresa);
            
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
                $vhloTpConvenio = new VhloTpConvenio();
                
                $vhloTpConvenio->setNumeroConvenio($params->numeroConvenio);
                $vhloTpConvenio->setFechaConvenio($fechaConvenio);
                $vhloTpConvenio->setFechaActaInicio($fechaActaInicio);
                $vhloTpConvenio->setFechaActaFin($fechaActaFin);
                $vhloTpConvenio->setAlcaldia($empresa);
                $vhloTpConvenio->setObservacion($params->observacion);
                $vhloTpConvenio->setActivo(1);

                $em->persist($vhloTpConvenio);

                foreach ($params->empresas as $key => $empresa) {
                    $empresaConvenio = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->find($empresa);
                    
                    $vhloTpConvenioEmpresa = new VhloTpConvenioEmpresa();
                    
                    $vhloTpConvenioEmpresa->setEmpresa($empresaConvenio);
                    $vhloTpConvenioEmpresa->setVhloTpConvenio($vhloTpConvenio);

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
     * @Route("/{id}/edit", name="vhlotpconvenio_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VhloTpConvenio $vhloTpConvenio)
    {
        $deleteForm = $this->createDeleteForm($vhloTpConvenio);
        $editForm = $this->createForm('JHWEB\VehiculoBundle\Form\VhloTpConvenioType', $vhloTpConvenio);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vhlotpconvenio_edit', array('id' => $vhloTpConvenio->getId()));
        }

        return $this->render('vhlotpconvenio/edit.html.twig', array(
            'vhloTpConvenio' => $vhloTpConvenio,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a vhloTpConvenio entity.
     *
     * @Route("/{id}", name="vhlotpconvenio_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VhloTpConvenio $vhloTpConvenio)
    {
        $form = $this->createDeleteForm($vhloTpConvenio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vhloTpConvenio);
            $em->flush();
        }

        return $this->redirectToRoute('vhlotpconvenio_index');
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

    
}
