<?php

namespace AppBundle\Controller;

use AppBundle\Entity\RepresentanteEmpresa;
use AppBundle\Entity\Ciudadano;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Representanteempresa controller.
 *
 * @Route("representanteempresa")
 */
class RepresentanteEmpresaController extends Controller
{
    /**
     * Lists all representanteEmpresa   entities.
     *
     * @Route("/", name="representanteempresa_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $representanteEmpresas = $em->getRepository('AppBundle:RepresentanteEmpresa')->findAll();

        return $this->render('representanteempresa/index.html.twig', array(
            'representanteEmpresas' => $representanteEmpresas,
        ));
    }

    /**
     * Creates a new representanteEmpresa entity.
     *
     * @Route("/new", name="representanteempresa_new")
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
            // if (count($params)==0) {
            //     $response = array(
            //         'status' => 'error',
            //         'code' => 400,
            //         'msj' => "Los campos no pueden estar vacios", 
            //     );
            // }else{
                $empresaId = $params->empresa->id;
                $ciudadanoId = $params->ciudadanoId;
                $fechaFinal = $params->fechaFinal;

                $fechaFinal=new \DateTime($fechaFinal);

                
                $em = $this->getDoctrine()->getManager();

                $empresa = $em->getRepository('AppBundle:Empresa')->find($empresaId);
                $ciudadano = $em->getRepository('AppBundle:Ciudadano')->find($ciudadanoId);


                $representanteVigente = $em->getRepository('AppBundle:RepresentanteEmpresa')->findOneBy(
                    array('empresa'=>$empresaId,'estado'=>1)
                );
            
                $representanteVigente->setEstado(0);    
                $representanteVigente->setfechaFinal($fechaFinal);    
                $em->persist($representanteVigente);
                $em->flush();

                $representanteEmpresa = new RepresentanteEmpresa();
                $representanteEmpresa->setCiudadano($ciudadano);
                $representanteEmpresa->setEmpresa($empresa);
                $representanteEmpresa->setFechaInicial($fechaFinal);
                $representanteEmpresa->setEstado(true);

                $em = $this->getDoctrine()->getManager();
                $em->persist($representanteEmpresa);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro creado con exito", 
                );
            // }
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
     * Finds and displays a sucursal entity.
     *
     * @Route("/{empresaId}/show", name="representanteEmpresaDato")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request,$empresaId)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            
            $em = $this->getDoctrine()->getManager();
            

            $representantes = $em->getRepository('AppBundle:RepresentanteEmpresa')->findBy(
                array('empresa'=>$empresaId,'estado'=>0)
            );
            $representanteVigente = $em->getRepository('AppBundle:RepresentanteEmpresa')->findOneBy(
                array('empresa'=>$empresaId,'estado'=>1)
            );
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro encontrado", 
                    'representantes'=> $representantes,
                    'representanteVigente'=> $representanteVigente,
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
     * Displays a form to edit an existing representanteEmpresa entity.
     *
     * @Route("/{id}/edit", name="representanteempresa_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, RepresentanteEmpresa $representanteEmpresa)
    {
        $deleteForm = $this->createDeleteForm($representanteEmpresa);
        $editForm = $this->createForm('AppBundle\Form\RepresentanteEmpresaType', $representanteEmpresa);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('representanteempresa_edit', array('id' => $representanteEmpresa->getId()));
        }

        return $this->render('representanteempresa/edit.html.twig', array(
            'representanteEmpresa' => $representanteEmpresa,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a representanteEmpresa entity.
     *
     * @Route("/{id}", name="representanteempresa_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, RepresentanteEmpresa $representanteEmpresa)
    {
        $form = $this->createDeleteForm($representanteEmpresa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($representanteEmpresa);
            $em->flush();
        }

        return $this->redirectToRoute('representanteempresa_index');
    }

    /**
     * Creates a form to delete a representanteEmpresa entity.
     *
     * @param RepresentanteEmpresa $representanteEmpresa The representanteEmpresa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(RepresentanteEmpresa $representanteEmpresa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('representanteempresa_delete', array('id' => $representanteEmpresa->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
