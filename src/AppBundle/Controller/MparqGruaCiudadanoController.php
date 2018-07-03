<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MparqGruaCiudadano;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Mparqgruaciudadano controller.
 *
 * @Route("mparqgruaciudadano")
 */
class MparqGruaCiudadanoController extends Controller
{
    /**
     * Lists all mparqGruaCiudadano entities.
     *
     * @Route("/{idGrua}/index", name="mparqgruaciudadano_index")
     * @Method("GET")
     */
    public function indexAction(Request $request, $idGrua)
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $gruaCiudadanos = $em->getRepository('AppBundle:MparqGruaCiudadano')->findByCiudadano(
            $idGrua
        );

        $response['data'] = array();

        if ($gruaCiudadanos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => count($gruaCiudadanos)." Registros encontrados", 
                'data'=> $gruaCiudadanos,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new mparqGruaCiudadano entity.
     *
     * @Route("/new", name="mparqgruaciudadano_new")
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

            /*if (count($params)==0) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "los campos no pueden estar vacios", 
                );
            }else{*/
                $gruaCiudadano = new MparqGruaCiudadano();

                $em = $this->getDoctrine()->getManager();

                $gruaCiudadano->setFechaInicio(new \Datetime($params->fechaInicio));
                if ($params->descripcion) {
                    $gruaCiudadano->setDescripcion($params->descripcion);
                }
                $gruaCiudadano->setTipo($params->tipo);

                $grua = $em->getRepository('AppBundle:MparqGrua')->find(
                    $params->gruaId
                );
                $gruaCiudadano->setGrua($grua);

                $ciudadano = $em->getRepository('AppBundle:Ciudadano')->find(
                    $params->ciudadanoId
                );
                $gruaCiudadano->setCiudadano($ciudadano);

                $em->persist($gruaCiudadano);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro creado con exito",  
                );
            //}
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
     * Finds and displays a mparqGruaCiudadano entity.
     *
     * @Route("/{id}", name="mparqgruaciudadano_show")
     * @Method("GET")
     */
    public function showAction(MparqGruaCiudadano $mparqGruaCiudadano)
    {
        $deleteForm = $this->createDeleteForm($mparqGruaCiudadano);

        return $this->render('mparqgruaciudadano/show.html.twig', array(
            'mparqGruaCiudadano' => $mparqGruaCiudadano,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mparqGruaCiudadano entity.
     *
     * @Route("/{id}/edit", name="mparqgruaciudadano_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MparqGruaCiudadano $mparqGruaCiudadano)
    {
        $deleteForm = $this->createDeleteForm($mparqGruaCiudadano);
        $editForm = $this->createForm('AppBundle\Form\MparqGruaCiudadanoType', $mparqGruaCiudadano);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mparqgruaciudadano_edit', array('id' => $mparqGruaCiudadano->getId()));
        }

        return $this->render('mparqgruaciudadano/edit.html.twig', array(
            'mparqGruaCiudadano' => $mparqGruaCiudadano,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a mparqGruaCiudadano entity.
     *
     * @Route("/{id}", name="mparqgruaciudadano_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MparqGruaCiudadano $mparqGruaCiudadano)
    {
        $form = $this->createDeleteForm($mparqGruaCiudadano);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mparqGruaCiudadano);
            $em->flush();
        }

        return $this->redirectToRoute('mparqgruaciudadano_index');
    }

    /**
     * Creates a form to delete a mparqGruaCiudadano entity.
     *
     * @param MparqGruaCiudadano $mparqGruaCiudadano The mparqGruaCiudadano entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MparqGruaCiudadano $mparqGruaCiudadano)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mparqgruaciudadano_delete', array('id' => $mparqGruaCiudadano->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
