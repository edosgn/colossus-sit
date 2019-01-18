<?php

namespace JHWEB\ConfigBundle\Controller;

use JHWEB\ConfigBundle\Entity\CfgAdmFormato;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgadmformato controller.
 *
 * @Route("cfgadmformato")
 */
class CfgAdmFormatoController extends Controller
{
    /**
     * Lists all cfgAdmFormato entities.
     *
     * @Route("/", name="cfgadmformato_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $formatos = $em->getRepository('JHWEBConfigBundle:CfgAdmFormato')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($formatos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($formatos)." registros encontrados", 
                'data'=> $formatos,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cfgAdmFormato entity.
     *
     * @Route("/new", name="cfgadmformato_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
           
            $em = $this->getDoctrine()->getManager();

            $formato = new CfgAdmFormato();

            $formato->setCodigo($params->codigo);
            $formato->setNombre(strtoupper($params->nombre));
            $formato->setCuerpo($params->cuerpo);
            $formato->setActivo(true);

            if ($params->idTipo) {
                $tipo = $em->getRepository('JHWEBConfigBundle:CfgAdmFormatoTipo')->find(
                    $params->idTipo
                );
                $formato->setTipo($tipo);
            }

            $em->persist($formato);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
            );
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
     * Finds and displays a cfgAdmFormato entity.
     *
     * @Route("/show", name="cfgadmformato_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $formato = $em->getRepository('JHWEBConfigBundle:CfgAdmFormato')->find(
                $params->id)
            ;

            if ($formato) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado", 
                    'data'=> $formato,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos",
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
     * Displays a form to edit an existing cfgAdmFormato entity.
     *
     * @Route("/edit", name="cfgadmformato_edit")
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
            $formato = $em->getRepository('JHWEBConfigBundle:CfgAdmFormato')->find(
                $params->id
            );

            if ($formato) {
                $formato->setCodigo($params->codigo);
                $formato->setNombre(strtoupper($params->nombre));
                $formato->setCuerpo($params->cuerpo);

                if ($params->idTipo) {
                    $tipo = $em->getRepository('JHWEBConfigBundle:CfgAdmFormatoTipo')->find(
                        $params->idTipo
                    );
                    $formato->setTipo($tipo);
                }

                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $formato,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida para editar",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a cfgAdmFormato entity.
     *
     * @Route("/{id}/delete", name="cfgadmformato_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgAdmFormato $cfgAdmFormato)
    {
        $form = $this->createDeleteForm($cfgAdmFormato);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgAdmFormato);
            $em->flush();
        }

        return $this->redirectToRoute('cfgadmformato_index');
    }

    /**
     * Creates a form to delete a cfgAdmFormato entity.
     *
     * @param CfgAdmFormato $cfgAdmFormato The cfgAdmFormato entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgAdmFormato $cfgAdmFormato)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgadmformato_delete', array('id' => $cfgAdmFormato->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =================================================== */

    /**
     * datos para select 2
     *
     * @Route("/select", name="cfgadminformato_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $formatos = $em->getRepository('JHWEBConfigBundle:CfgAdmFormato')->findBy(
            array('activo' => 1)
        );

        $response = null;

        foreach ($formatos as $key => $formato) {
            $response[$key] = array(
                'value' => $formato->getId(),
                'label' => $formato->getNombre(),
            );
        }

        return $helpers->json($response);
    }
}
