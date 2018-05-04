<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TipoDocumento;
use AppBundle\Form\TipoDocumentoType;

/**
 * TipoDocumento controller.
 *
 * @Route("/tipodocumento")
 */ 
class TipoDocumentoController extends Controller
{
     /**
     * Lists all TipoDocumento entities.
     *
     * @Route("/", name="peticionario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tiposDocumento = $em->getRepository('AppBundle:TipoDocumento')->findBy(
            array('estado' => 1)
        );

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "Lista de tiposDocumento",
            'data' => $tiposDocumento, 
        );
        return $helpers->json($response);
    }


    /**
     * Creates a new TipoDocumento entity.
     *
     * @Route("/new", name="tipodocumento_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck== true) {
            $json = $request->get("json",null);
            $params = json_decode($json);
           
                $nombreTipo = $params->nombreTipo;

                $diasDuracionTramite = $params->diasDuracionTramite;
                $codigoDocumento = $params->codigoDocumento;
                $estado = true;

                $tipoDocumento = new TipoDocumento();
                $tipoDocumento->setNombreTipo($nombreTipo);
                $tipoDocumento->setDiasDuracionTramite($diasDuraccionTramite);
                $tipoDocumento->setCodigoDocumento($codigoDocumento);
                $tipoDocumento->setEstado($estado);
                
                $em->persist($tipoDocumento);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro creado con exito", 
                );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida", 
            );
            } 
        return $helpers->json($response);
    }

    /**
     * Finds and displays a tipoDocumento entity.
     *
     * @Route("/{id}/show", name="tipo_documento_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request, TipoDocumento $tipoDocumento)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro encontrado", 
                    'data'=> $tipoDocumento,
            );
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }

   /**
     * Displays a form to edit an existing Tipo Documento entity.
     *
     * @Route("/edit", name="tipo_documento_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
       
       $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

                $nombreTipo = $params->nombreTipo;
                $diasDuracionTramite = $params->diasDuracionTramite;
                $codigoDocumento = $params->codigoDocumento;
                $tipoDocumentoId = $params->id;
                $estado = true;
                $tipoDocumento = $em->getRepository('AppBundle:TipoDocumento')->findOneBy(
                    array(
                        'estado' => 1,
                        'id' => $tipoDocumentoId
                    )
                );

            if ($tipoDocumento!=null) {

                $tipoDocumento->setNombreTipo($nombreTipo);
                $tipoDocumento->setDiasDuracionTramite($diasDuracionTramite);
                $tipoDocumento->setCodigoDocumento($codigoDocumento);
                $tipoDocumento->setEstado($estado);
                
                $em->persist($tipoDocumento);
                $em->flush();

                $em = $this->getDoctrine()->getManager();
                $em->flush();

                 $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Registro actualizado con exito", 
                        'data'=> $tipoDocumento,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El registro no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a tipoDocumento entity.
     *
     * @Route("/{id}/delete", name="almacen_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {

            $em = $this->getDoctrine()->getManager();
            $tipoDocumento = $em->getRepository('AppBundle:TipoDocumento')->find($id);

            if ($tipoDocumento!=null) {

                $tipoDocumento->setEstado(0);
                $em->persist($tipoDocumento);
                $em->flush();

                $responce = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "TipoDocumento eliminado con exito", 
                );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El TipoDocumento no se encuentra en la base de datos", 
                );
            }
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida", 
                );
        }

        return $helpers->json($responce);
    }

    /**
     * Creates a form to delete a TipoDocumento entity.
     *
     * @param TipoDocumento $tipoDocumento The TipoDocumento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TipoDocumento $tipoDocumento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tipodocumento_delete', array('id' => $tipoDocumento->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    /**
     * datos para select 2 
     *
     * @Route("/select", name="tipo_documento_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $tiposDocumento = $em->getRepository('AppBundle:TipoDocumento')->findBy(
        array('estado' => 1)
    );
      foreach ($tiposDocumento as $key => $tipoDocumento) {
        $response[$key] = array(
            'value' => $tipoDocumento->getId(),
            'label' => $tipoDocumento->getCodigoDocumento()."_".$tipoDocumento->getNombreTipo(),
            );
      }
       return $helpers->json($response);
    }
}
