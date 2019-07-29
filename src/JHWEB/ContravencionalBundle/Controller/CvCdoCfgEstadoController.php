<?php

namespace JHWEB\ContravencionalBundle\Controller;

use JHWEB\ContravencionalBundle\Entity\CvCdoCfgEstado;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cvcdocfgestado controller.
 *
 * @Route("cvcdocfgestado")
 */
class CvCdoCfgEstadoController extends Controller
{
    /**
     * Lists all cvCdoCfgEstado entities.
     *
     * @Route("/", name="cvcdocfgestado_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $estados = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->findBy(
            array(
                'activo' => true
            )
        );

        $response['data'] = array();

        if ($estados) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($estados)." registros encontrados", 
                'data'=> $estados,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cvCdoCfgEstado entity.
     *
     * @Route("/new", name="cvcdocfgestado_new")
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

            $estado = new CvCdoCfgEstado();

            $estado->setNombre(mb_strtoupper($params->nombre, 'utf-8'));
            $estado->setSigla(mb_strtoupper($params->sigla, 'utf-8'));
            $estado->setDias($params->dias);
            $estado->setHabiles($params->habiles);
            $estado->setSimit($params->simit);
            $estado->setActualiza($params->actualiza);
            $estado->setFinaliza($params->finaliza);
            $estado->setActivo(true);

            if ($params->idFormato) {
                $formato = $em->getRepository('JHWEBConfigBundle:CfgAdmFormato')->find(
                    $params->idFormato
                );
                $estado->setFormato($formato);
            }

            $em->persist($estado);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Registro creado con exito.',
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida.', 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Finds and displays a cvCdoCfgEstado entity.
     *
     * @Route("/show", name="cvcdocfgestado_show")
     * @Method("POST")
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

            $estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(
                $params->id
            );

            if ($estado) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Estado encontrado.", 
                    'data'=> $estado
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
     * Displays a form to edit an existing cvCdoCfgEstado entity.
     *
     * @Route("/edit", name="cvcdocfgestado_edit")
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
            
            $em = $this->getDoctrine()->getManager();
            
            $estado = $em->getRepository("JHWEBContravencionalBundle:CvCdoCfgEstado")->find(
                $params->id
            );

            if ($estado) {
                $estado->setNombre(mb_strtoupper($params->nombre, 'utf-8'));
                $estado->setSigla(mb_strtoupper($params->sigla, 'utf-8'));
                $estado->setDias($params->dias);
                $estado->setHabiles($params->habiles);
                $estado->setSimit($params->simit);
                $estado->setActualiza($params->actualiza);
                $estado->setFinaliza($params->finaliza);

                if ($params->idFormato) {
                    $formato = $em->getRepository('JHWEBConfigBundle:CfgAdmFormato')->find(
                        $params->idFormato
                    );
                    $estado->setFormato($formato);
                }
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $estado,
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
     * Deletes a cvCdoCfgEstado entity.
     *
     * @Route("/{id}/delete", name="cvcdocfgestado_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CvCdoCfgEstado $cvCdoCfgEstado)
    {
        $form = $this->createDeleteForm($cvCdoCfgEstado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cvCdoCfgEstado);
            $em->flush();
        }

        return $this->redirectToRoute('cvcdocfgestado_index');
    }

    /**
     * Creates a form to delete a cvCdoCfgEstado entity.
     *
     * @param CvCdoCfgEstado $cvCdoCfgEstado The cvCdoCfgEstado entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CvCdoCfgEstado $cvCdoCfgEstado)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cvcdocfgestado_delete', array('id' => $cvCdoCfgEstado->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ============================================== */

    /**
     * Listado de estados para selección con búsqueda
     *
     * @Route("/select", name="cvcdocfgestado_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $estados = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($estados as $key => $estado) {
            $response[$key] = array(
                'value' => $estado->getId(),
                'label' => $estado->getNombre()
            );
        }
        return $helpers->json($response);
    }

    /**
     * Listado de estados habilitados para selección con buscador.
     *
     * @Route("/select/availables/modulo", name="cvcdocfgestado_select_availables_modulo")
     * @Method({"GET", "POST"})
     */
    public function selectAvailablesByModuloAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $estados = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->getAvailablesByModulo(
                $params->idModulo
            );

            $response = null;

            foreach ($estados as $key => $estado) {
                $response[] = array(
                    'value' => $estado->getId(),
                    'label' => $estado->getNombre()
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
     * Creates a new cvCdoCfgEstado entity.
     *
     * @Route("/search/modulo", name="cvcdocfgestado_search_modulo")
     * @Method({"GET", "POST"})
     */
    public function searchByModuloAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $estados = $em->getRepository('JHWEBContravencionalBundle:CvCfgReparto')->findBy(
                array(
                    'modulo' => $params->idModulo,
                    'activo' => true
                )
            );

            if ($estados) {
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($estados)." registros encontrados.",
                    'data' => $estados,
                );
            }else{
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => 'Ningún estado asignado.',
                );
            }
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida.', 
            );
        }

        return $helpers->json($response);
    }
}
