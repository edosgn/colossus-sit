<?php

namespace JHWEB\ParqueaderoBundle\Controller;

use JHWEB\ParqueaderoBundle\Entity\PqoGruaCiudadano;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Pqogruaciudadano controller.
 *
 * @Route("pqogruaciudadano")
 */
class PqoGruaCiudadanoController extends Controller
{
    /**
     * Lists all pqoGruaCiudadano entities.
     *
     * @Route("/index", name="pqogruaciudadano_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $json = $request->get("data",null);
        $params = json_decode($json);

        $em = $this->getDoctrine()->getManager();
        $gruaCiudadanos = $em->getRepository('JHWEBParqueaderoBundle:PqoGruaCiudadano')->findByGrua(
            $params->idGrua
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
     * Creates a new pqoGruaCiudadano entity.
     *
     * @Route("/new", name="pqogruaciudadano_new")
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

            $gruaCiudadano = new PqoGruaCiudadano();

            $em = $this->getDoctrine()->getManager();

            $gruaCiudadano->setFechaInicial(new \Datetime($params->fechaInicial));
            if ($params->observaciones) {
                $gruaCiudadano->setObservaciones($params->observaciones);
            }
            $gruaCiudadano->setTipo($params->tipo);

            if ($params->idGrua) {
                $grua = $em->getRepository('JHWEBParqueaderoBundle:PqoCfgGrua')->find(
                    $params->idGrua
                );
                $gruaCiudadano->setGrua($grua);
            }

            if ($params->idCiudadano) {
                $ciudadano = $em->getRepository('AppBundle:Ciudadano')->find(
                    $params->idCiudadano
                );
                $gruaCiudadano->setCiudadano($ciudadano);
            }

            $em->persist($gruaCiudadano);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Registro creado con exito",  
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
     * Finds and displays a pqoGruaCiudadano entity.
     *
     * @Route("/{id}", name="pqogruaciudadano_show")
     * @Method("GET")
     */
    public function showAction(PqoGruaCiudadano $pqoGruaCiudadano)
    {
        $deleteForm = $this->createDeleteForm($pqoGruaCiudadano);

        return $this->render('pqogruaciudadano/show.html.twig', array(
            'pqoGruaCiudadano' => $pqoGruaCiudadano,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pqoGruaCiudadano entity.
     *
     * @Route("/{id}/edit", name="pqogruaciudadano_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, PqoGruaCiudadano $pqoGruaCiudadano)
    {
        $deleteForm = $this->createDeleteForm($pqoGruaCiudadano);
        $editForm = $this->createForm('JHWEB\ParqueaderoBundle\Form\PqoGruaCiudadanoType', $pqoGruaCiudadano);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pqogruaciudadano_edit', array('id' => $pqoGruaCiudadano->getId()));
        }

        return $this->render('pqogruaciudadano/edit.html.twig', array(
            'pqoGruaCiudadano' => $pqoGruaCiudadano,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pqoGruaCiudadano entity.
     *
     * @Route("/{id}", name="pqogruaciudadano_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PqoGruaCiudadano $pqoGruaCiudadano)
    {
        $form = $this->createDeleteForm($pqoGruaCiudadano);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pqoGruaCiudadano);
            $em->flush();
        }

        return $this->redirectToRoute('pqogruaciudadano_index');
    }

    /**
     * Creates a form to delete a pqoGruaCiudadano entity.
     *
     * @param PqoGruaCiudadano $pqoGruaCiudadano The pqoGruaCiudadano entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PqoGruaCiudadano $pqoGruaCiudadano)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pqogruaciudadano_delete', array('id' => $pqoGruaCiudadano->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
