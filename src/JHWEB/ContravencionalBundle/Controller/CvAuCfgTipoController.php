<?php

namespace JHWEB\ContravencionalBundle\Controller;

use JHWEB\ContravencionalBundle\Entity\CvAuCfgTipo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cvaucfgtipo controller.
 *
 * @Route("cvaucfgtipo")
 */
class CvAuCfgTipoController extends Controller
{
    /**
     * Lists all cvAuCfgTipo entities.
     *
     * @Route("/", name="cvaucfgtipo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $tipos = $em->getRepository('JHWEBContravencionalBundle:CvAuCfgTipo')->findBy(
            array(
                'activo' => true
            )
        );

        $response['data'] = array();

        if ($tipos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tipos)." registros encontrados", 
                'data'=> $tipos,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cvAuCfgTipo entity.
     *
     * @Route("/new", name="cvaucfgtipo_new")
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

            $tipo = new CvAuCfgTipo();

            if ($params->idFormato) {
                $formato = $em->getRepository('JHWEBConfigBundle:CfgAdmFormato')->find(
                    $params->idFormato
                );
                $tipo->setFormato($formato);
            }
        
            if ($params->finaliza) {
                $tiposOld = $em->getRepository('JHWEBContravencionalBundle:CvAuCfgTipo')->findByFinaliza(
                    true
                );

                foreach ($tiposOld as $key => $tipoOld) {
                    $tipo->setFinaliza(false);
                    $em->flush();
                }
            }
            $tipo->setFinaliza($params->finaliza);
            $tipo->setNombre(mb_strtoupper($params->nombre, 'utf-8'));
            $tipo->setActivo(true);

            $em->persist($tipo);
            $em->flush();

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
            );
        }else{
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
     * Finds and displays a cvAuCfgTipo entity.
     *
     * @Route("/show", name="cvaucfgtipo_show")
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

            $tipo = $em->getRepository('JHWEBContravencionalBundle:CvAuCfgTipo')->find(
                $params->id
            );

            if ($tipo) {
                $comparendo = $em->getRepository('JHWEBContravencionalBundle:CvCdoComparendo')->find(
                    $params->idComparendo
                );
    
                $template = $helpers->generateTemplate(
                    $comparendo,
                    $tipo->getFormato()->getCuerpo()
                );
    
                if ($template) {
                    $response = array(
                        'title' => 'Perfecto!',
                        'status' => 'success',
                        'code' => 200,
                        'message' => "Plantilla encontrada.", 
                        'data'=> array(
                            'tipo' => $tipo,
                            'template' => $template,
                        )
                    );
                }else{
                    $response = array(
                        'title' => 'Atención!',
                        'status' => 'warning',
                        'code' => 400,
                        'message' => 'La plantilla no pudo ser generada.',
                    );
                }
            }else{
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => 'El tipo de audiencia no se encuentra en la base de datos.',
                );
            }
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida', 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing cvAuCfgTipo entity.
     *
     * @Route("/edit", name="cvaucfgtipo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $tipo = $em->getRepository("JHWEBContravencionalBundle:CvAuCfgTipo")->find(
                $params->id
            );

            if ($tipo) {
                if ($params->idFormato) {
                    $tipo = $em->getRepository('JHWEBConfigBundle:CfgAdmFormato')->find(
                        $params->idFormato
                    );
                    $formato->setFormato($tipo);
                }
                
                if ($params->finaliza) {
                    $tiposOld = $em->getRepository('JHWEBContravencionalBundle:CvAuCfgTipo')->findByFinaliza(
                        true
                    );
    
                    foreach ($tiposOld as $key => $tipoOld) {
                        $tipo->setFinaliza(false);
                        $em->flush();
                    }
                }
                $tipo->setFinaliza($params->finaliza);
                $tipo->setNombre(mb_strtoupper($params->nombre, 'utf-8'));
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $atencion,
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
                'message' => "Autorizacion no valida para editar", 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a cvAuCfgTipo entity.
     *
     * @Route("/delete", name="cvaucfgtipo_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, CvAuCfgTipo $cvAuCfgTipo)
    {
        $form = $this->createDeleteForm($cvAuCfgTipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cvAuCfgTipo);
            $em->flush();
        }

        return $this->redirectToRoute('cvaucfgtipo_index');
    }

    /**
     * Creates a form to delete a cvAuCfgTipo entity.
     *
     * @param CvAuCfgTipo $cvAuCfgTipo The cvAuCfgTipo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CvAuCfgTipo $cvAuCfgTipo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cvaucfgtipo_delete', array('id' => $cvAuCfgTipo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =================================================== */

    /**
     * Listado de tipos de audiencia para seleccion con busqueda
     *
     * @Route("/select", name="cvaucfgtipo_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $tipos = $em->getRepository('JHWEBContravencionalBundle:CvAuCfgTipo')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($tipos as $key => $tipo) {
            $response[$key] = array(
                'value' => $tipo->getId(),
                'label' => $tipo->getNombre(),
            );
        }

        return $helpers->json($response);
    }
}
