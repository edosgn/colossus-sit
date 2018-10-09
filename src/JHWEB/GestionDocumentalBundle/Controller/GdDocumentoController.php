<?php

namespace JHWEB\GestionDocumentalBundle\Controller;

use JHWEB\GestionDocumentalBundle\Entity\GdDocumento;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Gddocumento controller.
 *
 * @Route("gddocumento")
 */
class GdDocumentoController extends Controller
{
    /**
     * Lists all gdDocumento entities.
     *
     * @Route("/", name="gddocumento_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $documentos = $em->getRepository('JHWEBGestionDocumentalBundle:GdDocumento')->findBy(
            array('activo'=>true)
        );

        $response['data'] = array();

        if ($documentos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($documentos)." Registros encontrados", 
                'data'=> $documentos,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new gdDocumento entity.
     *
     * @Route("/new", name="gddocumento_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization",null);
        $authCheck = $helpers->authCheck($hash);

        if($authCheck == true){
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $usuario = $em->getRepository('AppBundle:Usuario')->findOneByIdentificacion(
                $params->peticionario->identificacion
            );

            if ($usuario) {
                $peticionario = $em->getRepository('AppBundle:Ciudadano')->findOneByUsuario(
                    $usuario->getId()
                );

                if ($peticionario) {
                    $documento = new GdDocumento();

                    $fechaRegistro = new \Datetime(date('Y-m-d h:i:s'));

                    $consecutivo = $em->getRepository('AppBundle:MgdDocumento')->getMaximo(
                        $fechaRegistro->format('Y')
                    );
                    $consecutivo = (empty($consecutivo['maximo']) ? 1 : $consecutivo['maximo']+=1);
                    $documento->setConsecutivo($consecutivo);

                    $documento->setNumeroRadicado(
                        str_pad($consecutivo, 3, '0', STR_PAD_LEFT).$fechaRegistro->format('Y')
                    );

                    $documento->setNumeroOficio($params->documento->numeroOficio);
                    $documento->setFolios($params->documento->folios);
                    $documento->setFechaRegistro($fechaRegistro);
                    $documento->setDescripcion($params->documento->descripcion);

                    if ($params->documento->correoCertificadoLlegada == 'true') {
                        $documento->setCorreoCertificadoLlegada(true);
                    }

                    if ($params->documento->nombreTransportadoraLlegada) {
                        $documento->setNombreTransportadoraLlegada($params->documento->nombreTransportadoraLlegada);
                    }

                    if ($params->documento->fechaLlegada) {
                        $documento->setFechaLlegada($params->documento->fechaLlegada);
                    }

                    if ($params->documento->numeroGuiaLlegada) {
                        $documento->setNumeroGuiaLlegada($params->documento->numeroGuiaLlegada);
                    }

                    if ($params->documento->idTipoCorrespondencia) {
                        $tipoCorrespondencia = $em->getRepository('JHWEBGestionDocumentalBundle:GdCfgTipoCorrespondencia')->find(
                            $params->documento->idTipoCorrespondencia
                        );
                        $documento->setTipoCorrespondencia($tipoCorrespondencia);
                    }

                    $fechaActual = new \Datetime(date('Y-m-d'));
                    if ($params->documento->vigencia) {
                        $vigencia = $params->documento->vigencia;
                    }else{
                        $vigencia = $tipoCorrespondencia->getDiasVigencia();
                    }
                    $fechaVencimiento = $this->get('app.gestion.documental')->getFechaVencimiento(
                        $fechaActual,
                        $vigencia
                    );
                    $documento->setFechaVencimiento($fechaVencimiento);
                    $documento->setDiasVigencia($vigencia);

                    $documento->setPeticionario($peticionario);

                    $file = $request->files->get('file');
                   
                    if ($file) {
                        $extension = $file->guessExtension();
                        $filename = md5(rand().time()).".".$extension;
                        $dir=__DIR__.'/../../../web/docs';

                        $file->move($dir,$filename);
                        $documento->setUrl($filename);
                    }
                    $documento->setEstado('Pendiente');

                    $em = $this->getDoctrine()->getManager();

                    $tipoCorrespondencia = $em->getRepository('AppBundle:MgdTipoCorrespondencia')->find(
                        $params->tipoCorrespondenciaId
                    );
                    $documento->setTipoCorrespondencia($tipoCorrespondencia);
                    
                    $em->persist($documento);
                    $em->flush();

                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Registro creado con éxito",
                    );
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "El usuario encontrado no tiene datos regostrados como ciudadano",
                    );
                }
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Ningún usuario encontrado",
                );
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no valida",
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Finds and displays a gdDocumento entity.
     *
     * @Route("/{id}/show", name="gddocumento_show")
     * @Method("GET")
     */
    public function showAction(GdDocumento $gdDocumento)
    {
        $deleteForm = $this->createDeleteForm($gdDocumento);

        return $this->render('gddocumento/show.html.twig', array(
            'gdDocumento' => $gdDocumento,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing gdDocumento entity.
     *
     * @Route("/{id}/edit", name="gddocumento_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, GdDocumento $gdDocumento)
    {
        $deleteForm = $this->createDeleteForm($gdDocumento);
        $editForm = $this->createForm('JHWEB\GestionDocumentalBundle\Form\GdDocumentoType', $gdDocumento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('gddocumento_edit', array('id' => $gdDocumento->getId()));
        }

        return $this->render('gddocumento/edit.html.twig', array(
            'gdDocumento' => $gdDocumento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a gdDocumento entity.
     *
     * @Route("/{id}/delete", name="gddocumento_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, GdDocumento $gdDocumento)
    {
        $form = $this->createDeleteForm($gdDocumento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($gdDocumento);
            $em->flush();
        }

        return $this->redirectToRoute('gddocumento_index');
    }

    /**
     * Creates a form to delete a gdDocumento entity.
     *
     * @param GdDocumento $gdDocumento The gdDocumento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(GdDocumento $gdDocumento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('gddocumento_delete', array('id' => $gdDocumento->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ========================================================= */

    /**
     * Busca si existen documentos radicado por identificaccion de peticionario, nombre de la entidad o numero de oficio.
     *
     * @Route("/search", name="gddocumento_search")
     * @Method({"GET", "POST"})
     */
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $documentos = null;

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $tipoPeticionario = $params->idTipoPeticionario;

            if ($tipoPeticionario == "Persona") {
                $documentos = $em->getRepository('JHWEBGestionDocumentalBundle:GdDocumento')->getByPeticionario(
                    $tipoPeticionario,
                    $params->identificacion
                );
            }else{
                $documentos = $em->getRepository('JHWEBGestionDocumentalBundle:GdDocumento')->getByPeticionario(
                    $tipoPeticionario,
                    $params->entidadNombre,
                    $params->numeroOficio
                );
            }
            
            if ($documentos == null) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Registro no encontrado", 
                );
            }else{
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado", 
                    'data'=> $documentos,
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
