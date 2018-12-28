<?php

namespace JHWEB\GestionDocumentalBundle\Controller;

use JHWEB\GestionDocumentalBundle\Entity\GdTrazabilidad;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Gdtrazabilidad controller.
 *
 * @Route("gdtrazabilidad")
 */
class GdTrazabilidadController extends Controller
{
    /**
     * Lists all gdTrazabilidad entities.
     *
     * @Route("/", name="gdtrazabilidad_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $gdTrazabilidads = $em->getRepository('JHWEBGestionDocumentalBundle:GdTrazabilidad')->findAll();

        return $this->render('gdtrazabilidad/index.html.twig', array(
            'gdTrazabilidads' => $gdTrazabilidads,
        ));
    }

    /**
     * Creates a new gdTrazabilidad entity.
     *
     * @Route("/new", name="gdtrazabilidad_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $gdTrazabilidad = new Gdtrazabilidad();
        $form = $this->createForm('JHWEB\GestionDocumentalBundle\Form\GdTrazabilidadType', $gdTrazabilidad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($gdTrazabilidad);
            $em->flush();

            return $this->redirectToRoute('gdtrazabilidad_show', array('id' => $gdTrazabilidad->getId()));
        }

        return $this->render('gdtrazabilidad/new.html.twig', array(
            'gdTrazabilidad' => $gdTrazabilidad,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a gdTrazabilidad entity.
     *
     * @Route("/show", name="gdtrazabilidad_show")
     * @Method("GET")
     */
    public function showAction(Request $request)
    {
        $deleteForm = $this->createDeleteForm($gdTrazabilidad);

        return $this->render('gdtrazabilidad/show.html.twig', array(
            'gdTrazabilidad' => $gdTrazabilidad,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing gdTrazabilidad entity.
     *
     * @Route("/edit", name="gdtrazabilidad_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $deleteForm = $this->createDeleteForm($gdTrazabilidad);
        $editForm = $this->createForm('JHWEB\GestionDocumentalBundle\Form\GdTrazabilidadType', $gdTrazabilidad);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('gdtrazabilidad_edit', array('id' => $gdTrazabilidad->getId()));
        }

        return $this->render('gdtrazabilidad/edit.html.twig', array(
            'gdTrazabilidad' => $gdTrazabilidad,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a gdTrazabilidad entity.
     *
     * @Route("/delete", name="gdtrazabilidad_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request)
    {
        $form = $this->createDeleteForm($gdTrazabilidad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($gdTrazabilidad);
            $em->flush();
        }

        return $this->redirectToRoute('gdtrazabilidad_index');
    }

    /**
     * Creates a form to delete a gdTrazabilidad entity.
     *
     * @param GdTrazabilidad $gdTrazabilidad The gdTrazabilidad entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(GdTrazabilidad $gdTrazabilidad)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('gdtrazabilidad_delete', array('id' => $gdTrazabilidad->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ====================================================== */
    
    /**
     * Busca si existen documentos radicado y asignados a un funcionario.
     *
     * @Route("/search/funcionario", name="gdtrazabilidad_search")
     * @Method({"GET", "POST"})
     */
    public function searchByFuncionarioAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);


            $trazabilidades = $em->getRepository('JHWEBGestionDocumentalBundle:GdTrazabilidad')->findBy(
                array(
                    'responsable' => $params->idFuncionario,
                    'estado' => array('PENDIENTE','EN TRAMITE','ASIGNADO')
                )
            );
            
            if ($trazabilidades) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($trazabilidades)." Documentos registrados.", 
                    'data'=> $trazabilidades,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No tiene documentos asignados aún.", 
                );
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }

        return $helpers->json($response);
    }

    /* ====================================================== */
    /**
     * Busca si existen documentos radicado y asignados a un funcionario.
     *
     * @Route("/search/response/documento", name="gdtrazabilidad_search_response_documento")
     * @Method({"GET", "POST"})
     */
    public function searchResponseByDocumentoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);


            $trazabilidades = $em->getRepository('JHWEBGestionDocumentalBundle:GdTrazabilidad')->findBy(
                array(
                    'documento' => $params->idDocumento,
                    'estado' => 'RESPUESTA REALIZADA'
                )
            );
            
            if ($trazabilidades) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($trazabilidades)." Documentos registrados.", 
                    'data'=> $trazabilidades,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No tiene documentos asignados aún.", 
                );
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Busca peticionario por cedula o por nombre entidad y numero de oficio.
     *
     * @Route("/process", name="gdtrazabilidad_process")
     * @Method({"GET", "POST"})
     */
    public function processAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();

