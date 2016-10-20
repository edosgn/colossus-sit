<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TramiteEspecifico;
use AppBundle\Form\TramiteEspecificoType;

/**
 * TramiteEspecifico controller.
 *
 * @Route("/tramiteespecifico")
 */
class TramiteEspecificoController extends Controller
{
    /**
     * Lists all TramiteEspecifico entities.
     *
     * @Route("/", name="tramiteespecifico_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $tramiteEspecifico = $em->getRepository('AppBundle:TramiteEspecifico')->findBy(
            array('estado' => 1)
        );
        $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado tramiteEspecifico", 
                    'data'=> $tramiteEspecifico,
            );
         
        return $helpers->json($responce);
    }

    /**
     * Creates a new TramiteEspecifico entity.
     *
     * @Route("/new", name="tramiteespecifico_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck== true) {
            $json = $request->get("json",null);
            $params = json_decode($json);
            if (count($params)==0) {
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "los campos no pueden estar vacios", 
                );
            }else{
                        $valor = $params->valor;
                        $tramiteId = $params->tramiteId;
                        $tramiteGeneralId = $params->tramiteGeneralId;
                        $varianteId = $params->varianteId;
                        $casoId = $params->casoId;
                        $em = $this->getDoctrine()->getManager();
                        $tramite= $em->getRepository('AppBundle:Tramite')->find($tramiteId);
                        $tramiteGeneral = $em->getRepository('AppBundle:TramiteGeneral')->find($tramiteGeneralId);
                        $variante = $em->getRepository('AppBundle:Variante')->find($varianteId);
                        $caso = $em->getRepository('AppBundle:Caso')->find($casoId);
                        $tramiteEspecifico = new TramiteEspecifico();
                        $tramiteEspecifico->setValor($valor);
                        $tramiteEspecifico->setDatos(null);
                        $tramiteEspecifico->setTramite($tramite);
                        $tramiteEspecifico->setTramiteGeneral($tramiteGeneral);
                        $tramiteEspecifico->setVariante($variante);
                        $tramiteEspecifico->setCaso($caso);
                        $tramiteEspecifico->setEstado(true);
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($tramiteEspecifico);
                        $em->flush();

                        $responce = array(
                            'status' => 'success',
                            'code' => 200,
                            'msj' => "tramiteEspecifico creado con exito", 
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
     * Finds and displays a TramiteEspecifico entity.
     *
     * @Route("/show/{id}", name="tramiteespecifico_show")
     * @Method("POST")
     */
    public function showAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $tramiteEspecifico = $em->getRepository('AppBundle:TramiteEspecifico')->find($id);
            $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "tramiteEspecifico", 
                    'data'=> $tramiteEspecifico,
            );
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
     * Displays a form to edit an existing TramiteEspecifico entity.
     *
     * @Route("/edit", name="tramiteespecifico_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);
            $valor = $params->valor;
            $tramiteId = $params->tramiteId;
            $tramiteGeneralId = $params->tramiteGeneralId;
            $varianteId = $params->varianteId;
            $casoId = $params->casoId;
            $em = $this->getDoctrine()->getManager();
            $tramite= $em->getRepository('AppBundle:Tramite')->find($tramiteId);
            $tramiteGeneral = $em->getRepository('AppBundle:TramiteGeneral')->find($tramiteGeneralId);
            $variante = $em->getRepository('AppBundle:Variante')->find($varianteId);
            $caso = $em->getRepository('AppBundle:Caso')->find($casoId);

            $em = $this->getDoctrine()->getManager();
            $tramiteEspecifico = $em->getRepository("AppBundle:TramiteEspecifico")->find($params->id);

            if ($tramiteEspecifico!=null) {
                $tramiteEspecifico->setValor($valor);
                $tramiteEspecifico->setDatos(null);
                $tramiteEspecifico->setTramite($tramite);
                $tramiteEspecifico->setTramiteGeneral($tramiteGeneral);
                $tramiteEspecifico->setVariante($variante);
                $tramiteEspecifico->setCaso($caso);
                $tramiteEspecifico->setEstado(true);
                $em = $this->getDoctrine()->getManager();
                $em->persist($tramiteEspecifico);
                $em->flush();
                $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "tramiteEspecifico editado con exito", 
                );   
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El banco no se encuentra en la base de datos", 
                );
            }
        }else{
            $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar banco", 
                );
        }

        return $helpers->json($responce);
    }

    /**
     * Deletes a TramiteEspecifico entity.
     *
     * @Route("/{id}/delete", name="tramiteespecifico_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $tramiteEspecifico = $em->getRepository('AppBundle:TramiteEspecifico')->find($id);

            $tramiteEspecifico->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($tramiteEspecifico);
                $em->flush();
            $responce = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "tramiteEspecifico eliminado con exito", 
                );
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
     * Creates a form to delete a TramiteEspecifico entity.
     *
     * @param TramiteEspecifico $tramiteEspecifico The TramiteEspecifico entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TramiteEspecifico $tramiteEspecifico)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tramiteespecifico_delete', array('id' => $tramiteEspecifico->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Busca los tramites especifos de cada tramite general.
     *
     * @Route("/tramiteE/tramiteG/{id}", name="tramiteespecifico_tramiteGeneral_show")
     * @Method("POST")
     */
    public function showTRamiteEAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $tramiteEspecificos = $em->getRepository('AppBundle:TramiteEspecifico')->findBy(
            array('estado' => 1,'tramiteGeneral' => $id)
            );
            if ($tramiteEspecificos!=null) {
               $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "tramiteEspecificos", 
                    'data'=> $tramiteEspecificos,
            );
            }else{
                $responce = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "No existen tramites generales para este tramite especifico", 
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
}
