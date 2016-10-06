<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\VehiculoPesado;
use AppBundle\Form\VehiculoPesadoType;

/**
 * VehiculoPesado controller.
 *
 * @Route("/vehiculopesado")
 */
class VehiculoPesadoController extends Controller
{
    /**
     * Lists all VehiculoPesado entities.
     *
     * @Route("/", name="vehiculopesado_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $vehiculoPesado = $em->getRepository('AppBundle:VehiculoPesado')->findBy(
            array('estado' => 1)
        );
        $responce = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "listado vehiculoPesado", 
                    'data'=> $vehiculoPesado,
            );
        return $helpers->json($responce);
    }

    /**
     * Creates a new VehiculoPesado entity.
     *
     * @Route("/new", name="vehiculopesado_new")
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
                        $tonelaje = $params->tonelaje;
                        $numeroEjes = $params->numeroEjes;
                        $numeroMt = $params->numeroMt;
                        $fichaTecnicaHomologacionCarroceria = $params->fichaTecnicaHomologacionCarroceria;
                        $fichaTecnicaHomologacionChasis = $params->fichaTecnicaHomologacionChasis;
                        $vehiculoId = $params->vehiculoId;
                        $modalidadId = $params->modalidadId;
                        $empresaId = $params->empresaId;

                        $vehiculoPesado = new VehiculoPesado();

                        $vehiculoPesado->setTonelaje($tonelaje);
                        $vehiculoPesado->setNumeroEjes($numeroEjes);
                        $vehiculoPesado->setNumeroMt($numeroMt);
                        $vehiculoPesado->setEstado(true);

                        $em = $this->getDoctrine()->getManager();
                        $em->persist($vehiculoPesado);
                        $em->flush();

                        $responce = array(
                            'status' => 'success',
                            'code' => 200,
                            'msj' => "vehiculoPesado creado con exito", 
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
     * Finds and displays a VehiculoPesado entity.
     *
     * @Route("/{id}", name="vehiculopesado_show")
     * @Method("GET")
     */
    public function showAction(VehiculoPesado $vehiculoPesado)
    {
        $deleteForm = $this->createDeleteForm($vehiculoPesado);

        return $this->render('AppBundle:VehiculoPesado:show.html.twig', array(
            'vehiculoPesado' => $vehiculoPesado,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing VehiculoPesado entity.
     *
     * @Route("/{id}/edit", name="vehiculopesado_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, VehiculoPesado $vehiculoPesado)
    {
        $deleteForm = $this->createDeleteForm($vehiculoPesado);
        $editForm = $this->createForm('AppBundle\Form\VehiculoPesadoType', $vehiculoPesado);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vehiculoPesado);
            $em->flush();

            return $this->redirectToRoute('vehiculopesado_edit', array('id' => $vehiculoPesado->getId()));
        }

        return $this->render('AppBundle:VehiculoPesado:edit.html.twig', array(
            'vehiculoPesado' => $vehiculoPesado,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a VehiculoPesado entity.
     *
     * @Route("/{id}", name="vehiculopesado_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VehiculoPesado $vehiculoPesado)
    {
        $form = $this->createDeleteForm($vehiculoPesado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vehiculoPesado);
            $em->flush();
        }

        return $this->redirectToRoute('vehiculopesado_index');
    }

    /**
     * Creates a form to delete a VehiculoPesado entity.
     *
     * @param VehiculoPesado $vehiculoPesado The VehiculoPesado entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VehiculoPesado $vehiculoPesado)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vehiculopesado_delete', array('id' => $vehiculoPesado->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