            $trazabilidad = $em->getRepository('JHWEBGestionDocumentalBundle:GdTrazabilidad')->find(
                $params->idTrazabilidad
            );
            
            if ($trazabilidad) {
                if ($params->aceptada == 'true') {
                    $estado = 'EN TRAMITE';
                    $trazabilidad->setAceptada(true);
                    $trazabilidad->getDocumento()->setEstado('EN TRAMITE');

                    $fechaRegistro = new \Datetime(date('Y-m-d h:i:s'));

                    $consecutivo = $em->getRepository('JHWEBGestionDocumentalBundle:GdDocumento')->getMaximo(
                        $fechaRegistro->format('Y')
                    );
                    $consecutivo = (empty($consecutivo['maximo']) ? 1 : $consecutivo['maximo']+=1);

                    $trazabilidad->getDocumento()->setNumeroSalida('SH-STTD-'.
                        str_pad($consecutivo, 3, '0', STR_PAD_LEFT).'-'.$fechaRegistro->format('Y')
                    );

                    $em->flush();
                }else{
                    $estado = 'RECHAZADO';
                    $trazabilidad->getDocumento()->setEstado('RECHAZADO');
                }

                if ($params->observaciones) {
                    $trazabilidad->setObservaciones($params->observaciones);
                }
                $trazabilidad->setEstado($estado);

                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Radicado No. ".$trazabilidad->getDocumento()->getNumeroRadicado()." ".$trazabilidad->getEstado(),
                    'data' => $trazabilidad
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Registro no encontrado"
                );
            }

            
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorizacion no valida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Busca peticionario por cedula o por nombre entidad y numero de oficio.
     *
     * @Route("/response", name="gdtrazabilidad_response")
     * @Method({"GET", "POST"})
     */
    public function responseAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $documentos = null;

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();

            $trazabilidad = $em->getRepository('JHWEBGestionDocumentalBundle:GdTrazabilidad')->find(
                $params->idTrazabilidad
            );
            
            if ($trazabilidad) {
                $trazabilidad->setFechaRespuesta(
                    new \Datetime(date('Y-m-d h:i:s'))
                );
                $trazabilidad->setEstado('RESPUESTA REALIZADA');
                $trazabilidad->getDocumento()->setEstado('RESPUESTA REALIZADA');

                $file = $request->files->get('file');
                   
                if ($file) {
                    $extension = $file->guessExtension();

                    if ($extension == 'pdf') {
                        $filename = md5(rand().time()).".".$extension;
                        $dir=__DIR__.'/../../../../web/docs';

                        $file->move($dir,$filename);
                        $trazabilidad->setUrl($filename);

                        $em->flush();

                        $response = array(
                            'status' => 'success',
                            'code' => 200,
                            'message' => "Radicado No. ".$trazabilidad->getDocumento()->getNumeroRadicado()." ".$trazabilidad->getEstado(),
                            'data' => $trazabilidad
                        );
                    }else{
                        $response = array(
                            'status' => 'error',
                            'code' => 400,
                            'message' => "Solo se admiten documento de formato PDF"
                        );
                    }
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "Ningún documento seleccionado"
                    );
                }
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Registro no encontrado"
                );
            }           
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorizacion no valida", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Busca si existen trazabilidades por id de documento.
     *
     * @Route("/record/documento", name="gdtrazabilidad_record_documento")
     * @Method({"GET", "POST"})
     */
    public function recordByDocumentoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $trazabilidades = $em->getRepository('JHWEBGestionDocumentalBundle:GdTrazabilidad')->findBy(
                array(
                    'documento' => $params->id
                )
            );
            
            if ($trazabilidades) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($trazabilidades)." Documentos registrados.", 
                    'data'=> $trazabilidades,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El documento no tiene trazabilidades aún.", 
                );
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }

        return $helpers->json($response);
    }
}
