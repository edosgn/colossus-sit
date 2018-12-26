<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ConceptoParametroTramite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Conceptoparametrotramite controller.
 *
 * @Route("conceptoparametrotramite")
 */
class ConceptoParametroTramiteController extends Controller
{
    /**
     * Lists all conceptoParametroTramite entities.
     *
     * @Route("/", name="conceptoparametrotramite_index")
     * @Method("GET")
     */ 
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $conceptoParametroTramites = $em->getRepository('AppBundle:ConceptoParametroTramite')->findBy(
            array('estado' => 1)
        );
        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado conceptoParametroTramites", 
                    'data'=> $conceptoParametroTramites,
            );
         
        return $helpers->json($response);
    
    }
 
    /**
     * Creates a new conceptoParametroTramite entity.
     *
     * @Route("/new", name="conceptoparametrotramite_new")
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

            
            $em = $this->getDoctrine()->getManager();
            foreach ($params->trmites as $key => $idTramitePrecio) {
                $conceptoParametroTramite = new ConceptoParametroTramite;
                
                $tramitePrecio = $em->getRepository('AppBundle:TramitePrecio')->find($idTramitePrecio);
                $conceptoParametro = $em->getRepository('AppBundle:ConceptoParametro')->find($params->concepto);
                $conceptoParametroTramite->setTramitePrecio($tramitePrecio);
                $conceptoParametroTramite->setConceptoParametro($conceptoParametro);
                $conceptoParametroTramite->setEstado(true);

                $em->persist($conceptoParametroTramite);
                $em->flush();

            } 
 
            $response = array(
                'status' => 'success', 
                'code' => 200,
                'msj' => "concepto creado con exito", 
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
     * Finds and displays a conceptoParametroTramite entity.
     *
     * @Route("/{id}", name="conceptoparametrotramite_show")
     * @Method("GET")
     */
    public function showAction(ConceptoParametroTramite $conceptoParametroTramite)
    {
        $deleteForm = $this->createDeleteForm($conceptoParametroTramite);

        return $this->render('conceptoparametrotramite/show.html.twig', array(
            'conceptoParametroTramite' => $conceptoParametroTramite,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing conceptoParametroTramite entity.
     *
     * @Route("/{id}/edit", name="conceptoparametrotramite_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ConceptoParametroTramite $conceptoParametroTramite)
    {
        $deleteForm = $this->createDeleteForm($conceptoParametroTramite);
        $editForm = $this->createForm('AppBundle\Form\ConceptoParametroTramiteType', $conceptoParametroTramite);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('conceptoparametrotramite_edit', array('id' => $conceptoParametroTramite->getId()));
        }

        return $this->render('conceptoparametrotramite/edit.html.twig', array(
            'conceptoParametroTramite' => $conceptoParametroTramite,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Concepto entity.
     *
     * @Route("/{id}/delete", name="conceptoParametroTramite_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();
            $conceptoParametroTramite = $em->getRepository('AppBundle:ConceptoParametroTramite')->find($id);

            $conceptoParametroTramite->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($conceptoParametroTramite);
                $em->flush();
            $response = array(
                    'status' => 'success',
                        'code' => 200,
                        'msj' => "conceptoParametroTramite eliminado con exito", 
                );
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorización no valida", 
                );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a conceptoParametroTramite entity.
     *
     * @param ConceptoParametroTramite $conceptoParametroTramite The conceptoParametroTramite entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ConceptoParametroTramite $conceptoParametroTramite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('conceptoparametrotramite_delete', array('id' => $conceptoParametroTramite->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
