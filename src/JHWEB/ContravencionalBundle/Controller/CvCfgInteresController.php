<?php

namespace JHWEB\ContravencionalBundle\Controller;

use JHWEB\ContravencionalBundle\Entity\CvCfgInteres;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cvcfgintere controller.
 *
 * @Route("cvcfginteres")
 */
class CvCfgInteresController extends Controller
{
    /**
     * Lists all cvCfgIntere entities.
     *
     * @Route("/", name="cvcfginteres_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $intereses = $em->getRepository('JHWEBContravencionalBundle:CvCfgInteres')->findBy(
            array(
                'activo' => true
            )
        );

        $response['data'] = array();

        if ($intereses) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($intereses)." registros encontrados", 
                'data'=> $intereses,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cvCfgIntere entity.
     *
     * @Route("/new", name="cvcfginteres_new")
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
           
            $interes = new CvCfgInteres();

            $interes->setAnio($params->anio);
            $interes->setMes($params->mes);
            $interes->setValor($params->valor);
            $interes->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($interes);
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
     * Finds and displays a cvCfgIntere entity.
     *
     * @Route("/show", name="cvcfginteres_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $interes = $em->getRepository('JHWEBContravencionalBundle:CvCfgInteres')->find(
                $params->idInteres
            );

            $em->persist($interes);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro encontrado con exito",
                'data' => $interes
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
     * Displays a form to edit an existing cvCfgIntere entity.
     *
     * @Route("/{id}/edit", name="cvcfginteres_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CvCfgInteres $cvCfgIntere)
    {
        $deleteForm = $this->createDeleteForm($cvCfgIntere);
        $editForm = $this->createForm('JHWEB\ContravencionalBundle\Form\CvCfgInteresType', $cvCfgIntere);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cvcfginteres_edit', array('id' => $cvCfgIntere->getId()));
        }

        return $this->render('cvcfginteres/edit.html.twig', array(
            'cvCfgIntere' => $cvCfgIntere,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cvCfgIntere entity.
     *
     * @Route("/{id}/delete", name="cvcfginteres_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CvCfgInteres $cvCfgIntere)
    {
        $form = $this->createDeleteForm($cvCfgIntere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cvCfgIntere);
            $em->flush();
        }

        return $this->redirectToRoute('cvcfginteres_index');
    }

    /**
     * Creates a form to delete a cvCfgIntere entity.
     *
     * @param CvCfgInteres $cvCfgIntere The cvCfgIntere entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CvCfgInteres $cvCfgIntere)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cvcfginteres_delete', array('id' => $cvCfgIntere->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="cvcfginteres_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $intereses = $em->getRepository('JHWEBContravencionalBundle:CvCfgInteres')->findBy(
            array('activo' => true)
        );

        $response = null;

        foreach ($intereses as $key => $interes) {
            $response[$key] = array(
                'value' => $interes->getId(),
                'label' => $interes->getValor().' %'
            );
        }
        return $helpers->json($response);
    }

    /**
     * Selecciona el interes activo a la fecha
     *
     * @Route("/search/active", name="cvcfginteres_search_active")
     * @Method({"GET", "POST"})
     */
    public function searchActiveAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $interes = $em->getRepository('JHWEBContravencionalBundle:CvCfgInteres')->findOneBy(
            array('activo' => true)
        );

        if ($interes) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Interes parametrizado '.$interes->getValor().'%',
                'data' => $interes
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
