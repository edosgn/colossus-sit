<?php

namespace JHWEB\ContravencionalBundle\Controller;

use JHWEB\ContravencionalBundle\Entity\CvCfgPorcentajeInicial;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cvcfgporcentajeinicial controller.
 *
 * @Route("cvcfgporcentajeinicial")
 */
class CvCfgPorcentajeInicialController extends Controller
{
    /**
     * Lists all cvCfgPorcentajeInicial entities.
     *
     * @Route("/", name="cvcfgporcentajeinicial_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $porcentajes = $em->getRepository('JHWEBContravencionalBundle:CvCfgPorcentajeInicial')->findBy(
            array(
                'activo' => true
            )
        );

        $response['data'] = array();

        if ($porcentajes) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($porcentajes)." registros encontrados", 
                'data'=> $porcentajes,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cvCfgPorcentajeInicial entity.
     *
     * @Route("/new", name="cvcfgporcentajeinicial_new")
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
           
            $porcentaje = new CvCfgPorcentajeInicial();

            $porcentaje->setAnio($params->anio);
            $porcentaje->setValor($params->valor);
            $porcentaje->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($porcentaje);
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
     * Finds and displays a cvCfgPorcentajeInicial entity.
     *
     * @Route("/{id}", name="cvcfgporcentajeinicial_show")
     * @Method("GET")
     */
    public function showAction(CvCfgPorcentajeInicial $cvCfgPorcentajeInicial)
    {
        $deleteForm = $this->createDeleteForm($cvCfgPorcentajeInicial);

        return $this->render('cvcfgporcentajeinicial/show.html.twig', array(
            'cvCfgPorcentajeInicial' => $cvCfgPorcentajeInicial,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cvCfgPorcentajeInicial entity.
     *
     * @Route("/{id}/edit", name="cvcfgporcentajeinicial_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CvCfgPorcentajeInicial $cvCfgPorcentajeInicial)
    {
        $deleteForm = $this->createDeleteForm($cvCfgPorcentajeInicial);
        $editForm = $this->createForm('JHWEB\ContravencionalBundle\Form\CvCfgPorcentajeInicialType', $cvCfgPorcentajeInicial);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cvcfgporcentajeinicial_edit', array('id' => $cvCfgPorcentajeInicial->getId()));
        }

        return $this->render('cvcfgporcentajeinicial/edit.html.twig', array(
            'cvCfgPorcentajeInicial' => $cvCfgPorcentajeInicial,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cvCfgPorcentajeInicial entity.
     *
     * @Route("/{id}", name="cvcfgporcentajeinicial_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CvCfgPorcentajeInicial $cvCfgPorcentajeInicial)
    {
        $form = $this->createDeleteForm($cvCfgPorcentajeInicial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cvCfgPorcentajeInicial);
            $em->flush();
        }

        return $this->redirectToRoute('cvcfgporcentajeinicial_index');
    }

    /**
     * Creates a form to delete a cvCfgPorcentajeInicial entity.
     *
     * @param CvCfgPorcentajeInicial $cvCfgPorcentajeInicial The cvCfgPorcentajeInicial entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CvCfgPorcentajeInicial $cvCfgPorcentajeInicial)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cvcfgporcentajeinicial_delete', array('id' => $cvCfgPorcentajeInicial->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/search/active", name="cvcfgporcentajeinicial_search_active")
     * @Method({"GET", "POST"})
     */
    public function searchActiveAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $porcentaje = $em->getRepository('JHWEBContravencionalBundle:CvCfgPorcentajeInicial')->findOneBy(
            array('activo' => true)
        );

        if ($porcentaje) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Interes parametrizado '.$porcentaje->getValor().'%',
                'data' => $porcentaje
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Interes no parametrizado", 
            );
        } 

        
        return $helpers->json($response);
    }
}
